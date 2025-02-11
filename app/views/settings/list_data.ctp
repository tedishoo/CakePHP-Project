{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($settings as $setting){ if($st) echo ","; ?>			{
				"id":"<?php echo $setting['Setting']['id']; ?>",
				"setting_key":"<?php echo $setting['Setting']['setting_key']; ?>",
				"setting_value":"<?php echo $setting['Setting']['setting_value']; ?>",
				"date_from":"<?php echo $setting['Setting']['date_from']; ?>",
				"date_to":"<?php echo $setting['Setting']['date_to']; ?>",
				"remark":"<?php echo $setting['Setting']['remark']; ?>"			}
<?php $st = true; } ?>		]
}