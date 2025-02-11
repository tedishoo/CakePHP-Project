//<script>

    var ExpiredInsuranceForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'collaterals', 'action' => 'display')); ?>',
			defaultType: 'textfield',

			items: [{
				xtype: 'compositefield',
                msgTarget : 'side',
                anchor    : '-20',
				fieldLabel: '<span style="color:red;">*</span> Until Date',
                defaults: {
                    flex: 1
                },
				items: [
                    {
					xtype : 'datefield',
					format : 'Y-m-d',
					hiddenName:'data[Collateral][date]',
					id: 'date',
					name: 'data[Collateral][date]',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Until Date',
					anchor: '100%',
					allowBlank: false,
					editable: false,
					selectOnFocus:true,
					valueField: 'id',
					fieldLabel: '<span style="color:red;">*</span> Until Date',
					blankText: 'Your input is invalid.'
					}
				]
				},{
					xtype: 'combo',
					store: new Ext.data.ArrayStore({
						sortInfo: { field: "name", direction: "ASC" },
						storeId: 'my_array_store',
						id: 0,
						fields: ['id','name'],
						
						data: [						
						['HTML','HTML'],['PDF','PDF'],['EXCEL','EXCEL'],						
						]
						
					}),					
					displayField: 'name',
					typeAhead: true,
					hiddenName:'data[Collateral][type]',
					id: 'type',
					name: 'type',
					mode: 'local',					
					triggerAction: 'all',
					emptyText: 'Select Type',
					selectOnFocus:true,
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> OutPut Type',
					allowBlank: false,
					editable: false,
					lazyRender: true,
					blankText: 'Your input is invalid.'
				}, {
					xtype: 'textfield',
					id: 'title',
					name: 'data[Collateral][title]',
					hiddenName:'data[Collateral][title]',
					emptyText: 'give a title',
					valueField: 'id',
					anchor: '100%',
					fieldLabel: '<span style="color:red;">*</span> Title',
					allowBlank: false,
					blankText: 'Your input is invalid.'
					}]
		});
    
    
    var ExpiredInsuranceWindow = new Ext.Window({
	title: 'Expired Insurance',
	width: 400,
	minWidth: 400,
	autoHeight: true,
	resizable: false,
	items: ExpiredInsuranceForm,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
    modal: true,
	tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ExpiredInsuranceForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to view Expired Insurance report.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ExpiredInsuranceWindow.collapsed)
						ExpiredInsuranceWindow.expand(true);
					else
						ExpiredInsuranceWindow.collapse(true);
				}
			}],
	buttons: [{
		text: 'Display',
		handler: function(btn){
			var form = ExpiredInsuranceForm.getForm(); // or inputForm.getForm();
			var el = form.getEl().dom;
			var target = document.createAttribute("target");
			target.nodeValue = "_blank";
			el.setAttributeNode(target);
			el.action = form.url;
			el.submit();
		//ExpiredInsuranceForm.getForm().submit({  target:'_blank'});
		}
            },{
		text: 'Close',
		handler: function(btn){
                    ExpiredInsuranceWindow.close();
		}
            }]
    });
	ExpiredInsuranceWindow.show();