
var store_adjustments = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','mobile','date','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'adjustments', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'mobile', direction: "ASC"},
	groupField: 'date'
});


function AddAdjustment() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'adjustments', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var adjustment_data = response.responseText;
			
			eval(adjustment_data);
			
			AdjustmentAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the adjustment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditAdjustment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'adjustments', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var adjustment_data = response.responseText;
			
			eval(adjustment_data);
			
			AdjustmentEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the adjustment edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewAdjustment(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'adjustments', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var adjustment_data = response.responseText;

            eval(adjustment_data);

            AdjustmentViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the adjustment view form. Error code'); ?>: ' + response.status);
        }
    });
}

function DeleteAdjustment(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'adjustments', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Adjustment successfully deleted!'); ?>');
			RefreshAdjustmentData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the adjustment add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchAdjustment(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'adjustments', 'action' => 'search')); ?>',
		success: function(response, opts){
			var adjustment_data = response.responseText;

			eval(adjustment_data);

			adjustmentSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the adjustment search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByAdjustmentName(value){
	var conditions = '\'Adjustment.name LIKE\' => \'%' + value + '%\'';
	store_adjustments.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshAdjustmentData() {
	store_adjustments.reload();
}


if(center_panel.find('id', 'adjustment-tab') != "") {
	var p = center_panel.findById('adjustment-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Adjustments'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'adjustment-tab',
		xtype: 'grid',
		store: store_adjustments,
		columns: [
			{header: "<?php __('Mobile'); ?>", dataIndex: 'mobile', sortable: true},
			{header: "<?php __('Date'); ?>", dataIndex: 'date', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Adjustments" : "Adjustment"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewAdjustment(Ext.getCmp('adjustment-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Adjustments</b><br />Click here to create a new Adjustment'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddAdjustment();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-adjustment',
					tooltip:'<?php __('<b>Edit Adjustments</b><br />Click here to modify the selected Adjustment'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditAdjustment(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-adjustment',
					tooltip:'<?php __('<b>Delete Adjustments(s)</b><br />Click here to remove the selected Adjustment(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Adjustment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteAdjustment(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Adjustment'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Adjustments'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteAdjustment(sel_ids);
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
					text: '<?php __('View Adjustment'); ?>',
					id: 'view-adjustment',
					tooltip:'<?php __('<b>View Adjustment</b><br />Click here to see details of the selected Adjustment'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewAdjustment(sel.data.id);
						};
					},
					menu : {
						items: [
						]
					}
				}, ' ', '-',  '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'adjustment_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByAdjustmentName(Ext.getCmp('adjustment_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'adjustment_go_button',
					handler: function(){
						SearchByAdjustmentName(Ext.getCmp('adjustment_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchAdjustment();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_adjustments,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-adjustment').enable();
		p.getTopToolbar().findById('delete-adjustment').enable();
		p.getTopToolbar().findById('view-adjustment').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-adjustment').disable();
			p.getTopToolbar().findById('view-adjustment').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-adjustment').disable();
			p.getTopToolbar().findById('view-adjustment').disable();
			p.getTopToolbar().findById('delete-adjustment').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-adjustment').enable();
			p.getTopToolbar().findById('view-adjustment').enable();
			p.getTopToolbar().findById('delete-adjustment').enable();
		}
		else{
			p.getTopToolbar().findById('edit-adjustment').disable();
			p.getTopToolbar().findById('view-adjustment').disable();
			p.getTopToolbar().findById('delete-adjustment').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_adjustments.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
