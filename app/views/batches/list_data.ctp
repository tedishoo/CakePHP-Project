{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($batches as $batch){ if($st) echo ","; ?>			{
				"id":"<?php echo $batch['Batch']['id']; ?>",
				"month":"<?php if($batch['Batch']['month'] ==1){echo 'January';}
								else if($batch['Batch']['month'] ==2){echo 'February';}
								else if($batch['Batch']['month'] ==3){echo 'March';}
								else if($batch['Batch']['month'] ==4){echo 'April';}
								else if($batch['Batch']['month'] ==5){echo 'May';}
								else if($batch['Batch']['month'] ==6){echo 'June';}
								else if($batch['Batch']['month'] ==7){echo 'July';}
								else if($batch['Batch']['month'] ==8){echo 'August';}
								else if($batch['Batch']['month'] ==9){echo 'September';}
								else if($batch['Batch']['month'] ==10){echo 'October';}
								else if($batch['Batch']['month'] ==11){echo 'November';}
								else if($batch['Batch']['month'] ==12){echo 'December';}?>",
				"year":"<?php echo $batch['Batch']['year']; ?>",
				"created":"<?php echo $batch['Batch']['created']; ?>",
				"modified":"<?php echo $batch['Batch']['modified']; ?>"			}
<?php $st = true; } ?>		]
}