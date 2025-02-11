
var store_dates = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','date','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'dates', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'date', direction: "ASC"},
	groupField: 'created'
});


function AddDate() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dates', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var date_data = response.responseText;
			
			eval(date_data);
			
			DateAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the date add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditDate(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dates', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var date_data = response.responseText;
			
			eval(date_data);
			
			DateEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the date edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewDate(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'dates', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var date_data = response.responseText;

            eval(date_data);

            DateViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the date view form. Error code'); ?>: ' + response.status);
        }
    });
}
function ViewParentOutstandingBalances(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'index2')); ?>/'+id,
        success: function(response, opts) {
            var parent_outstandingBalances_data = response.responseText;

            eval(parent_outstandingBalances_data);

            parentOutstandingBalancesViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
        }
    });
}


function DeleteDate(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dates', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Date successfully deleted!'); ?>');
			RefreshDateData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the date add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchDate(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'dates', 'action' => 'search')); ?>',
		success: function(response, opts){
			var date_data = response.responseText;

			eval(date_data);

			dateSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the date search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByDateName(value){
	var conditions = '\'Date.name LIKE\' => \'%' + value + '%\'';
	store_dates.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshDateData() {
	store_dates.reload();
}


if(center_panel.find('id', 'date-tab') != "") {
	var p = center_panel.findById('date-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Dates'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'date-tab',
		xtype: 'grid',
		store: store_dates,
		columns: [
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Dates" : "Date"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewDate(Ext.getCmp('date-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Dates</b><br />Click here to create a new Date'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddDate();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-date',
					tooltip:'<?php __('<b>Edit Dates</b><br />Click here to modify the selected Date'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditDate(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-date',
					tooltip:'<?php __('<b>Delete Dates(s)</b><br />Click here to remove the selected Date(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Date'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteDate(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Date'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Dates'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteDate(sel_ids);
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
					text: '<?php __('View Date'); ?>',
					id: 'view-date',
					tooltip:'<?php __('<b>View Date</b><br />Click here to see details of the selected Date'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewDate(sel.data.id);
						};
					},
					menu : {
						items: [
{
							text: '<?php __('View Outstanding Balances'); ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentOutstandingBalances(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'date_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByDateName(Ext.getCmp('date_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'date_go_button',
					handler: function(){
						SearchByDateName(Ext.getCmp('date_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchDate();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_dates,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-date').enable();
		p.getTopToolbar().findById('delete-date').enable();
		p.getTopToolbar().findById('view-date').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-date').disable();
			p.getTopToolbar().findById('view-date').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-date').disable();
			p.getTopToolbar().findById('view-date').disable();
			p.getTopToolbar().findById('delete-date').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-date').enable();
			p.getTopToolbar().findById('view-date').enable();
			p.getTopToolbar().findById('delete-date').enable();
		}
		else{
			p.getTopToolbar().findById('edit-date').disable();
			p.getTopToolbar().findById('view-date').disable();
			p.getTopToolbar().findById('delete-date').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_dates.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
