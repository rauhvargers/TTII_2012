<?php

use Social\Facebook;

/**
 * Different ways of authentication
 */
class Controller_Account extends Controller_Template {

    public function action_create() {
	if (Input::method() == "POST") {
	    $exist_user = DB::select("id")
		    ->from("users")
		    ->where("email", "=", Input::post("usermail"))
		    ->execute()
		    ->as_array();
	    $is_err = false;
	    if (count($exist_user) > 0) {
		//sorry, the username is taken already :(
		Session::set_flash("error", "The username is already taken");
		$is_err = true;
	    }

	    if (Input::post("password") != Input::post("password_rep")) {
		Session::set_flash("error", "Passwords do not match!");
		$is_err = true;
	    }

	    if ($is_err == false) {
		//no errors - we can register!
		$verification_key = md5(mt_rand(0, mt_getrandmax()));
		$newid = Auth::instance()->create_user(
			Input::post("usermail"), //username = email
			Input::post("password"),
			Input::post("usermail"),
			1, //simple user
			array("verified" => false,
			      "verification_key" => $verification_key)
			);
		Session::set_flash("success", "Registration successful!\nYou still have to verify your e-mail address.");
		$this->action_send_verification_email($newid, Input::post("usermail"), $verification_key);
		//nothing else to do here
		Response::redirect("/");
	    }
	}
	$this->template->page_title = "Become a member";
	$this->template->content = View::forge("account/create");
    }

    public function action_send_verification_email($id, $mailaddress, $key) {

	$email = Email::forge();
	$email->from('admin@eventual.org', 'Eventual system');

	$email->to($mailaddress, "Eventual system user");
	$email->subject('Your registration in Eventual');

	$mail_text = "'Thank you for registering at eventual.org'
		     Please, verify your address by clicking this link: " .
		Uri::create("account/verify/" . $id . "/" . $key . "/");
	$email->body($mail_text);
	$email->send();
    }

    public function action_verify($userid, $key) {
	$auth = Auth::instance();

	if ($auth->force_login($userid)) {
	    //forced login worked well.
	    //is the verification key valid?
	    if ($auth->get_profile_fields("verification_key", null) != $key) {
		$auth->logout();//can' stay logged in!
		Session::set_flash("error", "Wrong verification key!");
	    } else {
		$auth->update_user(array("verified"=>true, "verification_key"=>null));
		Session::set_flash("success", "Welcome, now your e-mail address is verified!");
	    }
	} else {
	    //force log in did not work
	    Session::set_flash("errror", "Could not log you in!");
	}
	Response::redirect("/");
    }

    /**
     * Logging in with username and password.
     * This uses the "simple auth" bundled with FuelPHP.
     */
    public function action_simpleauth() {
	$data = array();

	// If so, you pressed the submit button. let's go over the steps
	if (Input::post()) {
	    // first of all, let's get a auth object
	    $auth = Auth::instance();

	    // check the credentials. This assumes that you have the previous table created and
	    // you have used the table definition and configuration as mentioned above.
	    if ($auth->login()) {
		if ($auth->get_profile_fields("verified", false) == false) {
		    Session::set_flash("error", "You have not verified your e-mail address yet!");
		} else {
		    // credentials ok, go right in
		    Response::redirect('/') and die();
		}
	    } else {
		// Oops, no soup for you. try to login again. Set some values to
		// repopulate the username field and give some error text back to the view
		//$data['username'] = Input::post('username');
		Session::set_flash("error", "User name or password incorrect.");
		//$data['login_error'] = 'Wrong username/password combo. Try again';
	    }
	}

	// Show the login form
	$this->template->content = View::forge('account/simpleauth', $data);
    }

    public function action_logout() {
	$auth = Auth::instance();
	$auth->logout();
	Response::redirect("/");
    }

    /**
     * Authenticates the user using Facebook.
     */
    public function action_fb() {
	
	$fb = Facebook::instance();


	if ($fb->check_login() == false) {
	    //user has not yet authenticated via facebook
	    $fbl_params = array("scope" => "email");
	    $loginurl = $fb->getLoginUrl($fbl_params);
	    Response::redirect($loginurl) and die();
	} else {
	    //facebook authentication successful.
	    $user_profile = $fb->api('/me');
	    //and we know the user's email
	    $fb_mail = $user_profile["email"];

	    //and the user's facebook ID
	    $fb_id = $user_profile["id"];

	    $auth = Auth::instance();

	    //simpleauth does not have a method for 
	    //checking if username is taken
	    //hence we do a direct DB select.
	    $fb_sql_user = DB::select("id")
		    ->from("users")
		    ->where("username", "=", "FB@" . $fb_mail)
		    ->execute()
		    ->as_array();

	    if (count($fb_sql_user) == 0) {
		//we don't have the user in the local DB yet
		//let us create a local user
		//coining a specific username,
		//assigning a random password		
		$user_id = $auth->create_user("FB@" . $fb_mail, hash("sha256", mt_rand(0, mt_getrandmax())), $fb_mail, 1, array(
		    "facebook_id" => $fb_id,
		    "verified" => true)
		);
	    } else {
		//we have the user. Let's log the user in
		$user_id = $fb_sql_user[0]["id"];
	    }

	    $auth->force_login($user_id);
	    Response::redirect("/");
	}
    }

    /**
     * Demonstrates how HTTP basic authentication can be used
     * @return \Response
     */
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

    /**
     * Self-made authentication function. Demonstrates logging in.
     * @return type
     */
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
	    $this->template->content = View::forge("account/password");
	} else {
	    //user is trying to authenticate

	    $user = Model_Orm_Passworduser::password_login(Input::post("username"), Input::post("password"));

	    if ($user == null) {
		Session::set_flash("error", "User name or password incorrect");
		//and returning the same login form
		$this->template->title = "Please, authenticate";
		$this->template->content = View::forge("account/password");
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

}
