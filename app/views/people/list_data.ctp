{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
			<?php $st = false; foreach($people as $person){ if($st) echo ","; ?>			{
				"id":"<?php echo $person['Person']['id']; ?>",
				"first_name":"<?php echo $person['Person']['first_name']; ?>",
				"middle_name":"<?php echo $person['Person']['middle_name']; ?>",
				"last_name":"<?php echo $person['Person']['last_name']; ?>",
				"birthdate":"<?php echo $person['Person']['birthdate']; ?>",
				"birth_location":"<?php echo $person['BirthLocation']['name']; ?>",
				"residence_location":"<?php echo $person['ResidenceLocation']['name']; ?>",
				"nationality":"<?php echo $person['Nationality']['name']; ?>",
				"kebele_or_farmers_association":"<?php echo $person['Person']['kebele_or_farmers_association']; ?>",
				"house_number":"<?php echo $person['Person']['house_number']; ?>"			}<?php $st = true; } ?>		]
}