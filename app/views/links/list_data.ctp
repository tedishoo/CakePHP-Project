{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($links as $link){ if($st) echo ","; ?>			
        {
				"id":"<?php echo $link['Link']['id']; ?>",
				"name":"<?php echo $link['Link']['name']; ?>",
				"container":"<?php echo $link['Container']['name']; ?>",
				"controller":"<?php echo $link['Link']['controller']; ?>",
				"action":"<?php echo $link['Link']['action']; ?>",
				"parameter":"<?php echo $link['Link']['parameter']; ?>",
                "function_name":"<?php echo $link['Link']['function_name']; ?>",
                "list_order":"<?php echo $link['Link']['list_order']; ?>"		
        }
<?php $st = true; } ?>		
    ]
}