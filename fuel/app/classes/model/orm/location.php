<?php 

class Model_Orm_Location extends Orm\Model
{
   protected static $_table_name = 'location';
   protected static $_primary_key = array('id');
   protected static $_properties = array(
	    'id', 
	    'title' => array(
		'data_type' => 'varchar',
		'label' => 'Title of the location',
		'validation' => array('required', 'min_length' => array(3), 'max_length' => array(200)),
		    'form' => array('type' => 'text'),
		    'default' => 'New location',
		)
	    );
   protected static $_has_many = array(
			    'events' => array(
				    'key_from' => 'id',
				    'model_to' => 'Model_Orm_Event',
				    'key_to' => 'location_id',
				    'cascade_save' => true,
				    'cascade_delete' => false)
				);

}
