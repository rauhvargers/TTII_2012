<?php

/**
 * Description of dbdemo
 *
 * @author Krissr
 */
class Model_Dbdemo extends \Model{
    
    public function load_all(){
	//$event_query = DB::query("select * from events order by id desc");
	$event_query = DB::select("*")
			    ->from("events")
			    ->order_by("id", "desc");
	return $event_query->execute()->as_array();	
    }
    
}
