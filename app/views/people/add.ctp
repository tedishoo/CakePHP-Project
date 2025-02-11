		<?php
			$this->ExtForm->create('Person');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PersonAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'Add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('first_name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('middle_name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('last_name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('birthdate', $options);
				?>,
				<?php 
					$options = array();
					$options['items'] = $birth_locations;
					$this->ExtForm->input('birth_location_id', $options);
				?>,
				<?php 
					$options = array();
					$options['items'] = $residence_locations;
					$this->ExtForm->input('residence_location_id', $options);
				?>,
				<?php 
					$options = array();
					$options['items'] = $nationalities;
					$this->ExtForm->input('nationality_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('kebele_or_farmers_association', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('house_number', $options);
				?>			
			]
		});
		
		var PersonAddWindow = new Ext.Window({
			title: '<?php __('Add Person'); ?>',
			width: 400,
			height:200,
			layout: 'fit',
			modal: true,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
			items: PersonAddForm,

			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PersonAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							PersonAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentPersonData();
<?php } else { ?>
							RefreshPersonData();
<?php } ?>
						},
						failure: function(f,a){
							Ext.Msg.alert('<?php __('Warning'); ?>', a.result.errormsg);
						}
					});
				}
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					PersonAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							PersonAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentPersonData();
<?php } else { ?>
							RefreshPersonData();
<?php } ?>
						},
						failure: function(f,a){
							Ext.Msg.alert('<?php __('Warning'); ?>', a.result.errormsg);
						}
					});
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					PersonAddWindow.close();
				}
			}]
		});
