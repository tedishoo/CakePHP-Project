
var store_outstandingBalances = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'account','date','balance','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'date_id', direction: "ASC"},
	groupField: 'balance'
});


function AddOutstandingBalance() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var outstandingBalance_data = response.responseText;
			
			eval(outstandingBalance_data);
			
			OutstandingBalanceAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the outstandingBalance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditOutstandingBalance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var outstandingBalance_data = response.responseText;
			
			eval(outstandingBalance_data);
			
			OutstandingBalanceEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the outstandingBalance edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewOutstandingBalance(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var outstandingBalance_data = response.responseText;

            eval(outstandingBalance_data);

            OutstandingBalanceViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the outstandingBalance view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteOutstandingBalance(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('OutstandingBalance successfully deleted!'); ?>');
			RefreshOutstandingBalanceData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the outstandingBalance add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchOutstandingBalance(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'search')); ?>',
		success: function(response, opts){
			var outstandingBalance_data = response.responseText;

			eval(outstandingBalance_data);

			outstandingBalanceSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the outstandingBalance search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByOutstandingBalanceName(value){
	var conditions = '\'OutstandingBalance.name LIKE\' => \'%' + value + '%\'';
	store_outstandingBalances.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshOutstandingBalanceData() {
	store_outstandingBalances.reload();
}


if(center_panel.find('id', 'outstandingBalance-tab') != "") {
	var p = center_panel.findById('outstandingBalance-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Outstanding Balances'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'outstandingBalance-tab',
		xtype: 'grid',
		store: store_outstandingBalances,
		columns: [
			{header: "<?php __('Account'); ?>", dataIndex: 'account', sortable: true},
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
			{header: "<?php __('Balance'); ?>", dataIndex: 'balance', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "OutstandingBalances" : "OutstandingBalance"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewOutstandingBalance(Ext.getCmp('outstandingBalance-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add OutstandingBalances</b><br />Click here to create a new OutstandingBalance'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddOutstandingBalance();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-outstandingBalance',
					tooltip:'<?php __('<b>Edit OutstandingBalances</b><br />Click here to modify the selected OutstandingBalance'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditOutstandingBalance(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-outstandingBalance',
					tooltip:'<?php __('<b>Delete OutstandingBalances(s)</b><br />Click here to remove the selected OutstandingBalance(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove OutstandingBalance'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteOutstandingBalance(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove OutstandingBalance'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected OutstandingBalances'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteOutstandingBalance(sel_ids);
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
					text: '<?php __('View OutstandingBalance'); ?>',
					id: 'view-outstandingBalance',
					tooltip:'<?php __('<b>View OutstandingBalance</b><br />Click here to see details of the selected OutstandingBalance'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewOutstandingBalance(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '<?php __('Account'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($accounts as $item){if($st) echo ",
							";?>['<?php echo $item['Account']['id']; ?>' ,'<?php echo $item['Account']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_outstandingBalances.reload({
								params: {
									start: 0,
									limit: list_size,
									account_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'outstandingBalance_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByOutstandingBalanceName(Ext.getCmp('outstandingBalance_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'outstandingBalance_go_button',
					handler: function(){
						SearchByOutstandingBalanceName(Ext.getCmp('outstandingBalance_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchOutstandingBalance();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_outstandingBalances,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-outstandingBalance').enable();
		p.getTopToolbar().findById('delete-outstandingBalance').enable();
		p.getTopToolbar().findById('view-outstandingBalance').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-outstandingBalance').disable();
			p.getTopToolbar().findById('view-outstandingBalance').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-outstandingBalance').disable();
			p.getTopToolbar().findById('view-outstandingBalance').disable();
			p.getTopToolbar().findById('delete-outstandingBalance').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-outstandingBalance').enable();
			p.getTopToolbar().findById('view-outstandingBalance').enable();
			p.getTopToolbar().findById('delete-outstandingBalance').enable();
		}
		else{
			p.getTopToolbar().findById('edit-outstandingBalance').disable();
			p.getTopToolbar().findById('view-outstandingBalance').disable();
			p.getTopToolbar().findById('delete-outstandingBalance').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_outstandingBalances.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
