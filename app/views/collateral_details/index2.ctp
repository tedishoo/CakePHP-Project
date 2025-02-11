//<script>
var store_parent_collateralDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','collateral','type','Owner','titledeed_or_platenumber','city','wereda_or_chasisnumber','kebele_or_motornumber','housenumber_or_yearofmake','created','modified'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentCollateralDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_collateralDetail_data = response.responseText;
			
			eval(parent_collateralDetail_data);
			
			CollateralDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateralDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentCollateralDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_collateralDetail_data = response.responseText;
			
			eval(parent_collateralDetail_data);
			
			CollateralDetailEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateralDetail edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCollateralDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var collateralDetail_data = response.responseText;

			eval(collateralDetail_data);

			CollateralDetailViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateralDetail view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewCollateralDetailInsurances(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_insurances_data = response.responseText;

			eval(parent_insurances_data);

			parentInsurancesViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentCollateralDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CollateralDetail(s) successfully deleted!'); ?>');
			RefreshParentCollateralDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateralDetail to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentCollateralDetailName(value){
	var conditions = '\'CollateralDetail.name LIKE\' => \'%' + value + '%\'';
	store_parent_collateralDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentCollateralDetailData() {
	store_parent_collateralDetails.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('CollateralDetails'); ?>',
	store: store_parent_collateralDetails,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'collateralDetailGrid',
	columns: [
		{header:"<?php __('collateral'); ?>", dataIndex: 'collateral', sortable: true, hidden: true},
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
		{header: "<?php __('Owner'); ?>", dataIndex: 'Owner', sortable: true},
		{header: "<?php __('Titledeed Or Platenumber'); ?>", dataIndex: 'titledeed_or_platenumber', sortable: true},
		{header: "<?php __('City'); ?>", dataIndex: 'city', sortable: true},
		{header: "<?php __('Wereda Or Chasisnumber'); ?>", dataIndex: 'wereda_or_chasisnumber', sortable: true},
		{header: "<?php __('Kebele Or Motornumber'); ?>", dataIndex: 'kebele_or_motornumber', sortable: true},
		{header: "<?php __('Housenumber Or Yearofmake'); ?>", dataIndex: 'housenumber_or_yearofmake', sortable: true},
		{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
		{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewCollateralDetail(Ext.getCmp('collateralDetailGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add CollateralDetail</b><br />Click here to create a new CollateralDetail'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentCollateralDetail();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-collateralDetail',
				tooltip:'<?php __('<b>Edit CollateralDetail</b><br />Click here to modify the selected CollateralDetail'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentCollateralDetail(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-collateralDetail',
				tooltip:'<?php __('<b>Delete CollateralDetail(s)</b><br />Click here to remove the selected CollateralDetail(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove CollateralDetail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentCollateralDetail(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove CollateralDetail'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected CollateralDetail'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentCollateralDetail(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View CollateralDetail'); ?>',
				id: 'view-collateralDetail2',
				tooltip:'<?php __('<b>View CollateralDetail</b><br />Click here to see details of the selected CollateralDetail'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewCollateralDetail(sel.data.id);
					};
				},
				menu : {
					items: [
 {
						text: '<?php __('View Insurances'); ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewCollateralDetailInsurances(sel.data.id);
							};
						}
					}
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_collateralDetail_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentCollateralDetailName(Ext.getCmp('parent_collateralDetail_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_collateralDetail_go_button',
				handler: function(){
					SearchByParentCollateralDetailName(Ext.getCmp('parent_collateralDetail_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_collateralDetails,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-collateralDetail').enable();
	g.getTopToolbar().findById('delete-parent-collateralDetail').enable();
        g.getTopToolbar().findById('view-collateralDetail2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-collateralDetail').disable();
                g.getTopToolbar().findById('view-collateralDetail2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-collateralDetail').disable();
		g.getTopToolbar().findById('delete-parent-collateralDetail').enable();
                g.getTopToolbar().findById('view-collateralDetail2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-collateralDetail').enable();
		g.getTopToolbar().findById('delete-parent-collateralDetail').enable();
                g.getTopToolbar().findById('view-collateralDetail2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-collateralDetail').disable();
		g.getTopToolbar().findById('delete-parent-collateralDetail').disable();
                g.getTopToolbar().findById('view-collateralDetail2').disable();
	}
});



var parentCollateralDetailsViewWindow = new Ext.Window({
	title: 'CollateralDetail Under the selected Item',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		g
	],

	buttons: [{
		text: 'Close',
		handler: function(btn){
			parentCollateralDetailsViewWindow.close();
		}
	}]
});

store_parent_collateralDetails.load({
    params: {
        start: 0,    
        limit: list_size
    }
});