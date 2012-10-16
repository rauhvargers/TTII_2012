<?php

class View_Event_List extends ViewModel
{
	/**
	 * Demonstration of how ViewModel can add more properties
	 * to view data.
	 */
	public function view() {
	    parent::view();
	    $this->generation_time = date("H:i:s u");
	}
}
