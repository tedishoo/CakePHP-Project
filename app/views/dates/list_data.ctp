{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($dates as $date){ if($st) echo ","; ?>			{
				"id":"<?php echo $date['Date']['id']; ?>",
				"date":"<?php echo $date['Date']['date']; ?>",
				"created":"<?php echo $date['Date']['created']; ?>",
				"modified":"<?php echo $date['Date']['modified']; ?>"			}
<?php $st = true; } ?>		]
}