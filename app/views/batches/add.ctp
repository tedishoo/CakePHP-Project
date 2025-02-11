		<?php
			$this->ExtForm->create('Batch');
			$this->ExtForm->defineFieldFunctions();
		?>
		
		var years = [];
		y = 2015
		while (y<=2025){
			 years.push([y]);
			 y++;
		}

		var yearStore = new Ext.data.SimpleStore
		({
			  fields : ['years'],
			  data : years
		});

		var BatchAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'batches', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [				
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "id", direction: "ASC" },
						storeId: 'month',
						id: 0,
						fields: ['id','name'],						
						data: [						
							[01,'January'],[02,'February'],[03,'March'],[04,'April'],[05,'May'],[06,'June'],[07,'July'],[08,'August'],
								[09,'September'],[10,'October'],[11,'November'],[12,'December'],
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[Batch][month]',
					id: 'month',
					name: 'month',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Month',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				{
					xtype: 'combo',
					store: yearStore,					
					displayField: 'years',
					typeAhead: true,
					hiddenName:'data[Batch][year]',
					id: 'year',
					name: 'year',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'years',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Year',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				}		]
		});
		
		var BatchAddWindow = new Ext.Window({
			title: '<?php __('Add Batch'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BatchAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BatchAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Batch.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BatchAddWindow.collapsed)
						BatchAddWindow.expand(true);
					else
						BatchAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					BatchAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BatchAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentBatchData();
<?php } else { ?>
							RefreshBatchData();
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
					BatchAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BatchAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBatchData();
<?php } else { ?>
							RefreshBatchData();
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
					BatchAddWindow.close();
				}
			}]
		});
