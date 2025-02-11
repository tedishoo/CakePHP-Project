		<?php
			$this->ExtForm->create('CollateralDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CollateralDetailAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $collaterals;
					$this->ExtForm->input('collateral_id', $options);
				?>,
				<?php 
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Type');
					$options['items'] = array('House' => 'House', 'Car' => 'Car');
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('Owner', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('titledeed_or_platenumber', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('city', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('wereda_or_chasisnumber', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('kebele_or_motornumber', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('housenumber_or_yearofmake', $options);
				?>			]
		});
		
		var CollateralDetailAddWindow = new Ext.Window({
			title: '<?php __('Add Collateral Detail'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CollateralDetailAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CollateralDetailAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Collateral Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CollateralDetailAddWindow.collapsed)
						CollateralDetailAddWindow.expand(true);
					else
						CollateralDetailAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CollateralDetailAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CollateralDetailAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentCollateralDetailData();
<?php } else { ?>
							RefreshCollateralDetailData();
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
					CollateralDetailAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CollateralDetailAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentCollateralDetailData();
<?php } else { ?>
							RefreshCollateralDetailData();
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
					CollateralDetailAddWindow.close();
				}
			}]
		});
