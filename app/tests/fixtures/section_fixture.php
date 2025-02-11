<?php
/* Section Fixture generated on: 2011-01-05 10:01:07 : 1294212487 */
class SectionFixture extends CakeTestFixture {
	var $name = 'Section';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary'),
		'program_id' => array('type' => 'string', 'null' => false, 'length' => 36),
		'academic_year_id' => array('type' => 'string', 'null' => false, 'length' => 50),
		'year' => array('type' => 'boolean', 'null' => false),
		'semester' => array('type' => 'boolean', 'null' => false),
		'section_number' => array('type' => 'integer', 'null' => false, 'length' => 2),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d241d87-19dc-4f32-b91b-04d80d5f2a32',
			'program_id' => 'Lorem ipsum dolor sit amet',
			'academic_year_id' => 'Lorem ipsum dolor sit amet',
			'year' => 1,
			'semester' => 1,
			'section_number' => 1
		),
	);
}
?>