<?php
/* Section Test cases generated on: 2011-01-05 10:01:08 : 1294212488*/
App::import('Model', 'Section');

class SectionTestCase extends CakeTestCase {
	var $fixtures = array('app.section', 'app.program', 'app.department', 'app.college', 'app.campus', 'app.university', 'app.location', 'app.location_type', 'app.college_detail', 'app.instructor', 'app.academic_position', 'app.management_position', 'app.employment_type', 'app.user', 'app.person', 'app.nationality', 'app.group', 'app.permission', 'app.groups_permission', 'app.groups_user', 'app.department_detail', 'app.course_offering', 'app.courses_curriculum_breakdown', 'app.curriculum_breakdown', 'app.curriculum', 'app.course', 'app.grading_type', 'app.course_category', 'app.composition', 'app.compositions_course', 'app.stream', 'app.program_type', 'app.enrollment_type', 'app.program_level', 'app.academic_year');

	function startTest() {
		$this->Section =& ClassRegistry::init('Section');
	}

	function endTest() {
		unset($this->Section);
		ClassRegistry::flush();
	}

}
?>