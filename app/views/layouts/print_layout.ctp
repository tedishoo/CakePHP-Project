<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Credit Information Center Helper - '); ?><?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		
		echo $this->Html->css('default') . "\n";
		echo $this->Html->css('extjs/resources/css/ext-all') . "\n";
		echo $this->Html->css('extjs/ux/css/ux-all') . "\n";
		
		echo $this->Html->script('extjs/adapter/ext/ext-base') . "\n";
		echo $this->Html->script('extjs/ext-all') . "\n";
                echo $this->Html->script('handleamharic') . "\n";
		
		echo $scripts_for_layout . "\n";
	?>
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
	</style>
</head>
<body style="margin: 10px;">
<?php echo $content_for_layout; ?>
</body>
</html>