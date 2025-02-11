        <?php
			$this->ExtForm->create('Container');
			$this->ExtForm->defineFieldFunctions();
		?>
        
        var containerEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'Edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $container['Container']['id'])); ?>,
				<?php 
					$options = array();
                    $options['value'] = $container['Container']['name'];
					$this->ExtForm->input('name', $options);
				?>,
                <?php 
					$options = array('anchor' => '40%');
                    $options['value'] = $container['Container']['list_order'];
					$this->ExtForm->input('list_order', $options);
				?>
			]
		});
		
		var containerEditWindow = new Ext.Window({
			title: '<?php __('Edit Module'); ?>',
			width: 400,
			height: 140,
			layout: 'fit',
			modal: true,
			resizable: false,
			collapsible: true,
			plain: true,
			bodyStyle: 'padding:5px;',
			buttonAlign: 'right',
			items: containerEditForm,

			buttons: [{
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					containerEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							containerEditWindow.hide();
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
					containerEditWindow.hide();
				}
			}]
		});
