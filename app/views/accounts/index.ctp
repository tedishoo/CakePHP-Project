
var store_accounts = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','first_name','middle_name','last_name','account_ref_no','date_account_opened','opening_balance_indicator','credit_type_code','product_type_code','frequency_code','admin_fee','credit_account_status_code','restructured_credit_account_ref_no','last_restructure_date','industry_sector_code','industry_sub_sector','export_credit_guarante','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'accounts', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'first_name', direction: "ASC"},
	groupField: 'industry_sector_code'
});


function AddAccount() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'accounts', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var account_data = response.responseText;
			
			eval(account_data);
			
			AccountAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the account add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditAccount(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'accounts', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var account_data = response.responseText;
			
			eval(account_data);
			
			AccountEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the account edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewAccount(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'accounts', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var account_data = response.responseText;

            eval(account_data);

            AccountViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the account view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentCredits(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'credits', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_credits_data = response.responseText;

            eval(parent_credits_data);

            parentCreditsViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteAccount(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'accounts', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Account successfully deleted!'); ?>');
			RefreshAccountData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the account add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchAccount(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'accounts', 'action' => 'search')); ?>',
		success: function(response, opts){
			var account_data = response.responseText;

			eval(account_data);

			accountSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the account search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByAccountName(value){
	var conditions = '\'Account.account_ref_no LIKE\' => \'%' + value + '%\'';
	store_accounts.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshAccountData() {
	store_accounts.reload();
}


if(center_panel.find('id', 'account-tab') != "") {
	var p = center_panel.findById('account-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Accounts'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'account-tab',
		xtype: 'grid',
		store: store_accounts,
		columns: [
			{header: "<?php __('First Name'); ?>", dataIndex: 'first_name', sortable: true},
			{header: "<?php __('Middle Name'); ?>", dataIndex: 'middle_name', sortable: true},
			{header: "<?php __('Last Name'); ?>", dataIndex: 'last_name', sortable: true},
			{header: "<?php __('Account Ref No'); ?>", dataIndex: 'account_ref_no', sortable: true},
			{header: "<?php __('Date Account Opened'); ?>", dataIndex: 'date_account_opened', sortable: true},
			{header: "<?php __('Opening Balance Indicator'); ?>", dataIndex: 'opening_balance_indicator', sortable: true},
			{header: "<?php __('Credit Type Code'); ?>", dataIndex: 'credit_type_code', sortable: true},
			{header: "<?php __('Product Type Code'); ?>", dataIndex: 'product_type_code', sortable: true},
			{header: "<?php __('Frequency Code'); ?>", dataIndex: 'frequency_code', sortable: true},
			{header: "<?php __('Admin Fee'); ?>", dataIndex: 'admin_fee', sortable: true},
			{header: "<?php __('Credit Account Status Code'); ?>", dataIndex: 'credit_account_status_code', sortable: true},
			{header: "<?php __('Restructured Credit Account Ref No'); ?>", dataIndex: 'restructured_credit_account_ref_no', sortable: true},
			{header: "<?php __('Last Restructure Date'); ?>", dataIndex: 'last_restructure_date', sortable: true},
			{header: "<?php __('Industry Sector Code'); ?>", dataIndex: 'industry_sector_code', sortable: true},
			{header: "<?php __('Industry Sub Sector'); ?>", dataIndex: 'industry_sub_sector', sortable: true},
			{header: "<?php __('Export Credit Guarante'); ?>", dataIndex: 'export_credit_guarante', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true,hidden: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true,hidden: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Accounts" : "Account"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewAccount(Ext.getCmp('account-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Accounts</b><br />Click here to create a new Account'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddAccount();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-account',
					tooltip:'<?php __('<b>Edit Accounts</b><br />Click here to modify the selected Account'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditAccount(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-account',
					tooltip:'<?php __('<b>Delete Accounts(s)</b><br />Click here to remove the selected Account(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Account'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.first_name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteAccount(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Account'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Accounts'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteAccount(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php __('View Account'); ?>',
					id: 'view-account',
					tooltip:'<?php __('<b>View Account</b><br />Click here to see details of the selected Account'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewAccount(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Credits'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentCredits(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Account Number]'); ?>',
					id: 'account_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByAccountName(Ext.getCmp('account_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'account_go_button',
					handler: function(){
						SearchByAccountName(Ext.getCmp('account_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchAccount();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_accounts,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-account').enable();
		p.getTopToolbar().findById('delete-account').enable();
		p.getTopToolbar().findById('view-account').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-account').disable();
			p.getTopToolbar().findById('view-account').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-account').disable();
			p.getTopToolbar().findById('view-account').disable();
			p.getTopToolbar().findById('delete-account').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-account').enable();
			p.getTopToolbar().findById('view-account').enable();
			p.getTopToolbar().findById('delete-account').enable();
		}
		else{
			p.getTopToolbar().findById('edit-account').disable();
			p.getTopToolbar().findById('view-account').disable();
			p.getTopToolbar().findById('delete-account').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_accounts.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
