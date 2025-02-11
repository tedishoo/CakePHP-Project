
var store_people = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','first_name','middle_name','last_name','birthdate','birth_location','residence_location','nationality','kebele_or_farmers_association','house_number'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'list_data')); ?>'
	}),	sortInfo:{field: 'first_name', direction: "ASC"},
	groupField: 'middle_name'
	});


function AddPerson() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var person_data = response.responseText;
			
			eval(person_data);
			
			PersonAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the person add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditPerson(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var person_data = response.responseText;
			
			eval(person_data);
			
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

function DeletePerson(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Person successfully deleted!'); ?>');
			RefreshPersonData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the person add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchPerson(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'people', 'action' => 'search')); ?>',
		success: function(response, opts){
			var person_data = response.responseText;

			eval(person_data);

			personSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the person search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByPersonName(value){
	var conditions = '\'Person.name LIKE\' => \'%' + value + '%\'';
	store_people.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshPersonData() {
	store_people.reload();
}


if(center_panel.find('id', 'person-tab') != "") {
	var p = center_panel.findById('person-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('People'); ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: 'person-tab',
		xtype: 'grid',
		store: store_people,
		columns: [
			{header: "<?php __('First Name'); ?>", dataIndex: 'first_name', sortable: true},
			{header: "<?php __('Middle Name'); ?>", dataIndex: 'middle_name', sortable: true},
			{header: "<?php __('Last Name'); ?>", dataIndex: 'last_name', sortable: true},
			{header: "<?php __('Birthdate'); ?>", dataIndex: 'birthdate', sortable: true},
			{header: "<?php __('BirthLocation'); ?>", dataIndex: 'birth_location', sortable: true},
			{header: "<?php __('ResidenceLocation'); ?>", dataIndex: 'residence_location', sortable: true},
			{header: "<?php __('Nationality'); ?>", dataIndex: 'nationality', sortable: true},
			{header: "<?php __('Kebele Or Farmers Association'); ?>", dataIndex: 'kebele_or_farmers_association', sortable: true},
			{header: "<?php __('House Number'); ?>", dataIndex: 'house_number', sortable: true}
		],		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "People" : "Person"]})'
        }),
		listeners: {
			celldblclick: function(){
				ViewPerson(Ext.getCmp('person-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [
				{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('Add Person'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddPerson();
					}
				},' ', '-', ' ',
				{
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-person',
					tooltip:'<?php __('Edit Person'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditPerson(sel.data.id);
						};
					}
				},' ', '-', ' ',
				{
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-person',
					tooltip:'<?php __('Delete Person'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
										title: '<?php __('Remove Person'); ?>',
										buttons: Ext.MessageBox.YESNO,
										msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
										fn: function(btn){
												if (btn == 'yes'){
														DeletePerson(sel[0].data.id);
												}
										}
								});
							}else{
								Ext.Msg.show({
										title: '<?php __('Remove Person'); ?>',
										buttons: Ext.MessageBox.YESNO,
										msg: '<?php __('Remove the selected People'); ?>?',
										fn: function(btn){
												if (btn == 'yes'){
														var sel_ids = '';
														for(i=0;i<sel.length;i++){
															if(i>0)
																sel_ids += '_';
															sel_ids += sel[i].data.id;
														}
														DeletePerson(sel_ids);
												}
										}
								});
							}
						} else {
							Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
						};
					}
				},' ', '-', ' ',
				{
					xtype: 'tbsplit',
					text: '<?php __('View Person'); ?>',
					id: 'view-person',
					tooltip:'<?php __('View Person'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewPerson(sel.data.id);
						};
					},
					menu : {
						items: [
                                                    						]
					}
				},' ', '-', 
				'<?php __('BirthLocation'); ?>: ',
				{
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
						['-1', 'All'],
						<?php $st = false;foreach ($birthlocations as $item){if($st) echo ',';?> ['<?php echo $item['BirthLocation']['id']; ?>' ,'<?php echo $item['BirthLocation']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_people.reload({
								params: {
									start: 0,
									limit: list_size,
									birthlocation_id : combo.getValue()
								}
							});

						}
					}
				},
				'->',
				{
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'person_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByPersonName(Ext.getCmp('person_search_field').getValue());
							}
						}

					}
				},
				{
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
					id: 'person_go_button',
					handler: function(){
						SearchByPersonName(Ext.getCmp('person_search_field').getValue());
					}
				},'-',
				{
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
					handler: function(){
						SearchPerson();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_people,
			displayInfo: true,
			displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of'); ?> {0}',
			emptyMsg: '<?php __('No data to display'); ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-person').enable();
		p.getTopToolbar().findById('delete-person').enable();
		p.getTopToolbar().findById('view-person').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-person').disable();
			p.getTopToolbar().findById('view-person').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-person').disable();
			p.getTopToolbar().findById('view-person').disable();
			p.getTopToolbar().findById('delete-person').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-person').enable();
			p.getTopToolbar().findById('view-person').enable();
			p.getTopToolbar().findById('delete-person').enable();
		}
		else{
			p.getTopToolbar().findById('edit-person').disable();
			p.getTopToolbar().findById('view-person').disable();
			p.getTopToolbar().findById('delete-person').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_people.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
