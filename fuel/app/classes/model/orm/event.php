<?php

class Model_Orm_Event extends Orm\Model {
    
    protected static $_table_name = 'events';
    protected static $_primary_key = array('id');
    
    
    protected static $_has_many = array(
	'agendas' => array(
	    'key_from' => 'id',
	    'model_to' => 'Model_Orm_Agenda',
	    'key_to' => 'event_id',
	    'cascade_save' => true,
	    'cascade_delete' => false)
    );
    
    
    

    protected static $_properties = array(
	'id',
	'title' => array(
	    'validation'=>array('required'),
	    'data_type' => 'varchar',
	    'label' => 'Title of the event'),
	'description' => array(
	    'data_type' => 'text',
	    'label' => 'Description: what will happen?'),
	'start' => array(
	    'data_type' => 'date',
	    'label' => 'Start date and time of the event'
	),
	'location_id' => array( 
		"form"=>array("type"=>true)
	),
	'poster' => array(
	    'data_type' => 'varchar',
	    'label' => 'Poster of the event (PDF document)'),
    );
    protected static $_belongs_to = array(
	'location' => array(
	    'key_from' => 'location_id',
	    'model_to' => 'Model_Orm_Location',
	    'key_to' => 'id')
    );

    public static function validate($factory) {
	$val = Validation::forge($factory);

	//because we want to check if location is valid
	$val->add_callable("Model_Orm_Location");

	$val->add_field('title', 'Title', 'required|max_length[255]');
	$val->add_field('start', 'Start date', 'required|max_length[50]');
	$val->add_field('location', 'Event location', 'required|valid_location');
	$val->add_field('description', 'Description', 'max_length[2000]');
	return $val;
    }

}
