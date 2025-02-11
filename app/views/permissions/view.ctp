
var store_permission_groups = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','description','is_builtin','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'groups', 'action' => 'list_data2', $permission['Permission']['id'])); ?>'	})
});
		
<?php $permission_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $permission['Permission']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Is Builtin', true) . ":</th><td><b>" . ($permission['Permission']['is_builtin']? 'Yes': 'No') . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $permission['Permission']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $permission['Permission']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var permission_view_panel_1 = {
			html : '<?php echo $permission_html; ?>',
			frame : true,
			height: 80
		}
		var permission_view_panel_2 = new Ext.TabPanel({
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
				store: store_permission_groups,
				title: '<?php __('Groups'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_permission_groups.getCount() == '')
							store_permission_groups.reload();
					}
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
,					{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true}
,					{header: "<?php __('Is Builtin'); ?>", dataIndex: 'is_builtin', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_permission_groups,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var PermissionViewWindow = new Ext.Window({
			title: '<?php __('View Permission'); ?>: <?php echo $permission['Permission']['name']; ?>',
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
				permission_view_panel_1,
				permission_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PermissionViewWindow.close();
				}
			}]
		});
