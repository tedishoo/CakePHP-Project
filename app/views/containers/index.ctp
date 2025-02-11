var store_containers = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name', 'list_order'		
        ]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'list_data')); ?>'	
    }),	
    sortInfo:{field: 'list_order', direction: "ASC"}
});


function AddContainer() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var container_data = response.responseText;
			
			eval(container_data);
			
			containerAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Module Add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditContainer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var container_data = response.responseText;
			
			eval(container_data);
			
			containerEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Module Edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewContainer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var container_data = response.responseText;
			
			eval(container_data);
			
			containerViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Module View form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewParentLinks(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_links_data = response.responseText;
			
			eval(parent_links_data);
			
			parentLinksViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Module View form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteContainer(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Module successfully deleted!'); ?>');
			RefreshContainerData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot delete the Module. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchContainer(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'search')); ?>',
		success: function(response, opts){
			var container_data = response.responseText;

			eval(container_data);

			containerSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Module Search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByContainerName(value){
	var conditions = '\'Container.name LIKE\' => \'%' + value + '%\'';
	store_containers.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshContainerData() {
	store_containers.reload();
}


if(center_panel.find('id', 'container-tab') != "") {
	var p = center_panel.findById('container-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Modules'); ?>',
		closable: true,
		loadMask: true,
		id: 'container-tab',
		xtype: 'grid',
		store: store_containers,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
            {header: "<?php __('Order'); ?>", dataIndex: 'list_order', sortable: true}		
        ],
		listeners: {
			celldblclick: function(){
				ViewContainer(Ext.getCmp('container-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
        viewConfig: {
            forceFit:true
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
						AddContainer();
					}
				},' ', '-', ' ',
				{
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-container',
					tooltip:'<?php __('Edit Module'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditContainer(sel.data.id);
						};
					}
				},' ', '-', ' ',
				{
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-container',
					tooltip:'<?php __('Delete Module'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
										title: '<?php __('Remove Module'); ?>',
										buttons: Ext.MessageBox.YESNOCANCEL,
										msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
										fn: function(btn){
												if (btn == 'yes'){
														DeleteContainer(sel[0].data.id);
												}
										}
								});
							}else{
								Ext.Msg.show({
										title: '<?php __('Remove Module'); ?>',
										buttons: Ext.MessageBox.YESNOCANCEL,
										msg: '<?php __('Remove the selected Containers'); ?>?',
										fn: function(btn){
												if (btn == 'yes'){
														var sel_ids = '';
														for(i=0;i<sel.length;i++){
															if(i>0)
																sel_ids += '_';
															sel_ids += sel[i].data.id;
														}
														DeleteContainer(sel_ids);
												}
										}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				},' ', '-', ' ',
				{
					xtype: 'tbsplit',
					text: '<?php __('View Module'); ?>',
					id: 'view-container',
					tooltip:'<?php __('View Module'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewContainer(sel.data.id);
						};
					},
					menu : {
						items: [
						{
							text: '<?php __('View Activity'); ?>',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentLinks(sel.data.id);
								};
							}
						}
						]
					}
				},' ', '-', 
				'->',
				{
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'container_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByContainerName(Ext.getCmp('container_search_field').getValue());
							}
						}

					}
				},
				{
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
					id: 'container_go_button',
					handler: function(){
						SearchByContainerName(Ext.getCmp('container_search_field').getValue());
					}
				},'-',
				{
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
					handler: function(){
						SearchContainer();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_containers,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-container').enable();
		p.getTopToolbar().findById('delete-container').enable();
		p.getTopToolbar().findById('view-container').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-container').disable();
			p.getTopToolbar().findById('view-container').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-container').disable();
			p.getTopToolbar().findById('view-container').disable();
			p.getTopToolbar().findById('delete-container').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-container').enable();
			p.getTopToolbar().findById('view-container').enable();
			p.getTopToolbar().findById('delete-container').enable();
		}
		else{
			p.getTopToolbar().findById('edit-container').disable();
			p.getTopToolbar().findById('view-container').disable();
			p.getTopToolbar().findById('delete-container').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_containers.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
