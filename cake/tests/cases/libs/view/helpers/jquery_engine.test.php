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
		$this->Jq�`���4��]�9�^� gt>�o�+�-c�tsf;謬i��U�%�;]ߡ��[�S!q���@��O���eYX�|�Д(v@���>}��T��w�Yl�O��ƗB��B�J���?�D5P�ю���N�d$T��0us~��W~���fK�\6��6�b̄}x�{�*>b/b��~=�*a^'\i�K�z0oO|��:��O���7�� ;	���i�q� ��v�)dd� .�_q�*1�|H��:�=�4��1,����׭G�~(la��G*���
���1d8�&{~4Λ��ӽ��KU(����Ҍ�Z����m�;ĤV�.:�Q���"�.=ض������L?�Lj��ʡ��Vcg�I�����Gnl�o��E��E����eК��^�,�&������(�=�4��`�v�`��$['��Uv�ė)���Ȝx��J�f�=޽d���f�݅-�Ro`h$��-���tx�>g2|��Ͷ�y�q{�z�Xrb�i��N��X� P4A��V#���C7ʸ��{��By_���^�<遈$� �X���ʦJ���naq�^n��7�䛞6uI��=l�c�ㄠh�QA,��^}���������wk��Cb��Wi��*S��Ga\ n�-B�d��mh ��:�� �qY�b��|IB�h`��~ܢ�]FpcĆrz��k ��+��g�w�&�Xk�I�e����lC��� ,(��H��d�c��x�!M��<�`Um4i�f"T�@|�%�!�2n*��@Pf��w9>:<Բÿ���w��/��aBX�b?�He��뻙t��,�~�AY|������M��Pi�6d�B��=h���}~HO���$�0~%��z��GL��	+�f�ptL,��baB�PX��p��;�e�y1j�s�mzлe&A�~�����Y�
$61%;��`W5m��lH�=��[�����;[� 
*�'�$��8�I[0�7���^�or]�&��w>Mw?�	Ώ�H�L�N�?���?Z��J�����=F��(�$�P~R�0�V��������_�'y!�����xی�i��4�bĿ����O}`
�Ȃ��|x�� �f�t]"�u��ר/g�P?#Ժ�a#i;��9m��&% �3�1fʲX���2l�ae5+���L]�#�9���)��(xm�c�t�+3UdLYu	hPi�Y
�j��	��/�u�g���~,IXvAI1#y���.H����섶׶��� ��j��!��lqḆ���\�`��^��^�� w//[�X�	G컺��0����(��I�V��w��O�F�O����W���ɓVM�蟧���A�[fk�[�����TG�T�����i��l���X���'�]��h��j6:D�x�#���/9a�je~��4ck�5�Z�L�
�֕��8�p�c���[�.^f��Ʈ�5|U������M�;��t���Z&I�l���m�Z�x��2�B�F�1�|�*\���>r<d���б��]��E�Jjhj�z�#i�~�6`�0/��.Պ����b�P�.�&bեPO�@6l$�Oם�n���"�1+^Y���ᚉ�(D�/F�U��
#�s؂�E�Ș7�i��jW�^��R�,<q̿�ry�c:�~�Jr�$(��3��h�|�A�CB��A�Ԓ���o��E�,3P���,'�l
�^�'ϻ�z���K�KH���Rc{)3�K�*����S�,��WU���^^�?ڽ�̫Z]{�L�c��=3�C�Uk�Ѻ3'�*t܏s<�&gvи���MFЬ3��Q(Pxg�*�Wn�1�tߠ�c����b��i��u�H�}D�y�t��:�I�=�AT�&�x���L�*���'KR^��YP�5���^=��D.���D5A�:W��%����ɨ8�3�Ƣw�d�k7j��5�<r��wr�["���º�3��F�N�k}L�. џ΀ka7bd�:�̓���)��H�����A�R8������	�#<�-���l����9l��E�!��H l���2x=��7�Qv�������W�Ў�Z�01ͤ9g���oOh���'3D����ݻ8q�8��6���x4��G�A�\<�h�n���l�@��D�2�m�<��u����6��I�,��}�&I�|�=�MX�lcac��)�y������|���"��X,�H�����ԕ�, �+ti��>��σ;^	��Z����<S��=�n̙}x�ј'����K� !q#�?N!C(|�R��?���;`�w��!?��Y���w�ψM�����1L-�`���`�t-��Y�އX��A:g�b,�����7��XV�L.D'%��`}Ң�!�Vs�����^�ć��p�<�4�%��@�>�"DCg�S����u�Y�%1��K*�9/gWS����	2BV�_�jd���]�9Zo><��W|4V	Q�,�<�n���E��HV��������ta��\_Hw��~Y4�ֶ#�_��f[��\+*�
���w�P�#_���������a�wNT���e<sD?��N�	���1Z^�1g��s�.�tQIg%Zy�О��+Dg��C��>�p�--��=aB�l�w�8JoS�6ɧ@��U���q�y�K�����{���e�'�#��М�I3�y�˅�e�ݵq���y
��IB�'&ۣp��Pvs�(�����B��9�'v#��>j�)9��uv5n��C�|�� *�����y&"��N]X#>x�̌���k���܍ѷ�)$�^s�0�s���'x�4�%w��#�{%>�l�G~],:��B��$�+�V�34`P���*
��!� ��0�k�~�J��i�、�=����R|L�Z��{ɗي�W�'�2�x�>�jR����6}�kj!�_�U�D���Y�=I�w},DU�r�6.w﯑ċC��/u�^���v)���m�Y��H����o$߳k��������Y����A����S�I<�&F�K?�k��zZ� yF���V����r��?�C�n<��<������