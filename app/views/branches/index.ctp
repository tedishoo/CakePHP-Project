
var store_branches = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','nbe_code','flex_code','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'list_data')); ?>'
	})
,	sortInfo:{field: 'name', direction: "ASC"}
});


function AddBranch() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var branch_data = response.responseText;
			
			eval(branch_data);
			
			BranchAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branch add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditBranch(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var branch_data = response.responseText;
			
			eval(branch_data);
			
			BranchEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branch edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewBranch(id) {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'view')); ?>/'+id,
        success: function(response, opts) {
            var branch_data = response.responseText;

            eval(branch_data);

            BranchViewWindow.show();
        },
        failure: function(response, opts) {
            Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branch view form. Error code'); ?>: ' + response.status);
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


function DeleteBranch(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Branch successfully deleted!'); ?>');
			RefreshBranchData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branch add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchBranch(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'branches', 'action' => 'search')); ?>',
		success: function(response, opts){
			var branch_data = response.responseText;

			eval(branch_data);

			branchSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the branch search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByBranchName(value){
	var conditions = '\'Branch.name LIKE\' => \'%' + value + '%\'';
	store_branches.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshBranchData() {
	store_branches.reload();
}


if(center_panel.find('id', 'branch-tab') != "") {
	var p = center_panel.findById('branch-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Branches'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'branch-tab',
		xtype: 'grid',
		store: store_branches,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Nbe Code'); ?>", dataIndex: 'nbe_code', sortable: true},
			{header: "<?php __('Flex Code'); ?>", dataIndex: 'flex_code', sortable: true},
			{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
			{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		],
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Branches" : "Branch"]})'
        })
,
		listeners: {
			celldblclick: function(){
				ViewBranch(Ext.getCmp('branch-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('<b>Add Branches</b><br />Click here to create a new Branch'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddBranch();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-branch',
					tooltip:'<?php __('<b>Edit Branches</b><br />Click here to modify the selected Branch'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditBranch(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-branch',
					tooltip:'<?php __('<b>Delete Branches(s)</b><br />Click here to remove the selected Branch(s)'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php __('Remove Branch'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											DeleteBranch(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php __('Remove Branch'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove the selected Branches'); ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											DeleteBranch(sel_ids);
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
					text: '<?php __('View Branch'); ?>',
					id: 'view-branch',
					tooltip:'<?php __('<b>View Branch</b><br />Click here to see details of the selected Branch'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewBranch(sel.data.id);
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
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'branch_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByBranchName(Ext.getCmp('branch_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
					id: 'branch_go_button',
					handler: function(){
						SearchByBranchName(Ext.getCmp('branch_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
                    tooltip:'<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>',
					handler: function(){
						SearchBranch();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_branches,
			displayInfo: true,
			displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of {0}'); ?>',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-branch').enable();
		p.getTopToolbar().findById('delete-branch').enable();
		p.getTopToolbar().findById('view-branch').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branch').disable();
			p.getTopToolbar().findById('view-branch').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-branch').disable();
			p.getTopToolbar().findById('view-branch').disable();
			p.getTopToolbar().findById('delete-branch').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-branch').enable();
			p.getTopToolbar().findById('view-branch').enable();
			p.getTopToolbar().findById('delete-branch').enable();
		}
		else{
			p.getTopToolbar().findById('edit-branch').disable();
			p.getTopToolbar().findById('view-branch').disable();
			p.getTopToolbar().findById('delete-branch').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_branches.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
