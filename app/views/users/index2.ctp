var store_parent_users = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','username','password','email','is_active','security_question','security_answer','person','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentUser() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_user_data = response.responseText;
			
			eval(parent_user_data);
			
			UserAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the user add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentUser(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_user_data = response.responseText;
			
			eval(parent_user_data);
			
			UserEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the user edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewUser(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var user_data = response.responseText;

			eval(user_data);

			UserViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the user view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewUserGroups(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'groups', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_groups_data = response.responseText;

			eval(parent_groups_data);

			parentGroupsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentUser(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('User(s) successfully deleted!'); ?>');
			RefreshParentUserData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the user to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentUserName(value){
	var conditions = '\'User.name LIKE\' => \'%' + value + '%\'';
	store_parent_users.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentUserData() {
	store_parent_users.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Users'); ?>',
	store: store_parent_users,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
        id: 'userGrid',
	columns: [
		{header: "<?php __('Username'); ?>", dataIndex: 'username', sortable: true},
		{header: "<?php __('Password'); ?>", dataIndex: 'password', sortable: true},
		{header: "<?php __('Email'); ?>", dataIndex: 'email', sortable: true},
		{header: "<?php __('Is Active'); ?>", dataIndex: 'is_active', sortable: true},
		{header: "<?php __('Security Question'); ?>", dataIndex: 'security_question', sortable: true},
		{header: "<?php __('Security Answer'); ?>", dataIndex: 'security_answer', sortable: true},
		{header:"<?php __('person'); ?>", dataIndex: 'person', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
    listeners: {
        celldblclick: function(){
            ViewUser(Ext.getCmp('userGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		
		items: [
			{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('Add User'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentUser();
				}
			},' ', '-', ' ',
			{
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-user',
				tooltip:'<?php __('Edit User'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentUser(sel.data.id);
					};
				}
			},' ', '-', ' ',
			{
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-user',
				tooltip:'<?php __('Delete User'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove User'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									fn: function(btn){
											if (btn == 'yes'){
													DeleteParentUser(sel[0].data.id);
											}
									}
							});
						}else{
							Ext.Msg.show({
									title: '<?php __('Remove User'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected User'); ?>?',
									fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentUser(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			},' ','-',' ',{
				xtype: 'tbsplit',
				text: '<?php __('View User'); ?>',
				id: 'view-user2',
				tooltip:'<?php __('View User'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewUser(sel.data.id);
					};
				},
				menu : {
					items: [
					{
						text: '<?php __('View Groups'); ?>',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewUserGroups(sel.data.id);
							};
						}
					}
					]
				}

                        },' ', '->',
			{
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_user_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentUserName(Ext.getCmp('parent_user_search_field').getValue());
						}
					}

				}
			},
			{
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				id: 'parent_user_go_button',
				handler: function(){
					SearchByParentUserName(Ext.getCmp('parent_user_search_field').getValue());
				}
			},' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_users,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-user').enable();
	g.getTopToolbar().findById('delete-parent-user').enable();
        g.getTopToolbar().findById('view-user2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-user').disable();
                g.getTopToolbar().findById('view-user2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-user').disable();
		g.getTopToolbar().findById('delete-parent-user').enable();
                g.getTopToolbar().findById('view-user2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-user').enable();
		g.getTopToolbar().findById('delete-parent-user').enable();
                g.getTopToolbar().findById('view-user2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-user').disable();
		g.getTopToolbar().findById('delete-parent-user').disable();
                g.getTopToolbar().findById('view-user2').disable();
	}
});



var parentUsersViewWindow = new Ext.Window({
	title: 'User Under the selected Item',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		g
	],

	buttons: [{
		text: 'Close',
		handler: function(btn){
			parentUsersViewWindow.close();
		}
	}]
});

store_parent_users.load({
    params: {
        start: 0,    
        limit: list_size
    }
});