
var store_permissions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','parent_permission','lft','rght'		
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'list_data')); ?>'
	})
});


function AddPermission(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'add')); ?>/'+id,
		success: function(response, opts) {
			var permission_data = response.responseText;
			
			eval(permission_data);
			
			PermissionAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the permission add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPermission(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var permission_data = response.responseText;
			
			eval(permission_data);
			
			PermissionEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the permission edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function DeletePermission(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Permission successfully deleted!'); ?>');
			RefreshPermissionData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the permission add form. Error code'); ?>: ' + response.status);
		}
	});
}

function RefreshPermissionData() {
	store_permissions.reload();
	
	var p = center_panel.findById('permission-tab');
	p.getRootNode().reload();
}

var selected_item_id = 0;
var selected_item_name = '';

if(center_panel.find('id', 'permission-tab') != "") {
	var p = center_panel.findById('permission-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add(
		new Ext.ux.tree.TreeGrid({
			title: '<?php __('Permissions'); ?>',
			closable: true,
			id: 'permission-tab',
			forceFit:true,
			columns:[
				{header: 'Permission', width: 200, dataIndex: 'name'},
				{header: 'Description', width: 700, dataIndex: 'description'},
				{header: 'Prerequisite', width: 100, dataIndex: 'prerequisite'}
			],
			dataUrl: '<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'list_data')); ?>',
			listeners: {
				click: function(n) {
					selected_item_id = n.attributes.id;
					selected_item_name = n.attributes.name;
					p.getTopToolbar().findById('add_permission').enable();
					p.getTopToolbar().findById('edit_permission').enable();
					p.getTopToolbar().findById('delete_permission').enable();
					if(n.attributes.name == 'All'){
						p.getTopToolbar().findById('edit_permission').disable();
						p.getTopToolbar().findById('delete_permission').disable();
					}
				}
			},
			tbar: new Ext.Toolbar({
				items:[
					{
						xtype: 'tbbutton',
						text: '<?php __('Add'); ?>',
						id: 'add_permission',
						tooltip:'<?php __('Add Child Permission'); ?>',
						icon: 'img/table_add.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								AddPermission(selected_item_id);
							}
						}
					},
					{
						xtype: 'tbbutton',
						text: '<?php __('Edit'); ?>',
						id: 'edit_permission',
						tooltip:'<?php __('Edit Permission'); ?>',
						icon: 'img/table_edit.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								EditPermission(selected_item_id);
							};
						}
					},' ', '-', ' ',
					{
						xtype: 'tbbutton',
						text: '<?php __('Delete'); ?>',
						id: 'delete_permission',
						tooltip:'<?php __('Delete Permission'); ?>',
						icon: 'img/table_delete.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								Ext.Msg.show({
									title: '<?php __('Remove Permission'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+selected_item_name+' <?php __('with all its child items'); ?>?',
									fn: function(btn){
										if (btn == 'yes'){
											DeletePermission(selected_item_id);
										}
									}
								});
							} else {
								Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
							}
						}
					}
				]
			})
		})
	);
	
	center_panel.setActiveTab(p);
}