<?php

namespace Fuel\Migrations;

class Create_structure
{
	public function up()
	{
		\DBUtil::create_table(
			'location', //table name
			array( //columns
			    'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			    'title' => array('constraint' => 255, 'type' => 'varchar')
			), 
			array('id') //primary key
			);
		\DBUtil::create_table('events', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'description' => array('type' => 'text','null'=>true),
			'location_id' => array('constraint' => 11, 'type' => 'int'),
		    	'start' => array('type' => 'datetime'),
			'poster' => array('constraint'=>255, 'type'=>'varchar', 'null'=>true)
			), array('id'));
		
		\DBUtil::create_table(
			'agenda', //table name
			array( //columns
			    'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			    'title' => array('constraint' => 255, 'type' => 'varchar'),
			    'event_id' => array('constraint' => 11, 'type' => 'int'),
			), 
			array('id') //primary key
			);

		\DBUtil::create_table('countries', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'iso_code' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));

		
		\DBUtil::create_table('users', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'username' => array('constraint' => 50, 'type' => 'varchar'),
			'password' => array('constraint' => 255, 'type' => 'varchar'),
			'group' => array('constraint' => 11, 'type' => 'int'),
			'email' => array('constraint' => 255, 'type' => 'varchar'),
			'last_login' => array('constraint' => 25, 'type' => 'varchar'),
			'login_hash' => array('constraint' => 255, 'type' => 'varchar'),
			'profile_fields' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int')
		), array('id'));

		
	}

	public function down()
	{
		\DBUtil::drop_table('location');
		\DBUtil::drop_table('events');
		\DBUtil::drop_table('agenda');
		\DBUtil::drop_table('countries');
		\DBUtil::drop_table('users');
	}
}