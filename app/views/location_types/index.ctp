
var store_locationTypes = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'locationTypes', 'action' => 'list_data')); ?>'
	})});


function AddLocationType() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'locationTypes', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var locationType_data = response.responseText;
			
			eval(locationType_data);
			
			LocationTypeAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the locationType add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditLocationType(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'locationTypes', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var locationType_data = response.responseText;
			
			eval(locationType_data);
			
			LocationTypeEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the locationType edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewLocationType(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'locationTypes', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var locationType_data = response.responseText;

            eval(locationType_data);

            LocationTypeViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the locationType view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentLocations(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_locations_data = response.responseText;

            eval(parent_locations_data);

            parentLocationsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteLocationType(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'locationTypes', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('LocationType successfully deleted!'); ?>');
			RefreshLocationTypeData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the locationType add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchLocationType(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'locationTypes', 'action' => 'search')); ?>',
		success: function(response, opts){
			var locationType_data = response.responseText;

			eval(locationType_data);

			locationTypeSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the locationType search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByLocationTypeName(value){
	var conditions = '\'LocationType.name LIKE\' => \'%' + value + '%\'';
	store_locationTypes.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshLocationTypeData() {
	store_locationTypes.reload();
}


if(center_panel.find('id', 'locationType-tab') != "") {
	var p = center_panel.findById('locationType-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Location Types'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'locationType-tab',
		xtype: 'grid',
		store: store_locationTypes,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
		],
		listeners: {
			celldblclick: function(){
				ViewLocationType(Ext.getCmp('locationType-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		viewConfig: {
			forceFit: true
		},
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add LocationTypes</b><br />Click here to create a new LocationType'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddLocationType();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-locationType',
					tooltip:'<?php __('<b>Edit LocationTypes</b><br />Click here to modify the selected LocationType'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditLocationType(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-locationType',
					tooltip:'<?php __('<b>Delete LocationTypes(s)</b><br />Click here to remove the selected LocationType(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
										title: '<?php __('Remove LocationType'); ?>',
										buttons: Ext.MessageBox.YESNO,
										msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
										icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
												if (btn == 'yes'){
														DeleteLocationType(sel[0].data.id);
												}
										}
								});
							}else{
								Ext.Msg.show({
										title: '<?php __('Remove LocationType'); ?>',
										buttons: Ext.MessageBox.YESNO,
										msg: '<?php __('Remove the selected LocationTypes'); ?>?',
										icon: Ext.MessageBox.QUESTION,
                                        fn: function(btn){
												if (btn == 'yes'){
														var sel_ids = '';
														for(i=0;i<sel.length;i++){
															if(i>0)
																sel_ids += '_';
															sel_ids += sel[i].data.id;
														}
														DeleteLocationType(sel_ids);
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
					text: '<?php __('View LocationType'); ?>',
					id: 'view-locationType',
					tooltip:'<?php __('<b>View LocationType</b><br />Click here to see details of the selected LocationType'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewLocationType(sel.data.id);
						};
					},
					menu : {
						items: [{
							text: '<?php __('View Locations'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentLocations(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'locationType_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByLocationTypeName(Ext.getCmp('locationType_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'locationType_go_button',
					handler: function(){
						SearchByLocationTypeName(Ext.getCmp('locationType_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchLocationType();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_locationTypes,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-locationType').enable();
		p.getTopToolbar().findById('delete-locationType').enable();
		p.getTopToolbar().findById('view-locationType').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-locationType').disable();
			p.getTopToolbar().findById('view-locationType').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-locationType').disable();
			p.getTopToolbar().findById('view-locationType').disable();
			p.getTopToolbar().findById('delete-locationType').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-locationType').enable();
			p.getTopToolbar().findById('view-locationType').enable();
			p.getTopToolbar().findById('delete-locationType').enable();
		}
		else{
			p.getTopToolbar().findById('edit-locationType').disable();
			p.getTopToolbar().findById('view-locationType').disable();
			p.getTopToolbar().findById('delete-locationType').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_locationTypes.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
