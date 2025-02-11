{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
			<?php $st = false; foreach($users as $user){ if($st) echo ","; ?>			
			{
				"id":"<?php echo $user['id']; ?>",
				"username":"<?php echo $user['username']; ?>",
				"email":"<?php echo $user['email']; ?>",
				"is_active":"<?php echo $user['is_active']? 'Yes': 'No'; ?>",
				"security_question":"<?php echo $user['security_question']; ?>",
				"security_answer":"<?php echo $user['security_answer']; ?>",
				"person":"<?php echo $user['Person']['first_name'] . ' ' . substr($user['Person']['middle_name'], 0, 1) . '. ' . $user['Person']['last_name']; ?>",
				"created":"<?php echo $user['created']; ?>",
				"modified":"<?php echo $user['modified']; ?>"			
			}<?php $st = true; } ?>		
		]
}