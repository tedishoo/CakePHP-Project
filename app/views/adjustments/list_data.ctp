{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($adjustments as $adjustment){ if($st) echo ","; ?>			{
				"id":"<?php echo $adjustment['Adjustment']['id']; ?>",
				"mobile":"<?php echo $adjustment['Adjustment']['mobile']; ?>",
				"date":"<?php echo $adjustment['Adjustment']['date']; ?>",
				"created":"<?php echo $adjustment['Adjustment']['created']; ?>",
				"modified":"<?php echo $adjustment['Adjustment']['modified']; ?>"			}
<?php $st = true; } ?>		]
}