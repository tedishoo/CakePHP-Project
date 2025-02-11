		<?php
			$this->ExtForm->create('Setting');
			$this->ExtForm->defineFieldFunctions();
		?>
		var SettingAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'settings', 'action' => 'Add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array('anchor'=>'60%');
					$this->ExtForm->input('setting_key', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('setting_value', $options);
				?>,
				<?php 
					$options = array('anchor'=>'50%');
					$this->ExtForm->input('date_from', $options);
				?>,
				<?php 
					$options = array('anchor'=>'50%');
					$this->ExtForm->input('date_to', $options);
				?>,
				<?php 
					$options = array('xtype' => 'textarea');
					$this->ExtForm->input('remark', $options);
				?>			
            ]
		});
		
		var SettingAddWindow = new Ext.Window({
			title: '<?php __('Add Setting'); ?>',
			width: 500,
			height: 250,
			layout: 'fit',
			modal: true,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SettingAddForm,

			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					SettingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SettingAddForm.getForm().reset();
							RefreshSettingData();
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
					SettingAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SettingAddWindow.close();
							RefreshSettingData();
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
					SettingAddWindow.close();
				}
			}]
		});
