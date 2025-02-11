		<?php
			$this->ExtForm->create('Location');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LocationAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'Add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$options['items'] = $location_types;
					$this->ExtForm->input('location_type_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('is_rural', $options);
				?>,
				<?php 
					$options = array();
					$options['hidden'] = $parent_id;
					$this->ExtForm->input('parent_id', $options);
				?>		
			]
		});
		
		var LocationAddWindow = new Ext.Window({
			title: '<?php __('Add Location'); ?>',
			width: 400,
			height:150,
			layout: 'fit',
			modal: true,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
			items: LocationAddForm,

			buttons: [{
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LocationAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							LocationAddForm.getForm().reset();
							RefreshLocationData();
							p.getRootNode().reload();
						},
						failure: function(f,a){
							Ext.Msg.alert('<?php __('Warning'); ?>', a.result.errormsg);
						}
					});
				}
			},{
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					LocationAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							LocationAddWindow.hide();
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
					LocationAddWindow.hide();
				}
			}]
		});
