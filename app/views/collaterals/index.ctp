//<script>
var store_collaterals = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: ['id','account','created','modified']
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'account', direction: "ASC"}
});


function AddCollateral() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var collateral_data = response.responseText;
			
			eval(collateral_data);
			
			CollateralAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateral add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCollateral(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var collateral_data = response.responseText;
			
			eval(collateral_data);
			
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
function ViewParentCollateralDetails(id) {
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

function ViewParentInsurances(id) {
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


function DeleteCollateral(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Collateral successfully deleted!'); ?>');
			RefreshCollateralData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateral add form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewExpiredInsurance(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'index_expired_insurance')); ?>/',		
		 success: function(response, opts) {
            var collateral_data = response.responseText;

            eval(collateral_data);

            ExpiredInsuranceWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Expired Insurance view form. Error code'); ?>: ' + response.status);
        }
	});
}

function SearchCollateral(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'search')); ?>',
		success: function(response, opts){
			var collateral_data = response.responseText;

			eval(collateral_data);

			collateralSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the collateral search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCollateralName(value){
	var conditions = '\'Collateral.name LIKE\' => \'%' + value + '%\'';
	store_collaterals.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCollateralData() {
	store_collaterals.reload();
}


if(center_panel.find('id', 'collateral-tab') != "") {
	var p = center_panel.findById('collateral-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Collaterals'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'collateral-tab',
		xtype: 'grid',
		store: store_collaterals,
		columns: [
			{header: "<?php __('Account'); ?>", dataIndex: 'account', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Collaterals" : "Collateral"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCollateral(Ext.getCmp('collateral-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Collaterals</b><br />Click here to create a new Collateral'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCollateral();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-collateral',
					tooltip:'<?php __('<b>Edit Collaterals</b><br />Click here to modify the selected Collateral'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCollateral(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-collateral',
					tooltip:'<?php __('<b>Delete Collaterals(s)</b><br />Click here to remove the selected Collateral(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Collateral'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteCollateral(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Collateral'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Collaterals'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteCollateral(sel_ids);
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
					text: '<?php __('View Collateral'); ?>',
					id: 'view-collateral',
					tooltip:'<?php __('<b>View Collateral</b><br />Click here to see details of the selected Collateral'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
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
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentCollateralDetails(sel.data.id);
								};
							}
						}
,/*{
							text: '<?php __('View Insurances'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentInsurances(sel.data.id);
								};
							}
						}*/
						]
					}
				}, ' ', '-',  '<?php __('Account'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;
							foreach ($accounts as $item){
								if($st) echo ",
								";?>['<?php echo $item['Account']['id']; ?>' ,'<?php echo str_replace("'",'',$item['Account']['first_name']).' '.str_replace("'",'',$item['Account']['middle_name']).' '.str_replace("'",'',$item['Account']['last_name']); ?>']<?php $st = true;
								}?>
							]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_collaterals.reload({
								params: {
									start: 0,
									limit: list_size,
									account_id : combo.getValue()
								}
							});
						}
					}
				},' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Expired Insurance'); ?>',
					id: 'expired-insurance',
					tooltip:'<?php __('<b>Expired Insurance</b><br />Click here to view Expired Insurance'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: false,
					handler: function(btn) {					
						
							ViewExpiredInsurance();
						
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'collateral_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCollateralName(Ext.getCmp('collateral_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'collateral_go_button',
					handler: function(){
						SearchByCollateralName(Ext.getCmp('collateral_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCollateral();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_collaterals,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-collateral').enable();
		p.getTopToolbar().findById('delete-collateral').enable();
		p.getTopToolbar().findById('view-collateral').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-collateral').disable();
			p.getTopToolbar().findById('view-collateral').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-collateral').disable();
			p.getTopToolbar().findById('view-collateral').disable();
			p.getTopToolbar().findById('delete-collateral').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-collateral').enable();
			p.getTopToolbar().findById('view-collateral').enable();
			p.getTopToolbar().findById('delete-collateral').enable();
		}
		else{
			p.getTopToolbar().findById('edit-collateral').disable();
			p.getTopToolbar().findById('view-collateral').disable();
			p.getTopToolbar().findById('delete-collateral').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_collaterals.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
