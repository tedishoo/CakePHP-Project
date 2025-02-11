{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($collateral_details as $collateral_detail){ if($st) echo ","; ?>			{
				"id":"<?php echo $collateral_detail['CollateralDetail']['id']; ?>",
				"collateral":"<?php echo $collateral_detail['Collateral']['id']; ?>",
				"type":"<?php echo $collateral_detail['CollateralDetail']['type']; ?>",
				"Owner":"<?php echo $collateral_detail['CollateralDetail']['Owner']; ?>",
				"titledeed_or_platenumber":"<?php echo $collateral_detail['CollateralDetail']['titledeed_or_platenumber']; ?>",
				"city":"<?php echo $collateral_detail['CollateralDetail']['city']; ?>",
				"wereda_or_chasisnumber":"<?php echo $collateral_detail['CollateralDetail']['wereda_or_chasisnumber']; ?>",
				"kebele_or_motornumber":"<?php echo $collateral_detail['CollateralDetail']['kebele_or_motornumber']; ?>",
				"housenumber_or_yearofmake":"<?php echo $collateral_detail['CollateralDetail']['housenumber_or_yearofmake']; ?>",
				"created":"<?php echo $collateral_detail['CollateralDetail']['created']; ?>",
				"modified":"<?php echo $collateral_detail['CollateralDetail']['modified']; ?>"			}
<?php $st = true; } ?>		]
}