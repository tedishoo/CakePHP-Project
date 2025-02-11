{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($collaterals as $collateral){ if($st) echo ","; ?>			{
				"id":"<?php echo $collateral['Collateral']['id']; ?>",
				"account":"<?php echo str_replace("'",'',$collateral['Account']['first_name']).' '.str_replace("'",'',$collateral['Account']['middle_name']).' '.str_replace("'",'',$collateral['Account']['last_name']); ?>",
				"created":"<?php echo $collateral['Collateral']['created']; ?>",
				"modified":"<?php echo $collateral['Collateral']['modified']; ?>"			}
<?php $st = true; } ?>		]
}