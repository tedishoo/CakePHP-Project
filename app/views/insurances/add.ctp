		<?php
			$this->ExtForm->create('Insurance');
			$this->ExtForm->defineFieldFunctions();
		?>
		var InsuranceAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $collateral_details;
					$this->ExtForm->input('collateral_detail_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('estimated_value', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date_estimated', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('insurance_company', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('date_insured', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('amount_insured', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('expire_date', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('policy_number', $options);
				?>			]
		});
		
		var InsuranceAddWindow = new Ext.Window({
			title: '<?php __('Add Insurance'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: InsuranceAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					InsuranceAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Insurance.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(InsuranceAddWindow.collapsed)
						InsuranceAddWindow.expand(true);
					else
						InsuranceAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					InsuranceAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							InsuranceAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentInsuranceData();
<?php } else { ?>
							RefreshInsuranceData();
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
					InsuranceAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							InsuranceAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentInsuranceData();
<?php } else { ?>
							RefreshInsuranceData();
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
					InsuranceAddWindow.close();
				}
			}]
		});
