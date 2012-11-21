<?php

use Social\Facebook;

/**
 * Different ways of authentication
 */
class Controller_Auth extends Controller_Template {

    public function action_basic() {
	if (Input::server("PHP_AUTH_USER", null) == null) {
	    $response = new Response();
	    $response->set_header('WWW-Authenticate', 'Basic realm="Authenticate for eventual.org"');
	    return $response;
	} else {
	    $response = Response::forge("You are authenticated as " . Input::server("PHP_AUTH_USER"));
	    return $response;
	}
    }

    public function action_password() {
	if (Session::get("username", null) != null) {
	    $this->template->title = "Already authenticated!";
	    $this->template->content = 'You have already loggend in! You are ' .
		    Session::get("username") . ' your role is ' .
		    Session::get("role");
	    return;
	}
	
	if (Input::post("username", null) == null) {
	    //there was no user input
	    $this->template->title = "Please, authenticate";
	    $this->template->content = View::forge("auth/password");
	} else {
	    //user is trying to authenticate

	    $user = Model_Orm_user::password_login(Input::post("username"), Input::post("password"));

	    if ($user == null) {
		Session::set_flash("error", "User name or password incorrect");
		//and returning the same login form
		$this->template->title = "Please, authenticate";
		$this->template->content = View::forge("auth/password");
	    } else {
		//tried to authenticate and succeeded
		$this->template->title = 'Authentication successful';
		$this->template->content = 'Authentication was successful, you are ' .
			$user->user_name . ' your role is ' .
			$user->user_role;
		Session::set("username", $user->user_name);
		Session::set("role", $user->user_role);
	    }
	}
    }
    
    public function action_setup(){
	$auth = Auth	::instance();
	$auth->create_user("kriss", "a", "kriss.rauhvargers@lu.lv", 100, array());
    }

    public function action_simpleauth() {
	$data = array();

	// If so, you pressed the submit button. let's go over the steps
	if (Input::post()) {
	    // first of all, let's get a auth object
	    $auth = Auth::instance();

	    // check the credentials. This assumes that you have the previous table created and
	    // you have used the table definition and configuration as mentioned above.
	    if ($auth->login()) {
		// credentials ok, go right in
		Response::redirect('event/index');
	    } else {
		// Oops, no soup for you. try to login again. Set some values to
		// repopulate the username field and give some error text back to the view
		//$data['username'] = Input::post('username');
		Session::set_flash("error", "User name or password incorrect");
		//$data['login_error'] = 'Wrong username/password combo. Try again';
	    }
	}

	// Show the login form
	$this->template->content = View::forge('auth/simpleauth', $data);
    }

    public function action_fb() {
	$fb = new Facebook();
	if ($fb->check_login() == 0) {
	    $fbl_params = array("scope" => "email");
	    $loginurl = Facebook::instance()->getLoginUrl($fbl_params);
	    Response::redirect($loginurl);
	} else {
	    $this->template->content = "You are ok:" . $fb->check_login();
	}
    }
    
    public function action_tw() {
	$tw = new Social\Twitter();
	$tw->login();
	$this->template->content = print_r($tw->logged_in());
	
	
    }

}
