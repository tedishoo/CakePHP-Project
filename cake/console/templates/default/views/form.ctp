<?php
		$isAdd = (strpos($action, 'add') !== false);
		$add = ($isAdd)? 'Add': 'Edit';
		$add_action = ($isAdd)? 'add': 'edit';
		
		echo "\t\t<?php\n";
			echo "\t\t\t\$this->ExtForm->create('{$modelClass}');\n";
			echo "\t\t\t\$this->ExtForm->defineFieldFunctions();\n";
		echo "\t\t?>\n";
?>
		var <?php echo $modelClass; ?><?php echo $add;  ?>Form = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo "<?php echo \$this->Html->url(array('controller' => '{$pluralVar}', 'action' => '{$add_action}')); ?>"; ?>',
			defaultType: 'textfield',

			items: [
<?php
				$started = false;
				foreach ($fields as $field) {
					if (strpos($action, 'add') !== false && $field == $primaryKey) {
						continue;
					} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
						if($started) echo ",\n";
						if($field == $primaryKey) {
							echo "\t\t\t\t<?php \$this->ExtForm->input('{$field}', array('hidden' => \$".Inflector::underscore($singularVar)."['{$modelClass}']['{$field}'])); ?>";
						} else {
							echo "\t\t\t\t<?php \n";
								echo "\t\t\t\t\t\$options = array();\n";
								if(strpos($field, '_id') !== false) {
									echo "\t\t\t\t\tif(isset(\$parent_id))\n";
										echo "\t\t\t\t\t\t\$options['hidden'] = \$parent_id;\n";
									echo "\t\t\t\t\telse\n";
										echo "\t\t\t\t\t\t\$options['items'] = \$" . Inflector::pluralize(Inflector::underscore(substr($field, 0, -3))) . ";\n";
								}
								if(!$isAdd){
									echo "\t\t\t\t\t\$options['value'] = \$". Inflector::underscore($singularVar) ."['{$modelClass}']['{$field}'];\n";
								}
								echo "\t\t\t\t\t\$this->ExtForm->input('{$field}', \$options);\n";
							echo "\t\t\t\t?>";
						}
					}
					$started = true;
				}
?>
			]
		});
		
		var <?php echo $modelClass; ?><?php echo $add;  ?>Window = new Ext.Window({
			title: '<?php echo "<?php __('" .$add;  ?> <?php echo $singularHumanName . "'); ?>"; ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: <?php echo $modelClass; ?><?php echo $add;  ?>Form,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					<?php echo $modelClass; ?><?php echo $add;  ?>Form.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to <?php echo $add=='Add'? 'insert a new': 'modify an existing';  ?> <?php echo $singularHumanName; ?>.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(<?php echo $modelClass; ?><?php echo $add;  ?>Window.collapsed)
						<?php echo $modelClass; ?><?php echo $add;  ?>Window.expand(true);
					else
						<?php echo $modelClass; ?><?php echo $add;  ?>Window.collapse(true);
				}
			}],
			buttons: [ <?php if($isAdd) { ?> {
				text: '<?php echo "<?php __('Save'); ?>"; ?>',
				handler: function(btn){
					<?php echo $modelClass; ?><?php echo $add;  ?>Form.getForm().submit({
						waitMsg: '<?php echo "<?php __('Submitting your data...'); ?>"; ?>',
						waitTitle: '<?php echo "<?php __('Wait Please...'); ?>"; ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php echo "<?php __('Success'); ?>"; ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							<?php echo $modelClass; ?><?php echo $add;  ?>Form.getForm().reset();
<?php echo "<?php if(isset(\$parent_id)){ ?>\n"; ?>
							RefreshParent<?php echo $modelClass; ?>Data();
<?php echo "<?php } else { ?>\n"; ?>
							Refresh<?php echo $modelClass; ?>Data();
<?php echo "<?php } ?>\n"; ?>
						},
						failure: function(f,a){
							Ext.Msg.show({
								title: '<?php echo "<?php __('Warning'); ?>"; ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.errormsg,
                                icon: Ext.MessageBox.ERROR
							});
						}
					});
				}
			}, <?php } ?>{
				text: '<?php echo "<?php __('Save" . (($isAdd)? ' & Close': '') . "'); ?>"; ?>',
				handler: function(btn){
					<?php echo $modelClass; ?><?php echo $add;  ?>Form.getForm().submit({
						waitMsg: '<?php echo "<?php __('Submitting your data...'); ?>"; ?>',
						waitTitle: '<?php echo "<?php __('Wait Please...'); ?>"; ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php echo "<?php __('Success'); ?>"; ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							<?php echo $modelClass; ?><?php echo $add;  ?>Window.close();
<?php echo "<?php if(isset(\$parent_id)){ ?>\n"; ?>
							RefreshParent<?php echo $modelClass; ?>Data();
<?php echo "<?php } else { ?>\n"; ?>
							Refresh<?php echo $modelClass; ?>Data();
<?php echo "<?php } ?>\n"; ?>
						},
						failure: function(f,a){
							Ext.Msg.show({
								title: '<?php echo "<?php __('Warning'); ?>"; ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.errormsg,
                                icon: Ext.MessageBox.ERROR
							});
						}
					});
				}
			},{
				text: '<?php echo "<?php __('Cancel'); ?>"; ?>',
				handler: function(btn){
					<?php echo $modelClass; ?><?php echo $add;  ?>Window.close();
				}
			}]
		});
