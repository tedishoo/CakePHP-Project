{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
			<?php $st = false; foreach($containers as $container){ if($st) echo ","; ?>			
        {
				"id":"<?php echo $container['Container']['id']; ?>",
				"name":"<?php echo $container['Container']['name']; ?>",
                "list_order": "<?php echo $container['Container']['list_order']; ?>"			
        }
<?php $st = true; } ?>		
    ]
}