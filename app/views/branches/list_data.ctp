{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($branches as $branch){ if($st) echo ","; ?>			{
				"id":"<?php echo $branch['Branch']['id']; ?>",
				"name":"<?php echo $branch['Branch']['name']; ?>",
				"nbe_code":"<?php echo $branch['Branch']['nbe_code']; ?>",
				"flex_code":"<?php echo $branch['Branch']['flex_code']; ?>",
				"created":"<?php echo $branch['Branch']['created']; ?>",
				"modified":"<?php echo $branch['Branch']['modified']; ?>"			}
<?php $st = true; } ?>		]
}