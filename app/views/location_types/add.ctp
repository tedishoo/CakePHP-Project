		<?php
			$this->ExtForm->create('LocationType');
			$this->ExtForm->defineFieldFunctions();
		?>
		var LocationTypeAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'locationTypes', 'action' => 'Add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>			]
		});
		
		var LocationTypeAddWindow = new Ext.Window({
			title: '<?php __('Add Location Type'); ?>',
			width: 400,
			height:200,
			layout: 'fit',
			modal: true,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: LocationTypeAddForm,

			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					LocationTypeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LocationTypeAddForm.getForm().reset();
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
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					LocationTypeAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							LocationTypeAddWindow.close();
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
					LocationTypeAddWindow.close();
				}
			}]
		});
