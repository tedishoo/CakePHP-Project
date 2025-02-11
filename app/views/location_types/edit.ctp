		<?php
			$this->ExtForm->create('LocationType');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LocationTypeEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'locationTypes', 'action' => 'Edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $location_type['LocationType']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $location_type['LocationType']['name'];
					$this->ExtForm->input('name', $options);
				?>			]
		});
		
		var LocationTypeEditWindow = new Ext.Window({
			title: '<?php __('Edit Location Type'); ?>',
			width: 400,
			height:200,
			layout: 'fit',
			modal: true,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LocationTypeEditForm,

			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LocationTypeEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LocationTypeEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentLocationTypeData();
<?php } else { ?>
							RefreshLocationTypeData();
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
					LocationTypeEditWindow.close();
				}
			}]
		});
