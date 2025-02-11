		<?php
			$this->ExtForm->create('OutstandingBalance');
			$this->ExtForm->defineFieldFunctions();
		?>
		var OutstandingBalanceEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $accounts;
					$options['value'] = $outstanding_balance['OutstandingBalance']['account_id'];
					$this->ExtForm->input('account_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $dates;
					$options['value'] = $outstanding_balance['OutstandingBalance']['date_id'];
					$this->ExtForm->input('date_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $outstanding_balance['OutstandingBalance']['balance'];
					$this->ExtForm->input('balance', $options);
				?>			]
		});
		
		var OutstandingBalanceEditWindow = new Ext.Window({
			title: '<?php __('Edit Outstanding Balance'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: OutstandingBalanceEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					OutstandingBalanceEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Outstanding Balance.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(OutstandingBalanceEditWindow.collapsed)
						OutstandingBalanceEditWindow.expand(true);
					else
						OutstandingBalanceEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					OutstandingBalanceEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							OutstandingBalanceEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentOutstandingBalanceData();
<?php } else { ?>
							RefreshOutstandingBalanceData();
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
					OutstandingBalanceEditWindow.close();
				}
			}]
		});
