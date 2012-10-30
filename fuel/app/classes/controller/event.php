<?php

use \Model_Events;
use \Model_Crudevent;
use \Model_Orm_Event;
/**
 * Description of event
 *
 * @author krissr
 */
class Controller_Event extends Controller_Template {

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
	    $main_content.=$event->id." ".$event->title."---";
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

    
    /**
     * Demonstrates reading data through an ORM model
     */
      public function action_ormlist() {		
	$event_model = Model_Orm_Event::find("all", 
			    array("related"=> array("agendas", "location")));
	
	$main_content = View::forge("event/ormlist");
	$main_content->set("event_model", $event_model);
	
	
	$this->template->page_title = "List of events from ORM model using relations";
	$this->template->page_content =  $main_content;
	
	
    }
    
}

?>
