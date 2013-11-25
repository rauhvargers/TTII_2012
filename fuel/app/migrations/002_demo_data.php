<?php

namespace Fuel\Migrations;

class Demo_data
{
	public function up()
	{
	    //we'll need some places where the events can take place
	    $locations=['Rīga', 'Valmiera', 'Ventspils'];
	    foreach ($locations as $location) {
		$loc = \Model_Orm_Location::forge();
		$loc->title=$location;
		$loc->save();
	    }
	    
	    //and let's create at least one event as well
	    $demo_event = \Model_Orm_Event::forge();
	    $demo_event->title="Notikums pēc nedēļas";
	    $demo_event->description = "Kaut kas, kam jānotiek nedēļu vēlāk nekā šī skripta izpilde.";
	    $startdate = \Fuel\Core\Date::forge(time() + (7 * 24 * 60 * 60));
	    $demo_event->start = $startdate->format('mysql', false); //'2013-11-27 07:00:00';
	    $demo_event->location_id = 1; //pieņemsim, ka Rīgā;
	    $demo_event->save();
	    
	    //the event shouldn't be empty - some agenda items
	    $agenda_items = ['Notikuma pats, pats sākums',
			     'Kaut kad drusku vēlāk', 
			     'Vēl mazliet vēlāk',
			     'Un nu jau arī beigas'];
	    foreach ($agenda_items as $agenda_item) {
		$demo_agenda = \Model_Orm_Agenda::forge();
		$demo_agenda->title = $agenda_item;
		$demo_agenda->event = $demo_event;
		$demo_agenda->save();
	    }
	    
	    //we also need some users. at least two.
	    \Auth::instance()->create_user(
			"admin@eventual.org", //username = email
			"fuel_dev",
			"admin@eventual.org",
			100, //admin
			array("verified" => true,
			      "verification_key" => md5(mt_rand(0, mt_getrandmax())))
			);
	    \Auth::instance()->create_user(
			"user@eventual.org", //username = email
			"fuel_dev",
			"user@eventual.org",
			1, //simple user
			array("verified" => true,
			      "verification_key" => md5(mt_rand(0, mt_getrandmax())))
			);
	    
	    
	}

	public function down()
	{
		\DBUtil::truncate_table('location');
		\DBUtil::truncate_table('events');
		\DBUtil::truncate_table('agenda');
		\DBUtil::truncate_table('countries');
		\DBUtil::truncate_table('users');
	}
}