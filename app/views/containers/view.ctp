
		var store_container_links = new Ext.data.Store({
			data: [
<?php
				$links = $container['Link'];
				$started = false;
				foreach ($links as $link):
					if($started) echo ',';
?>			[
				'<?php echo $link['id']; ?>',
				'<?php echo $link['name']; ?>',
				'<?php echo $link['controller']; ?>',
				'<?php echo $link['action']; ?>',
				'<?php echo $link['parameter']; ?>'				
			]
<?php $started = true; ?>
				<?php endforeach; ?>		    ],
			reader: new Ext.data.ArrayReader({id:'id'}, [
			'id',
			'name',
			'controller',
			'action',
			'parameter'			])
	    });
		
<?php $container_html = "<table cellspacing=3>" . 
		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $container['Container']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var container_view_panel_1 = {
			html : '<?php echo $container_html; ?>',
			id : 'container_view_panel_1',
			frame : true,
			height: 50
		}
		var container_view_panel_2 = {
			id : 'container_view_panel_2',
			frame : true,
			height: 215,
			items: [{
				xtype: 'grid',
				store: store_container_links,
				title: '<?php __('Activities under the Module'); ?>',
				height: 200,
				width: 462,
				enableColumnMove: false,
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
					{header: "<?php __('Controller'); ?>", dataIndex: 'controller', sortable: true},
					{header: "<?php __('Action'); ?>", dataIndex: 'action', sortable: true},
					{header: "<?php __('Parameter'); ?>", dataIndex: 'parameter', sortable: true, hidden: true}
				],
				viewConfig: {
					forceFit: true
				}
			}]
		}

		var containerViewWindow = new Ext.Window({
			title: '<?php __('View Module'); ?>: <?php echo $container['Container']['name']; ?>',
			width: 500,
			height: 340,
			modal: true,
			resizable: false,
			collapsible: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: [ 
				container_view_panel_1,
				container_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					containerViewWindow.hide();
				}
			}]
		});
