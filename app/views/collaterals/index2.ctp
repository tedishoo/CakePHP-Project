var store_parent_collaterals = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','account','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCollateral() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_collateral_data = response.responseText;
			
			eval(parent_collateral_data);
			
			CollateralAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateral add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCollateral(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_collateral_data = response.responseText;
			
			eval(parent_collateral_data);
			
			CollateralEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateral edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCollateral(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var collateral_data = response.responseText;

			eval(collateral_data);

			CollateralViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateral view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCollateralCollateralDetails(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_collateralDetails_data = response.responseText;

			eval(parent_collateralDetails_data);

			parentCollateralDetailsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCollateralInsurances(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_insurances_data = response.responseText;

			eval(parent_insurances_data);

			parentInsurancesViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentCollateral(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Collateral(s) successfully deleted!'); ?>');
			RefreshParentCollateralData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateral to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCollateralName(value){
	var conditions = '\'Collateral.name LIKE\' => \'%' + value + '%\'';
	store_parent_collaterals.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCollateralData() {
	store_parent_collaterals.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Collaterals'); ?>',
	store: store_parent_collaterals,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'collateralGrid',
	columns: [
		{header:"<?php __('account'); ?>", dataIndex: 'account', sortable: true},
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
            ViewCollateral(Ext.getCmp('collateralGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Collateral</b><br />Click here to create a new Collateral'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCollateral();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-collateral',
				tooltip:'<?php __('<b>Edit Collateral</b><br />Click here to modify the selected Collateral'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCollateral(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-collateral',
				tooltip:'<?php __('<b>Delete Collateral(s)</b><br />Click here to remove the selected Collateral(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Collateral'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCollateral(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Collateral'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Collateral'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCollateral(sel_ids);
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
				text: '<?php __('View Collateral'); ?>',
				id: 'view-collateral2',
				tooltip:'<?php __('<b>View Collateral</b><br />Click here to see details of the selected Collateral'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCollateral(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Collateral Details'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewCollateralCollateralDetails(sel.data.id);
							};
						}
					}
, {
						text: '<?php __('View Insurances'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewCollateralInsurances(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_collateral_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCollateralName(Ext.getCmp('parent_collateral_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_collateral_go_button',
				handler: function(){
					SearchByParentCollateralName(Ext.getCmp('parent_collateral_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_collaterals,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-collateral').enable();
	g.getTopToolbar().findById('delete-parent-collateral').enable();
        g.getTopToolbar().findById('view-collateral2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-collateral').disable();
                g.getTopToolbar().findById('view-collateral2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-collateral').disable();
		g.getTopToolbar().findById('delete-parent-collateral').enable();
                g.getTopToolbar().findById('view-collateral2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-collateral').enable();
		g.getTopToolbar().findById('delete-parent-collateral').enable();
                g.getTopToolbar().findById('view-collateral2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-collateral').disable();
		g.getTopToolbar().findById('delete-parent-collateral').disable();
                g.getTopToolbar().findById('view-collateral2').disable();
	}
});



var parentCollateralsViewWindow = new Ext.Window({
	title: 'Collateral Under the selected Item',
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
			parentCollateralsViewWindow.close();
		}
	}]
});

store_parent_collaterals.load({
    params: {
        start: 0,    
        limit: list_size
    }
});