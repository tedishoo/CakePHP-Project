var store_parent_insurances = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','collateral_detail','estimated_value','date_estimated','insurance_company','type','date_insured','amount_insured','expire_date','policy_number','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentInsurance() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_insurance_data = response.responseText;
			
			eval(parent_insurance_data);
			
			InsuranceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the insurance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentInsurance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_insurance_data = response.responseText;
			
			eval(parent_insurance_data);
			
			InsuranceEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the insurance edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewInsurance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var insurance_data = response.responseText;

			eval(insurance_data);

			InsuranceViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the insurance view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentInsurance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Insurance(s) successfully deleted!'); ?>');
			RefreshParentInsuranceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the insurance to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentInsuranceName(value){
	var conditions = '\'Insurance.name LIKE\' => \'%' + value + '%\'';
	store_parent_insurances.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentInsuranceData() {
	store_parent_insurances.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Insurances'); ?>',
	store: store_parent_insurances,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'insuranceGrid',
	columns: [
		{header:"<?php __('collateral_detail'); ?>", dataIndex: 'collateral_detail', sortable: true,hidden: true},
		{header: "<?php __('Estimated Value'); ?>", dataIndex: 'estimated_value', sortable: true},
		{header: "<?php __('Date Estimated'); ?>", dataIndex: 'date_estimated', sortable: true},
		{header: "<?php __('Insurance Company'); ?>", dataIndex: 'insurance_company', sortable: true},
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
		{header: "<?php __('Date Insured'); ?>", dataIndex: 'date_insured', sortable: true},
		{header: "<?php __('Amount Insured'); ?>", dataIndex: 'amount_insured', sortable: true},
		{header: "<?php __('Expire Date'); ?>", dataIndex: 'expire_date', sortable: true},
		{header: "<?php __('Policy Number'); ?>", dataIndex: 'policy_number', sortable: true},
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
            ViewInsurance(Ext.getCmp('insuranceGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Insurance</b><br />Click here to create a new Insurance'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentInsurance();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-insurance',
				tooltip:'<?php __('<b>Edit Insurance</b><br />Click here to modify the selected Insurance'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentInsurance(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-insurance',
				tooltip:'<?php __('<b>Delete Insurance(s)</b><br />Click here to remove the selected Insurance(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Insurance'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentInsurance(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Insurance'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Insurance'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentInsurance(sel_ids);
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
				text: '<?php __('View Insurance'); ?>',
				id: 'view-insurance2',
				tooltip:'<?php __('<b>View Insurance</b><br />Click here to see details of the selected Insurance'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewInsurance(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_insurance_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentInsuranceName(Ext.getCmp('parent_insurance_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_insurance_go_button',
				handler: function(){
					SearchByParentInsuranceName(Ext.getCmp('parent_insurance_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_insurances,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-insurance').enable();
	g.getTopToolbar().findById('delete-parent-insurance').enable();
        g.getTopToolbar().findById('view-insurance2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-insurance').disable();
                g.getTopToolbar().findById('view-insurance2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-insurance').disable();
		g.getTopToolbar().findById('delete-parent-insurance').enable();
                g.getTopToolbar().findById('view-insurance2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-insurance').enable();
		g.getTopToolbar().findById('delete-parent-insurance').enable();
                g.getTopToolbar().findById('view-insurance2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-insurance').disable();
		g.getTopToolbar().findById('delete-parent-insurance').disable();
                g.getTopToolbar().findById('view-insurance2').disable();
	}
});



var parentInsurancesViewWindow = new Ext.Window({
	title: 'Insurance Under the selected Item',
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
			parentInsurancesViewWindow.close();
		}
	}]
});

store_parent_insurances.load({
    params: {
        start: 0,    
        limit: list_size
    }
});