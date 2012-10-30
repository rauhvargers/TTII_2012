<?php 

class Model_Orm_Event extends Orm\Model
{
   protected static $_table_name = 'events';
   protected static $_primary_key = array('id');
   protected static $_properties = array(
	    'id', 
	    'title' => array(
		'data_type' => 'varchar',
		'label' => 'Title of the event'),
	    'location_id'
	    );
   
    protected static $_has_many = 
			    array(
			    'agendas' => array(
				    'key_from' => 'id',
				    'model_to' => 'Model_Orm_Agenda',
				    'key_to' => 'event_id',
				    'cascade_save' => true,
				    'cascade_delete' => false)
				);
	    
    protected static $_belongs_to = 
			array(
			    'location' => array(
				'key_from' => 'location_id',
				'model_to' => 'Model_Orm_Location',
				'key_to' => 'id')
    			    );
}
