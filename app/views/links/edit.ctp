        <?php
			$this->ExtForm->create('Link');
			$this->ExtForm->defineFieldFunctions();
		?>
        
        var linkEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'Edit')); ?>',
			defaultType: 'textfield',
			
			items: [
                <?php $this->ExtForm->input('id', array('hidden' => $link['Link']['id'])); ?>,
                <?php 
					$options = array();
                    $options['value'] = $link['Link']['name'];
					$this->ExtForm->input('name', $options);
				?>,
                <?php 
					$options = array('anchor' => '70%');
                    if(isset($parent_id))
                        $options['hidden'] = $parent_id;
                    else 
                        $options['items'] = $containers;
					$options['value'] = $link['Link']['container_id'];
					$this->ExtForm->input('container_id', $options);
				?>,
                <?php 
					$options = array('anchor' => '60%');
                    $options['value'] = $link['Link']['controller'];
					$this->ExtForm->input('controller', $options);
				?>,
                <?php 
					$options = array('anchor' => '60%');
                    $options['value'] = $link['Link']['action'];
					$this->ExtForm->input('action', $options);
				?>,
                <?php 
					$options = array();
                    $options['value'] = $link['Link']['parameter'];
					$this->ExtForm->input('parameter', $options);
				?>,
				<?php 
					$options = array('anchor' => '60%');
					$options['value'] = $link['Link']['function_name'];
					$this->ExtForm->input('function_name', $options);
				?>,
                <?php 
					$options = array('anchor' => '40%');
                    $options['value'] = $link['Link']['list_order'];
					$this->ExtForm->input('list_order', $options);
				?>
			]
		});
		
		var linkEditWindow = new Ext.Window({
			title: '<?php __('Edit Module Activity'); ?>',
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
			items: linkEditForm,

			buttons: [{
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					linkEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
							linkEditWindow.hide();
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
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					linkEditWindow.hide();
				}
			}]
		});
