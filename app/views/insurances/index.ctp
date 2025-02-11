
var store_insurances = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','collateral_detail','estimated_value','date_estimated','insurance_company','type','date_insured','amount_insured','expire_date','policy_number','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'collateral_detail_id', direction: "ASC"},
	groupField: 'estimated_value'
});


function AddInsurance() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var insurance_data = response.responseText;
			
			eval(insurance_data);
			
			InsuranceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the insurance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditInsurance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var insurance_data = response.responseText;
			
			eval(insurance_data);
			
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

function DeleteInsurance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Insurance successfully deleted!'); ?>');
			RefreshInsuranceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the insurance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchInsurance(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'search')); ?>',
		success: function(response, opts){
			var insurance_data = response.responseText;

			eval(insurance_data);

			insuranceSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the insurance search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByInsuranceName(value){
	var conditions = '\'Insurance.name LIKE\' => \'%' + value + '%\'';
	store_insurances.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshInsuranceData() {
	store_insurances.reload();
}


if(center_panel.find('id', 'insurance-tab') != "") {
	var p = center_panel.findById('insurance-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Insurances'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'insurance-tab',
		xtype: 'grid',
		store: store_insurances,
		columns: [
			{header: "<?php __('CollateralDetail'); ?>", dataIndex: 'collateral_detail', sortable: true},
			{header: "<?php __('Estimated Value'); ?>", dataIndex: 'estimated_value', sortable: true},
			{header: "<?php __('Date Estimated'); ?>", dataIndex: 'date_estimated', sortable: true},
			{header: "<?php __('Insurance Company'); ?>", dataIndex: 'insurance_company', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('Date Insured'); ?>", dataIndex: 'date_insured', sortable: true},
			{header: "<?php __('Amount Insured'); ?>", dataIndex: 'amount_insured', sortable: true},
			{header: "<?php __('Expire Date'); ?>", dataIndex: 'expire_date', sortable: true},
			{header: "<?php __('Policy Number'); ?>", dataIndex: 'policy_number', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Insurances" : "Insurance"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewInsurance(Ext.getCmp('insurance-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Insurances</b><br />Click here to create a new Insurance'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddInsurance();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-insurance',
					tooltip:'<?php __('<b>Edit Insurances</b><br />Click here to modify the selected Insurance'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditInsurance(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-insurance',
					tooltip:'<?php __('<b>Delete Insurances(s)</b><br />Click here to remove the selected Insurance(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Insurance'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteInsurance(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Insurance'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Insurances'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteInsurance(sel_ids);
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
					text: '<?php __('View Insurance'); ?>',
					id: 'view-insurance',
					tooltip:'<?php __('<b>View Insurance</b><br />Click here to see details of the selected Insurance'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewInsurance(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('CollateralDetail'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($collateraldetails as $item){if($st) echo ",
							";?>['<?php echo $item['CollateralDetail']['id']; ?>' ,'<?php echo $item['CollateralDetail']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_insurances.reload({
								params: {
									start: 0,
									limit: list_size,
									collateraldetail_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'insurance_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByInsuranceName(Ext.getCmp('insurance_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'insurance_go_button',
					handler: function(){
						SearchByInsuranceName(Ext.getCmp('insurance_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchInsurance();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_insurances,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-insurance').enable();
		p.getTopToolbar().findById('delete-insurance').enable();
		p.getTopToolbar().findById('view-insurance').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-insurance').disable();
			p.getTopToolbar().findById('view-insurance').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-insurance').disable();
			p.getTopToolbar().findById('view-insurance').disable();
			p.getTopToolbar().findById('delete-insurance').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-insurance').enable();
			p.getTopToolbar().findById('view-insurance').enable();
			p.getTopToolbar().findById('delete-insurance').enable();
		}
		else{
			p.getTopToolbar().findById('edit-insurance').disable();
			p.getTopToolbar().findById('view-insurance').disable();
			p.getTopToolbar().findById('delete-insurance').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_insurances.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
