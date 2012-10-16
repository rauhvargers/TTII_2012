<?php
/**
 * Description of event
 *
 * @author krissr
 */
class Controller_Event extends Controller_Template {
    
    public function action_list(){
	
//	$response = Response::forge("Hello, world (this is the event list).");
//	$response->set_header('Content-Type', 'text/plain');
//	return $response;

	$view_vars = array();
	$view_vars["the_date"] = date("H:i:s");	
	$view_vars["title"] = "<h1>List</h1> of events in ".$view_vars["the_date"];
	$view_vars["event_dates"] = array("2012-10-20", "2012-10-22", "2012-10-30");
	
	$this->template->page_title = "List of events";
	$this->template->page_content = View::forge("event/list", $view_vars);
	
	//return Response::forge($view_results);
    }
    
}
?>
