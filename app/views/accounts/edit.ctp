		<?php
			$this->ExtForm->create('Account');
			$this->ExtForm->defineFieldFunctions();
		?>
		var Agriculture =[						
					[1,'Agriculture','Temporary Crops'],[2,'Agriculture','Permanent Crops or Plantation'],[3,'Agriculture','Animal Husbandry'],[4,'Agriculture','Other Activity']
			];
		var Industries = [
					[5,'Industries','Large Scale'],[6,'Industries','Medium Scale'],[7,'Industries','Small Scale'],[8,'Industries','Mining and Quarrying'],
			];
		var DomesticTradeandService = [
					[9,'Domestic Trade and Service','Domestic Trade'],[10,'Domestic Trade and Service','Transport Service'],[11,'Domestic Trade and Service','Hotel and Tourism'],[12,'Domestic Trade and Service','Rental Services'],[13,'Domestic Trade and Service','Others']
			];
		var InternationalTrade = [
					[14,'International Trade','Export'],[15,'International Trade','Import']
			];
		var HousingandConstruction = [
				[16,'Housing and Construction','Residential Building'],[17,'Housing and Construction','Commercial Building'],[18,'Housing and Construction','Other Constructions']
			];
		var FinancialInstitutions = [
				[19,'Financial Institutions','Banks / Insurance'],[20,'Financial Institutions','Micro Finance']
			];
		var ConsumerLoan = [
				[21,'Consumer Loan','Personal Loan'],[22,'Consumer Loan','Condominium Loan'],[23,'Consumer Loan','Staff Mortgage Loan'],[24,'Consumer Loan','Other Mortgage Loan']
			];
		
		var AccountEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 150,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'accounts', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $account['Account']['id'])); ?>,
				<?php 
					$options = array();
					$options['value'] = $account['Account']['first_name'];
					$this->ExtForm->input('first_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $account['Account']['middle_name'];
					$this->ExtForm->input('middle_name', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $account['Account']['last_name'];
					$this->ExtForm->input('last_name', $options);
				?>,
				<?php 
					$options = array('disabled' => true);
					$options['value'] = $account['Account']['account_ref_no'];
					$this->ExtForm->input('account_ref_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $account['Account']['date_account_opened'];
					$this->ExtForm->input('date_account_opened', $options);
				?>,				
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'opening_balance_indicator',
						id: 0,
						fields: ['id','name'],
						
						data: [						
							[1,'Credit Limit'],	[2,'Opening Balance'],						
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[Account][opening_balance_indicator]',
					id: 'openingBalance',
					name: 'openingBalance',
					value: '<?php echo $account['Account']['opening_balance_indicator'] ?>',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Opening Balance Indicator',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},				
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'credit_type_code',
						id: 0,
						fields: ['id','name'],
						
						data: [						
							[1,'Line of Credit'],	[2,'Revolving Credit'],	 [3,'Installment Credit'],	[4,'Overdraft'],				
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[Account][credit_type_code]',
					id: 'creditTypeCode',
					name: 'creditTypeCode',
					value: '<?php echo $account['Account']['credit_type_code'] ?>',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Credit Type',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'product_type_code',
						id: 0,
						fields: ['id','name'],
						
						data: [						
							[3,'Student Loan'],	[4,'Overdraft'],	 [7,'Installment Credit'],	[8,'Revolving Installment Credit'],				
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[Account][product_type_code]',
					id: 'productTypeCode',
					name: 'productTypeCode',
					value: '<?php echo $account['Account']['product_type_code'] ?>',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Product Type',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'frequency_code',
						id: 0,
						fields: ['id','name'],
						
						data: [						
							[7,'Bullet (One lump sum upon maturity)'],	[9,'Revolving'],	 [10,'Overdraft'],				
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[Account][frequency_code]',
					id: 'frequencyCode',
					name: 'frequencyCode',
					value: '<?php echo $account['Account']['frequency_code'] ?>',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: 'Frequency Code',
					allowBlank: true,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				<?php 
					$options = array('anchor' => '100%', 'vtype' => 'Currency');
					$options['maskRe'] = '/[0-9.]/i';
					$options['value'] = $account['Account']['admin_fee'];
					$this->ExtForm->input('admin_fee', $options);
				?>,
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'credit_account_status_code',
						id: 0,
						fields: ['id','name'],
						
						data: [						
							[1,'Outstanding and in Arrears'],	[2,'Restructured Credit Facility'],	 [3,'Foreclosure'],	 
							[4,'Write-Off'],	[5,'Settled in Full - Normal'],	 [6,'Current and within Terms'],	
							[7,'Early Settlement'],	 [8,'Settled in Full - Foreclosure'],	 [9,'Account Closed in Error. Account Re-Opened'],				
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[Account][credit_account_status_code]',
					id: 'creditAccountStatusCode',
					name: 'creditAccountStatusCode',
					value: '<?php echo $account['Account']['credit_account_status_code'] ?>',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Credit Account Status Code',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				<?php 
					$options = array();
					$options['value'] = $account['Account']['restructured_credit_account_ref_no'];
					$this->ExtForm->input('restructured_credit_account_ref_no', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $account['Account']['last_restructure_date'];
					$this->ExtForm->input('last_restructure_date', $options);
				?>,	
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "namei", direction: "ASC" },
						storeId: 'industry_sector_code',
						id: 0,
						fields: ['id','namei'],
						
						data: [						
							[1,'Agriculture'],	[2,'Industries'],	 [3,'Domestic Trade and Service'],	[4,'International Trade'],	
							[5,'Housing and Construction'],	[6,'Financial Institutions'],	 [7,'Consumer Loan'],
						]
						
					}),					
					displayField: 'namei',
					typeAhead: true,
					hiddenName:'data[Account][industry_sector_code]',
					id: 'industrySectorCode',
					name: 'industrySectorCode',
					value: '<?php echo $account['Account']['industry_sector_code'] ?>',
					mode: 'local',					
					triggerAction: 'all',
					listeners:{select:{fn:function(combo,record) {
                        var comboSub = Ext.getCmp('industrySubSector');        
                        comboSub.clearValue();
						if(record.get(combo.displayField) == "Agriculture"){
							comboSub.getStore().loadData(Agriculture);
						}
						else if(record.get(combo.displayField) == "Industries"){
							comboSub.getStore().loadData(Industries);
						}
						else if(record.get(combo.displayField) == "Domestic Trade and Service"){
							comboSub.getStore().loadData(DomesticTradeandService);
						}
						else if(record.get(combo.displayField) == "International Trade"){
							comboSub.getStore().loadData(InternationalTrade);
						}
						else if(record.get(combo.displayField) == "International Trade"){
							comboSub.getStore().loadData(InternationalTrade);
						}
						else if(record.get(combo.displayField) == "Housing and Construction"){
							comboSub.getStore().loadData(HousingandConstruction);
						}
						else if(record.get(combo.displayField) == "Financial Institutions"){
							comboSub.getStore().loadData(FinancialInstitutions);
						}
						else if(record.get(combo.displayField) == "Consumer Loan"){
							comboSub.getStore().loadData(ConsumerLoan);
						}
                        }}
                    },
					emptyText: 'Select One',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Industry Sector',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'industry_sub_sector',
						id: 0,
						fields: ['id','namei','name'],						
						data: [[1,'Agriculture','Temporary Crops'],[2,'Agriculture','Permanent Crops or Plantation'],[3,'Agriculture','Animal Husbandry'],[4,'Agriculture','Other Activity'],
								[5,'Industries','Large Scale'],[6,'Industries','Medium Scale'],[7,'Industries','Small Scale'],[8,'Industries','Mining and Quarrying'],
								[9,'Domestic Trade and Service','Domestic Trade'],[10,'Domestic Trade and Service','Transport Service'],[11,'Domestic Trade and Service','Hotel and Tourism'],[12,'Domestic Trade and Service','Rental Services'],[13,'Domestic Trade and Service','Others'],
								[14,'International Trade','Export'],[15,'International Trade','Import'],
								[16,'Housing and Construction','Residential Building'],[17,'Housing and Construction','Commercial Building'],[18,'Housing and Construction','Other Constructions'],
								[19,'Financial Institutions','Banks / Insurance'],[20,'Financial Institutions','Micro Finance'],
								[21,'Consumer Loan','Personal Loan'],[22,'Consumer Loan','Condominium Loan'],[23,'Consumer Loan','Staff Mortgage Loan'],[24,'Consumer Loan','Other Mortgage Loan']]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[Account][industry_sub_sector]',
					id: 'industrySubSector',
					name: 'industrySubSector',
					value: '<?php echo $account['Account']['industry_sub_sector'] ?>',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					autoLoad: false,
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Industry Sub Sector',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				},
				{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'industry_sub_sector',
						id: 0,
						fields: ['id','name'],						
						data: [[1,'Yes'],[2,'No'],]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[Account][export_credit_guarante]',
					id: 'exportCreditGuarante',
					name: 'exportCreditGuarante',
					value: '<?php echo $account['Account']['export_credit_guarante'] ?>',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select One',
					autoLoad: false,
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Export Credit Guarante',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				}				]
		});
		
		var AccountEditWindow = new Ext.Window({
			title: '<?php __('Edit Account'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: AccountEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					AccountEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Account.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(AccountEditWindow.collapsed)
						AccountEditWindow.expand(true);
					else
						AccountEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					AccountEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							AccountEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentAccountData();
<?php } else { ?>
							RefreshAccountData();
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
					AccountEditWindow.close();
				}
			}]
		});
