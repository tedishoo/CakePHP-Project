<?php
/* Person Fixture generated on: 2010-11-24 12:11:58 : 1290591658 */
class PersonFixture extends CakeTestFixture {
	var $name = 'Person';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'first_name' => array('type' => 'string', 'null' => false, 'length' => 100),
		'middle_name' => array('type' => 'string', 'null' => false, 'length' => 100),
		'last_name' => array('type' => 'string', 'null' => false, 'length' => 100),
		'birthdate' => array('type' => 'date', 'null' => false),
		'birth_location_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'residence_location_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'nationality_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'kebele_or_farmers_association' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'house_number' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4cecddaa-c8f8-471c-83e1-02980d5f2a32',
			'first_name' => 'Lorem ipsum dolor sit amet',
			'middle_name' => 'Lorem ipsum dolor sit amet',
			'last_name' => 'Lorem ipsum dolor sit amet',
			'birthdate' => '2010-11-24',
			'birth_location_id' => 'Lorem ipsum dolor sit amet',
			'residence_location_id' => 'Lorem ipsum dolor sit amet',
			'nationality_id' => 'Lorem ipsum dolor sit amet',
			'kebele_or_farmers_association' => 'Lorem ipsum dolor sit amet',
			'house_number' => 'Lorem ipsum dolor '
		),
	);
}
?>