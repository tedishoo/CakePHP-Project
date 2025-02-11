		<?php
			$this->ExtForm->create('Collateral');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CollateralAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				
				{
						xtype: 'combo',
						store: new Ext.data.ArrayStore({
							sortInfo: { field: "name", direction: "ASC" },
							storeId: 'my_array_store',
							id: 0,
							fields: ['id','name'],
							
							data: [
							<?php foreach($accounts as $account){?>
							['<?php echo $account['Account']['id'];?>','<?php echo str_replace("'",'',$account['Account']['first_name']).' '.str_replace("'",'',$account['Account']['middle_name']).' '.str_replace("'",'',$account['Account']['last_name']);?>'],
							<?php
							}
							?>
							]
							
						}),					
						displayField: 'name',
						typeAhead: true,
						hiddenName:'data[Collateral][account_id]',
						id: 'collateral',
						name: 'collateral',
						mode: 'local',					
						triggerAction: 'all',
						emptyText: 'Select One',
						selectOnFocus:true,
						valueField: 'id',
						anchor: '100%',
						fieldLabel: '<span style="color:red;">*</span> Account',
						allowBlank: false,
						editable: true,
						lazyRender: true,
						blankText: 'Your input is invalid.'
					}	]
		});
		
		var CollateralAddWindow = new Ext.Window({
			title: '<?php __('Add Collateral'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CollateralAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CollateralAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Collateral.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CollateralAddWindow.collapsed)
						CollateralAddWindow.expand(true);
					else
						CollateralAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CollateralAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CollateralAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentCollateralData();
<?php } else { ?>
							RefreshCollateralData();
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
					CollateralAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CollateralAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCollateralData();
<?php } else { ?>
							RefreshCollateralData();
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
					CollateralAddWindow.close();
				}
			}]
		});
