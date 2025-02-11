{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($locationTypes as $locationType){ if($st) echo ","; ?>			{
				"id":"<?php echo $locationType['LocationType']['id']; ?>",
				"name":"<?php echo $locationType['LocationType']['name']; ?>"			}
<?php $st = true; } ?>		]
}