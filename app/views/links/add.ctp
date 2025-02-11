        <?php
			$this->ExtForm->create('Link');
			$this->ExtForm->defineFieldFunctions();
		?>
        
        var linkAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'Add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
                <?php 
					$options = array('anchor' => '80%');
                    if(isset($parent_id))
                        $options['hidden'] = $parent_id;
                    else 
                        $options['items'] = $containers;
					$this->ExtForm->input('container_id', $options);
				?>,
                <?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('controller', $options);
				?>,
                <?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('action', $options);
				?>,
                <?php 
					$options = array();
					$this->ExtForm->input('parameter', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$this->ExtForm->input('function_name', $options);
				?>,
                <?php
					$options = array('anchor' => '40%');
					$this->ExtForm->input('list_order', $options);
				?>
			]
		});
		
		var linkAddWindow = new Ext.Window({
			title: '<?php __('Add Module Activity'); ?>',
			width: 450,
			height: 240,
			minWidth: 450,
			minHeight: 240,
			layout: 'fit',
			modal: true,
			resizable: true,
			collapsible: true,
			plain: true,
			bodyStyle: 'padding:5px;',
			buttonAlign: 'right',
			items: linkAddForm,

			buttons: [{
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					linkAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							linkAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>							
                            RefreshParentLinkData();
<?php } else { ?>	
                            RefreshLinkData();
<?php } ?>				},
						failure: function(f,a){
							Ext.Msg.alert('<?php __('Warning'); ?>', a.result.errormsg);
						}
					});
				}
			},{
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					linkAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							linkAddWindow.close();
<?php if(isset($parent_id)){ ?>				
                            RefreshParentLinkData();
<?php } else { ?>			
                            RefreshLinkData();
<?php } ?>				
                        },
						failure: function(f,a){
							Ext.Msg.alert('<?php __('Warning'); ?>', a.result.errormsg);
						}
					});
				}
			}, {
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					linkAddWindow.hide();
				}
			}]
		});
