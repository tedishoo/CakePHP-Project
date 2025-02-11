{
	success: true,
	results: <?php echo count($sel_permissions['Permission']); ?>,
	rows: [
<?php
	$st = false;
	
	foreach($sel_permissions['Permission'] as $node){
		if($st) echo ",";
?>
		{
			id: '<?php echo $node['id']; ?>',
			name: '<?php echo $node['name']; ?>',
			description: '<?php echo $node['description']; ?>'
		}
<?php 
		$st = true;
	}
?>
	]
}

<?php //pr($sel_permissions); ?>