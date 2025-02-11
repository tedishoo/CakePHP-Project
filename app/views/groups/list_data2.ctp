{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
			<?php $st = false; foreach($groups as $group){ if($st) echo ","; ?>			{
				"id":"<?php echo $group['id']; ?>",
				"name":"<?php echo Inflector::humanize($group['name']) . ' [' . $group['name'] . ']'; ?>",
				"description":"<?php echo $group['description']; ?>",
				"is_builtin":"<?php echo $group['is_builtin']? 'Yes': 'No'; ?>",
				"created":"<?php echo $group['created']; ?>",
				"modified":"<?php echo $group['modified']; ?>"			
			}<?php $st = true; } ?>		
	]
}