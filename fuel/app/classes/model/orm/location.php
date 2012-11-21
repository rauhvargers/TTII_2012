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
   
    public static function get_locations()
    {
	return \DB::select('id', 'title')
		    ->from('location')
		    ->execute()
		    ->as_array('id', 'title');
    }
    
    
    /**
     * A validation function which checks if the number passed 
     * to it is a valid location ID.
     * @param type $val
     * @return boolean
     */
    public static function _validation_valid_location($val)
    {
	 

	if (Model_Orm_Location::find($val)==null) {
	    Validation::active()->set_message('valid_location', 
		'The field "location" must refer to a valid location.');
	    return false;
	}
	return true;
    }
}
