<?php

/**
 * This controller is only used for demonstrations in class.
 */
class Controller_Demo extends Controller_Template {
    
    /**
     * Working with view data: passing different items into the view
     */
    public function action_index(){
	    $viewdata = array();
	    $viewdata["title"] = rand(13284, 130249132);
	    $viewdata["data"] = "<script>alert('blabla')</script>";
	    $viewdata["countries"] = array("Latvia", "Latvia", 
					    "Lithuania", "Estonia");
	    //since this controller inherits from "Controller_Template"
	    //we only have to set different template fields
	    $this->template->page_content = 
			View::forge('welcome/helloworld', $viewdata);
	    $this->template->page_title = "Demo title";
    }

    /**
     * Loading the data from database 
     * (by invoking a method in a model Model_Dbdemo which does the job)
     */
    public function action_db() {
	
	$demodata = new Model_Dbdemo();
	$viewdata = array();
	$viewdata["events"]  = $demodata->load_all();
	
	$this->template->page_content = View::forge('demo/data', $viewdata);
	$this->template->page_title = "";
    }
    
    /**
     * Automatic creation of input forms.
     * @return view data
     */
    public function action_fieldset() {
	
	$output =""; //the generated output will be collected here
	
	$eventinstance = new Model_Orm_Event();
	//a new form which is identified as "eventform" 
	//in current view 
	$inputform = Fuel\Core\Fieldset::forge("eventform");
	
	//the fieldset class loads field information from our model
	$inputform->add_model($eventinstance);
	
	//since the location field should be a drop-down select box,
	//we add it manually.
	//The actual list of locations is loaded by the Model_Orm_Location model
        $inputform->add("location", "Select a location", 
			array(
			"type"=>"select",
			"name" =>"location_id",
			"options"=>
				Model_Orm_Location::get_locations()));

	//the Fieldset does not automatically add buttons, hence we do
	$inputform->add("submit", "",
			   array( "type"  =>  "submit",
				  "value"  =>  "Add" ,
				  "class"  =>  "btn medium primary" ));
	//this re-loads data from $_POST array if the form is re-submitted.
	$inputform->repopulate();

	//execute validations described in the model class
	if ($inputform->validation()->run()) {
	    //this is the good case!
	   $new_event = Model_Orm_Event::forge();
	   $fields = $inputform->validated();
	   $new_event->title = $fields["title"];
	   $new_event->description = $fields["description"];
	   $new_event->start = time();
	   $new_event->save();
	   //always do a redirect after saving an item!
	   Response::redirect("event/orm");
	   
	} else {
	    //there have been some problems, output them to the client
	    foreach ($inputform->validation()->error() as $error) {
		$output.="<p>".$error."</p>";
	    }
	}
	//the 'build' actually generates all HTML code
	$output .= $inputform->build();
	return Response::forge($output);
	
    }
    
    /**
     * demonstrates how ORM models can be used for loading 
     * DB information as well as creating new items or editing them.
     * @return view data
     */
    public function action_orm(){
	
	$demo_event = new Model_Orm_Event();
	$demo_event->title="Lecture demo";
	$demo_event->description="blabla";
	$demo_event->start = time();
	//$demo_event->save();
	
	$first_event = Model_Orm_Event::find(1);
	$first_event->title = "Modified title";
	$first_event->save();
	
	
	$events = Model_Orm_Event::find("all", 
			array('related' => array('agendas', 
						 'location'))
		    );
	
	$output = "";
	foreach ($events as $event) {
	    $output .= "=======\r\n";  
	    $output .= $event->title . "\r\n"; 
	     $output .= $event->description. "\r\n";
	     if (isset($event->location) && isset($event->location->title)) {
		$output .= $event->location->title .$event->location->id . "\r\n";
	     }
	     foreach ($event->agendas as $agenda) {
		$output .= "-" . $agenda->title."\r\n";
	     }
	}
	
	$response = Response::forge($output);
	$response->set_header("Content-Type", "text/plain");
	return $response;
    } 
}