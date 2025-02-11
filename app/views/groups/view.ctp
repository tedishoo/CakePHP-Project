
var store_group_permissions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','description','prerequisite'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'list_data3', $group['Group']['id'])); ?>'	})
});
var store_group_users = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','username','password','email','is_active','security_question','security_answer','person','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'list_data2', $group['Group']['id'])); ?>'	})
});
		
<?php $group_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $group['Group']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Description', true) . ":</th><td><b>" . $group['Group']['description'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Is Builtin', true) . ":</th><td><b>" . $group['Group']['is_builtin'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $group['Group']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $group['Group']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var group_view_panel_1 = {
			html : '<?php echo $group_html; ?>',
			frame : true,
			height: 80
		}
		var group_view_panel_2 = new Ext.TabPanel({
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
				store: store_group_permissions,
				title: '<?php __('Permissions'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_group_permissions.getCount() == '')
							store_group_permissions.reload();
					}
				},
				viewConfig: {
					forceFit: true
				},
				columns: [
					{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
					{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true}
				],
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_group_permissions,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			},{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_group_users,
				title: '<?php __('Users'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_group_users.getCount() == '')
							store_group_users.reload();
					}
				},
				viewConfig: {
					forceFit: true
				},
				columns: [
					{header: "<?php __('Username'); ?>", dataIndex: 'username', sortable: true},
					{header: "<?php __('Full Name'); ?>", dataIndex: 'person', sortable: true},
					{header: "<?php __('Email'); ?>", dataIndex: 'email', sortable: true},
					{header: "<?php __('Is Active'); ?>", dataIndex: 'is_active', sortable: true},
					{header: "<?php __('Security Question'); ?>", dataIndex: 'security_question', sortable: true, hidden: true},
					{header: "<?php __('Security Answer'); ?>", dataIndex: 'security_answer', sortable: true, hidden: true},
					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true, hidden: true},
					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true, hidden: true}
		
				],
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_group_users,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			
			]
		});

		var GroupViewWindow = new Ext.Window({
			title: '<?php __('View Group'); ?>: <?php echo $group['Group']['name']; ?>',
			width: 500,
			height:345,
			resizable: false,
			collapsible: true,
			plain: true,
			bodyStyle: 'padding:5px;',
			buttonAlign: 'right',
                        modal: true,
			items: [ 
				group_view_panel_1,
				group_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					GroupViewWindow.close();
				}
			}]
		});
