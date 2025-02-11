var store_parent_credits = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','account','batch','record_type_indicator','branch','reporting_date','opening_balance_credit','maturity_date','payment_due_date','repayment','total_installment_amount','installment_amount','last_date_active','number_of_instalment','original_loan_term','interest_amount','current_balance_amount','current_balance_indicator','date_of_last_payment_received','credit_account_status_code','date_settled','last_status_change','account_closure_date','account_arrears_date','overdue_balance','number_of_days_in_arrears','account_closure_reason_code','risk_classification_code','resturcture_flag_code','last_restructure_date','consent_flag_code','outstanding_balance_of_loan','approved_amount'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCredit() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_credit_data = response.responseText;
			
			eval(parent_credit_data);
			
			CreditAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the credit add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCredit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_credit_data = response.responseText;
			
			eval(parent_credit_data);
			
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


function DeleteParentCredit(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Credit(s) successfully deleted!'); ?>');
			RefreshParentCreditData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the credit to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCreditName(value){
	var conditions = '\'Credit.name LIKE\' => \'%' + value + '%\'';
	store_parent_credits.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCreditData() {
	store_parent_credits.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Credits'); ?>',
	store: store_parent_credits,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'creditGrid',
	columns: [
		{header:"<?php __('account'); ?>", dataIndex: 'account', sortable: true},
		{header:"<?php __('batch'); ?>", dataIndex: 'batch', sortable: true},
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
		{header: "<?php __('Approved Amount'); ?>", dataIndex: 'approved_amount', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewCredit(Ext.getCmp('creditGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add Credit</b><br />Click here to create a new Credit'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCredit();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-credit',
				tooltip:'<?php __('<b>Edit Credit</b><br />Click here to modify the selected Credit'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCredit(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-credit',
				tooltip:'<?php __('<b>Delete Credit(s)</b><br />Click here to remove the selected Credit(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Credit'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCredit(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove Credit'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Credit'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCredit(sel_ids);
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
				text: '<?php __('View Credit'); ?>',
				id: 'view-credit2',
				tooltip:'<?php __('<b>View Credit</b><br />Click here to see details of the selected Credit'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCredit(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_credit_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCreditName(Ext.getCmp('parent_credit_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_credit_go_button',
				handler: function(){
					SearchByParentCreditName(Ext.getCmp('parent_credit_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_credits,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-credit').enable();
	g.getTopToolbar().findById('delete-parent-credit').enable();
        g.getTopToolbar().findById('view-credit2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-credit').disable();
                g.getTopToolbar().findById('view-credit2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-credit').disable();
		g.getTopToolbar().findById('delete-parent-credit').enable();
                g.getTopToolbar().findById('view-credit2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-credit').enable();
		g.getTopToolbar().findById('delete-parent-credit').enable();
                g.getTopToolbar().findById('view-credit2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-credit').disable();
		g.getTopToolbar().findById('delete-parent-credit').disable();
                g.getTopToolbar().findById('view-credit2').disable();
	}
});



var parentCreditsViewWindow = new Ext.Window({
	title: 'Credit Under the selected Item',
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
			parentCreditsViewWindow.close();
		}
	}]
});

store_parent_credits.load({
    params: {
        start: 0,    
        limit: list_size
    }
});