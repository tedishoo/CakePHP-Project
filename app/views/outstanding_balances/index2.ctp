var store_parent_outstandingBalances = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'account','date','balance','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentOutstandingBalance() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_outstandingBalance_data = response.responseText;
			
			eval(parent_outstandingBalance_data);
			
			OutstandingBalanceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the outstandingBalance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentOutstandingBalance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_outstandingBalance_data = response.responseText;
			
			eval(parent_outstandingBalance_data);
			
			OutstandingBalanceEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the outstandingBalance edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewOutstandingBalance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var outstandingBalance_data = response.responseText;

			eval(outstandingBalance_data);

			OutstandingBalanceViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the outstandingBalance view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentOutstandingBalance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('OutstandingBalance(s) successfully deleted!'); ?>');
			RefreshParentOutstandingBalanceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the outstandingBalance to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentOutstandingBalanceName(value){
	var conditions = '\'OutstandingBalance.name LIKE\' => \'%' + value + '%\'';
	store_parent_outstandingBalances.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentOutstandingBalanceData() {
	store_parent_outstandingBalances.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('OutstandingBalances'); ?>',
	store: store_parent_outstandingBalances,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'outstandingBalanceGrid',
	columns: [
		{header:"<?php __('account'); ?>", dataIndex: 'account', sortable: true},
		{header:"<?php __('date'); ?>", dataIndex: 'date', sortable: true},
		{header: "<?php __('Balance'); ?>", dataIndex: 'balance', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewOutstandingBalance(Ext.getCmp('outstandingBalanceGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add OutstandingBalance</b><br />Click here to create a new OutstandingBalance'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentOutstandingBalance();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-outstandingBalance',
				tooltip:'<?php __('<b>Edit OutstandingBalance</b><br />Click here to modify the selected OutstandingBalance'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentOutstandingBalance(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-outstandingBalance',
				tooltip:'<?php __('<b>Delete OutstandingBalance(s)</b><br />Click here to remove the selected OutstandingBalance(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove OutstandingBalance'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentOutstandingBalance(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove OutstandingBalance'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected OutstandingBalance'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentOutstandingBalance(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View OutstandingBalance'); ?>',
				id: 'view-outstandingBalance2',
				tooltip:'<?php __('<b>View OutstandingBalance</b><br />Click here to see details of the selected OutstandingBalance'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewOutstandingBalance(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_outstandingBalance_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentOutstandingBalanceName(Ext.getCmp('parent_outstandingBalance_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_outstandingBalance_go_button',
				handler: function(){
					SearchByParentOutstandingBalanceName(Ext.getCmp('parent_outstandingBalance_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_outstandingBalances,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-outstandingBalance').enable();
	g.getTopToolbar().findById('delete-parent-outstandingBalance').enable();
        g.getTopToolbar().findById('view-outstandingBalance2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-outstandingBalance').disable();
                g.getTopToolbar().findById('view-outstandingBalance2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-outstandingBalance').disable();
		g.getTopToolbar().findById('delete-parent-outstandingBalance').enable();
                g.getTopToolbar().findById('view-outstandingBalance2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-outstandingBalance').enable();
		g.getTopToolbar().findById('delete-parent-outstandingBalance').enable();
                g.getTopToolbar().findById('view-outstandingBalance2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-outstandingBalance').disable();
		g.getTopToolbar().findById('delete-parent-outstandingBalance').disable();
                g.getTopToolbar().findById('view-outstandingBalance2').disable();
	}
});



var parentOutstandingBalancesViewWindow = new Ext.Window({
	title: 'OutstandingBalance Under the selected Item',
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
			parentOutstandingBalancesViewWindow.close();
		}
	}]
});

store_parent_outstandingBalances.load({
    params: {
        start: 0,    
        limit: list_size
    }
});