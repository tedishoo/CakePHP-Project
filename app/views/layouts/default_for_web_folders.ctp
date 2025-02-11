<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Credit Information Center - Helper'); echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('extjs/resources/css/ext-all') . "\n";
		echo $this->Html->css('extjs/ux/css/ux-all') . "\n";
		
		$useragent = $_SERVER['HTTP_USER_AGENT'];

		if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
			echo $this->Html->css('style_ie') . "\n";
		} else {
			echo $this->Html->css('style') . "\n";
		}
		
		echo $this->Html->script('extjs/adapter/ext/ext-base') . "\n";
		echo $this->Html->script('extjs/ext-all') . "\n";
		echo $this->Html->script('core') . "\n";
		echo $this->Html->script('jquery.min') . "\n";
		echo $this->Html->script('ddaccordion') . "\n";
		echo $this->Html->script('extjs/ux/ux-all') . "\n";
		echo $this->Html->script('handleamharic') . "\n";
		echo $this->Html->script('dtpicker') . "\n";
		echo $this->Html->script('overlib_mini') . "\n";
		
		echo $scripts_for_layout . "\n";
	?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style type="text/css">
		@font-face {
			font-family: Nyala;
			font-style:  normal;
			font-weight: normal;
			src: url('<?php echo Configure::read('localhost_string'); ?>/files/nyala.eot');
		}
		#content {
			color:#000000;
			font-family:'Nyala','Geez Unicode','GF Zemen Unicode','visual Geez Unicode',Verdana,"BitStream vera Sans",Helvetica,Sans-serif;
			font-size:16px;
		}
		
		.x-tree-node-leaf .x-tree-node-icon{
			background-image:url(../images/default/tree/folder.gif);
		}
	</style>
	<script type="text/javascript">
		ddaccordion.init({
			headerclass: "submenuheader", //Shared CSS class name of headers group
			contentclass: "submenu", //Shared CSS class name of contents group
			revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
			mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
			collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
			defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
			onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
			animatedefault: false, //Should contents open by default be animated into view?
			persiststate: true, //persist state of opened contents within browser session?
			toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
			togglehtml: ["suffix", '<?php echo $this->Html->image('plus.gif', array('class'=>'statusicon')); ?>', '<?php echo $this->Html->image('minus.gif', array('class'=>'statusicon')); ?>'], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
			animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
			oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
				//do nothing
			},
			onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
				//do nothing
			}
		})
	</script>

	<style type="text/css">
		.glossymenu{
			margin: 5px 0;
			padding: 0;
			width: 200px; /*width of menu*/
			border: 1px solid #9A9A9A;
			border-bottom-width: 0;
		}

		.glossymenu a.menuitem{
			background: black url(<?php echo Configure::read('localhost_string'); ?>/img/glossyback.gif) repeat-x bottom left;
			font: bold 14px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
			color: white;
			display: block;
			position: relative; /*To help in the anchoring of the ".statusicon" icon image*/
			width: auto;
			padding: 4px 0;
			padding-left: 10px;
			text-decoration: none;
		}

		.glossymenu a.menuitem:visited, .glossymenu .menuitem:active{
			color: white;
		}

		.glossymenu a.menuitem .statusicon{ /*CSS for icon image that gets dynamically added to headers*/
			position: absolute;
			top: 5px;
			right: 5px;
			border: none;
		}

		.glossymenu a.menuitem:hover{
			background-image: url(<?php echo Configure::read('localhost_string'); ?>/img/glossyback2.gif);
		}

		.glossymenu div.submenu{ /*DIV that contains each sub menu*/
			background: #a6ccef;
		}

		.glossymenu div.submenu ul{ /*UL of each sub menu*/
			list-style-type: none;
			margin: 0;
			padding: 0;
		}

		.glossymenu div.submenu ul li{
			border-bottom: 1px solid #86accf;
		}
		
		.glossymenu div.submenu ul li.current{
			background: #a6cccf;
		}

		.glossymenu div.submenu ul li a{
			display: block;
			font: normal 13px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
			color: black;
			text-decoration: none;
			padding: 2px 0;
			padding-left: 10px;
		}

		.glossymenu div.submenu ul li a:hover{
			background: #a6cccf;
			colorz: white;
		}

	</style>
</head>

<body>
<div id="main_header">
    <div id="header">
    	<?php echo $this->element('h_menu_1'); ?>
    	<ul class="free">
    		<li><a class="call">+251-11-661-5779 +251-11-662-5292</a></li>
    	</ul>
        <?php echo $this->element('h_menu_2'); ?>
    </div>
</div>
<div id="main_body">
    <div id="body">
        <table border="0" width="950px" cellpadding="0" cellspacing="0">
        	<tr>
        		<td valign="top" align="left" rowspan="2" width="250px">
					<form method="get" action="<?php echo Configure::read('localhost_string'); ?>/search/">
						<input type="text" value="<?php __('Search...');?>" onFocus="if(this.value == '<?php __('Search...');?>') this.value = '';" onBlur="if(this.value == '') this.value = '<?php __('Search...');?>'" size="24px" name="q" />
						<input type="submit" value="Go" />
					</form>
        			<?php echo $this->element('l_menu_2'); ?>
        		</td>
        		<td align="left" width="700px" valign="top" height="14px">
                    <?php $ac = ($this->action != 'index')? ' > <b>' . Inflector::humanize($this->action): ''; ?>
					<?php $yah = ($this->name == 'Pages')? '<b>Home</b>': 'Home > <b>' . Inflector::humanize(Inflector::underscore($this->name)) . '</b>' . $ac; ?>
        			<div id="yah">&nbsp;&nbsp;You Are Here: <i><?php echo $yah; ?></i></div>
        		</td>
        	</tr>
            <tr>	
                <td align="left" valign="top">
					<div id="content">
						<span style="color:#bb3434; background:#fdacac; width:600px;">
						<?php echo $this->Session->flash(); ?>
						</span>
						<?php echo $content_for_layout; ?>
					</div>
					<br/>
					<br/>
                </td>
            </tr>
        </table>
        <br class="balnk" />
    </div>
</div>
<div id="main_footer">
    <div id="footer">
        <?php echo $this->element('footer'); ?>
    </div>
</div>
</body>
</html>
