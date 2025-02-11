		<?php
			$this->ExtForm->create('Setting');
			$this->ExtForm->defineFieldFunctions();
		?>
		var SettingEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'settings', 'action' => 'Edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $setting['Setting']['id'])); ?>,
				<?php 
					$options = array('anchor'=>'60%');
					$options['value'] = $setting['Setting']['setting_key'];
					$this->ExtForm->input('setting_key', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $setting['Setting']['setting_value'];
					$this->ExtForm->input('setting_value', $options);
				?>,
				<?php 
					$options = array('anchor'=>'50%');
					$options['value'] = $setting['Setting']['date_from'];
					$this->ExtForm->input('date_from', $options);
				?>,
				<?php 
					$options = array('anchor'=>'50%');
					$options['value'] = $setting['Setting']['date_to'];
					$this->ExtForm->input('date_to', $options);
				?>,
				<?php 
					$options = array('xtype'=>'textarea');
					$options['value'] = $setting['Setting']['remark'];
					$this->ExtForm->input('remark', $options);
				?>			
            ]
		});
		
		var SettingEditWindow = new Ext.Window({
			title: '<?php __('Edit Setting'); ?>',
			width: 500,
			height: 250,
			layout: 'fit',
			modal: true,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: SettingEditForm,

			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					SettingEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							SettingEditWindow.close();
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
					SettingEditWindow.close();
				}
			}]
		});
        <?php pr($setting); ?>