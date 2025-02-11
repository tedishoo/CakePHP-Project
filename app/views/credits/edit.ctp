		<?php
			$this->ExtForm->create('Credit');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CreditEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $credit['Credit']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $accounts;
					$options['value'] = $credit['Credit']['account_id'];
					$this->ExtForm->input('account_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $batches;
					$options['value'] = $credit['Credit']['batch_id'];
					$this->ExtForm->input('batch_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['record_type_indicator'];
					$this->ExtForm->input('record_type_indicator', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['branch'];
					$this->ExtForm->input('branch', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['reporting_date'];
					$this->ExtForm->input('reporting_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['opening_balance_credit'];
					$this->ExtForm->input('opening_balance_credit', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['maturity_date'];
					$this->ExtForm->input('maturity_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['payment_due_date'];
					$this->ExtForm->input('payment_due_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['repayment'];
					$this->ExtForm->input('repayment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['total_installment_amount'];
					$this->ExtForm->input('total_installment_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['installment_amount'];
					$this->ExtForm->input('installment_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['last_date_active'];
					$this->ExtForm->input('last_date_active', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['number_of_instalment'];
					$this->ExtForm->input('number_of_instalment', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['original_loan_term'];
					$this->ExtForm->input('original_loan_term', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['interest_amount'];
					$this->ExtForm->input('interest_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['current_balance_amount'];
					$this->ExtForm->input('current_balance_amount', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['current_balance_indicator'];
					$this->ExtForm->input('current_balance_indicator', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['date_of_last_payment_received'];
					$this->ExtForm->input('date_of_last_payment_received', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['credit_account_status_code'];
					$this->ExtForm->input('credit_account_status_code', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['date_settled'];
					$this->ExtForm->input('date_settled', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['last_status_change'];
					$this->ExtForm->input('last_status_change', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['account_closure_date'];
					$this->ExtForm->input('account_closure_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['account_arrears_date'];
					$this->ExtForm->input('account_arrears_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['overdue_balance'];
					$this->ExtForm->input('overdue_balance', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['number_of_days_in_arrears'];
					$this->ExtForm->input('number_of_days_in_arrears', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['account_closure_reason_code'];
					$this->ExtForm->input('account_closure_reason_code', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['risk_classification_code'];
					$this->ExtForm->input('risk_classification_code', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['resturcture_flag_code'];
					$this->ExtForm->input('resturcture_flag_code', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['last_restructure_date'];
					$this->ExtForm->input('last_restructure_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['consent_flag_code'];
					$this->ExtForm->input('consent_flag_code', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['outstanding_balance_of_loan'];
					$this->ExtForm->input('outstanding_balance_of_loan', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $credit['Credit']['approved_amount'];
					$this->ExtForm->input('approved_amount', $options);
				?>			]
		});
		
		var CreditEditWindow = new Ext.Window({
			title: '<?php __('Edit Credit'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CreditEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CreditEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Credit.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CreditEditWindow.collapsed)
						CreditEditWindow.expand(true);
					else
						CreditEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CreditEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CreditEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCreditData();
<?php } else { ?>
							RefreshCreditData();
<?php } ?>
						},
						failure: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Warning'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.errormsg,
                                icon: Ext.MessageBox.ERROR
							});
						}
					});
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					CreditEditWindow.close();
				}
			}]
		});
