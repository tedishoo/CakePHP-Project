		<?php
			$this->ExtForm->create('Person');
			$this->ExtForm->defineFieldFunctions();
		?>
		var PersonEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'Edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $person['Person']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $person['Person']['first_name'];
					$this->ExtForm->input('first_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $person['Person']['middle_name'];
					$this->ExtForm->input('middle_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $person['Person']['last_name'];
					$this->ExtForm->input('last_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $person['Person']['birthdate'];
					$this->ExtForm->input('birthdate', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $birth_locations;
					$options['value'] = $person['Person']['birth_location_id'];
					$this->ExtForm->input('birth_location_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $residence_locations;
					$options['value'] = $person['Person']['residence_location_id'];
					$this->ExtForm->input('residence_location_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $nationalities;
					$options['value'] = $person['Person']['nationality_id'];
					$this->ExtForm->input('nationality_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $person['Person']['kebele_or_farmers_association'];
					$this->ExtForm->input('kebele_or_farmers_association', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $person['Person']['house_number'];
					$this->ExtForm->input('house_number', $options);
				?>			
            ]
		});
		
		var PersonEditWindow = new Ext.Window({
			title: '<?php __('Edit Person'); ?>',
			width: 400,
			height:200,
			layout: 'fit',
			modal: true,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
			items: PersonEditForm,

			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					PersonEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							PersonEditWindow.close();
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
					PersonEditWindow.close();
				}
			}]
		});
