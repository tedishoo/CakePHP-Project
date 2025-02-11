var store_parent_locations = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','parent_location','lft','rght'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentLocation() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_location_data = response.responseText;
			
			eval(parent_location_data);
			
			LocationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the location add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentLocation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_location_data = response.responseText;
			
			eval(parent_location_data);
			
			LocationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the location edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function DeleteParentLocation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Location(s) successfully deleted!'); ?>');
			RefreshParentLocationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the location to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentLocationName(value){
	var conditions = '\'Location.name LIKE\' => \'%' + value + '%\'';
	store_parent_locations.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentLocationData() {
	store_parent_locations.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Locations'); ?>',
	store: store_parent_locations,
	loadMask: true,
	height: 300,
	anchor: '100%',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Parent Location'); ?>", dataIndex: 'parent_location', sortable: true},
		{header: "<?php __('Lft'); ?>", dataIndex: 'lft', sortable: true},
		{header: "<?php __('Rght'); ?>", dataIndex: 'rght', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	tbar: new Ext.Toolbar({
		
		items: [
			{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('Add Location'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentLocation();
				}
			},' ', '-', ' ',
			{
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-location',
				tooltip:'<?php __('Edit Location'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentLocation(sel.data.id);
					};
				}
			},' ', '-', ' ',
			{
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-location',
				tooltip:'<?php __('Delete Location'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Location'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									fn: function(btn){
											if (btn == 'yes'){
													DeleteParentLocation(sel[0].data.id);
											}
									}
							});
						}else{
							Ext.Msg.show({
									title: '<?php __('Remove Location'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Location'); ?>?',
									fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentLocation(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			},' ', '->',
			{
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_location_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentLocationName(Ext.getCmp('parent_location_search_field').getValue());
						}
					}

				}
			},
			{
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				id: 'parent_location_go_button',
				handler: function(){
					SearchByParentLocationName(Ext.getCmp('parent_location_search_field').getValue());
				}
			},' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_locations,
		displayInfo: true,
		displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of'); ?> {0}'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-location').enable();
	g.getTopToolbar().findById('delete-parent-location').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-location').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-location').disable();
		g.getTopToolbar().findById('delete-parent-location').enable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-location').enable();
		g.getTopToolbar().findById('delete-parent-location').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-location').disable();
		g.getTopToolbar().findById('delete-parent-location').disable();
	}
});



var parentLocationsViewWindow = new Ext.Window({
	title: 'Location Under the selected Item',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	modal: true,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
	items: [
		g
	],

	buttons: [{
		text: 'Close',
		handler: function(btn){
			parentLocationsViewWindow.hide();
		}
	}]
});

store_parent_locations.load({
    params: {
        start: 0,    
        limit: list_size
    }
});