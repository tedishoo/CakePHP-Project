
var store_settings = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','setting_key','setting_value','date_from','date_to','remark'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'settings', 'action' => 'list_data')); ?>'
	}),	
    sortInfo:{field: 'setting_key', direction: "ASC"}
});

function AddSetting() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'settings', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var setting_data = response.responseText;
			
			eval(setting_data);
			
			SettingAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the setting add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'settings', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var setting_data = response.responseText;
			
			eval(setting_data);
			
			SettingEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the setting edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewSetting(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'settings', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var setting_data = response.responseText;

            eval(setting_data);

            SettingViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the setting view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteSetting(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'settings', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Setting successfully deleted!'); ?>');
			RefreshSettingData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the setting add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchSetting(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'settings', 'action' => 'search')); ?>',
		success: function(response, opts){
			var setting_data = response.responseText;

			eval(setting_data);

			settingSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the setting search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchBySettingName(value){
	var conditions = '\'Setting.name LIKE\' => \'%' + value + '%\'';
	store_settings.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshSettingData() {
	store_settings.reload();
}


if(center_panel.find('id', 'setting-tab') != "") {
	var p = center_panel.findById('setting-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Settings'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'setting-tab',
		xtype: 'grid',
		store: store_settings,
		columns: [
			{header: "<?php __('Setting Key'); ?>", dataIndex: 'setting_key', sortable: true},
			{header: "<?php __('Setting Value'); ?>", dataIndex: 'setting_value', sortable: true},
			{header: "<?php __('Date From'); ?>", dataIndex: 'date_from', sortable: true},
			{header: "<?php __('Date To'); ?>", dataIndex: 'date_to', sortable: true},
			{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
		],		
		viewConfig: {
            forceFit:true
        },
		listeners: {
			celldblclick: function(){
				ViewSetting(Ext.getCmp('setting-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Settings</b><br />Click here to create a new Setting'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddSetting();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-setting',
					tooltip:'<?php __('<b>Edit Settings</b><br />Click here to modify the selected Setting'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditSetting(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-setting',
					tooltip:'<?php __('<b>Delete Settings(s)</b><br />Click here to remove the selected Setting(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
										title: '<?php __('Remove Setting'); ?>',
										buttons: Ext.MessageBox.YESNO,
										msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
										icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
												if (btn == 'yes'){
														DeleteSetting(sel[0].data.id);
												}
										}
								});
							}else{
								Ext.Msg.show({
										title: '<?php __('Remove Setting'); ?>',
										buttons: Ext.MessageBox.YESNO,
										msg: '<?php __('Remove the selected Settings'); ?>?',
										icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
												if (btn == 'yes'){
														var sel_ids = '';
														for(i=0;i<sel.length;i++){
															if(i>0)
																sel_ids += '_';
															sel_ids += sel[i].data.id;
														}
														DeleteSetting(sel_ids);
												}
										}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Setting'); ?>',
					id: 'view-setting',
					tooltip:'<?php __('<b>View Setting</b><br />Click here to see details of the selected Setting'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewSetting(sel.data.id);
						};
					},
					menu : {
						items: [						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'setting_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchBySettingName(Ext.getCmp('setting_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'setting_go_button',
					handler: function(){
						SearchBySettingName(Ext.getCmp('setting_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchSetting();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_settings,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-setting').enable();
		p.getTopToolbar().findById('delete-setting').enable();
		p.getTopToolbar().findById('view-setting').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-setting').disable();
			p.getTopToolbar().findById('view-setting').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-setting').disable();
			p.getTopToolbar().findById('view-setting').disable();
			p.getTopToolbar().findById('delete-setting').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-setting').enable();
			p.getTopToolbar().findById('view-setting').enable();
			p.getTopToolbar().findById('delete-setting').enable();
		}
		else{
			p.getTopToolbar().findById('edit-setting').disable();
			p.getTopToolbar().findById('view-setting').disable();
			p.getTopToolbar().findById('delete-setting').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_settings.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
