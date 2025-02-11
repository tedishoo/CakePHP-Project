var store_parent_containers = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentContainer() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_container_data = response.responseText;
			
			eval(parent_container_data);
			
			containerAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Module Add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentContainer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_container_data = response.responseText;
			
			eval(parent_container_data);
			
			containerEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Module Edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function DeleteParentContainer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Module(s) successfully deleted!'); ?>');
			RefreshParentContainerData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot delete the Module(s). Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentContainerName(value){
	var conditions = '\'Container.name LIKE\' => \'%' + value + '%\'';
	store_parent_containers.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentContainerData() {
	store_parent_containers.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Modules'); ?>',
	store: store_parent_containers,
	loadMask: true,
	height: 300,
	anchor: '100%',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
    viewConfig: {
        forceFit: true    
    },
	tbar: new Ext.Toolbar({
		
		items: [
			{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('Add Module'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentContainer();
				}
			},' ', '-', ' ',
			{
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-container',
				tooltip:'<?php __('Edit Module'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentContainer(sel.data.id);
					};
				}
			},' ', '-', ' ',
			{
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-container',
				tooltip:'<?php __('Delete Module'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Module'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									fn: function(btn){
											if (btn == 'yes'){
													DeleteParentContainer(sel[0].data.id);
											}
									}
							});
						}else{
							Ext.Msg.show({
									title: '<?php __('Remove Module'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Module'); ?>?',
									fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentContainer(sel_ids);
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
				id: 'parent_container_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentContainerName(Ext.getCmp('parent_container_search_field').getValue());
						}
					}

				}
			},
			{
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				id: 'parent_container_go_button',
				handler: function(){
					SearchByParentContainerName(Ext.getCmp('parent_container_search_field').getValue());
				}
			},' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_containers,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-container').enable();
	g.getTopToolbar().findById('delete-parent-container').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-container').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-container').disable();
		g.getTopToolbar().findById('delete-parent-container').enable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-container').enable();
		g.getTopToolbar().findById('delete-parent-container').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-container').disable();
		g.getTopToolbar().findById('delete-parent-container').disable();
	}
});



var parentContainersViewWindow = new Ext.Window({
	title: 'Container Under the selected Item',
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
			parentContainersViewWindow.hide();
		}
	}]
});

store_parent_containers.load({
    params: {
        start: 0,    
        limit: list_size
    }
});