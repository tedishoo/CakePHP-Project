		<?php
			$this->ExtForm->create('Permission');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PermissionAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'Add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array('xtype' => 'textarea', 'height' => '50');
					$this->ExtForm->input('description', $options);
				?>,
				<?php 
					$options = array('anchor' => '70%', 
						'xtype' => 'combo', 
						'allowBlank' => 'true', 
						'fieldLabel' => 'Prerequisite');
					$options['items'] = $prerequisites;
					$this->ExtForm->input('prerequisite', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = $parent_id;
					$this->ExtForm->input('parent_id', $options);
				?>
			]
		});
		
		var PermissionAddWindow = new Ext.Window({
			title: '<?php __('Add Permission'); ?>',
			width: 400,
			height: 185,
			layout: 'fit',
			modal: true,
			resizable: false,
			collapsible: true,
			plain: true,
			bodyStyle: 'padding:5px;',
			buttonAlign: 'right',
			items: PermissionAddForm,

			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PermissionAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							PermissionAddForm.getForm().reset();
							RefreshPermissionData();
						},
						failure: function(f,a){
							Ext.Msg.alert('<?php __('Warning'); ?>', a.result.errormsg);
						}
					});
				}
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					PermissionAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							PermissionAddWindow.close();
							RefreshPermissionData();
						},
						failure: function(f,a){
							Ext.Msg.alert('<?php __('Warning'); ?>', a.result.errormsg);
						}
					});
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					PermissionAddWindow.close();
				}
			}]
		});
