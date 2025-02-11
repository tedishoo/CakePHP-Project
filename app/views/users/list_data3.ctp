{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
			<?php $st = false; foreach($users as $user){ if($st) echo ","; ?>			
			{
				"id":"<?php echo $user['User']['id']; ?>",
				"username":"<?php echo $user['User']['username']; ?>",
				"email":"<?php echo $user['User']['email']; ?>",
				"is_active":"<?php echo $user['User']['is_active']? 'Yes': 'No'; ?>",
				"security_question":"<?php echo $user['User']['security_question']; ?>",
				"security_answer":"<?php echo $user['User']['security_answer']; ?>",
				"person":"<?php echo $user['Person']['first_name'] . ' ' . substr($user['Person']['middle_name'], 0, 1) . '. ' . $user['Person']['last_name']; ?>",
				"created":"<?php echo $user['User']['created']; ?>",
				"modified":"<?php echo $user['User']['modified']; ?>"			
			}<?php $st = true; } ?>		
		]
}