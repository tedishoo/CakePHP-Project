
var store_locations = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','parent_location','lft','rght','is_rural'		
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'list_data')); ?>'
	})
});


function AddLocation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'add')); ?>/'+id,
		success: function(response, opts) {
			var location_data = response.responseText;
			
			eval(location_data);
			
			LocationAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the location add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditLocation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'edit')); ?>/'+id,
		success: function(response, opts) {
			var location_data = response.responseText;
			
			eval(location_data);
			
			LocationEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the location edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function DeleteLocation(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Location successfully deleted!'); ?>');
			RefreshLocationData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the location add form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchLocation(){
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'search')); ?>',
		success: function(response, opts){
			var location_data = response.responseText;

			eval(location_data);

			locationSearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the location search form. Error Code'); ?>: ' + response.status);
		}
	});
}

function SearchByLocationName(value){
	var conditions = '\'Location.name LIKE\' => \'%' + value + '%\'';
	store_locations.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshLocationData() {
	store_locations.reload();
	
	var p = center_panel.findById('location-tab');
	p.getRootNode().reload();
}

var selected_item_id = 0;
var selected_item_name = '';

if(center_panel.find('id', 'location-tab') != "") {
	var p = center_panel.findById('location-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add(
		new Ext.ux.tree.TreeGrid({
			title: '<?php __('Locations'); ?>',
			closable: true,
			id: 'location-tab',
			forceFit:true,
			columns:[
				{header: 'Locations', width: 300, dataIndex: 'name'},
				{header: 'Location Type', width: 300, dataIndex: 'location_type'},
				{header: 'Is Rural?', width: 300, dataIndex: 'is_rural'}
			],
			dataUrl: '<?php echo $this->Html->url(array('controller' => 'locations', 'action' => 'list_data')); ?>',
			listeners: {
				click: function(n) {
					selected_item_id = n.attributes.id;
					selected_item_name = n.attributes.name;
					p.getTopToolbar().findById('add_location').enable();
					p.getTopToolbar().findById('edit_location').enable();
					p.getTopToolbar().findById('delete_location').enable();
					if(n.attributes.name == 'Root Location'){
						p.getTopToolbar().findById('edit_location').disable();
						p.getTopToolbar().findById('delete_location').disable();
					}
				}
			},
			tbar: new Ext.Toolbar({
				items:[
					{
						xtype: 'tbbutton',
						text: '<?php __('Add'); ?>',
						id: 'add_location',
						tooltip:'<?php __('Add Child Location'); ?>',
						icon: 'img/table_add.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								AddLocation(selected_item_id);
							}
						}
					},
					{
						xtype: 'tbbutton',
						text: '<?php __('Edit'); ?>',
						id: 'edit_location',
						tooltip:'<?php __('Edit Location'); ?>',
						icon: 'img/table_edit.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								EditLocation(selected_item_id);
							};
						}
					},' ', '-', ' ',
					{
						xtype: 'tbbutton',
						text: '<?php __('Delete'); ?>',
						id: 'delete_location',
						tooltip:'<?php __('Delete Location'); ?>',
						icon: 'img/table_delete.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								Ext.Msg.show({
									title: '<?php __('Remove Location'); ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php __('Remove'); ?> '+selected_item_name+' <?php __('with all its child items'); ?>?',
									fn: function(btn){
										if (btn == 'yes'){
											DeleteLocation(selected_item_id);
										}
									}
								});
							} else {
								Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
							}
						}
					}
				]
			})
		})
	);
	center_panel.setActiveTab(p);
	
}
