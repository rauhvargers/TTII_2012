<?php
use Orm\Model;

class Model_Country extends Model
{
	protected static $_properties = array(
		'id',
		'name',
		'iso_code',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[255]');
		$val->add_field('iso_code', 'Iso Code', 'required|max_length[3]');

		return $val;
	}

}
