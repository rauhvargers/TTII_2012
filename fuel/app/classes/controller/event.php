<?php

use \Model_Orm_Event;

/**
 * An "event" is the central entity in the "Eventual".
 *
 * @author krissr
 */
class Controller_Event extends Controller_Public {
    private $_auth;
    private $_user_id;
    
    public function before() {
	parent::before();
	
	$this->_auth = Auth::instance();
	$userids = $this->_auth->get_user_id();
	$this->_user_id = $userids[1];
	
	//loads messages for event controller
	Lang::load("event");
	
    }
    /**
     * Demonstrates reading data through an ORM model
     */
    public function action_index() {
	$event_model = Model_Orm_Event::find("all", array(
		    //we only want future and current events
		    "where" => array(
			array('start', '>=', Date::forge()->format("%Y-%m-%d"))
		    ),
		    "order_by" => array("start" => "asc"),
		    "related" => array("agendas", "location")));

	$main_content = View::forge("event/index");
	$main_content->set("event_model", $event_model);

	$this->template->libs_js = array(
	    "http://code.jquery.com/jquery-1.8.2.js");

	$this->template->page_title = __("ACTION_INDEX_TITLE");
	$this->template->page_content = $main_content;
    }
    
    /**
     * Creation of new events.
     * Works on both the first load, which is typically 
     * a GET request as on later requests, which are POST.
     * When POST-ing, a validation is run on input data.
     * Validation rules taken from "Event" model.
     */
    public function action_create() {
	if ( ! Auth::has_access('event.create') ) {
	//if ($this->_user_id == 0){
	    Session::set_flash("error", __('ERR_CREATE_AUTH'));
	    Response::redirect("/") and die();
	}
	$data = array(); //to be passed into the view

	if (Input::method() == "POST") {
	    $val = Model_Orm_Event::validate('create');
	    if ($val->run()) {
		$newEvent = new Model_Orm_Event();
		$newEvent->title = $val->validated("title");
		$newEvent->start = $val->validated("start");
		$newEvent->description = $val->validated("description");
		$location = Model_Orm_Location::find(Input::post("location"));
		$newEvent->location = $location;
		//first, we save the item without attachments
		$newEvent->save();

		$errors = $this->try_get_attachments($newEvent);

		Session::set_flash("success", __('ACTION_CREATE_CREATED') . $val->validated("title"));
		Response::redirect("event/view/" . $newEvent->id);
	    } else {
		//validation did not work. 
		//But still, there may be uploaded files!
		$errors = $this->try_get_attachments();
		Session::set_flash("error", array_merge($val->error(), $errors));
	    }
	    $this->template->title = __("ACTION_CREATE_TITLE");
	    $data["form_key"] = Input::post("form_key");
	} else {
	    //the first GET request
	    $this->template->title = __("ACTION_CREATE_TITLE");

	    //we assign a random value to the form
	    $data["form_key"] = md5(mt_rand(1000, 10000));
	}
	$data["locations"] = Model_Orm_Location::get_locations();
	
	$this->add_rich_form_scripts();
	$this->template->page_content = View::forge("event/create", $data);
    }

    /**
     * Tries to get attachments from uploaded files
     * @param type $event
     * @return array list of errors
     */
    private function try_get_attachments($event = null) {
	//first we check if there is probably a file
	//already stored from previous submissions.
	$old_file = Session::get("uploaded_file_" . Input::post("form_key"), null);
	if ($old_file != null and $event != null) {
	    $event->poster = $old_file;
	    $event->save();
	    return array();
	}

	//no "old files" exist, let's catch the new ones!
	$config = array(
	    'path' => APPPATH . 'files',
	    'randomize' => false,
	    'auto_rename' => true,
	    'ext_whitelist' => array('pdf'),
	);

	// process the uploaded files in $_FILES
	Upload::process($config);

	// if there are any valid files
	if (Upload::is_valid()) {
	    // save them according to the config
	    Upload::save();
	    //call a model method to update the database
	    $newfile = Upload::get_files(0);
	    if ($event != null) {
		$event->poster = $newfile["saved_as"];
		$event->save();
		return array(); //done, no errors
	    } else {
		//there is no event yet (validation problems)
		//but there are uploaded files.
		//We store this information in the session
		//so that the next time user submits the form
		//with validation errors fixed, we can attach the "old" file
		Session::set("uploaded_file_" . Input::post("form_key"), $newfile["saved_as"]);
		return array(); //no errors here!
	    }
	} else {
	    if (count(Upload::get_errors(0)) > 0)
		//there was some problem with the files
		return array("The uploaded file could not be saved");
	    else
		return array();
	}
    }
    
    /**
     * Forced download of the attached file
     * @param type $id
     * @return \Response
     * @throws HttpNotFoundException
     */
    public function action_poster($id = null){
	//if the event request is not valid, return a 404 error
	if (is_null($id))
	    throw new HttpNotFoundException;
	
	$event = Model_Orm_Event::find($id);
	if (is_null($event))
	    throw new HttpNotFoundException;
	
	if ($event->poster != null) {
	    //the files are found in subfolder of APPPATH, named "files"
	    //DS stands for "Directory Separator"
	    //Since we know it's a PDF file, we force PDF mime type.
	    $response = new Response();
	    $response->set_header('Content-Type', 'application/pdf');
	    $response->set_header('Content-Disposition', 'attachment; filename="'.$event->poster.'"');
	    $response->body = file_get_contents(APPPATH."files".DS.$event->poster);
	    return $response;
	} else {
	    //no poster file for the current document!
	    throw new HttpNotFoundException;
	}
    }

    public function action_edit($id = null) {
	//looks up the even in the database
	//if anything is not OK - redirects back to the list of events

	is_null($id) and Response::redirect('event');
	$event = Model_Orm_Event::find($id, array("related" =>
		    array("location")));

	is_null($event) and Response::redirect('Event');

	//not POST = just read from database
	if (Input::method() == 'POST') {
	    $val = Model_Orm_Event::validate("edit");
	    if ($val->run()) {
		//validation is OK!
		$event->title = $val->validated("title");
		$event->description = $val->validated("description");
		$event->start = $val->validated("start");
		$event->location = Model_Orm_Location::find(Input::post("location"));
		if ($event->save()) {
		    Session::set_flash("success", "Changes saved successfuly!");
		} else {
		    Session::set_flash("error", "Somehow could not save the item.");
		}

		Response::redirect("event/view/" . $event->id);
	    } else {
		//POST data passed, but something wrong with validation
		Session::set_flash("error", $val->error());
	    }
	}

	$data["event"] = $event;
	$data["locations"] = Model_Orm_Location::get_locations();
	$this->add_rich_form_scripts();
	$this->template->title = "Editing the event " . $event->title;
	$this->template->page_content = View::forge("event/edit", $data);
    }

    /**
     * Displays information about the event
     * @param int $id Database ID of the item
     */
    public function action_view($id = null) {
	
	is_null($id) and Response::redirect('Event');
	
	$event = Model_Orm_Event::find($id, array("related" =>
		    array("agendas", "location")));

	is_null($event) and Response::redirect('Event');

	//$data["event"] = $event;
	$event_view = View::forge("event/view");
	$event_view->set("event", $event);
	$this->template->title = __("ACTION_VIEW_TITLE");
	$this->template->page_content = $event_view;
    }

    public function action_delete($id = null) {
	is_null($id) and Response::redirect('event');
	$event = Model_Orm_Event::find($id);
	is_null($event) and Response::redirect('Event');
	$event->delete();
	Session::set_flash("success", "Deleted the item ".$event->title);
	Response::redirect('Event');
    }
    /**
     * since we have "rich form", additional scripts
     * and stylesheets are needed
     */
    private function add_rich_form_scripts() {

	$this->template->libs_js = array(
	    "http://code.jquery.com/jquery-1.8.2.js",
	    "http://code.jquery.com/ui/1.9.1/jquery-ui.js",
	    "jquery-ui-timepicker-addon.js",
	    "http://cdn.aloha-editor.org/latest/lib/require.js"
	);
	$this->template->libs_css = array(
	    "http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css",
	    "datetimepicker.css",
	    "http://cdn.aloha-editor.org/latest/css/aloha.css"
	);
    }

}
