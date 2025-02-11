
		
<?php $credit_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Account', true) . ":</th><td><b>" . $credit['Account']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Batch', true) . ":</th><td><b>" . $credit['Batch']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Record Type Indicator', true) . ":</th><td><b>" . $credit['Credit']['record_type_indicator'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Branch', true) . ":</th><td><b>" . $credit['Credit']['branch'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Reporting Date', true) . ":</th><td><b>" . $credit['Credit']['reporting_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Opening Balance Credit', true) . ":</th><td><b>" . $credit['Credit']['opening_balance_credit'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Maturity Date', true) . ":</th><td><b>" . $credit['Credit']['maturity_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Payment Due Date', true) . ":</th><td><b>" . $credit['Credit']['payment_due_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Repayment', true) . ":</th><td><b>" . $credit['Credit']['repayment'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Total Installment Amount', true) . ":</th><td><b>" . $credit['Credit']['total_installment_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Installment Amount', true) . ":</th><td><b>" . $credit['Credit']['installment_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Last Date Active', true) . ":</th><td><b>" . $credit['Credit']['last_date_active'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Number Of Instalment', true) . ":</th><td><b>" . $credit['Credit']['number_of_instalment'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Original Loan Term', true) . ":</th><td><b>" . $credit['Credit']['original_loan_term'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Interest Amount', true) . ":</th><td><b>" . $credit['Credit']['interest_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Current Balance Amount', true) . ":</th><td><b>" . $credit['Credit']['current_balance_amount'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Current Balance Indicator', true) . ":</th><td><b>" . $credit['Credit']['current_balance_indicator'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Of Last Payment Received', true) . ":</th><td><b>" . $credit['Credit']['date_of_last_payment_received'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Credit Account Status Code', true) . ":</th><td><b>" . $credit['Credit']['credit_account_status_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Settled', true) . ":</th><td><b>" . $credit['Credit']['date_settled'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Last Status Change', true) . ":</th><td><b>" . $credit['Credit']['last_status_change'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Account Closure Date', true) . ":</th><td><b>" . $credit['Credit']['account_closure_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Account Arrears Date', true) . ":</th><td><b>" . $credit['Credit']['account_arrears_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Overdue Balance', true) . ":</th><td><b>" . $credit['Credit']['overdue_balance'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Number Of Days In Arrears', true) . ":</th><td><b>" . $credit['Credit']['number_of_days_in_arrears'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Account Closure Reason Code', true) . ":</th><td><b>" . $credit['Credit']['account_closure_reason_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Risk Classification Code', true) . ":</th><td><b>" . $credit['Credit']['risk_classification_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Resturcture Flag Code', true) . ":</th><td><b>" . $credit['Credit']['resturcture_flag_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Last Restructure Date', true) . ":</th><td><b>" . $credit['Credit']['last_restructure_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Consent Flag Code', true) . ":</th><td><b>" . $credit['Credit']['consent_flag_code'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Outstanding Balance Of Loan', true) . ":</th><td><b>" . $credit['Credit']['outstanding_balance_of_loan'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Approved Amount', true) . ":</th><td><b>" . $credit['Credit']['approved_amount'] . "</b></td></tr>" . 
"</table>"; 
?>
		var credit_view_panel_1 = {
			html : '<?php echo $credit_html; ?>',
			frame : true,
			height: 80
		}
		var credit_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var CreditViewWindow = new Ext.Window({
			title: '<?php __('View Credit'); ?>: <?php echo $credit['Credit']['id']; ?>',
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
				credit_view_panel_1,
				credit_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CreditViewWindow.close();
				}
			}]
		});
