var store_parent_<?php echo $pluralVar; ?> = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			<?php
				$started = false;
				foreach ($fields as $field) {
					$isKey = false;
					if($started) echo ",";
					if (!empty($associations['belongsTo'])) {
						foreach ($associations['belongsTo'] as $alias => $details) {
							if ($field === $details['foreignKey']) {
								$isKey = true;
								echo "'" . Inflector::underscore($alias) . "'";
								break;
							}
						}
					}
					if(!$isKey)
						echo "'{$field}'";
					$started = true;
				}
			?>	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: <?php echo "'<?php echo \$this->Html->url(array('controller' => '" . $pluralVar . "', 'action' => 'list_data', \$parent_id)); ?>'"; ?>
	})
});


function AddParent<?php echo $modelClass; ?>() {
	Ext.Ajax.request({
		url: '<?php echo "<?php echo \$this->Html->url(array('controller' => '{$pluralVar}', 'action' => 'add', \$parent_id)); ?>"; ?>',
		success: function(response, opts) {
			var parent_<?php echo $singularVar; ?>_data = response.responseText;
			
			eval(parent_<?php echo $singularVar; ?>_data);
			
			<?php echo $modelClass; ?>AddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php echo "<?php __('Error'); ?>"; ?>', '<?php echo "<?php __('Cannot get the {$singularVar} add form. Error code'); ?>"; ?>: ' + response.status);
		}
	});
}

function EditParent<?php echo $modelClass; ?>(id) {
	Ext.Ajax.request({
		url: '<?php echo "<?php echo \$this->Html->url(array('controller' => '{$pluralVar}', 'action' => 'edit')); ?>/'+id+'/<?php echo \$parent_id; ?>"; ?>',
		success: function(response, opts) {
			var parent_<?php echo $singularVar; ?>_data = response.responseText;
			
			eval(parent_<?php echo $singularVar; ?>_data);
			
			<?php echo $modelClass; ?>EditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php echo "<?php __('Error'); ?>', '<?php __('Cannot get the {$singularVar} edit form. Error code'); ?>"; ?>: ' + response.status);
		}
	});
}

function View<?php echo $modelClass; ?>(id) {
	Ext.Ajax.request({
		url: '<?php echo "<?php echo \$this->Html->url(array('controller' => '" . $pluralVar . "', 'action' => 'view')); ?>"; ?>/'+id,
		success: function(response, opts) {
			var <?php echo $singularVar; ?>_data = response.responseText;

			eval(<?php echo $singularVar; ?>_data);

			<?php echo $modelClass; ?>ViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php echo "<?php __('"; ?>Error<?php echo "'); ?>"; ?>', '<?php echo "<?php __('"; ?>Cannot get the <?php echo $singularVar; ?> view form. Error code<?php echo "'); ?>"; ?>: ' + response.status);
		}
	});
}

<?php
if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
	$otherPluralVar = Inflector::pluralize($otherSingularVar);
?>
function View<?php echo $modelClass; ?><?php echo Inflector::camelize($details['controller']); ?>(id) {
	Ext.Ajax.request({
		url: '<?php echo "<?php echo \$this->Html->url(array('controller' => '{$otherPluralVar}', 'action' => 'index2')); ?>"; ?>/'+id,
		success: function(response, opts) {
			var parent_<?php echo $otherPluralVar; ?>_data = response.responseText;

			eval(parent_<?php echo $otherPluralVar; ?>_data);

			parent<?php echo Inflector::camelize($details['controller']); ?>ViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php echo "<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>"; ?>: ' + response.status);
		}
	});
}

<?php
endforeach;
?>

function DeleteParent<?php echo $modelClass; ?>(id) {
	Ext.Ajax.request({
		url: '<?php echo "<?php echo \$this->Html->url(array('controller' => '{$pluralVar}', 'action' => 'delete')); ?>/"; ?>'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php echo "<?php __('Success'); ?>', '<?php __('" . Inflector::humanize($modelClass) . "(s) successfully deleted!'); ?>"; ?>');
			RefreshParent<?php echo $modelClass; ?>Data();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php echo "<?php __('Error'); ?>', '<?php __('Cannot get the {$singularVar} to be deleted. Error code'); ?>"; ?>: ' + response.status);
		}
	});
}

function SearchByParent<?php echo $modelClass; ?>Name(value){
	var conditions = '\'<?php echo $modelClass; ?>.name LIKE\' => \'%' + value + '%\'';
	store_parent_<?php echo $pluralVar; ?>.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParent<?php echo $modelClass; ?>Data() {
	store_parent_<?php echo $pluralVar; ?>.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php echo"<?php __('". Inflector::humanize($pluralVar) ."'); ?>"; ?>',
	store: store_parent_<?php echo $pluralVar; ?>,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: '<?php echo $singularVar; ?>Grid',
	columns: [
<?php
				$started = false;
				foreach ($fields as $field) {
					$isKey = false;
					if($field == 'id')
						continue;
					if($started) echo ",\n";
					if (!empty($associations['belongsTo'])) {
						foreach ($associations['belongsTo'] as $alias => $details) {
							if ($field === $details['foreignKey']) {
								$isKey = true;
								echo "\t\t{header:\"<?php __('" . Inflector::underscore($alias) . "'); ?>\", dataIndex: '" . Inflector::underscore($alias) . "', sortable: true}";
								break;
							}
						}
					}
					if ($isKey !== true) {
						echo "\t\t{header: \"<?php __('" . Inflector::humanize($field) . "'); ?>\", dataIndex: '{$field}', sortable: true}";
					}
					$started = true;
				}
?>
	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            View<?php echo $modelClass; ?>(Ext.getCmp('<?php echo $singularVar; ?>Grid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php echo "<?php __('Add'); ?>"; ?>',
				tooltip:'<?php echo "<?php __('<b>Add " . $modelClass . "</b><br />Click here to create a new " . $modelClass . "'); ?>"; ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParent<?php echo $modelClass; ?>();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php echo "<?php __('Edit'); ?>"; ?>',
				id: 'edit-parent-<?php echo $singularVar; ?>',
				tooltip:'<?php echo "<?php __('<b>Edit " . $modelClass . "</b><br />Click here to modify the selected " . $modelClass . "'); ?>"; ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParent<?php echo $modelClass; ?>(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php echo "<?php __('Delete'); ?>"; ?>',
				id: 'delete-parent-<?php echo $singularVar; ?>',
				tooltip:'<?php echo "<?php __('<b>Delete " . $modelClass . "(s)</b><br />Click here to remove the selected " . $modelClass . "(s)'); ?>"; ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php echo "<?php __('Remove {$modelClass}'); ?>"; ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php echo "<?php __('Remove'); ?>"; ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParent<?php echo $modelClass; ?>(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php echo "<?php __('Remove {$modelClass}'); ?>"; ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php echo "<?php __('Remove the selected " . Inflector::humanize($modelClass). "'); ?>?"; ?>',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParent<?php echo $modelClass; ?>(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php echo "<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>"; ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php echo "<?php __('"; ?>View <?php echo $modelClass; ?><?php echo "'); ?>"; ?>',
				id: 'view-<?php echo $singularVar; ?>2',
				tooltip:'<?php echo "<?php __('<b>View " . $modelClass . "</b><br />Click here to see details of the selected " . $modelClass . "'); ?>"; ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						View<?php echo $modelClass; ?>(sel.data.id);
					};
				},
				menu : {
					items: [
<?php
					   $started = false;
					   foreach ($relations as $alias => $details):
							   $otherSingularVar = Inflector::variable($alias);
							   $otherPluralHumanName = Inflector::humanize($details['controller']);
							   $otherPluralVar = Inflector::pluralize($otherSingularVar);
							   if($started) echo ",";
?> {
						text: '<?php echo "<?php __('View {$otherPluralHumanName}'); ?>"; ?>',
                        icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								View<?php echo $modelClass; ?><?php echo Inflector::camelize($details['controller']); ?>(sel.data.id);
							};
						}
					}
<?php
	$started = true;
endforeach;
?>
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php echo "<?php __('[Search By Name]'); ?>"; ?>',
				id: 'parent_<?php echo $singularVar; ?>_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParent<?php echo $modelClass; ?>Name(Ext.getCmp('parent_<?php echo $singularVar; ?>_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: '<?php __('GO'); ?>',
				tooltip:'<?php echo "<?php __('<b>GO</b><br />Click here to get search results'); ?>"; ?>',
				id: 'parent_<?php echo $singularVar; ?>_go_button',
				handler: function(){
					SearchByParent<?php echo $modelClass; ?>Name(Ext.getCmp('parent_<?php echo $singularVar; ?>_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_<?php echo $pluralVar; ?>,
		displayInfo: true,
		displayMsg: '<?php echo "<?php __('Displaying {0} - {1} of {2}'); ?>"; ?>',
		beforePageText: '<?php echo "<?php __('Page'); ?>"; ?>',
		afterPageText: '<?php echo "<?php __('of {0}'); ?>"; ?>',
		emptyMsg: '<?php echo "<?php __('No data to display'); ?>"; ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-<?php echo $singularVar; ?>').enable();
	g.getTopToolbar().findById('delete-parent-<?php echo $singularVar; ?>').enable();
        g.getTopToolbar().findById('view-<?php echo $singularVar; ?>2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-<?php echo $singularVar; ?>').disable();
                g.getTopToolbar().findById('view-<?php echo $singularVar; ?>2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-<?php echo $singularVar; ?>').disable();
		g.getTopToolbar().findById('delete-parent-<?php echo $singularVar; ?>').enable();
                g.getTopToolbar().findById('view-<?php echo $singularVar; ?>2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-<?php echo $singularVar; ?>').enable();
		g.getTopToolbar().findById('delete-parent-<?php echo $singularVar; ?>').enable();
                g.getTopToolbar().findById('view-<?php echo $singularVar; ?>2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-<?php echo $singularVar; ?>').disable();
		g.getTopToolbar().findById('delete-parent-<?php echo $singularVar; ?>').disable();
                g.getTopToolbar().findById('view-<?php echo $singularVar; ?>2').disable();
	}
});



var parent<?php echo Inflector::pluralize($modelClass); ?>ViewWindow = new Ext.Window({
	title: '<?php echo Inflector::humanize($modelClass); ?> Under the selected Item',
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
		text: '<?php __('Close'); ?>',
		handler: function(btn){
			parent<?php echo Inflector::pluralize($modelClass); ?>ViewWindow.close();
		}
	}]
});

store_parent_<?php echo $pluralVar; ?>.load({
    params: {
        start: 0,    
        limit: list_size
    }
});