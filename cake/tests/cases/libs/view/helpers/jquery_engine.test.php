<?php
/**
 * JqueryEngineTestCase
 *
 * PHP versions 4 and 5
 *
 * CakePHP : Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2006-2009, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright       Copyright 2006-2009, Cake Software Foundation, Inc.
 * @link            http://cakephp.org CakePHP Project
 * @package         cake.tests
 * @subpackage      cake.tests.cases.views.helpers
 * @license         MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import('Helper', array('Html', 'Js', 'JqueryEngine'));

class JqueryEngineHelperTestCase extends CakeTestCase {
/**
 * startTest
 *
 * @return void
 */
	function startTest() {
		$this->Jquery =& new JqueryEngineHelper();
	}

/**
 * end test
 *
 * @return void
 */
	function endTest() {
		unset($this->Jquery);
	}

/**
 * test selector method
 *
 * @return void
 */
	function testSelector() {
		$result = $this->Jquery->get('#content');
		$this->assertEqual($result, $this->Jquery);
		$this->assertEqual($this->Jquery->selection, '$("#content")');

		$result = $this->Jquery->get('document');
		$this->assertEqual($result, $this->Jquery);
		$this->assertEqual($this->Jquery->selection, '$(document)');

		$result = $this->Jquery->get('window');
		$this->assertEqual($result, $this->Jquery);
		$this->assertEqual($this->Jquery->selection, '$(window)');

		$result = $this->Jquery->get('ul');
		$this->assertEqual($result, $this->Jquery);
		$this->assertEqual($this->Jquery->selection, '$("ul")');
	}

/**
 * test event binding
 *
 * @return void
 */
	function testEvent() {
		$this->Jquery->get('#myLink');
		$result = $this->Jquery->event('click', 'doClick', array('wrap' => false));
		$expected = '$("#myLink").bind("click", doClick);';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->event('click', '$(this).show();', array('stop' => false));
		$expected = '$("#myLink").bind("click", function (event) {$(this).show();});';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->event('click', '$(this).hide();');
		$expected = '$("#myLink").bind("click", function (event) {$(this).hide();'."\n".'return false;});';
		$this->assertEqual($result, $expected);
	}

/**
 * test dom ready event creation
 *
 * @return void
 */
	function testDomReady() {
		$result = $this->Jquery->domReady('foo.name = "bar";');
		$expected = '$(document).ready(function () {foo.name = "bar";});';
		$this->assertEqual($result, $expected);
	}

/**
 * test Each method
 *
 * @return void
 */
	function testEach() {
		$this->Jquery->get('#foo');
		$result = $this->Jquery->each('$(this).hide();');
		$expected = '$("#foo").each(function () {$(this).hide();});';
		$this->assertEqual($result, $expected);
	}

/**
 * test Effect generation
 *
 * @return void
 */
	function testEffect() {
		$this->Jquery->get('#foo');
		$result = $this->Jquery->effect('show');
		$expected = '$("#foo").show();';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->effect('hide');
		$expected = '$("#foo").hide();';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->effect('hide', array('speed' => 'fast'));
		$expected = '$("#foo").hide("fast");';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->effect('fadeIn');
		$expected = '$("#foo").fadeIn();';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->effect('fadeOut');
		$expected = '$("#foo").fadeOut();';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->effect('slideIn');
		$expected = '$("#foo").slideDown();';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->effect('slideOut');
		$expected = '$("#foo").slideUp();';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->effect('slideDown');
		$expected = '$("#foo").slideDown();';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->effect('slideUp');
		$expected = '$("#foo").slideUp();';
		$this->assertEqual($result, $expected);
	}

/**
 * Test Request Generation
 *
 * @return void
 */
	function testRequest() {
		$result = $this->Jquery->request(array('controller' => 'posts', 'action' => 'view', 1));
		$expected = '$.ajax({url:"\\/posts\\/view\\/1"});';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->request(array('controller' => 'posts', 'action' => 'view', 1), array(
			'update' => '#content'
		));
		$expected = '$.ajax({dataType:"html", success:function (data, textStatus) {$("#content").html(data);}, url:"\/posts\/view\/1"});';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->request('/people/edit/1', array(
			'method' => 'post',
			'before' => 'doBefore',
			'complete' => 'doComplete',
			'success' => 'doSuccess',
			'error' => 'handleError',
			'type' => 'json',
			'data' => array('name' => 'jim', 'height' => '185cm'),
			'wrapCallbacks' => false
		));
		$expected = '$.ajax({beforeSend:doBefore, complete:doComplete, data:"name=jim&height=185cm", dataType:"json", error:handleError, success:doSuccess, type:"post", url:"\\/people\\/edit\\/1"});';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->request('/people/edit/1', array(
			'update' => '#updated',
			'success' => 'doFoo',
			'method' => 'post',
			'wrapCallbacks' => false
		));
		$expected = '$.ajax({dataType:"html", success:function (data, textStatus) {$("#updated").html(data);}, type:"post", url:"\\/people\\/edit\\/1"});';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->request('/people/edit/1', array(
			'update' => '#updated',
			'success' => 'doFoo',
			'method' => 'post',
			'dataExpression' => true,
			'data' => '$("#someId").serialize()',
			'wrapCallbacks' => false
		));
		$expected = '$.ajax({data:$("#someId").serialize(), dataType:"html", success:function (data, textStatus) {$("#updated").html(data);}, type:"post", url:"\\/people\\/edit\\/1"});';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->request('/people/edit/1', array(
			'success' => 'doFoo',
			'before' => 'doBefore',
			'method' => 'post',
			'dataExpression' => true,
			'data' => '$("#someId").serialize()',
		));
		$expected = '$.ajax({beforeSend:function (XMLHttpRequest) {doBefore}, data:$("#someId").serialize(), success:function (data, textStatus) {doFoo}, type:"post", url:"\\/people\\/edit\\/1"});';
		$this->assertEqual($result, $expected);
	}

/**
 * test that alternate jQuery object values work for request()
 *
 * @return void
 */
	function testRequestWithAlternateJqueryObject() {
		$this->Jquery->jQueryObject = '$j';

		$result = $this->Jquery->request('/people/edit/1', array(
			'update' => '#updated',
			'success' => 'doFoo',
			'method' => 'post',
			'dataExpression' => true,
			'data' => '$j("#someId").serialize()',
			'wrapCallbacks' => false
		));
		$expected = '$j.ajax({data:$j("#someId").serialize(), dataType:"html", success:function (data, textStatus) {$j("#updated").html(data);}, type:"post", url:"\\/people\\/edit\\/1"});';
		$this->assertEqual($result, $expected);
	}

/**
 * test sortable list generation
 *
 * @return void
 */
	function testSortable() {
		$this->Jquery->get('#myList');
		$result = $this->Jquery->sortable(array(
			'distance' => 5,
			'containment' => 'parent',
			'start' => 'onStart',
			'complete' => 'onStop',
			'sort' => 'onSort',
			'wrapCallbacks' => false
		));
		$expected = '$("#myList").sortable({containment:"parent", distance:5, sort:onSort, start:onStart, stop:onStop});';
		$this->assertEqual($result, $expected);

		$result = $this->Jquery->sortable(array(
			'distance' => 5,
			'containment' => 'parent',
			'start' => 'onStart',
			'complete' => 'onStop',
			'sort' => 'onSort',
		));
		$expected = '$("#myList").sortable({containment:"parent", distance:5, sort:function (event, ui) {onSort}, start:function (event, ui) {onStart}, stop:function (event, ui) {onStop}});';
		$this->assertEqual($result, $expected);
	}

/**
 * test drag() method
 *
 * @return void
 */
	function testDrag() {
		$this->JqÈ`ºè€ë4š‹]Ì9èµ^† gt>¸o¶+î-cÏtsf;è¬¬išÁU…%Ø;]ß¡ªÌ[¨S!qÁÒÖ@©ŽO“žŠeYX |’Ð”(v@õÌØ>}ßËT Çw¯Yl•O¹‰Æ—BºÙBýJ³íÒ?ÙD5PÉÑŽ–Š¦NÕd$TÃò0us~—¥W~ãæÄfK\6³æ6ðbÌ„}xÁ{”*>b/b·ï~=î*a^'\iøK¥z0oO|¡: ÑO¯†ï7û˜ ;	À®ëióœqä °½vÁ)dd£ .µ_q†*1Å|HÃÉ:Ã=Ú4•ˆ1,ËÀÓÓ×­Gà~(laÚðG*ŸéÑ
˜áâ1d8ò´&{~4Î›‡ÛÓ½´¾KU(èÆ¶ïÒŒúZ¬õ­œm¿;Ä¤Vœ.:‚Qõ€ú"Ü.=Ø¶ÄÍÎþÔL?ýLj³™Ê¡£ÊVcgøIù˜öµGnló¥oÚöE¡EÑàŒøeÐš¯Ù^Ú,þ&“ÑÌ÷êŽƒ(­=Ì4Ùå`«vÝ`®’$['î“„¨¯UvÀÄ—)œ‡øÈœxŒÅJÅfâ=Þ½dé†ÔfäÝ…-ŒRo`h$òú-àžötxÊ>g2|…†Í¶¼y…q{îz³XrbÊiº®NìX¯ P4Aš¦V#îÏôC7Ê¸ÊÈ{î­îBy_…‚œ^³<éˆ$ó ÿXäÀÊ¦JžÑðnaq¼^nùÎ7ä›ž6uIõÔ=lËc§ã„ h¬QA,öÔ^}‚œ¼ñÕñþÖÙwkÿàCbó¦íWi™Ö*SçïGa\ n¬-Bd¾´mh ïë:…î ëqY”b¨å|IB¹h`–Ì~Ü¢¼]FpcÄ†rzËÆk öÄ+üÙgçw³&óXk²I¤e±´ÝlCÄÍè ,(†HÀð•dïc¯õxØ!M¡Š<ð`Um4iâf"Tœ@|Ç%!Û2n*êÔ@Pf‚±w9>:<Ô²Ã¿¹†›wêîº/‹aBX‰b?°HeÛ‰ë»™tïÑ,¹~ÁAY|”–¨´¯ÀM¬õPi©6dƒBÖÛ=hÇý’}~HOŠèÔ$ö0~%Œ‹z³GLíß	+äf÷ptL,…ÇbaBÜPX¨æpÎ¸;¯eÊy1j–sÒmzÐ»e&A¶~Œ“­³ê¤Y¾
$61%;†ç`W5mÌ÷lHá=ÓÊ[šý†÷Ñ;[¦ 
*Ž'Ï$ñªà8¼I[0²7ƒâÛ^ó or]ç&›¥w>Mw?ñ	Î‰HõLN¿?ß?Zš×JÞé þïžœ’=FëÚ(ê$íP~Rÿ0ƒVµÞËé×ÈÁî_˜'y!¬¸‡ù•xÛŒÂiÆë4‘bÄ¿Œõ™‚O}`
ÖÈ‚ƒ¼|x©à ¬føt]"Üu³×¨/gëP?#Ôºôa#i;ïð9m­Û&%  3œ1fÊ²X¦§Ž2l†ae5+ã ûœL]™#Œ9§’³)©é(xm‡c±tû+3UdLYu	hPi¥Y
†j—ë	‡Ä/„u˜g‚€•~,IXvAI1#yã˜äí».HÙÁÜÙì„¶×¶ ŠÁ ¶Åjåî!ÐÿlqBÌ±‚ \¿`¹î^¤í^îå‡ w//[øX¸	Gì»ºûæ0´üî”ë(¼¼I÷V°w©ÎOÞFŒO ¾œàW†Ø˜É“VMÒèŸ§àóäAê[fk˜[•²¤“œTGêT½û‹¦ièë’lß‚X„ÜØ'š]û¸hÄî¿j6:Dÿx„#Œ´“/9a”je~éÌ4ckš5ëZÌLˆ
ÜÖ•áÎ8Ìp£c€ýú[Í.^fíìÆ®ª5|U¿µ²€ßèMä;ç÷tôÕåZ&IŒl—×ÖmýZñxœÞ2ûBF…1Ç|É*\þ×ÿ>r<dŸ»ƒÐ±ìð¬]ŒÌEÊJjhjá¸z©#i~°6`¾0/•¾.ÕŠñâøÕb±Pè.Ã&bÕ¥POò²@6l$˜O×înº¹þ"´1+^Y›öøáš‰¥(Dÿ/Fó†U¿È
#„sØ‚ÅEžÈ˜7Ýiá™jW±^ˆŒRÿ,<qÌ¿’ryœc:œ~†Jrµ$(Øâ3áÕhê•|™A±CBôÊA¥Ô’êÚo¬¼Eå¿,3P¤åž,'¦l
ú^ï'Ï»·zù®§KøKHìÎËRc{)3óK€*­ôÂà£SÈ,ÅÜWU­ôñ^^þ?Ú½ì±Ì«Z]{…L˜c‡ª=3 CÕUkÜÑº3'…*tÜs<ƒ&gvÐ¸´¡MFÐ¬3Áí°Q(PxgÁ*õWn²1Ÿtß ‘cœ‚½ÜbÇÐiŠí¶uñH†}DËyŒtØˆ:ÉI‰=ÞATâ&ÓxÃ¤LÉ*‡‚¶'KR^éþYP†5Œ·®^=û–D.·°õD5AÕ:W½À%ÿ®—É¨8»3ïÆ¢w›dûk7j”ó5¨<r°§wr‘["¹öêÂºÁ3ÕðFšNÍk}Là. ÑŸÎ€ka7bd™:íœÌ“Ÿæ´ó)ôïHŒþ‘þÈAùR8‰‰ Š¡’	Ö#<Ë-‹žl´™—¤9l‰°Eæ¬!»°H lö‚þ2x=àÒ7Qv½ö…¼ŸÐÚW¢ÐŽåZ¥01Í¤9gŒÄÔoOh‚µ'3DæÁÌé—Ý»8qé—8¾˜6¿ïÜx4ñÅGAÍ\<äh’n´Ðõlà@ëèD¼2×mï<ÈßuáüàÇ6…£I®,©„}†&Iá¸|ò=ØMXîlcacÙê)šyððü‰êß|ˆÆ×"ÌñX,šHéÅÞÆð¦Ô•È, »+ti™¼>åÎÏƒ;^	ˆÜZö“ñ¯<Síã=“nÌ™}xÐÑ˜'”¦£ÍKÂ !q#÷?N!C(|ëR«À?¾¿Ü;`Êw®†!?ž¨YŽ¡ó®wÀÏˆMƒš†‘ã1L-É`“½ð’`ût-¼½YëÞ‡Xèì„A:gë b,öþ††×7˜µXV—L.D'%øÎ`}Ò¢Ä!ÑVs¬¨Á™^ÛÄ‡çåp²<ÿ4½%­Ì@‰>á"DCgÎS‡ƒñu’Yä%1‚ÊK*À9/gWS»ö‰	2BVŠ_Ðjd›©í]¡9Zo><ï¯áW|4V	Qƒ,å<n‚ÜæE¨êHV¦ø——¶¯ªÅta¶ý\_HwŠ¶~Y4Ö¶#¤_·êf[Ðê\+*Ÿ
 ›wÿP†#_û†ÙôŽ¸€åaãwNT‚â€Üe<sD?ÙîNó	Öüìˆ1Z^¥1g˜çsì.ÇtQIg%ZyÀÐž¶–+DgÆßCÃû>©põ--à=aBõl±wè8JoS“6É§@ÐËUû­ÛqšyîK¢½”½Ì{ïŒý®eÍ'¦#‡äŠÐœ¯I3ËyÔË…Åe™Ýµq…¬ûy
„à¢IB€'&Û£p‡‰PvsÏ(Èõ–ÿƒBïù9í'v#Ž×>jõ)9£ uv5nòÔC¾|ùæ¹ *ˆúüŸy&"ÒÀN]X#>xÔÌŒ¥×Äk·»¶ÜÑ·À)$ò^sÀ0øs™Õö'x­4Ñ%w‚ï¯#{%>ølÃG~],:ƒ‡BùÃ$¸+ÇVî34`Pš¤ *
‘–!Ž ¯Û0ökš~¯JÃúiñ¥ã€é=²™«’R|LËZ©ý{É—ÙŠ’W¨'½2ðx€>ÎjRµöÈã6}ó–kj!Ù_½Uì–D»ÈüYÙ=IÝw},DUýr¶6.wï¯‘Ä‹C‡ÿ/uÅ^ëÀ÷v)¶éÊmýYÃòH«À¸ûo$ß³k´ÍÍÖÇõþ–Yºè«ÁA¾³ÁÓS‰I<¯&FµK?¤k¾ózZð yF·¼Vèù†r·—?ÔCµn<äË<µŽ™ãþË