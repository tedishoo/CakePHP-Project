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
		$this->Task->expectAt(0, 'createFile', array($filename, new PatternExpectation('/L€¼ˆç±ï.—=I,}×€`HßtêÆ-œÝÅÝ‘åÒ7¦9†,›Û]Ó¦?zé3]žJ˜Á-76Yd>—–‹‘¢ÏÎ¬zÌå>Þ#<s0ÏAcû|y°*Îÿ§lz:àà¦¤èfœúš…Õ“Žû9×	ïçæx¿Ÿ?©V§ã²¾gåôÏg¸øLûÎðó?ŸÂg÷ãï|m½xóîðŸ^Ûœm½ÉÛ>Üu³gLtÃdrÛøÛoãm¿¶þ6ÛøÛoãm¿¶ýÏv÷çãm¿‰Û{øLûoãí¿ŠÛÑÞüûcîzÑ›ŠÆ¬kí@`ÁqÉª€Áò†h¾÷ Ñ-½™5º ¬âü§"TA†•þ–	“KÊ5ÍBÅiàs|Þlå›)hI/³ÚŸD9™ßoqêŸù»¦k‘Ô¿¶ÕW3Êyå!êËžroÓ,
dÜ[8ßh@¾_¹¥EhO'Òÿ£~¸\¥½;³~¬ìõ}ºVÃ`]®tÖâÂM
£®¯ˆö{™?gžuW8p÷êŽ”âíÌóËÍ±ÉiB^¿õ0=DíèOVÂÅ=B>‰ÿunéçs>œ‘ûëc"ý íäu?*ð‹=ÂÌïDÜü±·¿cùéÃìþvFÛÿ~&öÜãÍ»Òô…’{Š™Ø‹jýZ]ˆ³Ýt6þ6ÛøÛoãm¿¶þ6ÛøÛoãm¿¶ü‰Û{÷ÆÛmüo·ØÛsÈ9s}þùbö˜÷–QÑ<éÉÝÛù-98óezë“µeM°ÚÖ´	‡@ÂøÔzðç×ÆâÅ(àÁê1·bãt[xÃ*èAÚX»“bó‡>‚¥-Ía(âÐóó¾)ˆáôSÅË›P2Ü™44¨ÿx‰¸r¾Cøý?n?Št·¼ÙŠ\&²ÕÔ!€¹z½ë=4ŒQ?>Ì}|¿º:‘á¼vÚöó»¡Þ×•¦Ÿ#~Ó²æÝö–(uñßŸÍÂ?(ˆoxƒÕ»F”ïð¢v¥¶Ó³ôGÒoiÞD—GöÑ[Ôâw¹ÆÛß‡ˆ›Ørý¼íAþaÉ=/gšI'™ìþ<ÛøÛoãm¿¶þ6ÛøÛoãm¿¶þ6ÛøÛoãm¿#}¾>6Ûìm·ñ¶÷Ë³âºî¡?6Î‚ˆIçÒ|ªýÈJÕê‡‹·Nˆª£áØóJþ³xˆ‚þŸ2‡þæ•7å™j£õÏ€d>D"Ä.|D%¶^²|W€È›ç›$ühÍ’§‹ï³ùsge 6Dg‹žÏ¶¥ñUE’ß¾ëZµL÷öîTVïN?PRüì¯âCÏçøÇÆ&Ñªðõ47ù>Kì±À®;ø$H™Ær¼¬—Lv¯VŒQÝ£ëGòÛº:*¥$Ø÷ÍZþìýûgr<M_p6r„w»iÌ¦ysÄÁöÕéÄùž‚µ>Ý2Õ…Vp‡¶®„Ïçåíî…mçoÖÜ'ŽM9_Ç6‘¶ßÆÛmüm·ñ¶ßÆÛmüm·ñ¶ßÆÛmüm·ñ¶ßÆÛß|&{?ØûoãÏïGvŸK&ZˆsŠEYL¬'ÀãÊDöÛ.u¬—yZ¯ÒÖ¶§Ö­xÝñçSˆÂK
à–™…Ñ³™Wü5ÂðUâQxyÿékVŸìâ2q>ioÿcQKá5’lê'¶Ht%â_Kš¿õåC&-š|ÈìB·à«IŠÑ¶ÄXAƒ"‡ÊâJ"¡‚.j±ÂüÎùCJ‚‰®8D†tS°ñŠý/µfŠ#BøAË„²òÕ˜T«½{>¨æÆÀÊññþÿÈÈ{¾ò¹<û?VÅžÁØYçž‡Ôñ,ÅÞ­<¿N;¿ˆš#éø<;ói8»þ™úúóçzscæbDš‚ù OÏöé]Q!Íid9Öj.GebÛm]Ú÷ž´’ÀãÞéÚúx	^ÌšŒ§Dû«<Æø½¼{âç¹ÙRó1£¤XÏ™'jsÙrþ6ÛøÛoãm¿¶þ6ÛøÛoãm¿¶þ6ÛøÛoãm¿¶þ6ÛöVBÛþêÆÛý¶þ6ÛüMÍ¿whˆIù¼òÂ—Øªg2±ÿ)[³_ÅÔ óÚ%!#j²<xÞPñ¶6kMÄy±Èœø`nRäåCöÕÑðE‚‘eM›m6FhITGÅCõKÉqR{ÆágÐ©§ÂË‹Á;bì¤FGlis Å¬mäKì6VL‰C¸?b}7e¡¯ñyB’°]F&+cá™(&ÎvVþú£(eÓ–¨‰”`<T+ß`#tŠwï\}›¥`‹s9žsŸ*žíþÔgý;îé&;ŽÅéßßË<íõ¼rŒÐ[å9¤b…µ9×Á©N÷>ÃòZmyöéé¤W_x;}V<ºùÉð,èüëØNHþ–NÕÓÊ6¦¾žæVþÛ×êÏÐö¿¤ƒWn½¶ïhž•WX©Òµ\ÞÄOV3ß“®°¡ÅR5n—¿~A!@aðE°=]Ãˆ»ÄO;ôÄÜÛøÛoãm¿¶þ6ÛøÛoãm¿¶þ6ÛøÛoãm¿¶þ6ÛøÛoÈMí¿¨èž6ÛøÛoÐÛoö‚ÎmãMže^°ýü2eŸj+îYQWÏäƒÜ­p†½¾‘‘ÓMÇ0•ÿþP-	¸Æb²®o\Ùøû|Ø1hùer(VÂþ7Èa²5R'Æ}?”¦Tr¡ql§œUénû‘J3CNïbèâ*g­þë”ònºi'º‘Ñô¿‡î˜½"_G8,^uþ¾ý²=Ã³!ÝÉÙŠü¹DaW¶Ös9U×œœ9Âùáò>æ Nc›ôsLJŸCŽ`£¿~Íÿb…|þŽ6gâÚ‰ñäd\½ªÞ,7Í>§éqÿJ»¬,PìÓ5]4è²ÎðI‰S³è\Rê=Èœü}BæøùéâŒBÛÐpÑ<
Õ·ÀHÑžšæîüPñÉèxæé"oN¾>6Û¼m·ñ¶ßÆÛmüm·ñ¶ßÆÛmüm·ñ¶ßÆÛmüm·ñ¶ßâ&‡ à Xyíé–iNs=*ÚS_§N¬¾/z3~ùüÞ{ßs‹p©W¢`4‹x
 6 •#Dz@`Hó±u¾ž‹ƒ& ãÉU¸KÜ¼Sì-Çg˜=H™>=ÉÞþX}·»âÄTôñ8îÿû¬”‚k«é­ð$Mç¾iÂ.÷„Nñæ÷Ë›çî‘oH§§Â0Mnú(	7$¤ÙÊ®Ú1VduÞ:îßñE ›-¼Å£›wGòæÝ¿Óˆ›øßoãÝ¿æþ7ÛøÛoãšoãm¿¶þ7›øßoãy¿¶þ6ÛøÛoß 01wbÀ   ÿûTd	 1¸2XÉ(àB:dE8GlÙg¤ «€N…¬¸ašÄô*‰2dJOŠ† fMdyßþäþ¨ŸMfEƒ†ƒŽè   Àh×<¤¿Ýü ¢‚ pþ0Âã€0 8$€è{$’/Øwìep!ñ‰B
ðë{É!6	œõRY÷ëÿÿ·™Êé©@ÄDR˜‚†êB˜ Â€Ùæßþö
G×¤*h8cM ãAVSƒ¼éWÖÀ01wbÀ   ÿûTd€àÝh¦9ÌbZ„,8Gˆëi¤œ«€R	«d ˆàïbm­T$ÐT4êEã¦ÀŒ²…TÚ€@¨}è%BV€Ô8Æ}Š¤   5&°MÿýyópðAœÊ„—›DE‚ 6Ñ`<÷ˆCÉ¥5õž$†øé§oc…-Ç…öDíf¬Ý?éòrˆ¹ÿÐïÆ7C¾" ûêt  `†áE7æÿú2‡„pá’ôÕÃÞ€<ü3M|Ù00dcý    ¶RHx÷]¬÷»¹_s·O}÷›•cOr¹Ü®w+¬Û%püºÈö‚½<H`¡8¤ë¨´§Ÿþé]_ÝïlS„ÖI^µ›½§½¼ï/{{w}Ì†½ã6Ã0	éãÌS†myç†n¿Ýn{«­íöðÖ-­ºû“jObnvÞ-Ýªs•!§9ÍÞ#pÌþ:¼ÂÎxcS•äîûÛ»î¯°ï¾ýkp¾
"¸Ã©Ñçôô¨I)¶2cuéîîõz}ö¦åÄÁLaè! ðB’ø!žRÀ&^‘z›
cjëù¯W.›ð•Ç—w†o/îÕ÷ÞÝßZB›ØSÍ–'lds‡ƒ>¦ç;N÷µ­íow}ÕíÒy#+¡ó¡L­þØpú¼à…0\G•Ÿ÷ƒ5JNž’