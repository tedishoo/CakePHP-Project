
var store_credits = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','account','batch','record_type_indicator','branch','reporting_date','opening_balance_credit','maturity_date','payment_due_date','repayment','total_installment_amount','installment_amount','last_date_active','number_of_instalment','original_loan_term','interest_amount','current_balance_amount','current_balance_indicator','date_of_last_payment_received','credit_account_status_code','date_settled','last_status_change','account_closure_date','account_arrears_date','overdue_balance','number_of_days_in_arrears','account_closure_reason_code','risk_classification_code','resturcture_flag_code','last_restructure_date','consent_flag_code','outstanding_balance_of_loan','approved_amount'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'account_id', direction: "ASC"},
	groupField: 'batch_id'
});


function AddCredit() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var credit_data = response.responseText;
			
			eval(credit_data);
			
			CreditAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the credit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCredit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var credit_data = response.responseText;
			
			eval(credit_data);
			
			CreditEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the credit edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCredit(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var credit_data = response.responseText;

            eval(credit_data);

            CreditViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the credit view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteCredit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Credit successfully deleted!'); ?>');
			RefreshCreditData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the credit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCredit(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'search')); ?>',
		success: function(response, opts){
			var credit_data = response.responseText;

			eval(credit_data);

			creditSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the credit search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCreditName(value){
	var conditions = '\'Credit.name LIKE\' => \'%' + value + '%\'';
	store_credits.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCreditData() {
	store_credits.reload();
}


if(center_panel.find('id', 'credit-tab') != "") {
	var p = center_panel.findById('credit-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Credits'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'credit-tab',
		xtype: 'grid',
		store: store_credits,
		columns: [
			{header: "<?php __('Account'); ?>", dataIndex: 'account', sortable: true},
			{header: "<?php __('Batch'); ?>", dataIndex: 'batch', sortable: true},
			{header: "<?php __('Record Type Indicator'); ?>", dataIndex: 'record_type_indicator', sortable: true},
			{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true},
			{header: "<?php __('Reporting Date'); ?>", dataIndex: 'reporting_date', sortable: true},
			{header: "<?php __('Opening Balance Credit'); ?>", dataIndex: 'opening_balance_credit', sortable: true},
			{header: "<?php __('Maturity Date'); ?>", dataIndex: 'maturity_date', sortable: true},
			{header: "<?php __('Payment Due Date'); ?>", dataIndex: 'payment_due_date', sortable: true},
			{header: "<?php __('Repayment'); ?>", dataIndex: 'repayment', sortable: true},
			{header: "<?php __('Total Installment Amount'); ?>", dataIndex: 'total_installment_amount', sortable: true},
			{header: "<?php __('Installment Amount'); ?>", dataIndex: 'installment_amount', sortable: true},
			{header: "<?php __('Last Date Active'); ?>", dataIndex: 'last_date_active', sortable: true},
			{header: "<?php __('Number Of Instalment'); ?>", dataIndex: 'number_of_instalment', sortable: true},
			{header: "<?php __('Original Loan Term'); ?>", dataIndex: 'original_loan_term', sortable: true},
			{header: "<?php __('Interest Amount'); ?>", dataIndex: 'interest_amount', sortable: true},
			{header: "<?php __('Current Balance Amount'); ?>", dataIndex: 'current_balance_amount', sortable: true},
			{header: "<?php __('Current Balance Indicator'); ?>", dataIndex: 'current_balance_indicator', sortable: true},
			{header: "<?php __('Date Of Last Payment Received'); ?>", dataIndex: 'date_of_last_payment_received', sortable: true},
			{header: "<?php __('Credit Account Status Code'); ?>", dataIndex: 'credit_account_status_code', sortable: true},
			{header: "<?php __('Date Settled'); ?>", dataIndex: 'date_settled', sortable: true},
			{header: "<?php __('Last Status Change'); ?>", dataIndex: 'last_status_change', sortable: true},
			{header: "<?php __('Account Closure Date'); ?>", dataIndex: 'account_closure_date', sortable: true},
			{header: "<?php __('Account Arrears Date'); ?>", dataIndex: 'account_arrears_date', sortable: true},
			{header: "<?php __('Overdue Balance'); ?>", dataIndex: 'overdue_balance', sortable: true},
			{header: "<?php __('Number Of Days In Arrears'); ?>", dataIndex: 'number_of_days_in_arrears', sortable: true},
			{header: "<?php __('Account Closure Reason Code'); ?>", dataIndex: 'account_closure_reason_code', sortable: true},
			{header: "<?php __('Risk Classification Code'); ?>", dataIndex: 'risk_classification_code', sortable: true},
			{header: "<?php __('Resturcture Flag Code'); ?>", dataIndex: 'resturcture_flag_code', sortable: true},
			{header: "<?php __('Last Restructure Date'); ?>", dataIndex: 'last_restructure_date', sortable: true},
			{header: "<?php __('Consent Flag Code'); ?>", dataIndex: 'consent_flag_code', sortable: true},
			{header: "<?php __('Outstanding Balance Of Loan'); ?>", dataIndex: 'outstanding_balance_of_loan', sortable: true},
			{header: "<?php __('Approved Amount'); ?>", dataIndex: 'approved_amount', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Credits" : "Credit"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCredit(Ext.getCmp('credit-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Credits</b><br />Click here to create a new Credit'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCredit();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-credit',
					tooltip:'<?php __('<b>Edit Credits</b><br />Click here to modify the selected Credit'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCredit(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-credit',
					tooltip:'<?php __('<b>Delete Credits(s)</b><br />Click here to remove the selected Credit(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Credit'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteCredit(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Credit'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Credits'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteCredit(sel_ids);
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
					text: '<?php __('View Credit'); ?>',
					id: 'view-credit',
					tooltip:'<?php __('<b>View Credit</b><br />Click here to see details of the selected Credit'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewCredit(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Account'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($accounts as $item){if($st) echo ",
							";?>['<?php echo $item['Account']['id']; ?>' ,'<?php echo $item['Account']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_credits.reload({
								params: {
									start: 0,
									limit: list_size,
									account_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'credit_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCreditName(Ext.getCmp('credit_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'credit_go_button',
					handler: function(){
						SearchByCreditName(Ext.getCmp('credit_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCredit();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_credits,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-credit').enable();
		p.getTopToolbar().findById('delete-credit').enable();
		p.getTopToolbar().findById('view-credit').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-credit').disable();
			p.getTopToolbar().findById('view-credit').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-credit').disable();
			p.getTopToolbar().findById('view-credit').disable();
			p.getTopToolbar().findById('delete-credit').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-credit').enable();
			p.getTopToolbar().findById('view-credit').enable();
			p.getTopToolbar().findById('delete-credit').enable();
		}
		else{
			p.getTopToolbar().findById('edit-credit').disable();
			p.getTopToolbar().findById('view-credit').disable();
			p.getTopToolbar().findById('delete-credit').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_credits.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
