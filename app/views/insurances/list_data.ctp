{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($insurances as $insurance){ if($st) echo ","; ?>			{
				"id":"<?php echo $insurance['Insurance']['id']; ?>",
				"collateral_detail":"<?php echo $insurance['CollateralDetail']['id']; ?>",
				"estimated_value":"<?php echo $insurance['Insurance']['estimated_value']; ?>",
				"date_estimated":"<?php echo $insurance['Insurance']['date_estimated']; ?>",
				"insurance_company":"<?php echo $insurance['Insurance']['insurance_company']; ?>",
				"type":"<?php echo $insurance['Insurance']['type']; ?>",
				"date_insured":"<?php echo $insurance['Insurance']['date_insured']; ?>",
				"amount_insured":"<?php echo $insurance['Insurance']['amount_insured']; ?>",
				"expire_date":"<?php echo $insurance['Insurance']['expire_date']; ?>",
				"policy_number":"<?php echo $insurance['Insurance']['policy_number']; ?>",
				"created":"<?php echo $insurance['Insurance']['created']; ?>",
				"modified":"<?php echo $insurance['Insurance']['modified']; ?>"			}
<?php $st = true; } ?>		]
}