<?php
/**
 * Description of events
 *
 * @deprecated AN EXAMPLE class, not used.
 * 
 * @author krissr
 */
//class Model_Events extends \Model {
//    
//    public function get_events() {
//  	   $example_return = array(
//		"2012-10-16"=>"Lecture",
//               	"2012-10-23"=>"Test");
//        return $example_return;		
//    }
//    
//    public function get_events_mysql() {
//    //$mysqli = new mysqli('localhost', 'my_user', 'my_password', 'my_db');
//	$mysqli = new \mysqli('localhost', 'fuel_dev', 'fuel_dev', 'fuel_dev');
//	$statement = $mysqli->prepare("select * from events");
//	$results = $statement->execute();
//	return $results;
//    }
//    
//    /**
//     * Loads all events from database
//     * @return record set
//     */
//    public function get_events_db(){
//	$query= \DB::select('id','title')->from('events')->order_by("id","desc");
//	return $query->execute()->as_array();
//    }
//
//}