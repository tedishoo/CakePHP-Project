var store_parent_people = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','first_name','middle_name','last_name','birthdate','birth_location','residence_location','nationality','kebele_or_farmers_association','house_number'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentPerson() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_person_data = response.responseText;
			
			eval(parent_person_data);
			
			PersonAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the person add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPerson(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_person_data = response.responseText;
			
			eval(parent_person_data);
			
			PersonEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the person edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerson(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var person_data = response.responseText;

			eval(person_data);

			PersonViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the person view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentPerson(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Person(s) successfully deleted!'); ?>');
			RefreshParentPersonData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the person to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPersonName(value){
	var conditions = '\'Person.name LIKE\' => \'%' + value + '%\'';
	store_parent_people.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPersonData() {
	store_parent_people.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('People'); ?>',
	store: store_parent_people,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
        id: 'personGrid',
	columns: [
		{header: "<?php __('First Name'); ?>", dataIndex: 'first_name', sortable: true},
		{header: "<?php __('Middle Name'); ?>", dataIndex: 'middle_name', sortable: true},
		{header: "<?php __('Last Name'); ?>", dataIndex: 'last_name', sortable: true},
		{header: "<?php __('Birthdate'); ?>", dataIndex: 'birthdate', sortable: true},
		{header:"<?php __('birth_location'); ?>", dataIndex: 'birth_location', sortable: true},
		{header:"<?php __('residence_location'); ?>", dataIndex: 'residence_location', sortable: true},
		{header:"<?php __('nationality'); ?>", dataIndex: 'nationality', sortable: true},
		{header: "<?php __('Kebele Or Farmers Association'); ?>", dataIndex: 'kebele_or_farmers_association', sortable: true},
		{header: "<?php __('House Number'); ?>", dataIndex: 'house_number', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
        listeners: {
                celldblclick: function(){
                        ViewPerson(Ext.getCmp('personGrid').getSelectionModel().getSelected().data.id);
                }
        },
	tbar: new Ext.Toolbar({
		
		items: [
			{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('Add Person'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPerson();
				}
			},' ', '-', ' ',
			{
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-person',
				tooltip:'<?php __('Edit Person'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentPerson(sel.data.id);
					};
				}
			},' ', '-', ' ',
			{
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-person',
				tooltip:'<?php __('Delete Person'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove Person'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									fn: function(btn){
											if (btn == 'yes'){
													DeleteParentPerson(sel[0].data.id);
											}
									}
							});
						}else{
							Ext.Msg.show({
									title: '<?php __('Remove Person'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected Person'); ?>?',
									fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentPerson(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			},' ','-',' ',{
				xtype: 'tbsplit',
				text: '<?php __('View Person'); ?>',
				id: 'view-person2',
				tooltip:'<?php __('View Person'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewPerson(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

                        },' ', '->',
			{
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_person_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentPersonName(Ext.getCmp('parent_person_search_field').getValue());
						}
					}

				}
			},
			{
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				id: 'parent_person_go_button',
				handler: function(){
					SearchByParentPersonName(Ext.getCmp('parent_person_search_field').getValue());
				}
			},' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_people,
		displayInfo: true,
		displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of'); ?> {0}'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-person').enable();
	g.getTopToolbar().findById('delete-parent-person').enable();
        g.getTopToolbar().findById('view-person2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-person').disable();
                g.getTopToolbar().findById('view-person2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-person').disable();
		g.getTopToolbar().findById('delete-parent-person').enable();
                g.getTopToolbar().findById('view-person2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-person').enable();
		g.getTopToolbar().findById('delete-parent-person').enable();
                g.getTopToolbar().findById('view-person2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-person').disable();
		g.getTopToolbar().findById('delete-parent-person').disable();
                g.getTopToolbar().findById('view-person2').disable();
	}
});



var parentPeopleViewWindow = new Ext.Window({
	title: 'Person Under the selected Item',
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
			parentPeopleViewWindow.close();
		}
	}]
});

store_parent_people.load({
    params: {
        start: 0,    
        limit: list_size
    }
});