<?php

/**
 * Works with events table.
 *
 * @author krissr
 */
class Model_Crudevent extends \Model_Crud {
      protected static $_table_name = 'events';
      protected static $_properties = array('id', 'title');
      
}