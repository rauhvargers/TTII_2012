<?php

/**
 * 
 *
 * @author krissr
 */
class Controller_Public extends Controller_Template {
    
    public function before() {
	parent::before();
	
	
	
	$auth = Auth::instance();
	$user_id = $auth->get_user_id();
	//when logged in, the ID will be put in the array as 
	//second element
	if ($user_id[1] != 0) {
	    //the user has logged in, we can load a language 
	    $lang_pref = $auth->get_profile_fields("language", null);
	    if ($lang_pref != null) {
		Config::set("language", $lang_pref);
	    }
	} else {
	    //we don't have a preference, let's load English
	    //no, we don' do anything, since English 
	    //is the default
	}
	Lang::load("main");
    }
}