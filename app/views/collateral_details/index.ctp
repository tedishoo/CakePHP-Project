
var store_collateralDetails = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','collateral','type','Owner','titledeed_or_platenumber','city','wereda_or_chasisnumber','kebele_or_motornumber','housenumber_or_yearofmake','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'collateral_id', direction: "ASC"},
	groupField: 'type'
});


function AddCollateralDetail() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var collateralDetail_data = response.responseText;
			
			eval(collateralDetail_data);
			
			CollateralDetailAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateralDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditCollateralDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var collateralDetail_data = response.responseText;
			
			eval(collateralDetail_data);
			
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
function ViewParentInsurances(id) {
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


function DeleteCollateralDetail(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('CollateralDetail successfully deleted!'); ?>');
			RefreshCollateralDetailData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the collateralDetail add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchCollateralDetail(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'search')); ?>',
		success: function(response, opts){
			var collateralDetail_data = response.responseText;

			eval(collateralDetail_data);

			collateralDetailSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the collateralDetail search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByCollateralDetailName(value){
	var conditions = '\'CollateralDetail.name LIKE\' => \'%' + value + '%\'';
	store_collateralDetails.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshCollateralDetailData() {
	store_collateralDetails.reload();
}


if(center_panel.find('id', 'collateralDetail-tab') != "") {
	var p = center_panel.findById('collateralDetail-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Collateral Details'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'collateralDetail-tab',
		xtype: 'grid',
		store: store_collateralDetails,
		columns: [
			{header: "<?php __('Collateral'); ?>", dataIndex: 'collateral', sortable: true},
			{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
			{header: "<?php __('Owner'); ?>", dataIndex: 'Owner', sortable: true},
			{header: "<?php __('Titledeed Or Platenumber'); ?>", dataIndex: 'titledeed_or_platenumber', sortable: true},
			{header: "<?php __('City'); ?>", dataIndex: 'city', sortable: true},
			{header: "<?php __('Wereda Or Chasisnumber'); ?>", dataIndex: 'wereda_or_chasisnumber', sortable: true},
			{header: "<?php __('Kebele Or Motornumber'); ?>", dataIndex: 'kebele_or_motornumber', sortable: true},
			{header: "<?php __('Housenumber Or Yearofmake'); ?>", dataIndex: 'housenumber_or_yearofmake', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "CollateralDetails" : "CollateralDetail"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewCollateralDetail(Ext.getCmp('collateralDetail-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add CollateralDetails</b><br />Click here to create a new CollateralDetail'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddCollateralDetail();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-collateralDetail',
					tooltip:'<?php __('<b>Edit CollateralDetails</b><br />Click here to modify the selected CollateralDetail'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditCollateralDetail(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-collateralDetail',
					tooltip:'<?php __('<b>Delete CollateralDetails(s)</b><br />Click here to remove the selected CollateralDetail(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove CollateralDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteCollateralDetail(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove CollateralDetail'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected CollateralDetails'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteCollateralDetail(sel_ids);
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
					text: '<?php __('View CollateralDetail'); ?>',
					id: 'view-collateralDetail',
					tooltip:'<?php __('<b>View CollateralDetail</b><br />Click here to see details of the selected CollateralDetail'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
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
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParentInsurances(sel.data.id);
								};
							}
						}
						]
					}
				}, ' ', '-',  '<?php __('Collateral'); ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php $st = false;foreach ($collaterals as $item){if($st) echo ",
							";?>['<?php echo $item['Collateral']['id']; ?>' ,'<?php echo $item['Collateral']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_collateralDetails.reload({
								params: {
									start: 0,
									limit: list_size,
									collateral_id : combo.getValue()
								}
							});
						}
					}
				},
 '->', {
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'collateralDetail_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByCollateralDetailName(Ext.getCmp('collateralDetail_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'collateralDetail_go_button',
					handler: function(){
						SearchByCollateralDetailName(Ext.getCmp('collateralDetail_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchCollateralDetail();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_collateralDetails,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-collateralDetail').enable();
		p.getTopToolbar().findById('delete-collateralDetail').enable();
		p.getTopToolbar().findById('view-collateralDetail').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-collateralDetail').disable();
			p.getTopToolbar().findById('view-collateralDetail').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-collateralDetail').disable();
			p.getTopToolbar().findById('view-collateralDetail').disable();
			p.getTopToolbar().findById('delete-collateralDetail').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-collateralDetail').enable();
			p.getTopToolbar().findById('view-collateralDetail').enable();
			p.getTopToolbar().findById('delete-collateralDetail').enable();
		}
		else{
			p.getTopToolbar().findById('edit-collateralDetail').disable();
			p.getTopToolbar().findById('view-collateralDetail').disable();
			p.getTopToolbar().findById('delete-collateralDetail').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_collateralDetails.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
