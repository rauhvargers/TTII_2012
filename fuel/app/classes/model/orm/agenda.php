<?php 

class Model_Orm_Agenda extends Orm\Model
{
   protected static $_table_name = 'agenda';
   protected static $_primary_key = array('id');
   protected static $_properties = array(
	    'id', 
	    'title' => array(
		'data_type' => 'varchar',
		'label' => 'Title of the agenda item',
		'validation' => array('required', 
				      'min_length' => array(3),
				      'max_length' => array(200)),
		    'form' => array('type' => 'text'),
		    'default' => 'New agenda item',
		)
	    );
    protected static $_belongs_to = 
			array(
			    'event' => array(
				'key_from' => 'event_id',
				'model_to' => 'Model_Orm_Event',
				'key_to' => 'id'			    )
			);

}
