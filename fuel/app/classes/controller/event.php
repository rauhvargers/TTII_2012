<?php

use \Model_Events;
use \Model_Crudevent;
use \Model_Orm_Event;

/**
 * An "event" is the central entity in the "Eventual".
 *
 * @author krissr
 */
class Controller_Event extends Controller_Template {

    public function action_index() {		
	return $this->action_ormlist();
    }

    /**
     * Demonstrates reading data through an ORM model
     */
    public function action_ormlist() {

	$event_model = Model_Orm_Event::find("all", array("related" => array("agendas", "location")));

	$main_content = View::forge("event/ormlist");
	$main_content->set("event_model", $event_model);


	$this->template->page_title = "List of events from ORM model using relations";
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
	if (Input::method() == "POST") {
	    $val = Model_Orm_Event::validate('create');
	    if ($val->run()) {
		$newEvent = new Model_Orm_Event();
		$newEvent->title = $val->validated("title");
		$newEvent->start = $val->validated("start");
		$newEvent->description = $val->validated("description");
		$location = Model_Orm_Location::find(Input::post("location"));
		$newEvent->location = $location;
		$newEvent->save();
		Session::set_flash("success", "New event created: " . $val->validated("title"));
		Response::redirect("event/view/" . $newEvent->id);
	    } else {
		Session::set_flash("error", $val->error());
	    }
	    $this->template->title = "Trying to save an event";
	} else {
	    $this->template->title = "Creating an event";
	}

	$data = array();
	$data["locations"] = Model_Orm_Location::get_locations();

	//since we have "rich form", additional scripts
	//and stylesheets are needed
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

	
	$this->template->page_content = View::forge("event/create", $data);
    }

    public function action_view($id=null) {
	
	is_null($id) and Response::redirect('Event');
	
	$event = Model_Orm_Event::find($id, 
				array("related" =>
				    array("agendas", "location")));

	is_null($event) and Response::redirect('Event');

	$data["event"] = $event;

	$this->template->title = "Viewing an event";
	$this->template->page_content = View::forge("event/view", $data);
    }

    /**
     * Renders a list of current events.
     */
    public function action_list() {
	/**
	 * The commented code demonstrates how you can use the 
	 * `Response` object to send additional headers
	 */
//	$response = Response::forge("Hello, world (this is the event list).");
//	$response->set_header('Content-Type', 'text/plain');
//	return $response;

	/**
	 * The easiest way to prepare data for a view - 
	 * an associative array. 
	 * Array content is not limited to simple types, 
	 * can contain sub-arrays, objects, etc.
	 */
	$view_vars = array();
	$view_vars["the_date"] = date("H:i:s");
	$view_vars["title"] = "<h1>List</h1> of events in " . $view_vars["the_date"];
	$view_vars["event_dates"] = array("2012-10-20", "2012-10-22", "2012-10-30");

	//since we are inheriting the Controller_Template,
	//template placeholders have to be filled.
	//template is located at APPPATH/views/template.php
	$this->template->page_title = "List of events";


	//Here we use a ViewModel to supplement view data
	//ViewModel::forge does not accept the data array
	// as the second parameter as View::forge does. (don't know why)
	//Hence I have to call "set" 

	$event_model = new Model_Events();
//	$view_vars["event_dates"] = 

	$main_content = ViewModel::forge("event/list");
	$main_content->set("the_date", date("H:i:s"));
	$main_content->set("title", "List of events");
	$main_content->set("event_dates", $event_model->get_events());
	$main_content->set("event_dates_mysql", $event_model->get_events_mysql());
	$main_content->set("event_dates_db", $event_model->get_events_db());

	$this->template->page_content = $main_content;

	/**
	 * if a template controller action returns a response object, 
	 * the template is ignored
	 */
	//return Response::forge($view_results);
    }

    public function action_crudlist() {
	$event_model = new Model_Crudevent();
	$events = $event_model->find_all();

	$main_content = "";
	foreach ($events as $event) {
	    $main_content.=$event->id . " " . $event->title . "---";
	}

	//$event = Model_Crudevent::find_by_pk(1);
	//$event->save();

	$this->template->page_title = "List of events from CRUD model";
	$this->template->page_content = $main_content;
    }

    public function action_crudupdate() {
	$event = Model_Crudevent::find_by_pk(1);
	$event->title = "Title was modified";
	$event->save();

	$this->template->page_title = "";
	$this->template->page_content = "";
    }

}

?>
