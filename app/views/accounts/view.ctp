
var store_account_credits = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','account','batch','record_type_indicator','branch','reporting_date','opening_balance_credit','maturity_date','payment_due_date','repayment','total_installment_amount','installment_amount','last_date_active','number_of_instalment','original_loan_term','interest_amount','current_balance_amount','current_balance_indicator','date_of_last_payment_received','credit_account_status_code','date_settled','last_status_change','account_closure_date','account_arrears_date','overdue_balance','number_of_days_in_arrears','account_closure_reason_code','risk_classification_code','resturcture_flag_code','last_restructure_date','consent_flag_code','outstanding_balance_of_loan','approved_amount'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'list_data', $account['Account']['id'])); ?>'	})
});
		
<?php $account_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('First Name', true) . ":</th><td><b>" . $account['Account']['first_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Middle Name', true) . ":</th><td><b>" . $account['Account']['middle_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Last Name', true) . ":</th><td><b>" . $account['Account']['last_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Account Ref No', true) . ":</th><td><b>" . $account['Account']['account_ref_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Account Opened', true) . ":</th><td><b>" . $account['Account']['date_account_opened'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Opening Balance Indicator', true) . ":</th><td><b>" . $account['Account']['opening_balance_indicator'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Credit Type Code', true) . ":</th><td><b>" . $account['Account']['credit_type_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Product Type Code', true) . ":</th><td><b>" . $account['Account']['product_type_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Admin Fee', true) . ":</th><td><b>" . $account['Account']['admin_fee'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Restructured Credit Account Ref No', true) . ":</th><td><b>" . $account['Account']['restructured_credit_account_ref_no'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Industry Sector Code', true) . ":</th><td><b>" . $account['Account']['industry_sector_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Industry Sub Sector', true) . ":</th><td><b>" . $account['Account']['industry_sub_sector'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Export Credit Guarante', true) . ":</th><td><b>" . $account['Account']['export_credit_guarante'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $account['Account']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $account['Account']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var account_view_panel_1 = {
			html : '<?php echo $account_html; ?>',
			frame : true,
			height: 80
		}
		var account_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
			{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_account_credits,
				title: '<?php __('Credits'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_account_credits.getCount() == '')
							store_account_credits.reload();
					}
				},
				columns: [
					{header: "<?php __('Batch'); ?>", dataIndex: 'batch', sortable: true}
,					{header: "<?php __('Record Type Indicator'); ?>", dataIndex: 'record_type_indicator', sortable: true}
,					{header: "<?php __('Branch'); ?>", dataIndex: 'branch', sortable: true}
,					{header: "<?php __('Reporting Date'); ?>", dataIndex: 'reporting_date', sortable: true}
,					{header: "<?php __('Opening Balance Credit'); ?>", dataIndex: 'opening_balance_credit', sortable: true}
,					{header: "<?php __('Maturity Date'); ?>", dataIndex: 'maturity_date', sortable: true}
,					{header: "<?php __('Payment Due Date'); ?>", dataIndex: 'payment_due_date', sortable: true}
,					{header: "<?php __('Repayment'); ?>", dataIndex: 'repayment', sortable: true}
,					{header: "<?php __('Total Installment Amount'); ?>", dataIndex: 'total_installment_amount', sortable: true}
,					{header: "<?php __('Installment Amount'); ?>", dataIndex: 'installment_amount', sortable: true}
,					{header: "<?php __('Last Date Active'); ?>", dataIndex: 'last_date_active', sortable: true}
,					{header: "<?php __('Number Of Instalment'); ?>", dataIndex: 'number_of_instalment', sortable: true}
,					{header: "<?php __('Original Loan Term'); ?>", dataIndex: 'original_loan_term', sortable: true}
,					{header: "<?php __('Interest Amount'); ?>", dataIndex: 'interest_amount', sortable: true}
,					{header: "<?php __('Current Balance Amount'); ?>", dataIndex: 'current_balance_amount', sortable: true}
,					{header: "<?php __('Current Balance Indicator'); ?>", dataIndex: 'current_balance_indicator', sortable: true}
,					{header: "<?php __('Date Of Last Payment Received'); ?>", dataIndex: 'date_of_last_payment_received', sortable: true}
,					{header: "<?php __('Credit Account Status Code'); ?>", dataIndex: 'credit_account_status_code', sortable: true}
,					{header: "<?php __('Date Settled'); ?>", dataIndex: 'date_settled', sortable: true}
,					{header: "<?php __('Last Status Change'); ?>", dataIndex: 'last_status_change', sortable: true}
,					{header: "<?php __('Account Closure Date'); ?>", dataIndex: 'account_closure_date', sortable: true}
,					{header: "<?php __('Account Arrears Date'); ?>", dataIndex: 'account_arrears_date', sortable: true}
,					{header: "<?php __('Overdue Balance'); ?>", dataIndex: 'overdue_balance', sortable: true}
,					{header: "<?php __('Number Of Days In Arrears'); ?>", dataIndex: 'number_of_days_in_arrears', sortable: true}
,					{header: "<?php __('Account Closure Reason Code'); ?>", dataIndex: 'account_closure_reason_code', sortable: true}
,					{header: "<?php __('Risk Classification Code'); ?>", dataIndex: 'risk_classification_code', sortable: true}
,					{header: "<?php __('Resturcture Flag Code'); ?>", dataIndex: 'resturcture_flag_code', sortable: true}
,					{header: "<?php __('Last Restructure Date'); ?>", dataIndex: 'last_restructure_date', sortable: true}
,					{header: "<?php __('Consent Flag Code'); ?>", dataIndex: 'consent_flag_code', sortable: true}
,					{header: "<?php __('Outstanding Balance Of Loan'); ?>", dataIndex: 'outstanding_balance_of_loan', sortable: true}
,					{header: "<?php __('Approved Amount'); ?>", dataIndex: 'approved_amount', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_account_credits,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var AccountViewWindow = new Ext.Window({
			title: '<?php __('View Account'); ?>: <?php echo $account['Account']['id']; ?>',
			width: 500,
			height:345,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				account_view_panel_1,
				account_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					AccountViewWindow.close();
				}
			}]
		});
