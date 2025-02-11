<?php
/**
 * FixtureTask Test case
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.tests.cases.console.libs.tasks
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import('Shell', 'Shell', false);

if (!defined('DISABLE_AUTO_DISPATCH')) {
	define('DISABLE_AUTO_DISPATCH', true);
}

if (!class_exists('ShellDispatcher')) {
	ob_start();
	$argv = false;
	require CAKE . 'console' .  DS . 'cake.php';
	ob_end_clean();
}

require_once CAKE . 'console' .  DS . 'libs' . DS . 'tasks' . DS . 'template.php';
require_once CAKE . 'console' .  DS . 'libs' . DS . 'tasks' . DS . 'fixture.php';

Mock::generatePartial(
	'ShellDispatcher', 'TestFixtureTaskMockShellDispatcher',
	array('getInput', 'stdout', 'stderr', '_stop', '_initEnvironment')
);

Mock::generatePartial(
	'FixtureTask', 'MockFixtureTask',
	array('in', 'out', 'err', 'createFile', '_stop')
);

Mock::generatePartial(
	'Shell', 'MockFixtureModelTask',
	array('in', 'out', 'err', 'createFile', '_stop', 'getName', 'getTable', 'listAll')
);

/**
 * FixtureTaskTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.console.libs.tasks
 */
class FixtureTaskTest extends CakeTestCase {

/**
 * fixtures
 *
 * @var array
 * @access public
 */
	var $fixtures = array('core.article', 'core.comment', 'core.datatype', 'core.binary_test');

/**
 * startTest method
 *
 * @return void
 * @access public
 */
	function startTest() {
		$this->Dispatcher =& new TestFixtureTaskMockShellDispatcher();
		$this->Task =& new MockFixtureTask();
		$this->Task->Model =& new MockFixtureModelTask();
		$this->Task->Dispatch =& $this->Dispatcher;
		$this->Task->Template =& new TemplateTask($this->Task->Dispatch);
		$this->Task->Dispatch->shellPaths = App::path('shells');
		$this->Task->Template->initialize();
	}

/**
 * endTest method
 *
 * @return void
 * @access public
 */
	function endTest() {
		unset($this->Task, $this->Dispatcher);
		ClassRegistry::flush();
	}

/**
 * test that initialize sets the path
 *
 * @return void
 * @access public
 */
	function testConstruct() {
		$this->Dispatch->params['working'] = DS . 'my' . DS . 'path';
		$Task =& new FixtureTask($this->Dispatch);

		$expected = DS . 'my' . DS . 'path' . DS . 'tests' . DS . 'fixtures' . DS;
		$this->assertEqual($Task->path, $expected);
	}

/**
 * test import option array generation
 *
 * @return void
 * @access public
 */
	function testImportOptions() {
		$this->Task->setReturnValueAt(0, 'in', 'y');
		$this->Task->setReturnValueAt(1, 'in', 'y');

		$result = $this->Task->importOptions('Article');
		$expected = array('schema' => 'Article', 'records' => true);
		$this->assertEqual($result, $expected);

		$this->Task->setReturnValueAt(2, 'in', 'n');
		$this->Task->setReturnValueAt(3, 'in', 'n');
		$this->Task->setReturnValueAt(4, 'in', 'n');

		$result = $this->Task->importOptions('Article');
		$expected = array();
		$this->assertEqual($result, $expected);

		$this->Task->setReturnValueAt(5, 'in', 'n');
		$this->Task->setReturnValueAt(6, 'in', 'n');
		$this->Task->setReturnValueAt(7, 'in', 'y');
		$result = $this->Task->importOptions('Article');
		$expected = array('fromTable' => true);
		$this->assertEqual($result, $expected);
	}

/**
 * test generating a fixture with database conditions.
 *
 * @return void
 * @access public
 */
	function testImportRecordsFromDatabaseWithConditions() {
		$this->Task->interactive = true;
		$this->Task->setReturnValueAt(0, 'in', 'WHERE 1=1 LIMIT 10');
		$this->Task->connection = 'test_suite';
		$this->Task->path = '/my/path/';
		$result = $this->Task->bake('Article', false, array('fromTable' => true, 'schema' => 'Article', 'records' => false));

		$this->assertPattern('/class ArticleFixture extends CakeTestFixture/', $result);
		$this->assertPattern('/var \$records/', $result);
		$this->assertPattern('/var \$import/', $result);
		$this->assertPattern("/'title' => 'First Article'/", $result, 'Missing import data %s');
		$this->assertPattern('/Second Article/', $result, 'Missing import data %s');
		$this->assertPattern('/Third Article/', $result, 'Missing import data %s');
	}

/**
 * test that execute passes runs bake depending with named model.
 *
 * @return void
 * @access public
 */
	function testExecuteWithNamedModel() {
		$this->Task->connection = 'test_suite';
		$this->Task->path = '/my/path/';
		$this->Task->args = array('article');
		$filename = '/my/path/article_fixture.php';
		$this->Task->expectAt(0, 'createFile', array($filename, new PatternExpectation('/class ArticleFixture/')));
		$this->Task->execute();
	}

/**
 * test that execute passes runs bake depending with named model.
 *
 * @return void
 * @access public
 */
	function testExecuteWithNamedModelVariations() {
		$this->Task->connection = 'test_suite';
		$this->Task->path = '/my/path/';

		$this->Task->args = array('article');
		$filename = '/my/path/article_fixture.php';
		$this->Task->expectAt(0, 'createFile', array($filename, new PatternExpectation('/class ArticleFixture/')));
		$this->Task->execute();

		$this->Task->args = array('articles');
		$filename = '/my/path/article_fixture.php';
		$this->Task->expectAt(1, 'createFile', array($filename, new PatternExpectation('/class ArticleFixture/')));
		$this->Task->execute();

		$this->Task->args = array('Articles');
		$filename = '/my/path/article_fixture.php';
		$this->Task->expectAt(2, 'createFile', array($filename, new PatternExpectation('/class ArticleFixture/')));
		$this->Task->execute();

		$this->Task->args = array('Article');
		$filename = '/my/path/article_fixture.php';
		$this->Task->expectAt(3, 'createFile', array($filename, new PatternExpectation('/class ArticleFixture/')));
		$this->Task->execute();
	}

/**
 * test that execute runs all() when args[0] = all
 *
 * @return void
 * @access public
 */
	function testExecuteIntoAll() {
		$this->Task->connection = 'test_suite';
		$this->Task->path = '/my/path/';
		$this->Task->args = array('all');
		$this->Task->Model->setReturnValue('listAll', array('articles', 'comments'));

		$filename = '/my/path/article_fixture.php';
		$this->Task->expectAt(0, 'createFile', array($filename, new PatternExpectation('/class ArticleFixture/')));
		$this->Task->execute();

		$filename = '/my/path/comment_fixture.php';
		$this->Task->expectAt(1, 'createFile', array($filename, new PatternExpectation('/class CommentFixture/')));
		$this->Task->execute();
	}

/**
 * test using all() with -count and -records
 *
 * @return void
 * @access public
 */
	function testAllWithCountAndRecordsFlags() {
		$this->Task->connection = 'test_suite';
		$this->Task->path = '/my/path/';
		$this->Task->args = array('all');
		$this->Task->params = array('count' => 10, 'records' => true);
		$this->Task->Model->setReturnValue('listAll', array('articles', 'comments'));

		$filename = '/my/path/article_fixture.php';
		$this->Task->expectAt(0, 'createFile', array($filename, new PatternExpectation('/title\' => \'Third Article\'/')));

		$filename = '/my/path/comment_fixture.php';
		$this->Task->expectAt(1, 'createFile', array($filename, new PatternExpectation('/comment\' => \'First Comment for First Article/')));
		$this->Task->expectCallCount('createFile', 2);
		$this->Task->all();
	}

/**
 * test interactive mode of execute
 *
 * @return void
 * @access public
 */
	function testExecuteInteractive() {
		$this->Task->connection = 'test_suite';
		$this->Task->path = '/my/path/';

		$this->Task->setReturnValue('in', 'y');
		$this->Task->Model->setReturnValue('getName', 'Article');
		$this->Task->Model->setReturnValue('getTable', 'articles', array('Article'));

		$filename = '/my/path/article_fixture.php';
		$this->Task->expectAt(0, 'createFile', array($filename, new PatternExpectation('/L�����.�=�I,}׀`H�t��-���ݑ��7�9�,�۝]Ӧ?z�3]�J��-76Yd>������άz��>�#�<s0�Ac�|y�*���lz:�ত�f����Փ��9�	���x��?��V����g���g��L����?��g���|m�x���^ۜm���>�u�gLt�dr���o�m����6���o�m�����v���m���{�L�o�������c�zћ�Ƭk�@`�q�ɪ���h�� �-��5� ����"T�A����	�K�5�B�i�s|�l��)hI/���D9��oq����k�Կ��W3�y�!�˞ro�,
d�[8�h@�_��EhO'���~�\���;�~���}�V�`]�t���M
�����{�?g�uW8p�Ꝏ������ͱ�iB^��0=D��OV��=B>��un���s>����c"� ��u?*��=���D�����c�����vF��~&���ͻ��{��؋j�Z]���t�6�6���o�m����6���o�m������{���m�o���s�9s}��b����Q�<�����-98�ez듵eM��ִ	�@���z������(���1�b�t[x�*�A�X���b�>��-�a(����)���S�˛P2��44��x��r�C��?n?�t��ي\&���!��z��=4�Q?>�}|��:��v����ו��#~Ӳ����(u�ߟ���?(�ox��ջF���v��ӳ�G�oi�D�G��[��w����߇���r���A�a�=/g�I'���<���o�m����6���o�m����6���o�m�#}�>6��m���˝����?6΂�I��|���J�ꇋ�N������J��x����2���7�j�����d>D"�.|D%�^�|W�ț�$�h������sge 6Dg��϶��UE�߾�Z�L���TV�N?PR���C�����&Ѫ��47�>K����;�$H��r���Lv�V�Qݣ�G�ۺ:*�$���Z����gr<M_p6r�w�i̦ys����������>�2ՅVp����������m�o��'�M9_�6�����m�m�����m�m�����m�m������|&{?��o���Gv�K&Z�s�EYL�'���D��.�u��yZ�����֭x���S��K
����ѳ�W�5���U�Qxy��kV���2q>io�cQK�5�l�'�Ht%�_K����C&-�|��B��I�Ѷ�XA�"���J"��.j�����C�J���8D�tS���/�f���#B�A˄��՘T��{>�����������{��<�?VŞ��Y瞇��,ŝޭ<�N;���#��<;�i8���������zsc�bD����O���]Q!�id9�j.Geb�m]�����������x	^̚��D����<����{���R�1��Xϙ'js�r�6���o�m����6���o�m����6���o�m����6��VB���������6��MͿwh�I�����g2��)[�_�� ��%!#j�<x�P�6kM�y�Ȝ�`nR��C����E��eM�m6FhITG�C�K�qR{��gЍ���ˋ�;b�FGlis Ŭm�K�6V�L�C�?b}7e���yB��]F&+c�(&�vV�����(eӖ���`<T+�`#t�w�\}��`�s9�s�*�����g�;��&;�����ˏ<���r��[�9�b��9���N�>��Zmy���W_x;}V<����,����؏NH��N����6����V����������Wn���h��WX�ҵ\��OV�3ߓ����R5n��~A!@a�E�=]È��O;������o�m����6���o�m����6���o�m����6���o�M��6���o��o���m�M��e^���2e�j+�YQW��ܭp������M��0���P-	��b���o\ف��|�1h�er(V��7�a�5R'�}?��Tr�ql��U�n��J3CN�b��*g����n�i'������"�_G8,^u�����=ó!������DaW��s9Uל�9����>� �Nc��sLJ�C�`��~���b�|��6g�ډ��d\���,7�>��q�J��,P��5]4���I�S��\R�=Ȝ�}B�����B��p�<
շ�Hў����P���x��"oN�>6ۼm�����m�m�����m�m�����m�m����&� � X�y��iNs=*�S_�N��/z3~���{�s�p�W�`4�x
� 6 �#Dz@`H��u����& ��U�KܼS�-�g�=H�>=���X}����T��8�������k���$M�i�.��N���˝����oH����0Mn�(	7$��ʮ�1Vdu�:���E �-�ţ�wG��ݿ������o�ݿ���7���o�o�m����7���o�y����6���o� 01wb�   ��Td	 1�2X�(�B:dE8Gl�g����N���a���*��2dJO�� fM�dy������MfE������   �h�<��������p�0��0 8$��{$��/�w�ep!�B
��{�!6	��RY���������@�DR����B� ������
G��*h8cM �AVS���W��01wb�   ��Td���h�9�bZ�,8G��i����R	�d ���bm��T$�T4�E㦏�����Tڀ@�}�%BV��8�}��   5&�M��y�p�A�ʄ��DE� 6�`<��Cɥ5���$����oc�-ǅ�D�f��?��r������7C�" ��t� `��E7���2��p����ހ<�3M|��00dc�    �RHx�]����_s�O}���cOr�ܮw+���%p������<H`�8�������]_��lS��I^��������/{{w}�̆��6�0	���S�my�n��n{������-����jObnv�ޝ-ݪs�!�9��#p��:���xcS����ۻ��kp�
"�é�����I)�2cu����z}�����La�! �B��!�R�&^�z�
cj���W.��Ǘw�o/������ZB��S��'lds��>��;N�����ow}���y#+��L���p����0\G����5JN���