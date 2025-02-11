		<?php
			$this->ExtForm->create('Location');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LocationEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'Edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $location['Location']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $location['Location']['name'];
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['items'] = $location_types;
					$options['value'] = $location['Location']['location_type_id'];
					$this->ExtForm->input('location_type_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $location['Location']['is_rural'];
					$this->ExtForm->input('is_rural', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = $location['Location']['parent_id'];
					$this->ExtForm->input('parent_id', $options);
				?>		
			]
		});
		
		var LocationEditWindow = new Ext.Window({
			title: '<?php __('Edit Location'); ?>',
			width: 400,
			height:150,
			layout: 'fit',
			modal: true,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
			items: LocationEditForm,

			buttons: [{
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LocationEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							LocationEditWindow.hide();
							RefreshLocationData();
							p.getRootNode().reload();
						},
						failure: function(f,a){
							Ext.Msg.alert('<?php __('Warning'); ?>', a.result.errormsg);
						}
					});
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					LocationEditWindow.hide();
				}
			}]
		});
