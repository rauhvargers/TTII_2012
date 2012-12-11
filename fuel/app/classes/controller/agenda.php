<?php

/**
 * Things you can do with an agenda item
 */
class Controller_Agenda extends Controller_Template {

    /**
     * Returns a list of event agenda items.
     * The method is mainly intended to be called using ajax
     * in this case, a json-formated string is returned.
     * @param int $event_id
     */
    public function action_index($event_id = null) {
	!isset($event_id) and Response::redirect("event");

	$event = Model_Orm_Event::find($event_id, array(
		    "related" =>
		    array("agendas")
		));
	!isset($event) and Response::redirect("event");

	if (Input::is_ajax()) {
	    $response = Response::forge(
			    Format::forge()->to_json($event->agendas)
	    );
	    $response->set_header("Content-Type", "application/json");
	    return $response;
	} else {
	    $data['event'] = $event;
	    $this->template->title = "Agenda items: " . $event->title;
	    $this->template->content = View::forge('agenda/index', $data);
	}
    }

    /**
     * Adding a new agenda item to the event
     * @param int $event_id
     */
    public function action_create($event_id = null) {

	is_null($event_id) and Response::redirect("event");

	$event = Model_Orm_Event::find($event_id);

	if (Input::method() == 'POST') {
	    $val = Model_Orm_Agenda::validate('create');
	    if ($val->run()) {
		$agenda = Model_Orm_Agenda::forge(
				array(
				    'title' => $val->validated('title')
			));
		$agenda->event = $event;

		if ($agenda and $agenda->save()) {
		    Session::set_flash('success', 'Added a new agenda item to the event "' . $event->title . '".');

		    Response::redirect('event/view/' . $event_id);
		} else {
		    Session::set_flash('error', 'Could not save the agenda item.');
		}
	    } else {
		Session::set_flash('error', $val->error());
	    }
	}

	$this->template->title = "Adding agenda items to `" . $event->title . "`.";
	$this->template->content = View::forge('agenda/create');
    }

    public function action_delete($id = null) {
	if ($item = Model_Orm_Agenda::find($id)) {
	    $title = $item->title;
	    $event_id = $item->event_id;
	    $item->delete();

	    Session::set_flash('success', 'Deleted the agenda item "' . $title . "'");
	} else {
	    Session::set_flash('error', 'Could not delete agenda item "' . $title . '"');
	}

	Response::redirect('event/view/' . $event_id);
    }

}