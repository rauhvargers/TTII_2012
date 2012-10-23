<?php

use Model\Events;
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

	
//	$view_vars["event_dates"] = array("2012-10-20", "2012-10-22", "2012-10-30");

	//since we are inheriting the Controller_Template,
	//template placeholders have to be filled.
	//template is located at APPPATH/views/template.php
	$this->template->page_title = "List of events";
	
	
	//Here we use a ViewModel to supplement view data
	//ViewModel::forge does not accept the data array
	// as the second parameter as View::forge does. (don't know why)
	//Hence I have to call "set" 
	
	$event_model = new Events();
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
    
//    public function action_test(){
//	
//	$results = DB::select('id','title')->from('events')->execute();
//	foreach ($result as $resultitem) {
//	    echo $resultitem["title"];
//	    echo $resultitem["id"];
//	}
//	$this->template->page_title = "Test action";
//	$this->template->page_content = $s;
//    }

}

?>
