var store_parent_links = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','container','controller','action','parameter', 'function_name', {name: 'list_order', type: 'int'}	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'list_data', $parent_id)); ?>'	})
});

function AddParentLink() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_link_data = response.responseText;
			
			eval(parent_link_data);
			
			linkAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Activity Add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentLink(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_link_data = response.responseText;
			
			eval(parent_link_data);
			
			linkEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Activity Edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function DeleteParentLink(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Activity(ies) successfully deleted!'); ?>');
			RefreshParentLinkData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot delete the Activity. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentLinkName(value){
	var conditions = '\'Link.name LIKE\' => \'%' + value + '%\'';
	store_parent_links.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentLinkData() {
	store_parent_links.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Activities'); ?>',
	store: store_parent_links,
	loadMask: true,
	height: 300,
	anchor: '100%',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Module'); ?>", dataIndex: 'container', sortable: true},
		{header: "<?php __('Controller'); ?>", dataIndex: 'controller', sortable: true},
		{header: "<?php __('Action'); ?>", dataIndex: 'action', sortable: true},
		{header: "<?php __('Parameter'); ?>", dataIndex: 'parameter', sortable: true, hidden: true},	
        {header: "<?php __('Function'); ?>", dataIndex: 'function_name', sortable: true},	
        {header: "<?php __('Order'); ?>", dataIndex: 'list_order', sortable: true}	
    ],
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
				tooltip:'<?php __('Add Activity'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentLink();
				}
			},' ', '-', ' ',
			{
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-link',
				tooltip:'<?php __('Edit Activity'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentLink(sel.data.id);
					};
				}
			},' ', '-', ' ',
			{
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-link',
				tooltip:'<?php __('Delete Activity'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Activity'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									fn: function(btn){
											if (btn == 'yes'){
													DeleteParentLink(sel[0].data.id);
											}
									}
							});
						}else{
							Ext.Msg.show({
									title: '<?php __('Remove Activity'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Activity'); ?>?',
									fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentLink(sel_ids);
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
				id: 'parent_link_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentLinkName(Ext.getCmp('parent_link_search_field').getValue());
						}
					}

				}
			},
			{
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				id: 'parent_link_go_button',
				handler: function(){
					SearchByParentLinkName(Ext.getCmp('parent_link_search_field').getValue());
				}
			},' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_links,
		displayInfo: true,
		displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of'); ?> {0}'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-link').enable();
	g.getTopToolbar().findById('delete-parent-link').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-link').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-link').disable();
		g.getTopToolbar().findById('delete-parent-link').enable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-link').enable();
		g.getTopToolbar().findById('delete-parent-link').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-link').disable();
		g.getTopToolbar().findById('delete-parent-link').disable();
	}
});



var parentLinksViewWindow = new Ext.Window({
	title: 'Link Under the selected Item',
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
			parentLinksViewWindow.hide();
		}
	}]
});

store_parent_links.load({
    params: {
        start: 0,    
        limit: list_size
    }
});