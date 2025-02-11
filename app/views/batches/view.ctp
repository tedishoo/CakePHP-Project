
var store_batch_credits = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','account','batch','record_type_indicator','branch','reporting_date','opening_balance_credit','maturity_date','payment_due_date','repayment','total_installment_amount','installment_amount','last_date_active','number_of_instalment','original_loan_term','interest_amount','current_balance_amount','current_balance_indicator','date_of_last_payment_received','credit_account_status_code','date_settled','last_status_change','account_closure_date','account_arrears_date','overdue_balance','number_of_days_in_arrears','account_closure_reason_code','risk_classification_code','resturcture_flag_code','last_restructure_date','consent_flag_code','outstanding_balance_of_loan','approved_amount'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'list_data', $batch['Batch']['id'])); ?>'	})
});
		
<?php $batch_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Month', true) . ":</th><td><b>" . $batch['Batch']['month'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Year', true) . ":</th><td><b>" . $batch['Batch']['year'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $batch['Batch']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $batch['Batch']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var batch_view_panel_1 = {
			html : '<?php echo $batch_html; ?>',
			frame : true,
			height: 80
		}
		var batch_view_panel_2 = new Ext.TabPanel({
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
				store: store_batch_credits,
				title: '<?php __('Credits'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_batch_credits.getCount() == '')
							store_batch_credits.reload();
					}
				},
				columns: [
					{header: "<?php __('Account'); ?>", dataIndex: 'account', sortable: true}
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
					store: store_batch_credits,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var BatchViewWindow = new Ext.Window({
			title: '<?php __('View Batch'); ?>: <?php echo $batch['Batch']['id']; ?>',
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
				batch_view_panel_1,
				batch_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					BatchViewWindow.close();
				}
			}]
		});
