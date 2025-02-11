{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
			<?php $st = false; foreach($groups as $group){ if($st) echo ","; ?>			
			{
				"id":"<?php echo $group['Group']['id']; ?>",
				"name":"<?php echo $group['Group']['name']; ?>",
				"description":"<?php echo $group['Group']['description']; ?>",
				"is_builtin":"<?php echo $group['Group']['is_builtin']? 'Yes': 'No'; ?>",
				"created":"<?php echo $group['Group']['created']; ?>",
				"modified":"<?php echo $group['Group']['modified']; ?>"			
			}
			<?php $st = true; } ?>		
	]
}