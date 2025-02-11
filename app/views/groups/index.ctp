
var store_groups = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','description','is_builtin','created','modified'		
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'groups', 'action' => 'list_data')); ?>'
	}),	
	sortInfo:{
		field: 'name', direction: "ASC"
	},
	groupField: 'is_builtin'
});


function AddGroup() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'groups', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var group_data = response.responseText;
			
			eval(group_data);
			
			GroupAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.show({
				title: '<?php __('Failure'); ?>',
				buttons: Ext.MessageBox.OK,
				msg: '<?php __('Cannot get the group add form. Error code'); ?>: ' + response.status ,
				icon: Ext.MessageBox.ERROR
			});
		}
	});
}

function EditGroup(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'groups', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var group_data = response.responseText;
			
			eval(group_data);
			
			GroupEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.show({
				title: '<?php __('Failure'); ?>',
				buttons: Ext.MessageBox.OK,
				msg: '<?php __('Cannot get the group edit form. Error code'); ?>: ' + response.status ,
				icon: Ext.MessageBox.ERROR
			});
		}
	});
}

function ViewGroup(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'groups', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var group_data = response.responseText;

            eval(group_data);

            GroupViewWindow.show();
        },
        failure: function(response, opts) {
			Ext.Msg.show({
				title: '<?php __('Failure'); ?>',
				buttons: Ext.MessageBox.OK,
				msg: '<?php __('Cannot get the group view form. Error code'); ?>: ' + response.status ,
				icon: Ext.MessageBox.ERROR
			});
        }
    });
}
function ViewParentPermissions(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_permissions_data = response.responseText;

            eval(parent_permissions_data);

            parentPermissionsViewWindow.show();
        },
        failure: function(response, opts) {
			Ext.Msg.show({
				title: '<?php __('Failure'); ?>',
				buttons: Ext.MessageBox.OK,
				msg: '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status ,
				icon: Ext.MessageBox.ERROR
			});
        }
    });
}

function ViewParentUsers(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_users_data = response.responseText;

            eval(parent_users_data);

            parentUsersViewWindow.show();
        },
        failure: function(response, opts) {
			Ext.Msg.show({
				title: '<?php __('Failure'); ?>',
				buttons: Ext.MessageBox.OK,
				msg: '<?php __('Cannot get the group view form. Error code'); ?>: ' + response.status ,
				icon: Ext.MessageBox.ERROR
			});
        }
    });
}


function DeleteGroup(id) {
	Ext.Ajax.request ({
		url: '<?php echo $this->Html->url(array('controller' => 'groups', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.show({
				title: '<?php __('Success'); ?>',
				buttons: Ext.MessageBox.OK,
				msg: '<?php __('Group successfully deleted!'); ?>',
				icon: Ext.MessageBox.INFO
			});
			RefreshGroupData();
		},
		failure: function(response, opts) {
			Ext.Msg.show({
				title: '<?php __('Failure'); ?>',
				buttons: Ext.MessageBox.OK,
				msg: '<?php __('Cannot get the group add form. Error code'); ?>: ' + response.status ,
				icon: Ext.MessageBox.ERROR
			});
		}
	});
}

function SearchGroup(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'groups', 'action' => 'search')); ?>',
		success: function(response, opts){
			var group_data = response.responseText;

			eval(group_data);

			groupSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the group search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByGroupName(value){
	var conditions = '\'Group.name LIKE\' => \'%' + value + '%\'';
	store_groups.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshGroupData() {
	store_groups.reload();
}


if(center_panel.find('id', 'group-tab') != "") {
	var p = center_panel.findById('group-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Groups'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'group-tab',
		xtype: 'grid',
		store: store_groups,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true, width: 100},
			{header: "<?php __('Description'); ?>", dataIndex: 'description', sortable: true, width: 300},
			{header: "<?php __('Is Builtin?'); ?>", dataIndex: 'is_builtin', sortable: true, width: 50},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true, hidden: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true, hidden: true}
		],		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Groups" : "Group"]})'
        }),
		listeners: {
			celldblclick: function(){
				ViewGroup(Ext.getCmp('group-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: true
		}),
		tbar: new Ext.Toolbar({
			
			items: [
				{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('Add Group'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddGroup();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-group',
					tooltip:'<?php __('Edit Group'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditGroup(sel.data.id);
						};
					}
				},' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-group',
					tooltip:'<?php __('Delete Group'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
										title: '<?php __('Remove Group'); ?>',
										buttons: Ext.MessageBox.YESNO,
										msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
										fn: function(btn){
												if (btn == 'yes'){
														DeleteGroup(sel[0].data.id);
												}
										}
								});
							}else{
								Ext.Msg.show({
										title: '<?php __('Remove Group'); ?>',
										buttons: Ext.MessageBox.YESNO,
										msg: '<?php __('Remove the selected Groups'); ?>?',
										fn: function(btn){
												if (btn == 'yes'){
														var sel_ids = '';
														for(i=0;i<sel.length;i++){
															if(i>0)
																sel_ids += '_';
															sel_ids += sel[i].data.id;
														}
														DeleteGroup(sel_ids);
												}
										}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				},' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Group'); ?>',
					id: 'view-group',
					tooltip:'<?php __('View Group'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewGroup(sel.data.id);
						};
					},
					menu : {
						items: [
                                                    						{
							text: '<?php __('View Permissions'); ?>',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentPermissions(sel.data.id);
								};
							}
						}
,						{
							text: '<?php __('View Users'); ?>',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentUsers(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-', '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'group_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByGroupName(Ext.getCmp('group_search_field').getValue());
							}
						}

					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
					id: 'group_go_button',
					handler: function(){
						SearchByGroupName(Ext.getCmp('group_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
					handler: function(){
						SearchGroup();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_groups,
			displayInfo: true,
			displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of'); ?> {0}',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-group').enable();
		p.getTopToolbar().findById('delete-group').enable();
		p.getTopToolbar().findById('view-group').enable();
		
        var sm = p.getSelectionModel();
		var sel = sm.getSelected();
		if (sel.data.is_builtin == '<?php __('Yes'); ?>'){
            p.getTopToolbar().findById('delete-group').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-group').disable();
		p.getTopToolbar().findById('view-group').disable();
		p.getTopToolbar().findById('delete-group').disable();
	});
	center_panel.setActiveTab(p);
	
	store_groups.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
