{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($outstanding_balances as $outstanding_balance){ if($st) echo ","; ?>			{
				"account":"<?php echo $outstanding_balance['Account']['id']; ?>",
				"date":"<?php echo $outstanding_balance['Date']['id']; ?>",
				"balance":"<?php echo $outstanding_balance['OutstandingBalance']['balance']; ?>",
				"created":"<?php echo $outstanding_balance['OutstandingBalance']['created']; ?>",
				"modified":"<?php echo $outstanding_balance['OutstandingBalance']['modified']; ?>"			}
<?php $st = true; } ?>		]
}