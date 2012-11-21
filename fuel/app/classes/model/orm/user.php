<?php
class Model_Orm_User extends Orm\Model {

    protected static $_table_name = 'passwordusers';
    protected static $_primary_key = array('user_id');
    protected static $_properties = array(
	'user_id',
	'user_name' => array('data_type' => 'varchar'),
	'user_password' => array(
	    'data_type' => 'varchar'),
	'user_role' => array(
	    'data_type' => 'varchar'));
    
    /**
     * Trying to log in using simple DB password comparison
     * @param string $username
     * @param string $password
     * @return object
     */
    public static function password_login($username, $password) {

	$self = Model_Orm_User::query()
		    ->where("user_name","=", $username)
		    ->get_one();
	
	//if no such user is found then there is no chance of authentication
	if ($self == null){
	    return null;
	}
	
	//authentication can't be successful if passwords do not match
	if ($self->user_password != $password){
	    return null;
	}
	 
	//passwords match. Returning the object
	return $self;
    }

}
