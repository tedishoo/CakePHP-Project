        <?php
			$this->ExtForm->create('Container');
			$this->ExtForm->defineFieldFunctions();
		?>
        
        var containerAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'Add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
                <?php
					$options = array('anchor' => '40%');
					$this->ExtForm->input('list_order', $options);
				?>
			]
		});
		
		var containerAddWindow = new Ext.Window({
			title: '<?php __('Add Module'); ?>',
			width: 400,
			height: 140,
			layout: 'fit',
			modal: true,
			resizable: false,
			collapsible: true,
			plain: true,
			bodyStyle: 'padding:5px;',
			buttonAlign: 'right',
			items: containerAddForm,

			buttons: [{
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					containerAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							containerAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>							
                            RefreshParentContainerData();
<?php } else { ?>							
                            RefreshContainerData();
<?php } ?>						
                        },
						failure: function(f,a){
							Ext.Msg.alert('<?php __('Warning'); ?>', a.result.errormsg);
						}
					});
				}
			},{
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					containerAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							containerAddWindow.close();
<?php if(isset($parent_id)){ ?>					
                            RefreshParentContainerData();
<?php } else { ?>			
                            RefreshContainerData();
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
					containerAddWindow.close();
				}
			}]
		});
