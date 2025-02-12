<?php
/**
 * SetTest file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <http://book.cakephp.org/view/1196/Testing>
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://book.cakephp.org/view/1196/Testing CakePHP(tm) Tests
 * @package       cake
 * @subpackage    cake.tests.cases.libs
 * @since         CakePHP(tm) v 1.2.0.4206
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
App::import('Core', 'Set');

/**
 * SetTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs
 */
class SetTest extends CakeTestCase {

/**
 * testNumericKeyExtraction method
 *
 * @access public
 * @return void
 */
	function testNumericKeyExtraction() {
		$data = array('plugin' => null, 'controller' => '', 'action' => '', 1, 'whatever');
		$this->assertIdentical(Set::extract($data, '{n}'), array(1, 'whatever'));
		$this->assertIdentical(Set::diff($data, Set::extract($data, '{n}')), array('plugin' => null, 'controller' => '', 'action' => ''));
	}

/**
 * testEnum method
 *
 * @access public
 * @return void
 */
	function testEnum() {
		$result = Set::enum(1, 'one, two');
		$this->assertIdentical($result, 'two');
		$result = Set::enum(2, 'one, two');
		$this->assertNull($result);

		$set = array('one', 'two');
		$result = Set::enum(0, $set);
		$this->assertIdentical($result, 'one');
		$result = Set::enum(1, $set);
		$this->assertIdentical($result, 'two');

		$result = Set::enum(1, array('one', 'two'));
		$this->assertIdentical($result, 'two');
		$result = Set::enum(2, array('one', 'two'));
		$this->assertNull($result);

		$result = Set::enum('first', array('first' => 'one', 'second' => 'two'));
		$this->assertIdentical($result, 'one');
		$result = Set::enum('third', array('first' => 'one', 'second' => 'two'));
		$this->assertNull($result);

		$result = Set::enum('no', array('no' => 0, 'yes' => 1));
		$this->assertIdentical($result, 0);
		$result = Set::enum('not sure', array('no' => 0, 'yes' => 1));
		$this->assertNull($result);

		$result = Set::enum(0);
		$this->assertIdentical($result, 'no');
		$result = Set::enum(1);
		$this->assertIdentical($result, 'yes');
		$result = Set::enum(2);
		$this->assertNull($result);
	}

/**
 * testFilter method
 *
 * @access public
 * @return void
 */
	function testFilter() {
		$result = Set::filter(array('0', false, true, 0, array('one thing', 'I can tell you', 'is you got to be', false)));
		$expected = array('0', 2 => true, 3 => 0, 4 => array('one thing', 'I can tell you', 'is you got to be', false));
		$this->assertIdentical($result, $expected);
	}

/**
 * testNumericArrayCheck method
 *
 * @access public
 * @return void
 */
	function testNumericArrayCheck() {
		$data = array('one');
		$this->assertTrue(Set::numeric(array_keys($data)));

		$data = array(1 => 'one');
		$this->assertFalse(Set::numeric($data));

		$data = array('one');
		$this->assertFalse(Set::numeric($data));

		$data = array('one' => 'two');
		$this->assertFalse(Set::numeric($data));

		$data = array('one' => 1);
		$this->assertTrue(Set::numeric($data));

		$data = array(0);
		$this->assertTrue(Set::numeric($data));

		$data = array('one', 'two', 'three', 'four', 'five');
		$this->assertTrue(Set::numeric(array_keys($data)));

		$data = array(1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five');
		$this->assertTrue(Set::numeric(array_keys($data)));

		$data = array('1' => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five');
		$this->assertTrue(Set::numeric(array_keys($data)));

		$data = array('one', 2 => 'two', 3 => 'three', 4 => 'four', 'a' => 'five');
		$this->assertFalse(Set::numeric(array_keys($data)));
	}

/**
 * testKeyCheck method
 *
 * @access public
 * @return void
 */
	function testKeyCheck() {
		$data = array('Multi' => array('dimensonal' => array('array')));
		$this->assertTrue(Set::check($data, 'Multi.dimensonal'));
		$this->assertFalse(Set::check($data, 'Multi.dimensonal.array'));

		$data = array(
			array(
				'Article' => array('id' => '1', 'user_id' => '1', 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'),
				'User' => array('id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(
					array('id' => '1', 'article_id' => '1', 'user_id' => '2', 'comment' => 'First Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:45:23', 'updated' => '2007-03-18 10:47:31'),
					array('id' => '2', 'article_id' => '1', 'user_id' => '4', 'comment' => 'Second Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:47:23', 'updated' => '2007-03-18 10:49:31'),
				),
				'Tag' => array(
					array('id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
					array('id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31')
				)
			),
			array(
				'Article' => array('id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'),
				'User' => array('id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(),
				'Tag' => array()
			)
		);
		$this->assertTrue(Set::check($data, '0.Article.user_id'));
		$this->assertTrue(Set::check($data, '0.Comment.0.id'));
		$this->assertFalse(Set::check($data, '0.Comment.0.id.0'));
		$this->assertTrue(Set::check($data, '0.Article.user_id'));
		$this->assertFalse(Set::check($data, '0.Article.user_id.a'));
	}

/**
 * testMerge method
 *
 * @access public
 * @return void
 */
	function testMerge() {
		$r = Set::merge(array('foo'));
		$this->assertIdentical($r, array('foo'));

		$r = Set::merge('foo');
		$this->assertIdentical($r, array('foo'));

		$r = Set::merge('foo', 'bar');
		$this->assertIdentical($r, array('foo', 'bar'));

		if (substr(PHP_VERSION, 0, 1) >= 5) {
			$r = eval('class StaticSetCaller{static function merge($a, $b){return Set::merge($a, $b);}} return StaticSetCaller::merge("foo", "bar");');
			$this->assertIdentical($r, array('foo', 'bar'));
		}

		$r = Set::merge('foo', array('user' => 'bob', 'no-bar'), 'bar');
		$this->assertIdentical($r, array('foo', 'user' => 'bob', 'no-bar', 'bar'));

		$a = array('foo', 'foo2');
		$b = array('bar', 'bar2');
		$this->assertIdentical(Set::merge($a, $b), array('foo', 'foo2', 'bar', 'bar2'));

		$a = array('foo' => 'bar', 'bar' => 'foo');
		$b = array('foo' => 'no-bar', 'bar' => 'no-foo');
		$this->assertIdentical(Set::merge($a, $b), array('foo' => 'no-bar', 'bar' => 'no-foo'));

		$a = array('users' => array('bob', 'jim'));
		$b = array('users' => array('lisa', 'tina'));
		$this->assertIdentical(Set::merge($a, $b), array('users' => array('bob', 'jim', 'lisa', 'tina')));

		$a = array('users' => array('jim', 'bob'));
		$b = array('users' => 'none');
		$this->assertIdentical(Set::merge($a, $b), array('users' => 'none'));

		$a = array('users' => array('lisa' => array('id' => 5, 'pw' => 'secret')), 'cakephp');
		$b = array('users' => array('lisa' => array('pw' => 'new-pass', 'age' => 23)), 'ice-cream');
		$this->assertIdentical(Set::merge($a, $b), array('users' => array('lisa' => array('id' => 5, 'pw' => 'new-pass', 'age' => 23)), 'cakephp', 'ice-cream'));

		$c = array('users' => array('lisa' => array('pw' => 'you-will-never-guess', 'age' => 25, 'pet' => 'dog')), 'chocolate');
		$expected = array('users' => array('lisa' => array('id' => 5, 'pw' => 'you-will-never-guess', 'age' => 25, 'pet' => 'dog')), 'cakephp', 'ice-cream', 'chocolate');
		$this->assertIdentical(Set::merge($a, $b, $c), $expected);

		$this->assertIdentical(Set::merge($a, $b, array(), $c), $expected);

		$r = Set::merge($a, $b, $c);
		$this->assertIdentical($r, $expected);

		$a = array('Tree', 'CounterCache',
				'Upload' => array('folder' => 'products',
					'fields' => array('image_1_id', 'image_2_id', 'image_3_id', 'image_4_id', 'image_5_id')));
		$b =  array('Cacheable' => array('enabled' => false),
				'Limit',
				'Bindable',
				'Validator',
				'Transactional');

		$expected = array('Tree', 'CounterCache',
				'Upload' => array('folder' => 'products',
					'fields' => array('image_1_id', 'image_2_id', 'image_3_id', 'image_4_id', 'image_5_id')),
				'Cacheable' => array('enabled' => false),
				'Limit',
				'Bindable',
				'Validator',
				'Transactional');

		$this->assertIdentical(Set::merge($a, $b), $expected);

		$expected = array('Tree' => null, 'CounterCache' => null,
				'Upload' => array('folder' => 'products',
					'fields' => array('image_1_id', 'image_2_id', 'image_3_id', 'image_4_id', 'image_5_id')),
				'Cacheable' => array('enabled' => false),
				'Limit' => null,
				'Bindable' => null,
				'Validator' => null,
				'Transactional' => null);

		$this->assertIdentical(Set::normalize(Set::merge($a, $b)), $expected);
	}

/**
 * testSort method
 *
 * @access public
 * @return void
 */
	function testSort() {
		$a = array(
			0 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate'))),
			1 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay')))
		);
		$b = array(
			0 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay'))),
			1 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate')))

		);
		$a = Set::sort($a, '{n}.Friend.{n}.name', 'asc');
		$this->assertIdentical($a, $b);

		$b = array(
			0 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate'))),
			1 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay')))
		);
		$a = array(
			0 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay'))),
			1 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate')))

		);
		$a = Set::sort($a, '{n}.Friend.{n}.name', 'desc');
		$this->assertIdentical($a, $b);

		$a = array(
			0 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate'))),
			1 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay'))),
			2 => array('Person' => array('name' => 'Adam'),'Friend' => array(array('name' => 'Bob')))
		);
		$b = array(
			0 => array('Person' => array('name' => 'Adam'),'Friend' => array(array('name' => 'Bob'))),
			1 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate'))),
			2 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay')))
		);
		$a = Set::sort($a, '{n}.Person.name', 'asc');
		$this->assertIdentical($a, $b);

		$a = array(
			array(7,6,4),
			array(3,4,5),
			array(3,2,1),
		);

		$b = array(
			array(3,2,1),
			array(3,4,5),
			array(7,6,4),
		);

		$a = Set::sort($a, '{n}.{n}', 'asc');
		$this->assertIdentical($a, $b);

		$a = array(
			array(7,6,4),
			array(3,4,5),
			array(3,2,array(1,1,1)),
		);

		$b = array(
			array(3,2,array(1,1,1)),
			array(3,4,5),
			array(7,6,4),
		);

		$a = Set::sort($a, '{n}', 'asc');
		$this->assertIdentical($a, $b);

		$a = array(
			0 => array('Person' => array('name' => 'Jeff')),
			1 => array('Shirt' => array('color' => 'black'))
		);
		$b = array(
			0 => array('Shirt' => array('color' => 'black')),
			1 => array('Person' => array('name' => 'Jeff')),
		);
		$a = Set::sort($a, '{n}.Person.name', 'ASC');
		$this->assertIdentical($a, $b);

		$names = array(
			array('employees' => array(array('name' => array('first' => 'John', 'last' => 'Doe')))),
			array('employees' => array(array('name' => array('first' => 'Jane', 'last' => 'Doe')))),
			array('employees' => array(array('name' => array()))),
			array('employees' => array(array('name' => array())))
		);
		$result = Set::sort($names, '{n}.employees.0.name', 'asc', 1);
		$expected = array(
			array('employees' => array(array('name' => array('first' => 'John', 'last' => 'Doe')))),
			array('employees' => array(array('name' => array('first' => 'Jane', 'last' => 'Doe')))),
			array('employees' => array(array('name' => array()))),
			array('employees' => array(array('name' => array())))
		);
		$this->assertEqual($result, $expected);
	}

/**
 * testExtract method
 *
 * @access public
 * @return void
 */
	function testExtract() {
		$a = array(
			array(
				'Article' => array('id' => '1', 'user_id' => '1', 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'),
				'User' => array('id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(
					array('id' => '1', 'article_id' => '1', 'user_id' => '2', 'comment' => 'First Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:45:23', 'updated' => '2007-03-18 10:47:31'),
					array('id' => '2', 'article_id' => '1', 'user_id' => '4', 'comment' => 'Second Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:47:23', 'updated' => '2007-03-18 10:49:31'),
				),
				'Tag' => array(
					array('id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
					array('id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31')
				),
				'Deep' => array(
					'Nesting' => array(
						'test' => array(
							1 => 'foo',
							2 => array(
								'and' => array('more' => 'stuff')
							)
						)
					)
				)
			),
			array(
				'Article' => array('id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'),
				'User' => array('id' => '2', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(),
				'Tag' => array()
			),
			array(
				'Article' => array('id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'),
				'User' => array('id' => '3', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(),
				'Tag' => array()
			),
			array(
				'Article' => array('id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'),
				'User' => array('id' => '4', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(),
				'Tag' => array()
			),
			array(
				'Article' => array('id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'),
				'User' => array('id' => '5', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(),
				'Tag' => array()
			)
		);
		$b = array('Deep' => $a[0]['Deep']);
		$c = array(
			array('a' => array('I' => array('a' => 1))),
			array(
				'a' => array(
					2
				)
			),
			array('a' => array('II' => array('a' => 3, 'III' => array('a' => array('foo' => 4))))),
		);

		$expected = array(array('a' => $c[2]['a']));
		$r = Set::extract('/a/II[a=3]/..', $c);
		$this->assertEqual($r, $expected);

		$expected = array(1, 2, 3, 4, 5);
		$this->assertEqual(Set::extract('/User/id', $a), $expected);

		$expected = array(1, 2, 3, 4, 5);
		$this->assertEqual(Set::extract('/User/id', $a), $expected);

		$expected = array(
			array('id' => 1), array('id' => 2), array('id' => 3), array('id' => 4), array('id' => 5)
		);

		$r = Set::extract('/User/id', $a, array('flatten' => false));
		$this->assertEqual($r, $expected);

		$expected = array(array('test' => $a[0]['Deep']['Nesting']['test']));
		$this->assertEqual(Set::extract('/Deep/Nesting/test', $a), $expected);
		$this->assertEqual(Set::extract('/Deep/Nesting/test', $b), $expected);

		$expected = array(array('test' => $a[0]['Deep']['Nesting']['test']));
		$r = Set::extract('/Deep/Nesting/test/1/..', $a);
		$this->assertEqual($r, $expected);

		$expected = array(array('test' => $a[0]['Deep']['Nesting']['test']));
		$r = Set::extract('/Deep/Nesting/test/2/and/../..', $a);
		$this->assertEqual($r, $expected);

		$expected = array(array('test' => $a[0]['Deep']['Nesting']['test']));
		$r = Set::extract('/Deep/Nesting/test/2/../../../Nesting/test/2/..', $a);
		$this->assertEqual($r, $expected);

		$expected = array(2);
		$r = Set::extract('/User[2]/id', $a);
		$this->assertEqual($r, $expected);

		$expected = array(4, 5);
		$r = Set::extract('/User[id>3]/id', $a);
		$this->assertEqual($r, $expected);

		$expected = array(2, 3);
		$r = Set::extract('/User[id>1][id<=3]/id', $a);
		$this->assertEqual($r, $expected);

		$expected = array(array('I'), array('II'));
		$r = Set::extract('/a/@*', $c);
		$this->assertEqual($r, $expected);

		$single = array(
			'User' => array(
				'id' => 4,
				'name' => 'Neo',
			)
		);
		$tricky = array(
			0 => array(
				'User' => array(
					'id' => 1,
					'name' => 'John',
				)
			),
			1 => array(
				'User' => array(
					'id' => 2,
					'name' => 'Bob',
				)
			),
			2 => array(
				'User' => array(
					'id' => 3,
					'name' => 'Tony',
				)
			),
			'User' => array(
				'id' => 4,
				'name' => 'Neo',
			)
		);

		$expected = array(1, 2, 3, 4);
		$r = Set::extract('/User/id', $tricky);
		$this->assertEqual($r, $expected);

		$expected = array(4);
		$r = Set::extract('/User/id', $single);
		$this->assertEqual($r, $expected);

		$expected = array(1, 3);
		$r = Set::extract('/User[name=/n/]/id', $tricky);
		$this->assertEqual($r, $expected);

		$expected = array(4);
		$r = Set::extract('/User[name=/N/]/id', $tricky);
		$this->assertEqual($r, $expected);

		$expected = array(1, 3, 4);
		$r = Set::extract('/User[name=/N/i]/id', $tricky);
		$this->assertEqual($r, $expected);

		$expected = array(array('id', 'name'), array('id', 'name'), array('id', 'name'), array('id', 'name'));
		$r = Set::extract('/User/@*', $tricky);
		$this->assertEqual($r, $expected);

		$common = array(
			array(
				'Article' => array(
					'id' => 1,
					'name' => 'Article 1',
				),
				'Comment' => array(
					array(
						'id' => 1,
						'user_id' => 5,
						'article_id' => 1,
						'text' => 'Comment 1',
					),
					array(
						'id' => 2,
						'user_id' => 23,
						'article_id' => 1,
						'text' => 'Comment 2',
					),
					array(
						'id' => 3,
						'user_id' => 17,
						'article_id' => 1,
						'text' => 'Comment 3',
					),
				),
			),
			array(
				'Article' => array(
					'id' => 2,
					'name' => 'Article 2',
				),
				'Comment' => array(
					array(
						'id' => 4,
						'user_id' => 2,
						'article_id' => 2,
						'text' => 'Comment 4',
						'addition' => '',
					),
					array(
						'id' => 5,
						'user_id' => 23,
						'article_id' => 2,
						'text' => 'Comment 5',
						'addition' => 'foo',
					),
				),
			),
			array(
				'Article' => array(
					'id' => 3,
					'name' => 'Article 3',
				),
				'Comment' => array(),
			)
		);

		$r = Set::extract('/Comment/id', $common);
		$expected = array(1, 2, 3, 4, 5);
		$this->assertEqual($r, $expected);

		$expected = array(1, 2, 4, 5);
		$r = Set::extract('/Comment[id!=3]/id', $common);
		$this->assertEqual($r, $expected);

		$r = Set::extract('/', $common);
		$this->assertEqual($r, $common);

		$expected = array(1, 2, 4, 5);
		$r = Set::extract($common, '/Comment[id!=3]/id');
		$this->assertEqual($r, $expected);

		$expected = array($common[0]['Comment'][2]);
		$r = Set::extract($common, '/Comment/2');
		$this->assertEqual($r, $expected);

		$expected = array($common[0]['Comment'][0]);
		$r = Set::extract($common, '/Comment[1]/.[id=1]');
		$this->assertEqual($r, $expected);

		$expected = array($common[1]['Comment'][1]);
		$r = Set::extract($common, '/1/Comment/.[2]');
		$this->assertEqual($r, $expected);

		$expected = array();
		$r = Set::extract('/User/id', array());
		$this->assertEqual($r, $expected);

		$expected = array(5);
		$r = Set::extract('/Comment/id[:last]', $common);
		$this->assertEqual($r, $expected);

		$expected = array(1);
		$r = Set::extract('/Comment/id[:first]', $common);
		$this->assertEqual($r, $expected);

		$expected = array(3);
		$r = Set::extract('/Article[:last]/id', $common);
		$this->assertEqual($r, $expected);

		$expected = array(array('Comment' => $common[1]['Comment'][0]));
		$r = Set::extract('/Comment[addition=]', $common);
		$this->assertEqual($r, $expected);

		$habtm = array(
			array(
				'Post' => array(
					'id' => 1,
					'title' => 'great post',
				),
				'Comment' => array(
					array(
						'id' => 1,
						'text' => 'foo',
						'User' => array(
							'id' => 1,
							'name' => 'bob'
						),
					),
					array(
						'id' => 2,
						'text' => 'bar',
						'User' => array(
							'id' => 2,
							'name' => 'tod'
						),
					),
				),
			),
			array(
				'Post' => array(
					'id' => 2,
					'title' => 'fun post',
				),
				'Comment' => array(
					array(
						'id' => 3,
						'text' => '123',
						'User' => array(
							'id' => 3,
							'name' => 'dan'
						),
					),
					array(
						'id' => 4,
						'text' => '987',
						'User' => array(
							'id' => 4,
							'name' => 'jim'
						),
					),
				),
			),
		);

		$r = Set::extract('/Comment/User[name=/bob|dan/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');
		$this->assertEqual($r[1]['Comment']['User']['name'], 'dan');
		$this->assertEqual(count($r), 2);

		$r = Set::extract('/Comment/User[name=/bob|tod/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');

		$this->assertEqual($r[1]['Comment']['User']['name'], 'tod');
		$this->assertEqual(count($r), 2);

		$tree = array(
			array(
				'Category' => array('name' => 'Category 1'),
				'children' => array(array('Category' => array('name' => 'Category 1.1')))
			),
			array(
				'Category' => array('name' => 'Category 2'),
				'children' => array(
					array('Category' => array('name' => 'Category 2.1')),
					array('Category' => array('name' => 'Category 2.2'))
				)
			),
			array(
				'Category' => array('name' => 'Category 3'),
				'children' => array(array('Category' => array('name' => 'Category 3.1')))
			)
		);

		$expected = array(array('Category' => $tree[1]['Category']));
		$r = Set::extract('/Category[name=Category 2]', $tree);
		$this->assertEqual($r, $expected);

		$expected = array(
			array('Category' => $tree[1]['Category'], 'children' => $tree[1]['children'])
		);
		$r = Set::extract('/Category[name=Category 2]/..', $tree);
		$this->assertEqual($r, $expected);

		$expected = array(
			array('children' => $tree[1]['children'][0]),
			array('children' => $tree[1]['children'][1])
		);
		$r = Set::extract('/Category[name=Category 2]/../children', $tree);
		$this->assertEqual($r, $expected);

		$habtm = array(
			array(
				'Post' => array(
					'id' => 1,
					'title' => 'great post',
				),
				'Comment' => array(
					array(
						'id' => 1,
						'text' => 'foo',
						'User' => array(
							'id' => 1,
							'name' => 'bob'
						),
					),
					array(
						'id' => 2,
						'text' => 'bar',
						'User' => array(
							'id' => 2,
							'name' => 'tod'
						),
					),
				),
			),
			array(
				'Post' => array(
					'id' => 2,
					'title' => 'fun post',
				),
				'Comment' => array(
					array(
						'id' => 3,
						'text' => '123',
						'User' => array(
							'id' => 3,
							'name' => 'dan'
						),
					),
					array(
						'id' => 4,
						'text' => '987',
						'User' => array(
							'id' => 4,
							'name' => 'jim'
						),
					),
				),
			),
		);

		$r = Set::extract('/Comment/User[name=/\w+/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');
		$this->assertEqual($r[1]['Comment']['User']['name'], 'tod');
		$this->assertEqual($r[2]['Comment']['User']['name'], 'dan');
		$this->assertEqual($r[3]['Comment']['User']['name'], 'dan');
		$this->assertEqual(count($r), 4);

		$r = Set::extract('/Comment/User[name=/[a-z]+/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');
		$this->assertEqual($r[1]['Comment']['User']['name'], 'tod');
		$this->assertEqual($r[2]['Comment']['User']['name'], 'dan');
		$this->assertEqual($r[3]['Comment']['User']['name'], 'dan');
		$this->assertEqual(count($r), 4);

		$r = Set::extract('/Comment/User[name=/bob|dan/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');
		$this->assertEqual($r[1]['Comment']['User']['name'], 'dan');
		$this->assertEqual(count($r), 2);

		$r = Set::extract('/Comment/User[name=/bob|tod/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');
		$this->assertEqual($r[1]['Comment']['User']['name'], 'tod');
		$this->assertEqual(count($r), 2);

		$mixedKeys = array(
			'User' => array(
				0 => array(
					'id' => 4,
					'name' => 'Neo'
				),
				1 => array(
					'id' => 5,
					'name' => 'Morpheus'
				),
				'stringKey' => array()
			)
		);
		$expected = array('Neo', 'Morpheus');
		$r = Set::extract('/User/name', $mixedKeys);
		$this->assertEqual($r, $expected);

		$f = array(
			array(
				'file' => array(
					'name' => 'zipfile.zip',
					'type' => 'application/zip',
					'tmp_name' => '/tmp/php178.tmp',
					'error' => 0,
					'size' => '564647'
				)
			),
			array(
				'file' => array(
					'name' => 'zipfile2.zip',
					'type' => 'application/x-zip-compressed',
					'tmp_name' => '/tmp/php179.tmp',
					'error' => 0,
					'size' => '354784'
				)
			),
			array(
				'file' => array(
					'name' => 'picture.jpg',
					'type' => 'image/jpeg',
					'tmp_name' => '/tmp/php180.tmp',
					'error' => 0,
					'size' => '21324'
				)
			)
		);
		$expected = array(array('name' => 'zipfile2.zip','type' => 'application/x-zip-compressed','tmp_name' => '/tmp/php179.tmp','error' => 0,'size' => '354784'));
		$r = Set::extract('/file/.[type=application/x-zip-compressed]', $f);
		$this->assertEqual($r, $expected);

		$expected = array(array('name' => 'zipfile.zip','type' => 'application/zip','tmp_name' => '/tmp/php178.tmp','error' => 0,'size' => '564647'));
		$r = Set::extract('/file/.[type=application/zip]', $f);
		$this->assertEqual($r, $expected);

		$hasMany = array(
			'Node' => array(
				'id' => 1,
				'name' => 'First',
				'state' => 50
			),
			'ParentNode' => array(
				0 => array(
					'id' => 2,
					'name' => 'Second',
					'state' => 60,
				)
			)
		);
		$result = Set::extract('/ParentNode/name', $hasMany);
		$expected = array('Second');
		$this->assertEqual($result, $expected);
	}

/**
 * test parent selectors with extract
 *
 * @return void
 */
	function testExtractParentSelector() {
		$tree = array(
			array(
				'Category' => array(
					'name' => 'Category 1'
				),
				'children' => array(
					array(
						'Category' => array(
							'name' => 'Category 1.1'
						)
					)
				)
			),
			array(
				'Category' => array(
					'name' => 'Category 2'
				),
				'children' => array(
					array(
						'Category' => array(
							'name' => 'Category 2.1'
						)
					),
					array(
						'Category' => array(
							'name' => 'Category 2.2'
						)
					),
				)
			),
			array(
				'Category' => array(
					'name' => 'Category 3'
				),
				'children' => array(
					array(
						'Category' => array(
							'name' => 'Category 3.1'
						)
					)
				)
			)
		);
		$expected = array(array('Category' => $tree[1]['Category']));
		$r = Set::extract('/Category[name=Category 2]', $tree);
		$this->assertEqual($r, $expected);

		$expected = array(array('Category' => $tree[1]['Category'], 'children' => $tree[1]['children']));
		$r = Set::extract('/Category[name=Category 2]/..', $tree);
		$this->assertEqual($r, $expected);

		$expected = array(array('children' => $tree[1]['children'][0]), array('children' => $tree[1]['children'][1]));
		$r = Set::extract('/Category[name=Category 2]/../children', $tree);
		$this->assertEqual($r, $expected);

		$single = array(
			array(
				'CallType' => array(
					'name' => 'Internal Voice'
				),
				'x' => array(
					'hour' => 7
				)
			)
		);

		$expected = array(7);
		$r = Set::extract('/CallType[name=Internal Voice]/../x/hour', $single);
		$this->assertEqual($r, $expected);

		$multiple = array(
			array(
				'CallType' => array(
					'name' => 'Internal Voice'
				),
				'x' => array(
					'hour' => 7
				)
			),
			array(
				'CallType' => array(
					'name' => 'Internal Voice'
				),
				'x' => array(
					'hour' => 2
				)
			),
			array(
				'CallType' => array(
					'name' => 'Internal Voice'
				),
				'x' => array(
					'hour' => 1
				)
			)
		);

		$expected = array(7,2,1);
		$r = Set::extract('/CallType[name=Internal Voice]/../x/hour', $multiple);
		$this->assertEqual($r, $expected);

		$a = array(
			'Model' => array(
				'0' => array(
					'id' => 18,
					'SubModelsModel' => array(
						'id' => 1,
						'submodel_id' => 66,
						'model_id' => 18,
						'type' => 1
					),
				),
				'1' => array(
					'id' => 0,
					'SubModelsModel' => array(
						'id' => 2,
						'submodel_id' => 66,
						'model_id' => 0,
						'type' => 1
					),
				),
				'2' => array(
					'id' => 17,
					'SubModelsModel' => array(
						'id' => 3,
						'submodel_id' => 66,
						'model_id' => 17,
						'type' => 2
					),
				),
				'3' => array(
					'id' => 0,
					'SubModelsModel' => array(
						'id' => 4,
						'submodel_id' => 66,
						'model_id' => 0,
						'type' => 2
					)
				)
			)
		);

		$expected = array(
			array(
				'Model' => array(
					'id' => 17,
					'SubModelsModel' => array(
						'id' => 3,
						'submodel_id' => 66,
						'model_id' => 17,
						'type' => 2
					),
				)
			),
			array(
				'Model' => array(
					'id' => 0,
					'SubModelsModel' => array(
						'id' => 4,
						'submodel_id' => 66,
						'model_id' => 0,
						'type' => 2
					)
				)
			)
		);
		$r = Set::extract('/Model/SubModelsModel[type=2]/..', $a);
		$this->assertEqual($r, $expected);
	}

/**
 * test that extract() still works when arrays don't contain a 0 index.
 *
 * @return void
 */
	function testExtractWithNonZeroArrays() {
		$nonZero = array(
			1 => array(
				'User' => array(
					'id' => 1,
					'name' => 'John',
				)
			),
			2 => array(
				'User' => array(
					'id' => 2,
					'name' => 'Bob',
				)
			),
			3 => array(
				'User' => array(
					'id' => 3,
					'name' => 'Tony',
				)
			)
		);
		$expected = array(1, 2, 3);
		$r = Set::extract('/User/id', $nonZero);
		$this->assertEqual($r, $expected);
		
		$expected = array(
			array('User' => array('id' => 1, 'name' => 'John')),
			array('User' => array('id' => 2, 'name' => 'Bob')),
			array('User' => array('id' => 3, 'name' => 'Tony')),
		);
		$result = Set::extract('/User', $nonZero);
		$this->assertEqual($result, $expected);

		$nonSequential = array(
			'User' => array(
				0  => array('id' => 1),
				2  => array('id' => 2),
				6  => array('id' => 3),
				9  => array('id' => 4),
				3  => array('id' => 5),
			),
		);

		$nonZero = array(
			'User' => array(
				2  => array('id' => 1),
				4  => array('id' => 2),
				6  => array('id' => 3),
				9  => array('id' => 4),
				3  => array('id' => 5),
			),
		);

		$expected = array(1, 2, 3, 4, 5);
		$this->assertEqual(Set::extract('/User/id', $nonSequential), $expected);

		$result = Set::extract('/User/id', $nonZero);
		$this->assertEqual($result, $expected, 'Failed non zero array key extract');

		$expected = array(1, 2, 3, 4, 5);
		$this->assertEqual(Set::extract('/User/id', $nonSequential), $expected);

		$result = Set::extract('/User/id', $nonZero);
		$this->assertEqual($result, $expected, 'Failed non zero array key extract');

		$startingAtOne = array(
			'Article' => array(
				1 => array(
					'id' => 1,
					'approved' => 1,
				),
			)
		);

		$expected = array(0 => array('Article' => array('id' => 1, 'approved' => 1)));
		$result = Set::extract('/Article[approved=1]', $startingAtOne);
		$this->assertEqual($result, $expected);
	}
/**
 * testExtractWithArrays method
 *
 * @access public
 * @return void
 */
	function testExtractWithArrays() {
		$data = array(
			'Level1' => array(
				'Level2' => array('test1', 'test2'),
				'Level2bis' => array('test3', 'test4')
			)
		);
		$this->assertEqual(Set::extract('/Level1/Level2', $data), array(array('Level2' => array('test1', 'test2'))));
		$this->assertEqual(Set::extract('/Level1/Level2bis', $data), array(array('Level2bis' => array('test3', 'test4'))));
	}

/**
 * test extract() with elements that have non-array children.
 *
 * @return void
 */
	function testExtractWithNonArrayElements() {
		$data = array(
			'node' => array(
				array('foo'),
				'bar'
			)
		);
		$result = Set::extract('/node', $data);
		$expected = array(
			array('node' => array('foo')),
			'bar'
		);
		$this->assertEqual($result, $expected);

		$data = array(
			'node' => array(
				'foo' => array('bar'),
				'bar' => array('foo')
			)
		);
		$result = Set::extract('/node', $data);
		$expected = array(
			array('foo' => array('bar')),
			array('bar' => array('foo')),
		);
		$this->assertEqual($result, $expected);

		$data = array(
			'node' => array(
				'foo' => array(
					'bar'
				),
				'bar' => 'foo'
			)
		);
		$result = Set::extract('/node', $data);
		$expected = array(
			array('foo' => array('bar')),
			'foo'
		);
		$this->assertEqual($result, $expected);
	}

/**
 * testMatches method
 *
 * @access public
 * @return void
 */
	function testMatches() {
		$a = array(
			array('Article' => array('id' => 1, 'title' => 'Article 1')),
			array('Article' => array('id' => 2, 'title' => 'Article 2')),
			array('Article' => array('id' => 3, 'title' => 'Article 3'))
		);

		$this->assertTrue(Set::matches(array('id=2'), $a[1]['Article']));
		$this->assertFalse(Set::matches(array('id>2'), $a[1]['Article']));
		$this->assertTrue(Set::matches(array('id>=2'), $a[1]['Article']));
		$this->assertFalse(Set::matches(array('id>=3'), $a[1]['Article']));
		$this->assertTrue(Set::matches(array('id<=2'), $a[1]['Article']));
		$this->assertFalse(Set::matches(array('id<2'), $a[1]['Article']));
		$this->assertTrue(Set::matches(array('id>1'), $a[1]['Article']));
		$this->assertTrue(Set::matches(array('id>1', 'id<3', 'id!=0'), $a[1]['Article']));

		$this->assertTrue(Set::matches(array('3'), null, 3));
		$this->assertTrue(Set::matches(array('5'), null, 5));

		$this->assertTrue(Set::matches(array('id'), $a[1]['Article']));
		$this->assertTrue(Set::matches(array('id', 'title'), $a[1]['Article']));
		$this->assertFalse(Set::matches(array('non-existant'), $a[1]['Article']));

		$this->assertTrue(Set::matches('/Article[id=2]', $a));
		$this->assertFalse(Set::matches('/Article[id=4]', $a));
		$this->assertTrue(Set::matches(array(), $a));

		$r = array(
			'Attachment' => array(
				'keep' => array()
			),
			'Comment' => array(
				'keep' => array(
					'Attachment' =>  array(
						'fields' => array(
							0 => 'attachment',
						),
					),
				)
			),
			'User' => array(
				'keep' => array()
			),
			'Article' => array(
				'keep' => array(
					'Comment' =>  array(
						'fields' => array(
							0 => 'comment',
							1 => 'published',
						),
					),
					'User' => array(
						'fields' => array(
							0 => 'user',
						),
					),
				)
			)
		);

		$this->assertTrue(Set::matches('/Article/keep/Comment', $r));
		$this->assertEqual(Set::extract('/Article/keep/Comment/fields', $r), array('comment', 'published'));
		$this->assertEqual(Set::extract('/Article/keep/User/fields', $r), array('user'));


	}

/**
 * testSetExtractReturnsEmptyArray method
 *
 * @access public
 * @return void
 */
	function testSetExtractReturnsEmptyArray() {

		$this->assertIdentical(Set::extract(array(), '/Post/id'), array());

		$this->assertIdentical(Set::extract('/Post/id', array()), array());

		$this->assertIdentical(Set::extract('/Post/id', array(
			array('Post' => array('name' => 'bob')),
			array('Post' => array('name' => 'jim'))
		)), array());

		$this->assertIdentical(Set::extract(array(), 'Message.flash'), null);

	}

/**
 * testClassicExtract method
 *
 * @access public
 * @return void
 */
	function testClassicExtract() {
		$a = array(
			array('Article' => array('id' => 1, 'title' => 'Article 1')),
			array('Article' => array('id' => 2, 'title' => 'Article 2')),
			array('Article' => array('id' => 3, 'title' => 'Article 3'))
		);

		$result = Set::extract($a, '{n}.Article.id');
		$expected = array( 1, 2, 3 );
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a, '{n}.Article.title');
		$expected = array( 'Article 1', 'Article 2', 'Article 3' );
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a, '1.Article.title');
		$expected = 'Article 2';
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a, '3.Article.title');
		$expected = null;
		$this->assertIdentical($result, $expected);

		$a = array(
			array(
				'Article' => array('id' => 1, 'title' => 'Article 1',
				'User' => array('id' => 1, 'username' => 'mariano.iglesias'))
			),
			array(
				'Article' => array('id' => 2, 'title' => 'Article 2',
				'User' => array('id' => 1, 'username' => 'mariano.iglesias'))
			),
			array(
				'Article' => array('id' => 3, 'title' => 'Article 3',
				'User' => array('id' => 2, 'username' => 'phpnut'))
			)
		);

		$result = Set::extract($a, '{n}.Article.User.username');
		$expected = array( 'mariano.iglesias', 'mariano.iglesias', 'phpnut' );
		$this->assertIdentical($result, $expected);

		$a = array(
			array('Article' => array('id' => 1, 'title' => 'Article 1',
				'Comment' => array(
					array('id' => 10, 'title' => 'Comment 10'),
					array('id' => 11, 'title' => 'Comment 11'),
					array('id' => 12, 'title' => 'Comment 12')))),
			array('Article' => array('id' => 2, 'title' => 'Article 2',
				'Comment' => array(
					array('id' => 13, 'title' => 'Comment 13'),
					array('id' => 14, 'title' => 'Comment 14')))),
			array('Article' => array('id' => 3, 'title' => 'Article 3')));

		$result = Set::extract($a, '{n}.Article.Comment.{n}.id');
		$expected = array (array(10, 11, 12), array(13, 14), null);
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a, '{n}.Article.Comment.{n}.title');
		$expected = array(
			array('Comment 10', 'Comment 11', 'Comment 12'),
			array('Comment 13', 'Comment 14'),
			null
		);
		$this->assertIdentical($result, $expected);

		$a = array(array('1day' => '20 sales'), array('1day' => '2 sales'));
		$result = Set::extract($a, '{n}.1day');
		$expected = array('20 sales', '2 sales');
		$this->assertIdentical($result, $expected);

		$a = array(
			'pages'     => array('name' => 'page'),
			'fruites'   => array('name' => 'fruit'),
			0           => array('name' => 'zero')
		);
		$result = Set::extract($a, '{s}.name');
		$expected = array('page','fruit');
		$this->assertIdentical($result, $expected);

		$a = array(
			0 => array('pages' => array('name' => 'page')),
			1 => array('fruites'=> array('name' => 'fruit')),
			'test' => array(array('name' => 'jippi')),
			'dot.test' => array(array('name' => 'jippi'))
		);

		$result = Set::extract($a, '{n}.{s}.name');
		$expected = array(0 => array('page'), 1 => array('fruit'));
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a, '{s}.{n}.name');
		$expected = array(array('jippi'), array('jippi'));
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a,'{\w+}.{\w+}.name');
		$expected = array(
			array('pages' => 'page'),
			array('fruites' => 'fruit'),
			'test' => array('jippi'),
			'dot.test' => array('jippi')
		);
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a,'{\d+}.{\w+}.name');
		$expected = array(array('pages' => 'page'), array('fruites' => 'fruit'));
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a,'{n}.{\w+}.name');
		$expected = array(array('pages' => 'page'), array('fruites' => 'fruit'));
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a,'{s}.{\d+}.name');
		$expected = array(array('jippi'), array('jippi'));
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a,'{s}');
		$expected = array(array(array('name' => 'jippi')), array(array('name' => 'jippi')));
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a,'{[a-z]}');
		$expected = array(
			'test' => array(array('name' => 'jippi')),
			'dot.test' => array(array('name' => 'jippi'))
		);
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a, '{dot\.test}.{n}');
		$expected = array('dot.test' => array(array('name' => 'jippi')));
		$this->assertIdentical($result, $expected);

		$a = new stdClass();
		$a->articles = array(
			array('Article' => array('id' => 1, 'title' => 'Article 1')),
			array('Article' => array('id' => 2, 'title' => 'Article 2')),
			array('Article' => array('id' => 3, 'title' => 'Article 3')));

		$result = Set::extract($a, 'articles.{n}.Article.id');
		$expected = array( 1, 2, 3 );
		$this->assertIdentical($result, $expected);

		$result = Set::extract($a, 'articles.{n}.Article.title');
		$expected = array( 'Article 1', 'Article 2', 'Article 3' );
		$this->assertIdentical($result, $expected);
	}

/**
 * testInsert method
 *
 * @access public
 * @return void
 */
	function testInsert() {
		$a = array(
			'pages' => array('name' => 'page')
		);

		$result = Set::insert($a, 'files', array('name' => 'files'));
		$expected = array(
			'pages'     => array('name' => 'page'),
			'files'		=> array('name' => 'files')
		);
		$this->assertIdentical($result, $expected);

		$a = array(
			'pages' => array('name' => 'page')
		);
		$result = Set::insert($a, 'pages.name', array());
		$expected = array(
			'pages'     => array('name' => array()),
		);
		$this->assertIdentical($result, $expected);

		$a = array(
			'pages' => array(
				0 => array('name' => 'main'),
				1 => array('name' => 'about')
			)
		);

		$result = Set::insert($a, 'pages.1.vars', array('title' => 'page title'));
		$expected = array(
			'pages' => array(
				0 => array('name' => 'main'),
				1 => array('name' => 'about', 'vars' => array('title' => 'page title'))
			)
		);
		$this->assertIdentical($result, $expected);
	}

/**
 * testRemove method
 *
 * @access public
 * @return void
 */
	function testRemove() {
		$a = array(
			'pages'     => array('name' => 'page'),
			'files'		=> array('name' => 'files')
		);

		$result = Set::remove($a, 'files', array('name' => 'files'));
		$expected = array(
			'pages'     => array('name' => 'page')
		);
		$this->assertIdentical($result, $expected);

		$a = array(
			'pages' => array(
				0 => array('name' => 'main'),
				1 => array('name' => 'about', 'vars' => array('title' => 'page title'))
			)
		);

		$result = Set::remove($a, 'pages.1.vars', array('title' => 'page title'));
		$expected = array(
			'pages' => array(
				0 => array('name' => 'main'),
				1 => array('name' => 'about')
			)
		);
		$this->assertIdentical($result, $expected);

		$result = Set::remove($a, 'pages.2.vars', array('title' => 'page title'));
		$expected = $a;
		$this->assertIdentical($result, $expected);
	}

/**
 * testCheck method
 *
 * @access public
 * @return void
 */
	function testCheck() {
		$set = array(
			'My Index 1' => array('First' => 'The first item')
		);
		$this->assertTrue(Set::check($set, 'My Index 1.First'));
		$this->assertTrue(Set::check($set, 'My Index 1'));
		$this->assertTrue(Set::check($set, array()));

		$set = array(
			'My Index 1' => array('First' => array('Second' => array('Third' => array('Fourth' => 'Heavy. Nesting.'))))
		);
		$this->assertTrue(Set::check($set, 'My Index 1.First.Second'));
		$this->assertTrue(Set::check($set, 'My Index 1.First.Second.Third'));
		$this->assertTrue(Set::check($set, 'My Index 1.First.Second.Third.Fourth'));
		$this->assertFalse(Set::check($set, 'My Index 1.First.Seconds.Third.Fourth'));
	}

/**
 * testWritingWithFunkyKeys method
 *
 * @access public
 * @return void
 */
	function testWritingWithFunkyKeys() {
		$set = Set::insert(array(), 'Session Test', "test");
		$this->assertEqual(Set::extract($set, 'Session Test'), 'test');

		$set = Set::remove($set, 'Session Test');
		$this->assertFalse(Set::check($set, 'Session Test'));

		$this->assertTrue($set = Set::insert(array(), 'Session Test.Test Case', "test"));
		$this->assertTrue(Set::check($set, 'Session Test.Test Case'));
	}

/**
 * testDiff method
 *
 * @access public
 * @return void
 */
	function testDiff() {
		$a = array(
			0 => array('name' => 'main'),
			1 => array('name' => 'about')
		);
		$b = array(
			0 => array('name' => 'main'),
			1 => array('name' => 'about'),
			2 => array('name' => 'contact')
		);

		$result = Set::diff($a, $b);
		$expected = array(
			2 => array('name' => 'contact')
		);
		$this->assertIdentical($result, $expected);

		$result = Set::diff($a, array());
		$expected = $a;
		$this->assertIdentical($result, $expected);

		$result = Set::diff(array(), $b);
		$expected = $b;
		$this->assertIdentical($result, $expected);

		$b = array(
			0 => array('name' => 'me'),
			1 => array('name' => 'about')
		);

		$result = Set::diff($a, $b);
		$expected = array(
			0 => array('name' => 'main')
		);
		$this->assertIdentical($result, $expected);

		$a = array();
		$b = array('name' => 'bob', 'address' => 'home');
		$result = Set::diff($a, $b);
		$this->assertIdentical($result, $b);


		$a = array('name' => 'bob', 'address' => 'home');
		$b = array();
		$result = Set::diff($a, $b);
		$this->assertIdentical($result, $a);

		$a = array('key' => true, 'another' => false, 'name' => 'me');
		$b = array('key' => 1, 'another' => 0);
		$expected = array('name' => 'me');
		$result = Set::diff($a, $b);
		$this->assertIdentical($result, $expected);

		$a = array('key' => 'value', 'another' => null, 'name' => 'me');
		$b = array('key' => 'differentValue', 'another' => null);
		$expected = array('key' => 'value', 'name' => 'me');
		$result = Set::diff($a, $b);
		$this->assertIdentical($result, $expected);

		$a = array('key' => 'value', 'another' => null, 'name' => 'me');
		$b = array('key' => 'differentValue', 'another' => 'value');
		$expected = array('key' => 'value', 'another' => null, 'name' => 'me');
		$result = Set::diff($a, $b);
		$this->assertIdentical($result, $expected);

		$a = array('key' => 'value', 'another' => null, 'name' => 'me');
		$b = array('key' => 'differentValue', 'another' => 'value');
		$expected = array('key' => 'differentValue', 'another' => 'value', 'name' => 'me');
		$result = Set::diff($b, $a);
		$this->assertIdentical($result, $expected);

		$a = array('key' => 'value', 'another' => null, 'name' => 'me');
		$b = array(0 => 'differentValue', 1 => 'value');
		$expected = $a + $b;
		$result = Set::diff($a, $b);
		$this->assertIdentical($result, $expected);
	}

/**
 * testContains method
 *
 * @access public
 * @return void
 */
	function testContains() {
		$a = array(
			0 => array('name' => 'main'),
			1 => array('name' => 'about')
		);
		$b = array(
			0 => array('name' => 'main'),
			1 => array('name' => 'about'),
			2 => array('name' => 'contact'),
			'a' => 'b'
		);

		$this->assertTrue(Set::contains($a, $a));
		$this->assertFalse(Set::contains($a, $b));
		$this->assertTrue(Set::contains($b, $a));
	}

/**
 * testCombine method
 *
 * @access public
 * @return void
 */
	function testCombine() {
		$result = Set::combine(array(), '{n}.User.id', '{n}.User.Data');
		$this->assertFalse($result);
		$result = Set::combine('', '{n}.User.id', '{n}.User.Data');
		$this->assertFalse($result);

		$a = array(
			array('User' => array('id' => 2, 'group_id' => 1,
				'Data' => array('user' => 'mariano.iglesias','name' => 'Mariano Iglesias'))),
			array('User' => array('id' => 14, 'group_id' => 2,
				'Data' => array('user' => 'phpnut', 'name' => 'Larry E. Masters'))),
			array('User' => array('id' => 25, 'group_id' => 1,
				'Data' => array('user' => 'gwoo','name' => 'The Gwoo'))));
		$result = Set::combine($a, '{n}.User.id');
		$expected = array(2 => null, 14 => null, 25 => null);
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, '{n}.User.id', '{n}.User.non-existant');
		$expected = array(2 => null, 14 => null, 25 => null);
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, '{n}.User.id', '{n}.User.Data');
		$expected = array(
			2 => array('user' => 'mariano.iglesias',	'name' => 'Mariano Iglesias'),
			14 => array('user' => 'phpnut',	'name' => 'Larry E. Masters'),
			25 => array('user' => 'gwoo',	'name' => 'The Gwoo'));
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, '{n}.User.id', '{n}.User.Data.name');
		$expected = array(
			2 => 'Mariano Iglesias',
			14 => 'Larry E. Masters',
			25 => 'The Gwoo');
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, '{n}.User.id', '{n}.User.Data', '{n}.User.group_id');
		$expected = array(
			1 => array(
				2 => array('user' => 'mariano.iglesias', 'name' => 'Mariano Iglesias'),
				25 => array('user' => 'gwoo', 'name' => 'The Gwoo')),
			2 => array(
				14 => array('user' => 'phpnut', 'name' => 'Larry E. Masters')));
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, '{n}.User.id', '{n}.User.Data.name', '{n}.User.group_id');
		$expected = array(
			1 => array(
				2 => 'Mariano Iglesias',
				25 => 'The Gwoo'),
			2 => array(
				14 => 'Larry E. Masters'));
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, '{n}.User.id');
		$expected = array(2 => null, 14 => null, 25 => null);
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, '{n}.User.id', '{n}.User.Data');
		$expected = array(
			2 => array('user' => 'mariano.iglesias', 'name' => 'Mariano Iglesias'),
			14 => array('user' => 'phpnut', 'name' => 'Larry E. Masters'),
			25 => array('user' => 'gwoo', 'name' => 'The Gwoo'));
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, '{n}.User.id', '{n}.User.Data.name');
		$expected = array(2 => 'Mariano Iglesias', 14 => 'Larry E. Masters', 25 => 'The Gwoo');
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, '{n}.User.id', '{n}.User.Data', '{n}.User.group_id');
		$expected = array(
			1 => array(
				2 => array('user' => 'mariano.iglesias', 'name' => 'Mariano Iglesias'),
				25 => array('user' => 'gwoo', 'name' => 'The Gwoo')),
			2 => array(
				14 => array('user' => 'phpnut', 'name' => 'Larry E. Masters')));
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, '{n}.User.id', '{n}.User.Data.name', '{n}.User.group_id');
		$expected = array(
			1 => array(
				2 => 'Mariano Iglesias',
				25 => 'The Gwoo'),
			2 => array(
				14 => 'Larry E. Masters'));
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, '{n}.User.id', array('{0}: {1}', '{n}.User.Data.user', '{n}.User.Data.name'), '{n}.User.group_id');
		$expected = array (
			1 => array (
				2 => 'mariano.iglesias: Mariano Iglesias',
				25 => 'gwoo: The Gwoo'),
			2 => array (14 => 'phpnut: Larry E. Masters'));
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, array('{0}: {1}', '{n}.User.Data.user', '{n}.User.Data.name'), '{n}.User.id');
		$expected = array('mariano.iglesias: Mariano Iglesias' => 2, 'phpnut: Larry E. Masters' => 14, 'gwoo: The Gwoo' => 25);
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, array('{1}: {0}', '{n}.User.Data.user', '{n}.User.Data.name'), '{n}.User.id');
		$expected = array('Mariano Iglesias: mariano.iglesias' => 2, 'Larry E. Masters: phpnut' => 14, 'The Gwoo: gwoo' => 25);
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, array('%1$s: %2$d', '{n}.User.Data.user', '{n}.User.id'), '{n}.User.Data.name');
		$expected = array('mariano.iglesias: 2' => 'Mariano Iglesias', 'phpnut: 14' => 'Larry E. Masters', 'gwoo: 25' => 'The Gwoo');
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, array('%2$d: %1$s', '{n}.User.Data.user', '{n}.User.id'), '{n}.User.Data.name');
		$expected = array('2: mariano.iglesias' => 'Mariano Iglesias', '14: phpnut' => 'Larry E. Masters', '25: gwoo' => 'The Gwoo');
		$this->assertIdentical($result, $expected);

		$b = new stdClass();
		$b->users = array(
			array('User' => array('id' => 2, 'group_id' => 1,
				'Data' => array('user' => 'mariano.iglesias','name' => 'Mariano Iglesias'))),
			array('User' => array('id' => 14, 'group_id' => 2,
				'Data' => array('user' => 'phpnut', 'name' => 'Larry E. Masters'))),
			array('User' => array('id' => 25, 'group_id' => 1,
				'Data' => array('user' => 'gwoo','name' => 'The Gwoo'))));
		$result = Set::combine($b, 'users.{n}.User.id');
		$expected = array(2 => null, 14 => null, 25 => null);
		$this->assertIdentical($result, $expected);

		$result = Set::combine($b, 'users.{n}.User.id', 'users.{n}.User.non-existant');
		$expected = array(2 => null, 14 => null, 25 => null);
		$this->assertIdentical($result, $expected);

		$result = Set::combine($a, 'fail', 'fail');
		$this->assertEqual($result, array());
	}

/**
 * testMapReverse method
 *
 * @access public
 * @return void
 */
	function testMapReverse() {
		$result = Set::reverse(null);
		$this->assertEqual($result, null);

		$result = Set::reverse(false);
		$this->assertEqual($result, false);

		$expected = array(
		'Array1' => array(
				'Array1Data1' => 'Array1Data1 value 1', 'Array1Data2' => 'Array1Data2 value 2'),
		'Array2' => array(
				0 => array('Array2Data1' => 1, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				1 => array('Array2Data1' => 2, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				2 => array('Array2Data1' => 3, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				3 => array('Array2Data1' => 4, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				4 => array('Array2Data1' => 5, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4')),
		'Array3' => array(
				0 => array('Array3Data1' => 1, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				1 => array('Array3Data1' => 2, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				2 => array('Array3Data1' => 3, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				3 => array('Array3Data1' => 4, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				4 => array('Array3Data1' => 5, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4')));
		$map = Set::map($expected, true);
		$this->assertEqual($map->Array1->Array1Data1, $expected['Array1']['Array1Data1']);
		$this->assertEqual($map->Array2[0]->Array2Data1, $expected['Array2'][0]['Array2Data1']);

		$result = Set::reverse($map);
		$this->assertIdentical($result, $expected);

		$expected = array(
			'Post' => array('id'=> 1, 'title' => 'First Post'),
			'Comment' => array(
				array('id'=> 1, 'title' => 'First Comment'),
				array('id'=> 2, 'title' => 'Second Comment')
			),
			'Tag' => array(
				array('id'=> 1, 'title' => 'First Tag'),
				array('id'=> 2, 'title' => 'Second Tag')
			),
		);
		$map = Set::map($expected);
		$this->assertIdentical($map->title, $expected['Post']['title']);
		foreach ($map->Comment as $comment) {
			$ids[] = $comment->id;
		}
		$this->assertIdentical($ids, array(1, 2));

		$expected = array(
		'Array1' => array(
				'Array1Data1' => 'Array1Data1 value 1', 'Array1Data2' => 'Array1Data2 value 2', 'Array1Data3' => 'Array1Data3 value 3','Array1Data4' => 'Array1Data4 value 4',
				'Array1Data5' => 'Array1Data5 value 5', 'Array1Data6' => 'Array1Data6 value 6', 'Array1Data7' => 'Array1Data7 value 7', 'Array1Data8' => 'Array1Data8 value 8'),
		'string' => 1,
		'another' => 'string',
		'some' => 'thing else',
		'Array2' => array(
				0 => array('Array2Data1' => 1, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				1 => array('Array2Data1' => 2, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				2 => array('Array2Data1' => 3, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				3 => array('Array2Data1' => 4, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				4 => array('Array2Data1' => 5, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4')),
		'Array3' => array(
				0 => array('Array3Data1' => 1, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				1 => array('Array3Data1' => 2, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				2 => array('Array3Data1' => 3, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				3 => array('Array3Data1' => 4, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				4 => array('Array3Data1' => 5, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4')));
		$map = Set::map($expected, true);
		$result = Set::reverse($map);
		$this->assertIdentical($result, $expected);

		$expected = array(
		'Array1' => array(
				'Array1Data1' => 'Array1Data1 value 1', 'Array1Data2' => 'Array1Data2 value 2', 'Array1Data3' => 'Array1Data3 value 3','Array1Data4' => 'Array1Data4 value 4',
				'Array1Data5' => 'Array1Data5 value 5', 'Array1Data6' => 'Array1Data6 value 6', 'Array1Data7' => 'Array1Data7 value 7', 'Array1Data8' => 'Array1Data8 value 8'),
		'string' => 1,
		'another' => 'string',
		'some' => 'thing else',
		'Array2' => array(
				0 => array('Array2Data1' => 1, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				1 => array('Array2Data1' => 2, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				2 => array('Array2Data1' => 3, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				3 => array('Array2Data1' => 4, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4'),
				4 => array('Array2Data1' => 5, 'Array2Data2' => 'Array2Data2 value 2', 'Array2Data3' => 'Array2Data3 value 2', 'Array2Data4' => 'Array2Data4 value 4')),
		'string2' => 1,
		'another2' => 'string',
		'some2' => 'thing else',
		'Array3' => array(
				0 => array('Array3Data1' => 1, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				1 => array('Array3Data1' => 2, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				2 => array('Array3Data1' => 3, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				3 => array('Array3Data1' => 4, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4'),
				4 => array('Array3Data1' => 5, 'Array3Data2' => 'Array3Data2 value 2', 'Array3Data3' => 'Array3Data3 value 2', 'Array3Data4' => 'Array3Data4 value 4')),
		'string3' => 1,
		'another3' => 'string',
		'some3' => 'thing else');
		$map = Set::map($expected, true);
		$result = Set::reverse($map);
		$this->assertIdentical($result, $expected);

		$expected = array(�%P� �1��T��dx�HP)l��MIGB�β�'�ބ�{	f�Fj��NZ]+�If���'��8.�r��ٺ��ڡy��#zY��6�����R��t���Er?U�cS?1��#�"(�Q�&�G0��Qn��]��r��;��z�{�n��OfM�e<�����ҝ�,G�r�;����ћ~�N��U�B�32O[��;{�QfIG�jԋ ��@��D��笮[�Zx��W]"�}9����L�X�	B�F��T²���d̨�Q։�H���V��m�r�]D���X��o�r�i�miǢ�Ux��"�Qc3�ϴ)D�M�~�i-W��o��k��3���ۮ�-]i[t��� ���}"�u���;��m��ށ���G�ȿb^�2yyqp��f
:"�%f$M^�|�	��\Ƭnܶ�*%V�:)���[��.M�)r�xWZG�z�'�k�� ��P
@( ���� � /��@L� ��P
@( ��P
@( ��P
@( ��P
@( ��P
@( ��P
@( ��P
@( ��P��� �� ��	� ��P
@( ��P
@( ��P
@( ��P
@( ��P
@( ��P
@( ��P
@( ��P
��������������k����>�v��A;o�=��x{��c3�ߎ�;��'m���~3Owu�c�p��ڇx�����/�i��x�~;P���������<=�ױ����j�t���X������1�8}��C��v�`{��4��w^�<g��w��N��yb�f����ǌ����:	�}��,_�����{�>�v��A;o�=��x{��c3�ߎ�;��'m���~3Owu�c�p��ڇx�����/�i��x�~;P���������<=�ױ����j�t���X������1�8}��C��v�`{��4��w^�<g��w��N��yb�f����ǌ����:	�}��,_�����{�>�v��A;o�=��x{��c3�ߎ�;��'m���~3Owu�c�p��ڇx�����/�i��x�~;P���������<=�ױ����j�t���X������1�8}��C��v�`{��4��w^�<g��w��N��yb�f����ǌ����:	�}��,_�����{�>�v��A;o�=��x{��c3�ߎ�;��'m���~3Owu�c�p��ڇx�����/�i��x�~;P���������<=�ױ����j�t���X������1�8}��C��v�`{��4��w^�<g��w��N��yb�f����ǌ����:	�}��,_�����{�>�v��A;o�=��x{��c3�ߎ�;��'m���~3Owu�c�p��ڇx�����/�i��x�~;P���������<=�ױ����j�t���X������1�8}��C��v�`{��4��w^�<g��w��N��yb�f����ǌ����:	�}��,_�����{�>�v��A;o�=��x{��c3�ߎ�;��'m���~3Owu�c�p��ڇx�����/�i��x�~;P���������<=�ױ����j�t���X������1�8}��C��v�`{��4��w^�<g��w��N��yb�f����ǌ����:	�}��,_�����{�>�v��A;o�=��x{��c3�ߎ�;��'m���~3Owu�c�p��ڇx�����/�i��x�~;P���������<=�ױ����j�t���X������1�8}��C��v�`{��4��w^�<g��w��>��yb�f����ǌ����Z�}��,_�����{�>�v��@�o�=��x{��c3�ߎ�;�hm���~3Owu�c�p��ڇx-�����/�i�x��ڇx-�����/�i��x�~;P��}������<=�ױ����j#����?��J�S��3aֶ�m�׬�ϳ���Ç����FW����J�:Q�6�#ѧ�-}VS�\�$z4���Q�Cd�F�4��3�l���料Fy�=|��(�!�G�O�Ze�6H�i�KL�<���>ii�g��#ѧ�-2��$z4���Q�Cd�F�4��3�l���料Fy�=|��(�!�G�O�Ze�6H�i�KL�<���>ii�g��#ѧ�-2��$z4���Q�Cd�F�4��3�l���料Fy�=|��(�!�G�O�Ze�6H�i�KL�<���>ii�g��%ѓ�ZeC<������*�6Itd料P�!�K�'4�ʇ���%ѓ�Ze�6H�d料P�!�K�'4�ʆy�]9��T3�l����-2��$z2sKL�<��.����(�!�K�'4�ʆy�=9��T3�l����-2��$z2sKL�<���>ii�g��#ѧ�-2��$z4���Q�Cd�F�4��3�l���料Fy�=|��(�!�G�O�Ze�6H�i�KL�<���>ii�g��#ѧ�-2��$z4���Q�Cd�F�4��3�l���料Fy�=|��(�!�G�O�Ze�6H�d料FyN9��3�����u�E=�n7R�"ɣ��DHF2�����(n0fT�.b�ݓM�W�z�$+o3�n�\�ڛ���0B�Vl���NЎ�z�������cĚ�f\n0D�=MC.�E@!��͗��t����VaJ�׽����Qs+n7{�R$��^#��cūF�,G�v�#�l�QS"�
c��se�9�K��{�m�_X�2��e/[�Nʱ'��O ��q��D�(�rЪyBDJ�Q9s?���r�V�h�����Qw#wT�_;Q����owHIIL�&Jm��䔗B�*`���l�"�:�8���̑Nb�3)M�ǋ�ל������A�+�l�`���|ٙ�n��Mi�K�ZzdH�E��1MҸ��W�ܓ�owyl*���K����jN���w{�Q�����yC@�td�ܣ��E�cd�p(��j���J���\���]���pc�Jj-K�o(�>�II��\��x9�Ez���|�ix^����A�@( ��P
@( ��P
@( ����>@��IIF��7��J��U+�e�����T���C�5��]��/EthU�:��G.\I�8|���B�$��k��R�O�B|��' �����/��jev1tl����X���� L��ـ�8�b&��EG7 \,�̘V�Ӆ)����9L#� L?��WsIU�t����'�����)�|~Z�4�J�Sn�=�BS��9Y�?��<kJ�V.Q�:/�d0c�G��x*��V$;k��4�� 
&Ǉ����{��E�5�'�⪰�*�l���J�W(�rx���&3()����]�Vf�"�r��Eb2��9@G?�%8�K�XZ��طЎD��x��(������6��0��qZP
@( ��P
@( ����m����Hx�\ڑ����D�X	� s�2Le)~�g(FX�tB��De��z�����#U�P�i��o1�Z�� of�i{�j#���eD��SID�GP�QU#�Gf)�1G1S���0ԉ�w�i�����P1��c�� :��n��/�#�����8��n�������ַVȏ���%�_�����e��_�ܚ�x�0R��Rp�So\�p������� 1@p1x�*U�quQU�"|u�,����e�� <� �5�u}Ɵ�>�]�( ��P
@( ��P
@( ��P
�yYp�(a�Ϝ0� �>*�U��C��^j�/��:�V��d�8p���?=r�gU�^�GQ�K7����r�7�����������©:a��_ߘ����S5V�S/��9q.l��>��ի�kզ��V�-2Qk�2\��VS��h�98��%l� �z4�קʇ��zi�4�k����,�e�a�n^>n�N#̍+����?� E�Ԧe��sᖜ����a�+6\��VW)�ּ�9��c6XR��|ܷ)�����N�1�Ì�q�㫬�vh��=�}��Zk� S���9S6
f�����U�Lѧ?�5�3彛E�s��i��p�m�6���U7�}/V�_�S��K}_�G��z٫�B�W\��/�q\*�ɍkN�;k^��&_yݮ�y�%=7O�u�?XS.eϏ��8���[_���z֘S�a���}�����+ޮ�>�O�)G>S���?�� 5i.u]K��a�{�w,�� �z�����썎�L�� `q~Z��=⦯���M���Y��}����� �-��<@( ��P
@( ��P
@( ��P��%�y� �k��n���� �����
endstream
endobj
158 0 obj
<< /Type /Page
/Parent 1 0 R
/MediaBox [ 0 0 595 792 ]
/Resources 3 0 R
/Contents 156 0 R
/Annots 159 0 R
>>
endobj
159 0 obj
[
160 0 R
]
endobj
160 0 obj
<< /Type /Annot
/Subtype /Link
/Rect [ 316.136 65.509 558.866 56.509 ]
/C [ 0 0 0 ]
/Border [ 0 0 0 ]
/A << /URI (http://www.ibm.com/legal/copytrade.shtml)
/S /URI >>
/H /I
>>
endobj
161 0 obj
<< /Length 1206 /Filter /FlateDecode 
 >>
stream
x��W�k�6�=���(�e����c���X��Q�ñ�ԍ:��-���{��HN�$�@��������O�������#qV�����wP���Z�q�cM�+���9�7�}��q�	n,���7���g�S���R����B�ΰ�]ؚ/G�`ˁ��)8���/��x&�kk��;�q�z��\T�:�몐y.�����(Wr�'z%����y��y�������?�by�ȓ5��(w�"���Z�dW�l!�uz� ��Yn
�x:�{�[�ň�n�MAY�c+ L��UW�\k�Y��I�l��l��[VV�40G{tr��C��.���T��q�x�F�y�ێ��!�=;�]�K��#V?�
��D~�Mפ&�Ż�s�(�f��O旛u[xV{Q��,ћ����&��k�����1�$��8�>o`��6�?��.<���rym\\U����~e	�NnKQ��\��/_±�q��f���fV�⡙B�FoU�F����OC��w)D�"��qT�BhZ�~wkg�D�c�zT�P�#F����9�T����q\�Jm\��u��,k�bqG��
���~�,A��Fm8�v��ӣ]eU.�AJ�Ch_K���|r�D����ޔ� jo�[��*f�L�`�n�����G(r�D�{��o��{�1��9v�p[�(��jZSr�����~{��)T��Գ��>�,ﴬv�r �akW�,��N8t��e��pت��v��)<�+���S��8����y��<��W�8�2�*��s$ٟk����z-��2�7z���'
]N��q�Q�<�S��+��������������mHu�������ֆ����^d��������0՘a��4�(�4��~�G8EA�Ҫ�^�NsG�J��twr��N��M'YCw��]D���L���u�0C9�^'��^���l�fRnz$ގr�j�a��
��l�d	rw_�aJ��\�ѯY��M��=J��xD�?��Ma�c� be�H�����(@�6w9
Ҍ��ŶxA�|�&�M��U��<��r���Xv-B��C�41���}d^Y��BT��c������ÃBl�"��)P�J"6<��m��+�ˏ���������"�q�Mgi�T��;S���B�����;��)�<��Ռ��H[b�|i�s}��h�w
endstream
endobj
162 0 obj
<< /Type /Page
/Parent 1 0 R
/MediaBox [ 0 0 595 792 ]
/Resources 3 0 R
/Contents 161 0 R
/Annots 163 0 R
>>
endobj
163 0 obj
[
164 0 R
]
endobj
164 0 obj
<< /Type /Annot
/Subtype /Link
/Rect [ 45.866 65.509 288.596 56.509 ]
/C [ 0 0 0 ]
/Border [ 0 0 0 ]
/A << /URI (http://www.ibm.com/legal/copytrade.shtml)
/S /URI >>
/H /I
>>
endobj
165 0 obj
<< /Length 454 /Filter /FlateDecode 
 >>
stream
x�uT�n�0��+|L��kc��nۨ��j�"UU�^��1��됀��D\fl�{3o69���HHJ(~z8�Dጒu�bA�\�C�ێ���E?�&G��Y �Q\#6bل���;���}���l^�jms�q���7:&C��5���AUͪ�"S	Ql������7�{�f4�@'*#T�%�8T��
&1<:[�'�$w��c]�Fs�e,���L9U�7�U�V{@d`%�����Czh��@���a�j2��/��
�"�uc��ʰ@1�9�����о�u�]��RKy!G�L�$Q�4�n�Q�_���w�L���.�Pfב�v�%�9ʥ����)�A�;S�Կ؜��^>���c �~پ�(C�"{V�5P�8�����Ϥ����%k���b��љ�c��|���h]�+�P��[�
�C&>r����Q�t5�Z����V
endstream
endobj
166 0 obj
<</Type /XObject
/Subtype /Image
/Name /Im16
/Length 70036
/Width 500
/Height 351
/BitsPerComponent 8
/ColorSpace /DeviceRGB
/Filter /DCTDecode 
>>
stream
���� JFIF   d d  �� Ducky     P  �� Adobe d�   �� � 		

					�� _� �� �           	
            
	 !"1WAQ�2��U�B#��a�Rb�3S$4t�Xq��r��C�d5V���s��c��T�%'�&	�D�e(  
	  !1AQa��"R�q���2b��Br�����S��#�3���Cc�����s��   ? �/X����_N��)�Ph훰��H� `L��^X5�m���+ǰw��K^g����.������}��gx;�� Ym9&�Y��ut� #ꋝ��䒙��PK����d�	L�6A����<���D�E�O�Ŭ���W�8�@�˓�� g�v���������
}ahZ0���n�x�i�eX�I���җ!��w1�^bc�.#h�ZDq�Y��j,�=�w�gxu�?�_�F��M��N:�N#�l�����;��r,�N���}���*�'^�L��2�=A��9��;�ec%|x�s)>���-�����LE��:��� ����]�ᲿOu~q�o{�o��ʽ�!**��"3M���6��<W��:���Y�M4D�DM4D�DM4D�DMUEʧ���t� �u�6���v�9����t!���)�5������6��i�d�O� ��B�"��l����eJ(�L�n�b����[�u�H�b;���4��w8�;�&����l����P��柦�ea��R3��\o�3��ڲ���Tuj�تJ�"��f\�q�_�lh��[DDL�`�ӧ[��j��v2���ǭ�%�'�]l������j����~\(��Ji�6�O��FŦ��R!�&"e!��-�ᐎ� [��9����R" �u�#�V�Q:�q�QQO�ۦ}28�0�e�ސ�R��gX��P%��8r�������7�h��$h��ܺ.�	������֖9�;��`GWidv��է ��z�$���"��WA�k�"a��o(�rl��Q�uz�Ȉ�p���>�Uq��c��U���l7w�\��/��ĥ��N����I!c��!w����'�Y��{���1��|M�k�-~��1�U�dA_��Zh,۷�8�¦&�?x�`�a�(�c������{��R�n��V5v�� NO��Z�=��wXrJΝtfd���1�f?Mc6�q�6[�iؙ4����cbn�Ai�Ox�᭍���Q���VB@��b�ڟӴ��|�˼6vt��;��VU��mKb\�~���.,�춧
SpyƍH۽։�"�C�G�#yi(�Q[g-������E����_Ţ��ͬ�Q�X[0�����n"Ɩ�#��f80l����C~�X�O
%V�6uTC_�X��Y���bu�}��J�l dχ0a	7*Ԉ���l޴�{ޮwj+����1��GuM���� �i�N�����u��zX�u�4���d�zP[���d+a�4�.ɏ����z;I�85���Y|�ݵ��詈v�c޳�����`}H���|f���[���-�+G�I)Q�����aFm�,D���+�xw��'��n�,_����H�a�.��Ȩp�sik�l�����[oDn��^&x�l"�?���I�ք�Ŷ.�#/��6�_[�Ւ��H���5~e���++�c��q�H�t��e��[�O���F�XC)�I9߈u����bL������#5哗GO�������R�%�m��O�ݜ���H�A�6�[n�,@�883��tDv���N}B9۽@�.ri�v�uk�.�%S��}(v+�Q�������tv�H�YFf=Д����e��B<��1����W!�p��{��e��2LiOW�I���;5j$�e�DA|����Yu}\��1�0#@�jd,�1Z�� �>>�U�E<*���]�]m�]��mA�-�T׽:^;/�ct��^�r>:'7�	L�� ����|m@�'�=�kf]U��ӯf��d������r<Q�Sl���#�*sj߻s&�V�o��#��/�`;v��}��x l�/N'Z3�c��jx��`գ{B��ȅl�1��A��e6={CJs���?8�C�?���D�� Hl?�c�Խ��S-W��L4�������r��̥�T3���U���t�ƶ`r7N��$�M������-�n۬�A�W��Mߕ�fQRz����V�ե�����4�C�������Ʀ� �V��A
\��$^�!���#�.���˛��VF�|�A�m/$�R4��V�!�G˱\o*�ڵ"�b{Mpx����uE�4;�0�Huy*�lZ�)�&��"h��&��"h��&��"h��&��"�x�m��a��M8q�q��p ���;׻�(*�&I���g�g&;NΌ��q�e�N&г0��wk�������?E�F�~��>֜���r=e��n���lݷ� �������*��l��DvS���`xv�8�*�����Q��bH/�"��0���S`�1*b���oc�����،Ē�q@8`��B:���{2���w�n>%�,t��2�Է��mL�T4���ڏ6��]�����!w��� :��)VI]n�ؑ:����'�����A��/;���M�H���Q�k�y��7�S�.��g�BH^������x��UD�QQQ~*�����r;���,�G���!�(b����-p\��6��m�� ��qwDw� ���/{DR~-��8��8��3􎘈�ly@����'t�{`i�K��sj��盎���K�H�s�Ѹ��$qz�����Jtp30 #q�4DD�*��QG�IJh���u�N �b뀣�$0�WD]���%8��6���#qQq���!���[tE��Vu�����m�����h���DP���.�8��/6iŷ[L=�0l�S�GD_Lq��h� ��*��""v���}��"�k>�m��ɫ^e�i��E������E���� ���W��"�k��*J�Q�4�J܅����"�.�ㇷ~\�l��ef��Pq�8s2����
A�D\W?ňHK(�B]�]���{D\�����e���-ŷ�^"h8��TUl�;~ ��G��/��b���'�q�6�ʌ�����P0T�B�[TK�t4���/Yn>Q3q��6ԅm��� �PP�"?tt\Ǩx��\a'� !�]� �;�"�]A�MO*�b� �R��s��q������� ��G���DX��|:#f�K������a��'���!�7MH̾1x�E���cIǆW7�o����������QxnC�P_}��LL��b$H+�Z�+��Q��� p�GD\#f�d�B����D�È�l���� (#��Mv�n�Hu�\`�;MA'����'P�T!��!zP�Az}>���E��C�xp�*�Î�� �e����{D_�8����Q���Y�������0��{�Rw{�{�"Pq��{�b��6w$�?c�v�Q��۷/`yi���������D\S�x�l�#���I%�)�h����Q�#s%��i�=��[D\Nq���ɢ/��8��E�����|On��;}����ӜG����_�h�n5�|��J�-�q^EV$�����Hwf���cD^��^=�ǷDP�e���/F�fc%�$EGd�~��@���"J��"�|��s�<��~�/UUXm��cý�����@���h&�Ex'�K�C�.�ӜG����_�h��s�� �P+�M?Nq���ɢ'��#� QA���4D�9��(?�� &���8��E��������
'��	��4E8Ք9�!�ړ��Ć�Cl��@c�KDYIj�'���/�D]~=�۹��<wq��3K>4����.�Ȫ��s�c=��X�ķ#���#��?�E?�#�f������6zz�_�VEH�7&FNSC,\��p�b�������Z�U��G�C�q]�ɮ��e���t'�ɕD�V� ��z7��������]9���<����O�(�5c򷫉��tE?bz"��Ygdy�����'ہ&EM���fHS�|\�M����<ȿe�(
Y����CH ^X��!�m	�]�!W������΢B�:u��bń�V�q���,�&��[N�*�sͺ�;!�i�d�,����gE3[��ԏ_�VY0���TaЅ
|hp���"+�D�ţ�x����C!�"�h��;j����i�� ��ܔ^��/�n�1���|N�������SCǡa(�l��H�X�x͍S�J.10�E"��i��;\ݷDXq�Zܓ��!g3$�6���_��_�%�3qZhSk>��K�D���"���h��SYcA.#�Y@�(��`��y��4�!��S��D�w���R���WK/�����nq>U{F��^�y���ՓiQ{�[�=�e�"�>U���t���*�Z�l�u���֣��֓Q�Fc�G�CV�l�.������*�֞Fc�7z�v4��\�k��a�((�g�h�tQ{7�����:��?��)%�bT�*���2�Ih�WxP�s6�a��[�D|t�odC�"�����
��\�s�H�"�0C���7	�"UT. &������w�6�����1Z��P����di�a��:88��m�V#7C�SJ��aU�T��4�b��s[��pwc� ��U絠g]����:M9�ߘ���i0鸥d�K+|�j<;�XC]
p4���槼뎃n���k��DT�����=�u\,��?��牳Y2:��I��_T�nN][�Ӷ�$D�WW-�@�H~;`�&ДQ��7/�RD �k�[$uG� %��M��sˢ܇�Qxߙ��}�zN��}�wV���-jŁ��`�j�0̈́ܩ2V{�6FL"9�F��F��"[%x��#�Y��(v4R�ܞ�	z�ű��㮸�e����2�<�bU%̈Ғ<����!@A�*��bA&��4n*��0�,8R�&����	�U<T�<9#�e]n�kz�"����v5d��
���SڍW5�f�m�%3�@CW�1EhI�+]�F��5�Jz��?f��a���k_S�j���0]L���K�t�Xȝ�I�������Wsd�P�կWJI�U��U�Z�[\q�ݱ�����;r��RH�AqNkL4R�f����Q��E�W�h�&��ϩ�S����D7�^�#\Ӏ�|��E[[J6O�G>�X�ܖ�4��d�g���c��irfWJ�N��VW[.��nC���Q`�~�"V��`ɛF2����z 	���_����:�����G�Yg]����#�E<v������I/�A�"K�#Q�;���~�ke���&����%�9-��k��6��TV�ͪ�eL�=t��m�H�X�aU@�[��o])��8n�i�(H�BosG���T��ц�C��ك��d�5�c�q��OV]�cIɺX�%��t�����XWDH�!�aN9T�^Q�c�F:�J1$��/��� �!�TFRk"����=���u����jM��^._q���Թh��V���5���+�e����YP\�\�uDCv�F;�DI�A#��*ڎ��JQ�hSA��i��#�U.���WD�j+zt�D֮^����e��a�ܒ�@&�H직����tw��D�\�;E���%�;�P��f�1#����l:×`���~���|K�r"�e�����m�Dv�R���@"1�)4
2�cj���ؖo+��`H��sڲ����<��Ռe�ڱzKԼ�8�ȫr:!�
z�jƶ�$9�D��x	"R!�ɧZ|LV11��ffJ���q �0H�L��&�p���¼�^���h��&��"h��&��"h��&���n#
"���+��|;��S����B/"V�f,����c�:�sv�#y���pc%t�M�i�x�F���Ut��.��7���ϳ�7R2����^5&�i��ۀj�&��]�$�D��M��1��fE�.+��wY�+Y����D�O��.e3!m!?xxv���d��\���T�p/�^ꢺ�]M�f�f���D�����h#J1�7\.���n���a6V5/oWʴ��Q3���At��'D�y�d��J�-Y��
��]D7���qz�2�:j�,� -��XX�<#�ŶeK���e�n�
7���ݯ�?i����������"/�nƬl��	
m�u�mU�x7r��7��[�L���Knǳ���P��z��}�90�G� a�7�+C��̌"�jȺ��!
w�..��Lb�Nb����&%����.�B6�tZ��`O�L����Ag���j�v?���~��mvtS�0��mq�Q�u�MjÁn�$�7=9�����=<+ZXu����vϦ/;d�M5a�r��H��I���d�DT��B ]�bǉ��*d $p�������o0F�������#r�]Dv�ff<T�
ː����	#��9��P@����
z�I&����Gݑ,����He���w,�QT7pN<xq�ʂʑ.Y��)�&���=Ψb�R�����̪���c�@�68�b�1^j�'����xpzO���\��˖�Z�X`��Y��� ���Y����(3=�]p[�'���*o_��DU��W�]=z��芇{;�_s�t�FGt."��ډ��.�``��Hu{�s,�k���w���f[�fXu�jݳ��\e��}���Q��X�#�<k���P��>#qw#��E'���v=[�،�6dv85�M8����2���EbX�d����.��5�S�W�����$���GS���ı��]�G8P�t�@s*.Dg�"BR#-�f�1Hȋ��%��O�j9��� lE�s|i���ݬ! ڊ=��b9���{Q�T^��P�Rj+���6�^�h��-�;�h����ı�<k������ⲙ(Һ�W*)(���3�P���|;����X�#�<k����A��p�:�6�ٷְ�p�Æ�fݻK�s'�w��d���V+#/Sk"�m67���lP~* ���D{��:X�#�<k���䞥�3oR*'��I�a����,�ػ���,K̧ƻڎp��>���m�4��gm�۹?�{��M,K̣ƻڎp�Z����V��(Bh�'x~)v�����ibX�d����,Hå���:�I9�wr^�{�ga!����w~�K�s'�w��c�}��gۀ[w�D����ې��*��%��O�j9����p�DE�!��q�a�|����O�j9��M��P���͸��(Bh�QQRN�T/wK�s'�w��X�y����L7�ZBm�Arι�QOt�p��UKK�s)�����.j�=�� ���o7��o�ǎ�ޞ{xibX�d���p����~=�c�O�Ϋ������<G2��hg�ں��%���,K̧ǆ�s��W[�d��}_å�b9�ǆ�s��W[�d��}_å�b9�ǆ�s��W[�d��}_å�b9�ǆ�s��W[�d��}_å�b9�ǆ�s��W[�d��}_å�b9�ǆ�s��W[�d��}_å�b9�ǆ�s��W[�d��}_å�b9�ǆ�s��W[{c���gժ/���,G2x�ڎp�'��TR!� �*)�M�EUD��J��<;t�,G2x�ڎp������Q|����ı���j9�}����Q|����ı���j9�}����Q|����ı���j9�}����P�����ı����G8O�u��J���:X�#�<{���	�����C����K�s'�w��>����(~_W��bX�d�����'ں��%���,K̞=��s��W[{d��}_å�b9�ǻڎp�j�ol�?/��t�,G2x�{Q��]m풇���%��O�j9�}����P�����ı����G8O�u��J���:X�#�<{���	�����C����K�s'�w��>����(~_W��bX�d�����'ں��%���,K̞=��s�d�i��s~c�1�V�����J@�|���w�qn-lo/˼�H�i=QT8�P*Yڸ��x��JO�]o풇����,G2�ǻڎp��^��7�����E��W��^��F�~*qW��?�:X�#�<k���
5s��ĳ�q�4$6����|a!'��,G2��j9��k�x3B��}F�*�!�*���g\ןo��/;���*�P�$\�d�ar�a�6�{D�D�D��0��j�k��JD��mm� ы�o�]����B�9UX�<�N��N�ӬxҿmS�SЄ�����bX�e>=��s�������E����K�s'����?�I��F!ug���&���H���7�x�*���%��Q�]��w�����P�����ı�|{���	�����C����K�s'�w��>����(~_W��bX�d�����'ں��%���,K̞=��s��|��*m��(��p�X���X�#�<xmG8U���rߟa�Z�e��.��'%�UU�R�ı�<k����A�� ��w�h���ı��]�C8O�� �1߭�~{K�s'�w��~0lxu���K�]��~�Q��X?\���!�eWV1��Y�i�'K`8
D��8���/�ۻ�$W��}�� y��
8q*�&κ7�!�:F��_�b��.4���#d1"+��d��ݝ��no�}P.>���n��0�c5Ҿ���=�ְ{5��j�`L#p�Z|b��dj��`��D`�}�۴��c!i>��/gx��"��-fO&&��|���B&��V�wf2)�z+!-�^)��j���~G#���,�j�h>���G�=H��-�p|�.��}��3�!����ý���qQ]�;��K�U�� ֋?HZ\�؉-��s,�w�]U��,[�7��z�9E�\4z���Z��~3�l�ӽ�OIj� w���6�=�|*�p����.�r��ᒕ_�|�zld����BK������L���om"uI;�Kv�I��Zz1�<�fm7 ���Kg�:婹��iN׼���Sc75�[#EGt��"��h�l�X�:T���+ �H8�T2�Post Body';
		$expected->published = 'Y';
		$expected->created = "2007-03-18 10:39:23";
		$expected->updated = "2007-03-18 10:41:31";

		$expected->Author = new stdClass;
		$expected->Author->id = '1';
		$expected->Author->user = 'mariano';
		$expected->Author->password = '5f4dcc3b5aa765d61d8327deb882cf99';
		$expected->Author->created = "2007-03-17 01:16:23";
		$expected->Author->updated = "2007-03-17 01:18:31";
		$expected->Author->test = "working";
		$expected->Author->_name_ = 'Author';

		$expected2 = new stdClass;
		$expected2->_name_ = 'Post';
		$expected2->id = '2';
		$expected2->author_id = '3';
		$expected2->title = 'Second Post';
		$expected2->body = 'Second Post Body';
		$expected2->published = 'Y';
		$expected2->created = "2007-03-18 10:41:23";
		$expected2->updated = "2007-03-18 10:43:31";

		$expected2->Author = new stdClass;
		$expected2->Author->id = '3';
		$expected2->Author->user = 'larry';
		$expected2->Author->password = '5f4dcc3b5aa765d61d8327deb882cf99';
		$expected2->Author->created = "2007-03-17 01:20:23";
		$expected2->Author->updated = "2007-03-17 01:22:31";
		$expected2->Author->test = "working";
		$expected2->Author->_name_ = 'Author';

		$test = array();
		$test[0] = $expected;
		$test[1] = $expected2;

		$this->assertIdentical($test, $result);

		$result = Set::map(
				array(
					'Post' => array('id' => '1', 'author_id' => '1', 'title' => 'First Post', 'body' => 'First Post Body', 'published' => 'Y', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'),
					'Author' => array('id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31', 'test' => 'working'),
				)
			);
		$expected = new stdClass;
		$expected->_name_ = 'Post';
		$expected->id = '1';
		$expected->author_id = '1';
		$expected->title = 'First Post';
		$expected->body = 'First Post Body';
		$expected->published = 'Y';
		$expected->created = "2007-03-18 10:39:23";
		$expected->updated = "2007-03-18 10:41:31";

		$expected->Author = new stdClass;
		$expected->Author->id = '1';
		$expected->Author->user = 'mariano';
		$expected->Author->password = '5f4dcc3b5aa765d61d8327deb882cf99';
		$expected->Author->created = "2007-03-17 01:16:23";
		$expected->Author->updated = "2007-03-17 01:18:31";
		$expected->Author->test = "working";
		$expected->Author->_name_ = 'Author';
		$this->assertIdentical($expected, $result);

		//Case where extra HABTM fields come back in a result
		$data = array(
			'User' => array(
				'id' => 1,
				'email' => 'user@example.com',
				'first_name' => 'John',
				'last_name' => 'Smith',
			),
			'Piece' => array(
				array(
					'id' => 1,
					'title' => 'Moonlight Sonata',
					'composer' => 'Ludwig van Beethoven',
					'PiecesUser' => array(
						'id' => 1,
						'created' => '2008-01-01 00:00:00',
						'modified' => '2008-01-01 00:00:00',
						'piece_id' => 1,
						'user_id' => 2,
					)
				),
				array(
					'id' => 2,
					'title' => 'Moonlight Sonata 2',
					'composer' => 'Ludwig van Beethoven',
					'PiecesUser' => array(
						'id' => 2,
						'created' => '2008-01-01 00:00:00',
						'modified' => '2008-01-01 00:00:00',
						'piece_id' => 2,
						'user_id' => 2,
					)
				)
			)
		);

		$result = Set::map($data);

		$expected = new stdClass();
		$expected->_name_ = 'User';
		$expected->id = 1;
		$expected->email = 'user@example.com';
		$expected->first_name = 'John';
		$expected->last_name = 'Smith';

		$piece = new stdClass();
		$piece->id = 1;
		$piece->title = 'Moonlight Sonata';
		$piece->composer = 'Ludwig van Beethoven';

		$piece->PiecesUser = new stdClass();
		$piece->PiecesUser->id = 1;
		$piece->PiecesUser->created = '2008-01-01 00:00:00';
		$piece->PiecesUser->modified = '2008-01-01 00:00:00';
		$piece->PiecesUser->piece_id = 1;
		$piece->PiecesUser->user_id = 2;
		$piece->PiecesUser->_name_ = 'PiecesUser';

		$piece->_name_ = 'Piece';


		$piece2 = new stdClass();
		$piece2->id = 2;
		$piece2->title = 'Moonlight Sonata 2';
		$piece2->composer = 'Ludwig van Beethoven';

		$piece2->PiecesUser = new stdClass();
		$piece2->PiecesUser->id = 2;
		$piece2->PiecesUser->created = '2008-01-01 00:00:00';
		$piece2->PiecesUser->modified = '2008-01-01 00:00:00';
		$piece2->PiecesUser->piece_id = 2;
		$piece2->PiecesUser->user_id = 2;
		$piece2->PiecesUser->_name_ = 'PiecesUser';

		$piece2->_name_ = 'Piece';

		$expected->Piece = array($piece, $piece2);

		$this->assertIdentical($expected, $result);

		//Same data, but should work if _name_ has been manually defined:
		$data = array(
			'User' => array(
				'id' => 1,
				'email' => 'user@example.com',
				'first_name' => 'John',
				'last_name' => 'Smith',
				'_name_' => 'FooUser',
			),
			'Piece' => array(
				array(
					'id' => 1,
					'title' => 'Moonlight Sonata',
					'composer' => 'Ludwig van Beethoven',
					'_name_' => 'FooPiece',
					'PiecesUser' => array(
						'id' => 1,
						'created' => '2008-01-01 00:00:00',
						'modified' => '2008-01-01 00:00:00',
						'piece_id' => 1,
						'user_id' => 2,
						'_name_' => 'FooPiecesUser',
					)
				),
				array(
					'id' => 2,
					'title' => 'Moonlight Sonata 2',
					'composer' => 'Ludwig van Beethoven',
					'_name_' => 'FooPiece',
					'PiecesUser' => array(
						'id' => 2,
						'created' => '2008-01-01 00:00:00',
						'modified' => '2008-01-01 00:00:00',
						'piece_id' => 2,
						'user_id' => 2,
						'_name_' => 'FooPiecesUser',
					)
				)
			)
		);

		$result = Set::map($data);

		$expected = new stdClass();
		$expected->_name_ = 'FooUser';
		$expected->id = 1;
		$expected->email = 'user@example.com';
		$expected->first_name = 'John';
		$expected->last_name = 'Smith';

		$piece = new stdClass();
		$piece->id = 1;
		$piece->title = 'Moonlight Sonata';
		$piece->composer = 'Ludwig van Beethoven';
		$piece->_name_ = 'FooPiece';
		$piece->PiecesUser = new stdClass();
		$piece->PiecesUser->id = 1;
		$piece->PiecesUser->created = '2008-01-01 00:00:00';
		$piece->PiecesUser->modified = '2008-01-01 00:00:00';
		$piece->PiecesUser->piece_id = 1;
		$piece->PiecesUser->user_id = 2;
		$piece->PiecesUser->_name_ = 'FooPiecesUser';

		$piece2 = new stdClass();
		$piece2->id = 2;
		$piece2->title = 'Moonlight Sonata 2';
		$piece2->composer = 'Ludwig van Beethoven';
		$piece2->_name_ = 'FooPiece';
		$piece2->PiecesUser = new stdClass();
		$piece2->PiecesUser->id = 2;
		$piece2->PiecesUser->created = '2008-01-01 00:00:00';
		$piece2->PiecesUser->modified = '2008-01-01 00:00:00';
		$piece2->PiecesUser->piece_id = 2;
		$piece2->PiecesUser->user_id = 2;
		$piece2->PiecesUser->_name_ = 'FooPiecesUser';

		$expected->Piece = array($piece, $piece2);

		$this->assertIdentical($expected, $result);
	}

/**
 * testPushDiff method
 *
 * @access public
 * @return void
 */
	function testPushDiff() {
		$array1 = array('ModelOne' => array('id'=>1001, 'field_one'=>'a1.m1.f1', 'field_two'=>'a1.m1.f2'));
		$array2 = array('ModelTwo' => array('id'=>1002, 'field_one'=>'a2.m2.f1', 'field_two'=>'a2.m2.f2'));

		$result = Set::pushDiff($array1, $array2);

		$this->assertIdentical($result, $array1 + $array2);

		$array3 = array('ModelOne' => array('id'=>1003, 'field_one'=>'a3.m1.f1', 'field_two'=>'a3.m1.f2', 'field_three'=>'a3.m1.f3'));
		$result = Set::pushDiff($array1, $array3);

		$expected = array('ModelOne' => array('id'=>1001, 'field_one'=>'a1.m1.f1', 'field_two'=>'a1.m1.f2', 'field_three'=>'a3.m1.f3'));
		$this->assertIdentical($result, $expected);


		$array1 = array(
				0 => array('ModelOne' => array('id'=>1001, 'field_one'=>'s1.0.m1.f1', 'field_two'=>'s1.0.m1.f2')),
				1 => array('ModelTwo' => array('id'=>1002, 'field_one'=>'s1.1.m2.f2', 'field_two'=>'s1.1.m2.f2')));
		$array2 = array(
				0 => array('ModelOne' => array('id'=>1001, 'field_one'=>'s2.0.m1.f1', 'field_two'=>'s2.0.m1.f2')),
				1 => array('ModelTwo' => array('id'=>1002, 'field_one'=>'s2.1.m2.f2', 'field_two'=>'s2.1.m2.f2')));

		$result = Set::pushDiff($array1, $array2);
		$this->assertIdentical($result, $array1);

		$array3 = array(0 => array('ModelThree' => array('id'=>1003, 'field_one'=>'s3.0.m3.f1', 'field_two'=>'s3.0.m3.f2')));

		$result = Set::pushDiff($array1, $array3);
		$expected = array(
					0 => array('ModelOne' => array('id'=>1001, 'field_one'=>'s1.0.m1.f1', 'field_two'=>'s1.0.m1.f2'),
						'ModelThree' => array('id'=>1003, 'field_one'=>'s3.0.m3.f1', 'field_two'=>'s3.0.m3.f2')),
					1 => array('ModelTwo' => array('id'=>1002, 'field_one'=>'s1.1.m2.f2', 'field_two'=>'s1.1.m2.f2')));
		$this->assertIdentical($result, $expected);

		$result = Set::pushDiff($array1, null);
		$this->assertIdentical($result, $array1);

		$result = Set::pushDiff($array1, $array2);
		$this->assertIdentical($result, $array1+$array2);
	}

/**
 * testSetApply method
 * @access public
 * @return void
 *
 */
	function testApply() {
		$data = array(
			array('Movie' => array('id' => 1, 'title' => 'movie 3', 'rating' => 5)),
			array('Movie' => array('id' => 1, 'title' => 'movie 1', 'rating' => 1)),
			array('Movie' => array('id' => 1, 'title' => 'movie 2', 'rating' => 3))
		);

		$result = Set::apply('/Movie/rating', $data, 'array_sum');
		$expected = 9;
		$this->assertEqual($result, $expected);

		if (PHP5) {
			$result = Set::apply('/Movie/rating', $data, 'array_product');
			$expected = 15;
			$this->assertEqual($result, $expected);
		}

		$result = Set::apply('/Movie/title', $data, 'ucfirst', array('type' => 'map'));
		$expected = array('Movie 3', 'Movie 1', 'Movie 2');
		$this->assertEqual($result, $expected);

		$result = Set::apply('/Movie/title', $data, 'strtoupper', array('type' => 'map'));
		$expected = array('MOVIE 3', 'MOVIE 1', 'MOVIE 2');
		$this->assertEqual($result, $expected);

		$result = Set::apply('/Movie/rating', $data, array('SetTest', '_method'), array('type' => 'reduce'));
		$expected = 9;
		$this->assertEqual($result, $expected);

		$result = Set::apply('/Movie/rating', $data, 'strtoupper', array('type' => 'non existing type'));
		$expected = null;
		$this->assertEqual($result, $expected);

	}

/**
 * Helper method to test Set::apply()
 *
 * @access protected
 * @return void
 */
	function _method($val1, $val2) {
		$val1 += $val2;
		return $val1;
	}

/**
 * testXmlSetReverse method
 *
 * @access public
 * @return void
 */
	function testXmlSetReverse() {
		App::import('Core', 'Xml');

		$string = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<rss version="2.0">
		  <channel>
		  <title>Cake PHP Google Group</title>
		  <link>http://groups.google.com/group/cake-php</link>
		  <description>Search this group before posting anything. There are over 20,000 posts and it&amp;#39;s very likely your question was answered before. Visit the IRC channel #cakephp at irc.freenode.net for live chat with users and developers of Cake. If you post, tell us the version of Cake, PHP, and database.</description>
		  <language>en</language>
		  	<item>
			  <title>constructng result array when using findall</title>
			  <link>http://groups.google.com/group/cake-php/msg/49bc00f3bc651b4f</link>
			  <description>i&#39;m using cakephp to construct a logical data model array that will be &lt;br&gt; passed to a flex app. I have the following model association: &lt;br&gt; ServiceDay-&amp;gt;(hasMany)ServiceTi me-&amp;gt;(hasMany)ServiceTimePrice. So what &lt;br&gt; the current output from my findall is something like this example: &lt;br&gt; &lt;p&gt;Array( &lt;br&gt; [0] =&amp;gt; Array(</description>
			  <guid isPermaLink="true">http://groups.google.com/group/cake-php/msg/49bc00f3bc651b4f</guid>
			  <author>bmil...@gmail.com(bpscrugs)</author>
			  <pubDate>Fri, 28 Dec 2007 00:44:14 UT</pubDate>
			  </item>
			  <item>
			  <title>Re: share views between actions?</title>
			  <link>http://groups.google.com/group/cake-php/msg/8b350d898707dad8</link>
			  <description>Then perhaps you might do us all a favour and refrain from replying to &lt;br&gt; things you do not understand. That goes especially for asinine comments. &lt;br&gt; Indeed. &lt;br&gt; To sum up: &lt;br&gt; No comment. &lt;br&gt; In my day, a simple &amp;quot;RTFM&amp;quot; would suffice. I&#39;ll keep in mind to ignore any &lt;br&gt; further responses from you. &lt;br&gt; You (and I) were referring to the *online documentation*, not other</description>
			  <guid isPermaLink="true">http://groups.google.com/group/cake-php/msg/8b350d898707dad8</guid>
			  <author>subtropolis.z...@gmail.com(subtropolis zijn)</author>
			  <pubDate>Fri, 28 Dec 2007 00:45:01 UT</pubDate>
			 </item>
		</channel>
		</rss>';
		$xml = new Xml($string);
		$result = Set::reverse($xml);
		$expected = array('Rss' => array(
			'version' => '2.0',
			'Channel' => array(
				'title' => 'Cake PHP Google Group',
				'link' => 'http://groups.google.com/group/cake-php',
				'description' => 'Search this group before posting anything. There are over 20,000 posts and it&#39;s very likely your question was answered before. Visit the IRC channel #cakephp at irc.freenode.net for live chat with users and developers of Cake. If you post, tell us the version of Cake, PHP, and database.',
				'language' => 'en',
				'Item' => array(
					array(
						'title' => 'constructng result array when using findall',
						'link' => 'http://groups.google.com/group/cake-php/msg/49bc00f3bc651b4f',
						'description' => "i'm using cakephp to construct a logical data model array that will be <br> passed to a flex app. I have the following model association: <br> ServiceDay-&gt;(hasMany)ServiceTi me-&gt;(hasMany)ServiceTimePrice. So what <br> the current output from my findall is something like this example: <br><p>Array( <br> [0] =&gt; Array(",
						'guid' => array('isPermaLink' => 'true', 'value' => 'http://groups.google.com/group/cake-php/msg/49bc00f3bc651b4f'),
						'author' => 'bmil...@gmail.com(bpscrugs)',
						'pubDate' => 'Fri, 28 Dec 2007 00:44:14 UT',
					),
					array(
						'title' => 'Re: share views between actions?',
						'link' => 'http://groups.google.com/group/cake-php/msg/8b350d898707dad8',
						'description' => 'Then perhaps you might do us all a favour and refrain from replying to <br> things you do not understand. That goes especially for asinine comments. <br> Indeed. <br> To sum up: <br> No comment. <br> In my day, a simple &quot;RTFM&quot; would suffice. I\'ll keep in mind to ignore any <br> further responses from you. <br> You (and I) were referring to the *online documentation*, not other',
						'guid' => array('isPermaLink' => 'true', 'value' => 'http://groups.google.com/group/cake-php/msg/8b350d898707dad8'),
						'author' => 'subtropolis.z...@gmail.com(subtropolis zijn)',
						'pubDate' => 'Fri, 28 Dec 2007 00:45:01 UT'
					)
				)
			)
		));
		$this->assertEqual($result, $expected);
		$string ='<data><post title="Title of this post" description="cool"/></data>';

		$xml = new Xml($string);
		$result = Set::reverse($xml);
		$expected = array('Data' => array('Post' => array('title' => 'Title of this post', 'description' => 'cool')));
		$this->assertEqual($result, $expected);

		$xml = new Xml('<example><item><title>An example of a correctly reversed XMLNode</title><desc/></item></example>');
		$result = Set::reverse($xml);
		$expected = array('Example' =>
			array(
				'Item' => array(
					'title' => 'An example of a correctly reversed XMLNode',
					'desc' => array(),
				)
			)
		);
		$this->assertIdentical($result, $expected);

		$xml = new Xml('<example><item attr="123"><titles><title>title1</title><title>title2</title></titles></item></example>');
		$result = Set::reverse($xml);
		$expected =
			array('Example' => array(
				'Item' => array(
					'attr' => '123',
					'Titles' => array(
						'Title' => array('title1', 'title2')
					)
				)
			)
		);
		$this->assertIdentical($result, $expected);

		$xml = new Xml('<example attr="ex_attr"><item attr="123"><titles>list</titles>textforitems</item></example>');
		$result = Set::reverse($xml);
		$expected =
			array('Example' => array(
				'attr' => 'ex_attr',
				'Item' => array(
					'attr' => '123',
					'titles' => 'list',
					'value'  => 'textforitems'
				)
			)
		);
		$this->assertIdentical($result, $expected);

		$string = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
		<rss version="2.0">
		  <channel>
		  <title>Cake PHP Google Group</title>
		  <link>http://groups.google.com/group/cake-php</link>
		  <description>Search this group before posting anything. There are over 20,000 posts and it&amp;#39;s very likely your question was answered before. Visit the IRC channel #cakephp at irc.freenode.net for live chat with users and developers of Cake. If you post, tell us the version of Cake, PHP, and database.</description>
		  <language>en</language>
		  	<item>
			  <title>constructng result array when using findall</title>
			  <link>http://groups.google.com/group/cake-php/msg/49bc00f3bc651b4f</link>
			  <description>i&#39;m using cakephp to construct a logical data model array that will be &lt;br&gt; passed to a flex app. I have the following model association: &lt;br&gt; ServiceDay-&amp;gt;(hasMany)ServiceTi me-&amp;gt;(hasMany)ServiceTimePrice. So what &lt;br&gt; the current output from my findall is something like this example: &lt;br&gt; &lt;p&gt;Array( &lt;br&gt; [0] =&amp;gt; Array(</description>
			  	<dc:creator>cakephp</dc:creator>
				<category><![CDATA[cakephp]]></category>
				<category><![CDATA[model]]></category>
			  <guid isPermaLink="true">http://groups.google.com/group/cake-php/msg/49bc00f3bc651b4f</guid>
			  <author>bmil...@gmail.com(bpscrugs)</author>
			  <pubDate>Fri, 28 Dec 2007 00:44:14 UT</pubDate>
			  </item>
			  <item>
			  <title>Re: share views between actions?</title>
			  <link>http://groups.google.com/group/cake-php/msg/8b350d898707dad8</link>
			  <description>Then perhaps you might do us all a favour and refrain from replying to &lt;br&gt; things you do not understand. That goes especially for asinine comments. &lt;br&gt; Indeed. &lt;br&gt; To sum up: &lt;br&gt; No comment. &lt;br&gt; In my day, a simple &amp;quot;RTFM&amp;quot; would suffice. I&#39;ll keep in mind to ignore any &lt;br&gt; further responses from you. &lt;br&gt; You (and I) were referring to the *online documentation*, not other</description>
			  	<dc:creator>cakephp</dc:creator>
				<category><![CDATA[cakephp]]></category>
				<category><![CDATA[model]]></category>
			  <guid isPermaLink="true">http://groups.google.com/group/cake-php/msg/8b350d898707dad8</guid>
			  <author>subtropolis.z...@gmail.com(subtropolis zijn)</author>
			  <pubDate>Fri, 28 Dec 2007 00:45:01 UT</pubDate>
			 </item>
		</channel>
		</rss>';

		$xml = new Xml($string);
		$result = Set::reverse($xml);

		$expected = array('Rss' => array(
			'version' => '2.0',
			'Channel' => array(
				'title' => 'Cake PHP Google Group',
				'link' => 'http://groups.google.com/group/cake-php',
				'description' => 'Search this group before posting anything. There are over 20,000 posts and it&#39;s very likely your question was answered before. Visit the IRC channel #cakephp at irc.freenode.net for live chat with users and developers of Cake. If you post, tell us the version of Cake, PHP, and database.',
				'language' => 'en',
				'Item' => array(
					array(
						'title' => 'constructng result array when using findall',
						'link' => 'http://groups.google.com/group/cake-php/msg/49bc00f3bc651b4f',
						'description' => "i'm using cakephp to construct a logical data model array that will be <br> passed to a flex app. I have the following model association: <br> ServiceDay-&gt;(hasMany)ServiceTi me-&gt;(hasMany)ServiceTimePrice. So what <br> the current output from my findall is something like this example: <br><p>Array( <br> [0] =&gt; Array(",
						'creator' => 'cakephp',
						'Category' => array('cakephp', 'model'),
						'guid' => array('isPermaLink' => 'true', 'value' => 'http://groups.google.com/group/cake-php/msg/49bc00f3bc651b4f'),
						'author' => 'bmil...@gmail.com(bpscrugs)',
						'pubDate' => 'Fri, 28 Dec 2007 00:44:14 UT',
					),
					array(
						'title' => 'Re: share views between actions?',
						'link' => 'http://groups.google.com/group/cake-php/msg/8b350d898707dad8',
						'description' => 'Then perhaps you might do us all a favour and refrain from replying to <br> things you do not understand. That goes especially for asinine comments. <br> Indeed. <br> To sum up: <br> No comment. <br> In my day, a simple &quot;RTFM&quot; would suffice. I\'ll keep in mind to ignore any <br> further responses from you. <br> You (and I) were referring to the *online documentation*, not other',
						'creator' => 'cakephp',
						'Category' => array('cakephp', 'model'),
						'guid' => array('isPermaLink' => 'true', 'value' => 'http://groups.google.com/group/cake-php/msg/8b350d898707dad8'),
						'author' => 'subtropolis.z...@gmail.com(subtropolis zijn)',
						'pubDate' => 'Fri, 28 Dec 2007 00:45:01 UT'
					)
				)
			)
		));
		$this->assertEqual($result, $expected);

		$text = '<?xml version="1.0" encoding="UTF-8"?>
		<XRDS xmlns="xri://$xrds">
		<XRD xml:id="oauth" xmlns="xri://$XRD*($v*2.0)" version="2.0">
			<Type>xri://$xrds*simple</Type>
			<Expires>2008-04-13T07:34:58Z</Expires>
			<Service>
				<Type>http://oauth.net/core/1.0/endpoint/authorize</Type>
				<Type>http://oauth.net/core/1.0/parameters/auth-header</Type>
				<Type>http://oauth.net/core/1.0/parameters/uri-query</Type>
				<URI priority="10">https://ma.gnolia.com/oauth/authorize</URI>
				<URI priority="20">http://ma.gnolia.com/oauth/authorize</URI>
			</Service>
		</XRD>
		<XRD xmlns="xri://$XRD*($v*2.0)" version="2.0">
			<Type>xri://$xrds*simple</Type>
				<Service priority="10">
					<Type>http://oauth.net/discovery/1.0</Type>
					<URI>#oauth</URI>
				</Service>
		</XRD>
		</XRDS>';

		$xml = new Xml($text);
		$result = Set::reverse($xml);

		$expected = array('XRDS' => array(
			'xmlns' => 'xri://$xrds',
			'XRD' => array(
				array(
					'xml:id' => 'oauth',
					'xmlns' => 'xri://$XRD*($v*2.0)',
					'version' => '2.0',
					'Type' => 'xri://$xrds*simple',
					'Expires' => '2008-04-13T07:34:58Z',
					'Service' => array(
						'Type' => array(
							'http://oauth.net/core/1.0/endpoint/authorize',
							'http://oauth.net/core/1.0/parameters/auth-header',
							'http://oauth.net/core/1.0/parameters/uri-query'
						),
						'URI' => array(
							array(
								'value' => 'https://ma.gnolia.com/oauth/authorize',
								'priority' => '10',
							),
							array(
								'value' => 'http://ma.gnolia.com/oauth/authorize',
								'priority' => '20'
							)
						)
					)
				),
				array(
					'xmlns' => 'xri://$XRD*($v*2.0)',
					'version' => '2.0',
					'Type' => 'xri://$xrds*simple',
					'Service' => array(
						'priority' => '10',
						'Type' => 'http://oauth.net/discovery/1.0',
						'URI' => '#oauth'
					)
				)
			)
		));
		$this->assertEqual($result, $expected);
	}

/**
 * testStrictKeyCheck method
 *
 * @access public
 * @return void
 */
	function testStrictKeyCheck() {
		$set = array('a' => 'hi');
		$this->assertFalse(Set::check($set, 'a.b'));
	}

/**
 * Tests Set::flatten
 *
 * @access public
 * @return void
 */
	function testFlatten() {
		$data = array('Larry', 'Curly', 'Moe');
		$result = Set::flatten($data);
		$this->assertEqual($result, $data);

		$data[9] = 'Shemp';
		$result = Set::flatten($data);
		$this->assertEqual($result, $data);

		$data = array(
			array(
				'Post' => array('id' => '1', 'author_id' => '1', 'title' => 'First Post'),
				'Author' => array('id' => '1', 'user' => 'nate', 'password' => 'foo'),
			),
			array(
				'Post' => array('id' => '2', 'author_id' => '3', 'title' => 'Second Post', 'body' => 'Second Post Body'),
				'Author' => array('id' => '3', 'user' => 'larry', 'password' => null),
			)
		);

		$result = Set::flatten($data);
		$expected = array(
			'0.Post.id' => '1', '0.Post.author_id' => '1', '0.Post.title' => 'First Post', '0.Author.id' => '1',
			'0.Author.user' => 'nate', '0.Author.password' => 'foo', '1.Post.id' => '2', '1.Post.author_id' => '3',
			'1.Post.title' => 'Second Post', '1.Post.body' => 'Second Post Body', '1.Author.id' => '3',
			'1.Author.user' => 'larry', '1.Author.password' => null
		);
		$this->assertEqual($result, $expected);
	}
}
