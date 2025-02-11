var store_links = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id', 'name', 'container', 'controller', 'action', 'parameter', {name: 'list_order', type: 'int'}	
        ]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'list_data')); ?>'	
    }),	
    sortInfo:{field: 'list_order', direction: "ASC"},
	groupField: 'container'
});

function AddLink() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'add')); ?>',
		success: function(response, opts) {
			var link_data = response.responseText;
			
			eval(link_data);
			
			linkAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Activity Add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditLink(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var link_data = response.responseText;
			
			eval(link_data);
			
			linkEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Activity Edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewLink(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var link_data = response.responseText;
			
			eval(link_data);
			
			linkViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Activity View form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteLink(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Link successfully deleted!'); ?>');
			RefreshLinkData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot delete the Activity. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchLink(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'links', 'action' => 'search')); ?>',
		success: function(response, opts){
			var link_data = response.responseText;

			eval(link_data);

			linkSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the Activity Search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByLinkName(value){
	var conditions = '\'Link.name LIKE\' => \'%' + value + '%\'';
	store_links.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshLinkData() {
	store_links.reload();
}


if(center_panel.find('id', 'link-tab') != "") {
	var p = center_panel.findById('link-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php __('Activities'); ?>',
		closable: true,
		loadMask: true,
		id: 'link-tab',
		xtype: 'grid',
		store: store_links,
		columns: [
			{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
			{header: "<?php __('Module'); ?>", dataIndex: 'container', sortable: true},
			{header: "<?php __('Controller'); ?>", dataIndex: 'controller', sortable: true},
			{header: "<?php __('Action'); ?>", dataIndex: 'action', sortable: true},
			{header: "<?php __('Parameter'); ?>", dataIndex: 'parameter', sortable: true},
            {header: "<?php __('Order'); ?>", dataIndex: 'list_order', sortable: true}	
        ],
		listeners: {
			celldblclick: function(){
				ViewLink(Ext.getCmp('link-tab').getSelectionModel().getSelected().data.id);
			}
		},
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Activities" : "Activity"]})'
        }),
        sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [
				{
					xtype: 'tbbutton',
					text: '<?php __('Add'); ?>',
					tooltip:'<?php __('Add Activity'); ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						AddLink();
					}
				},' ', '-', ' ',
				{
					xtype: 'tbbutton',
					text: '<?php __('Edit'); ?>',
					id: 'edit-link',
					tooltip:'<?php __('Edit Activity'); ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							EditLink(sel.data.id);
						};
					}
				},' ', '-', ' ',
				{
					xtype: 'tbbutton',
					text: '<?php __('Delete'); ?>',
					id: 'delete-link',
					tooltip:'<?php __('Delete Activity'); ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
										title: '<?php __('Remove Activity'); ?>',
										buttons: Ext.MessageBox.YESNOCANCEL,
										msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
										fn: function(btn){
												if (btn == 'yes'){
														DeleteLink(sel[0].data.id);
												}
										}
								});
							}else{
								Ext.Msg.show({
										title: '<?php __('Remove Activity'); ?>',
										buttons: Ext.MessageBox.YESNOCANCEL,
										msg: '<?php __('Remove the selected Activities'); ?>?',
										fn: function(btn){
												if (btn == 'yes'){
														var sel_ids = '';
														for(i=0;i<sel.length;i++){
															if(i>0)
																sel_ids += '_';
															sel_ids += sel[i].data.id;
														}
														DeleteLink(sel_ids);
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
					xtype: 'tbbutton',
					text: '<?php __('View Activity'); ?>',
					id: 'view-link',
					tooltip:'<?php __('View Activity'); ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							ViewLink(sel.data.id);
						};
					}
				},' ', '-', 
				'<?php __('Module'); ?>: ',
				{
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
						['-1', 'All'],
						<?php $st = false;foreach ($containers as $item){if($st) echo ',';?> ['<?php echo $item['Container']['id']; ?>' ,'<?php echo $item['Container']['name']; ?>']<?php $st = true;}?>						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					forceSelection : true,
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_links.reload({
								params: {
									start: 0,
									limit: list_size,
									container_id : combo.getValue()
								}
							});

						}
					}
				},
				'->',
				{
					xtype: 'textfield',
					emptyText: '<?php __('[Search By Name]'); ?>',
					id: 'link_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchByLinkName(Ext.getCmp('link_search_field').getValue());
							}
						}

					}
				},
				{
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('GO'); ?>',
					id: 'link_go_button',
					handler: function(){
						SearchByLinkName(Ext.getCmp('link_search_field').getValue());
					}
				},'-',
				{
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php __('Advanced Search'); ?>',
					handler: function(){
						SearchLink();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_links,
			displayInfo: true,
			displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
			beforePageText: '<?php __('Page'); ?>',
			afterPageText: '<?php __('of'); ?> {0}'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-link').enable();
		p.getTopToolbar().findById('delete-link').enable();
		p.getTopToolbar().findById('view-link').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-link').disable();
			p.getTopToolbar().findById('view-link').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-link').disable();
			p.getTopToolbar().findById('view-link').disable();
			p.getTopToolbar().findById('delete-link').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-link').enable();
			p.getTopToolbar().findById('view-link').enable();
			p.getTopToolbar().findById('delete-link').enable();
		}
		else{
			p.getTopToolbar().findById('edit-link').disable();
			p.getTopToolbar().findById('view-link').disable();
			p.getTopToolbar().findById('delete-link').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_links.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
