		<?php
			$this->ExtForm->create('Credit');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CreditAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $accounts;
					$this->ExtForm->input('account_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $batches;
					$this->ExtForm->input('batch_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('record_type_indicator', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('branch', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('reporting_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('opening_balance_credit', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('maturity_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('payment_due_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('repayment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('total_installment_amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('installment_amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('last_date_active', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('number_of_instalment', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('original_loan_term', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('interest_amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('current_balance_amount', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('current_balance_indicator', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date_of_last_payment_received', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('credit_account_status_code', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date_settled', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('last_status_change', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('account_closure_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('account_arrears_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('overdue_balance', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('number_of_days_in_arrears', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('account_closure_reason_code', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('risk_classification_code', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('resturcture_flag_code', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('last_restructure_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('consent_flag_code', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('outstanding_balance_of_loan', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('approved_amount', $options);
				?>			]
		});
		
		var CreditAddWindow = new Ext.Window({
			title: '<?php __('Add Credit'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CreditAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CreditAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Credit.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CreditAddWindow.collapsed)
						CreditAddWindow.expand(true);
					else
						CreditAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CreditAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CreditAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					CreditAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CreditAddWindow.close();
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
					CreditAddWindow.close();
				}
			}]
		});
