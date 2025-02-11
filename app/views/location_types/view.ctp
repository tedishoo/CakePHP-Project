
var store_locationType_locations = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','parent','name','location_type','is_rural','lft','rght'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'list_data', $locationType['LocationType']['id'])); ?>'	})
});
		
<?php $locationType_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $locationType['LocationType']['name'] . "</b></td></tr>" . 
"</table>"; 
?>
		var locationType_view_panel_1 = {
			html : '<?php echo $locationType_html; ?>',
			frame : true,
			height: 80
		}
		var locationType_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
			{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_locationType_locations,
				title: '<?php __('Locations'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_locationType_locations.getCount() == '')
							store_locationType_locations.reload();
					}
				},
				columns: [
					{header: "<?php __('Parent'); ?>", dataIndex: 'parent', sortable: true}
,					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Location Type'); ?>", dataIndex: 'location_type', sortable: true}
,					{header: "<?php __('Is Rural'); ?>", dataIndex: 'is_rural', sortable: true}
,					{header: "<?php __('Lft'); ?>", dataIndex: 'lft', sortable: true}
,					{header: "<?php __('Rght'); ?>", dataIndex: 'rght', sortable: true}
		
				],
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_locationType_locations,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var LocationTypeViewWindow = new Ext.Window({
			title: '<?php __('View LocationType'); ?>: <?php echo $locationType['LocationType']['name']; ?>',
			width: 500,
			height:345,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				locationType_view_panel_1,
				locationType_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					LocationTypeViewWindow.close();
				}
			}]
		});
