
var store_user_groups = new Ext.data.Store({
	data: [
<?php $st = false; foreach($user['Group'] as $g){ if($st) echo ","; ?>	
		[
			"<?php echo $g['id']; ?>","<?php echo Inflector::humanize($g['name']); ?>",
			"<?php echo $g['description']; ?>","<?php echo $g['is_builtin']? 'Yes': 'No'; ?>"
		]
<?php $st = true; } ?>	
	],
	reader: new Ext.data.ArrayReader({id:'id'}, [
		'id',
		'name',
		'description',
		'is_builtin'
	])
});
		
<?php $user_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Username', true) . ":</th><td><b>" . $user['User']['username'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Full Name', true) . ":</th><td><b>" . $user['Person']['first_name'] . ' ' . $user['Person']['middle_name'] . ' ' . $user['Person']['last_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Email', true) . ":</th><td><b>" . $user['User']['email'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Is Active', true) . ":</th><td><b>" . (($user['User']['is_active'])? 'Yes': 'No') . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Security Question', true) . ":</th><td><b>" . $user['User']['security_question'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Security Answer', true) . ":</th><td><b>" . $user['User']['security_answer'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $user['User']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $user['User']['modified'] . "</b></td></tr>" . 
"</table>";
?>
		var user_view_panel_1 = {
			html : '<?php echo $user_html; ?>',
			frame : true,
			height: 150
		}
		var user_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:150,
			plain:true,
			defaults:{autoScroll: true},
			items:[{
					xtype: 'grid',
					loadMask: true,
					stripeRows: true,
					store: store_user_groups,
					title: '<?php echo $user['User']['username'] . ' ' . __('is member in these groups', true); ?>',
					enableColumnMove: false,
					columns: [
						{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true, width: 40},
						{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true},
						{header: "<?php __('Is Builtin'); ?>", dataIndex: 'is_builtin', sortable: true, width: 30}
					],
					viewConfig: {
						forceFit: true
					}
				}			
			]
		});

		var UserViewWindow = new Ext.Window({
			title: '<?php __('View User'); ?>: <?php echo $user['User']['username'] . ' [' . $user['Person']['first_name'] . ' ' . $user['Person']['middle_name'] . ' ' . $user['Person']['last_name'] . ']'; ?>',
			width: 500,
			height:380,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
            modal: true,
			items: [ 
				user_view_panel_1,
				user_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					UserViewWindow.close();
				}
			}]
		});
