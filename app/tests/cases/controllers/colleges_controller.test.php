<?php
/* Colleges Test cases generated on: 2010-10-29 11:10:07 : 1288336447*/
App::import('Controller', 'Colleges');

class TestCollegesController extends CollegesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CollegesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.college', 'app.campus', 'app.university', 'app.location', 'app.location_type', 'app.college_detail', 'app.instructor', 'app.department', 'app.course', 'app.department_detail', 'app.program', 'app.stream', 'app.program_type', 'app.enrollment_type', 'app.program_level', 'app.curriculum', 'app.section', 'app.instructor_department');

	function startTest() {
		$this->Colleges =& new TestCollegesController();
		$this->Colleges->constructClasses();
	}

	function endTest() {
		unset($this->Colleges);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testIndex2() {

	}

	function testSearch() {

	}

	function testListDatum() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>