		<?php
			$this->ExtForm->create('CollateralDetail');
			$this->ExtForm->defineFieldFunctions();
		?>
		var CollateralDetailEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $collateral_detail['CollateralDetail']['id'])); ?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $collaterals;
					$options['value'] = $collateral_detail['CollateralDetail']['collateral_id'];
					$this->ExtForm->input('collateral_id', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $collateral_detail['CollateralDetail']['type'];
					$this->ExtForm->input('type', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $collateral_detail['CollateralDetail']['Owner'];
					$this->ExtForm->input('Owner', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $collateral_detail['CollateralDetail']['titledeed_or_platenumber'];
					$this->ExtForm->input('titledeed_or_platenumber', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $collateral_detail['CollateralDetail']['city'];
					$this->ExtForm->input('city', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $collateral_detail['CollateralDetail']['wereda_or_chasisnumber'];
					$this->ExtForm->input('wereda_or_chasisnumber', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $collateral_detail['CollateralDetail']['kebele_or_motornumber'];
					$this->ExtForm->input('kebele_or_motornumber', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $collateral_detail['CollateralDetail']['housenumber_or_yearofmake'];
					$this->ExtForm->input('housenumber_or_yearofmake', $options);
				?>			]
		});
		
		var CollateralDetailEditWindow = new Ext.Window({
			title: '<?php __('Edit Collateral Detail'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CollateralDetailEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CollateralDetailEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Collateral Detail.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(CollateralDetailEditWindow.collapsed)
						CollateralDetailEditWindow.expand(true);
					else
						CollateralDetailEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					CollateralDetailEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CollateralDetailEditWindow.close();
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
					CollateralDetailEditWindow.close();
				}
			}]
		});
