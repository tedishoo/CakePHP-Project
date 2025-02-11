<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Abay Bank EATS Connector Pro'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		
		echo $this->Html->css('uploader') . "\n";
		
        echo $this->Html->script('handleamharic') . "\n";
		
		echo $scripts_for_layout . "\n";
	?>
</head>
<body>
	<?php echo $content_for_layout; ?>
</body>
</html>