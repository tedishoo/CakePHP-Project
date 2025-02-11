		<?php
			$this->ExtForm->create('Adjustment');
			$this->ExtForm->defineFieldFunctions();
		?>
		var AdjustmentEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'adjustments', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $adjustment['Adjustment']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $adjustment['Adjustment']['mobile'];
					$this->ExtForm->input('mobile', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $adjustment['Adjustment']['date'];
					$this->ExtForm->input('date', $options);
				?>			]
		});
		
		var AdjustmentEditWindow = new Ext.Window({
			title: '<?php __('Edit Adjustment'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: AdjustmentEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					AdjustmentEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Adjustment.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(AdjustmentEditWindow.collapsed)
						AdjustmentEditWindow.expand(true);
					else
						AdjustmentEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					AdjustmentEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							AdjustmentEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentAdjustmentData();
<?php } else { ?>
							RefreshAdjustmentData();
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
					AdjustmentEditWindow.close();
				}
			}]
		});
