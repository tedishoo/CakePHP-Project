		<?php
			$this->ExtForm->create('Insurance');
			$this->ExtForm->defineFieldFunctions();
		?>
		var InsuranceEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $insurance['Insurance']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $collateral_details;
					$options['value'] = $insurance['Insurance']['collateral_detail_id'];
					$this->ExtForm->input('collateral_detail_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $insurance['Insurance']['estimated_value'];
					$this->ExtForm->input('estimated_value', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $insurance['Insurance']['date_estimated'];
					$this->ExtForm->input('date_estimated', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $insurance['Insurance']['insurance_company'];
					$this->ExtForm->input('insurance_company', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $insurance['Insurance']['type'];
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $insurance['Insurance']['date_insured'];
					$this->ExtForm->input('date_insured', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $insurance['Insurance']['amount_insured'];
					$this->ExtForm->input('amount_insured', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $insurance['Insurance']['expire_date'];
					$this->ExtForm->input('expire_date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $insurance['Insurance']['policy_number'];
					$this->ExtForm->input('policy_number', $options);
				?>			]
		});
		
		var InsuranceEditWindow = new Ext.Window({
			title: '<?php __('Edit Insurance'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: InsuranceEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					InsuranceEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Insurance.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(InsuranceEditWindow.collapsed)
						InsuranceEditWindow.expand(true);
					else
						InsuranceEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					InsuranceEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							InsuranceEditWindow.close();
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
					InsuranceEditWindow.close();
				}
			}]
		});
