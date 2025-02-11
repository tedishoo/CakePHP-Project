
var store_batches = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','month','year','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'batches', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'month', direction: "ASC"},
	groupField: 'year'
});


function AddBatch() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'batches', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var batch_data = response.responseText;
			
			eval(batch_data);
			
			BatchAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the batch add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBatch(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'batches', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var batch_data = response.responseText;
			
			eval(batch_data);
			
			BatchEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the batch edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBatch(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'batches', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var batch_data = response.responseText;

            eval(batch_data);

            BatchViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the batch view form. Error code'); ?>: ' + response.status);
        }
    });
}
function GenerateReport(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'batches', 'action' => 'report')); ?>/'+id,
        success: function(response, opts) {
            var batch_data = response.responseText;

            eval(batch_data);

            BatchViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the report form. Error code'); ?>: ' + response.status);
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


function DeleteBatch(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'batches', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Batch successfully deleted!'); ?>');
			RefreshBatchData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the batch add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBatch(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'batches', 'action' => 'search')); ?>',
		success: function(response, opts){
			var batch_data = response.responseText;

			eval(batch_data);

			batchSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the batch search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBatchName(value){
	var conditions = '\'Batch.name LIKE\' => \'%' + value + '%\'';
	store_batches.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBatchData() {
	store_batches.reload();
}


if(center_panel.find('id', 'batch-tab') != "") {
	var p = center_panel.findById('batch-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Batches'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'batch-tab',
		xtype: 'grid',
		store: store_batches,
		columns: [
			{header: "<?php __('Month'); ?>", dataIndex: 'month', sortable: true},
			{header: "<?php __('Year'); ?>", dataIndex: 'year', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Batches" : "Batch"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBatch(Ext.getCmp('batch-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Batches</b><br />Click here to create a new Batch'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBatch();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-batch',
					tooltip:'<?php __('<b>Edit Batches</b><br />Click here to modify the selected Batch'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBatch(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-batch',
					tooltip:'<?php __('<b>Delete Batches(s)</b><br />Click here to remove the selected Batch(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Batch'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.month+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBatch(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Batch'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Batches'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBatch(sel_ids);
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
					text: '<?php __('View Batch'); ?>',
					id: 'view-batch',
					tooltip:'<?php __('<b>View Batch</b><br />Click here to see details of the selected Batch'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBatch(sel.data.id);
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
				},' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Generate Report'); ?>',
					id: 'generate-report',
					tooltip:'<?php __('<b>Generate Report</b><br />Click here to Generate Report for the selected Batch'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							GenerateReport(sel.data.id);
						};
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'batch_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBatchName(Ext.getCmp('batch_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'batch_go_button',
					handler: function(){
						SearchByBatchName(Ext.getCmp('batch_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBatch();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_batches,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-batch').enable();
		p.getTopToolbar().findById('delete-batch').enable();
		p.getTopToolbar().findById('view-batch').enable();
		p.getTopToolbar().findById('generate-report').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-batch').disable();
			p.getTopToolbar().findById('view-batch').disable();
			p.getTopToolbar().findById('generate-report').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-batch').disable();
			p.getTopToolbar().findById('view-batch').disable();
			p.getTopToolbar().findById('generate-report').disable();
			p.getTopToolbar().findById('delete-batch').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-batch').enable();
			p.getTopToolbar().findById('view-batch').enable();
			p.getTopToolbar().findById('generate-report').enable();
			p.getTopToolbar().findById('delete-batch').enable();
		}
		else{
			p.getTopToolbar().findById('edit-batch').disable();
			p.getTopToolbar().findById('view-batch').disable();
			p.getTopToolbar().findById('generate-report').disable();
			p.getTopToolbar().findById('delete-batch').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_batches.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
