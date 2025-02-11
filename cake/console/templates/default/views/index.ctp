
<?php $filter_field = ''; ?>
var store_<?php echo $pluralVar;?> = new Ext.data.<?php echo (count($fields) > 2)? 'Grouping': '' ?>Store({
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
								if($filter_field == '')
									$filter_field = $alias;
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
		url: '<?php echo "<?php echo \$this->Html->url(array('controller' => '" . $pluralVar . "', 'action' => 'list_data')); ?>"; ?>'
	})
<?php if(count($fields) > 2) { echo ","; ?>
	sortInfo:{field: '<?php echo $fields[1] ?>', direction: "ASC"},
	groupField: '<?php echo $fields[2] ?>'
<?php   } ?>
});


function Add<?php echo $modelClass; ?>() {
	Ext.Ajax.request({
		url: '<?php echo "<?php echo \$this->Html->url(array('controller' => '" . $pluralVar . "', 'action' => 'add')); ?>"; ?>',
		success: function(response, opts) {
			var <?php echo $singularVar; ?>_data = response.responseText;
			
			eval(<?php echo $singularVar; ?>_data);
			
			<?php echo $modelClass; ?>AddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php echo "<?php __('"; ?>Error<?php echo "'); ?>"; ?>', '<?php echo "<?php __('"; ?>Cannot get the <?php echo $singularVar; ?> add form. Error code<?php echo "'); ?>"; ?>: ' + response.status);
		}
	});
}

function Edit<?php echo $modelClass; ?>(id) {
	Ext.Ajax.request({
		url: '<?php echo "<?php echo \$this->Html->url(array('controller' => '" . $pluralVar . "', 'action' => 'edit')); ?>"; ?>/'+id,
		success: function(response, opts) {
			var <?php echo $singularVar; ?>_data = response.responseText;
			
			eval(<?php echo $singularVar; ?>_data);
			
			<?php echo $modelClass; ?>EditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php echo "<?php __('"; ?>Error<?php echo "'); ?>"; ?>', '<?php echo "<?php __('"; ?>Cannot get the <?php echo $singularVar; ?> edit form. Error code<?php echo "'); ?>"; ?>: ' + response.status);
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
?>
<?php
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
	$otherPluralVar = Inflector::pluralize($otherSingularVar);
?>
function ViewParent<?php echo Inflector::camelize($details['controller']); ?>(id) {
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

function Delete<?php echo $modelClass; ?>(id) {
	Ext.Ajax.request({
		url: '<?php echo "<?php echo \$this->Html->url(array('controller' => '" . $pluralVar . "', 'action' => 'delete')); ?>"; ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php echo "<?php __('"; ?>Success<?php echo "'); ?>"; ?>', '<?php echo "<?php __('"; ?><?php echo $modelClass; ?> successfully deleted!<?php echo "'); ?>"; ?>');
			Refresh<?php echo $modelClass; ?>Data();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php echo "<?php __('"; ?>Error<?php echo "'); ?>"; ?>', '<?php echo "<?php __('"; ?>Cannot get the <?php echo $singularVar; ?> add form. Error code<?php echo "'); ?>"; ?>: ' + response.status);
		}
	});
}

function Search<?php echo $modelClass; ?>(){
	Ext.Ajax.request({
		url: '<?php echo "<?php echo \$this->Html->url(array('controller' => '" . $pluralVar . "', 'action' => 'search')); ?>"; ?>',
		success: function(response, opts){
			var <?php echo $singularVar; ?>_data = response.responseText;

			eval(<?php echo $singularVar; ?>_data);

			<?php echo $singularVar; ?>SearchWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php echo "<?php __('"; ?>Error<?php echo "'); ?>"; ?>','<?php echo "<?php __('"; ?>Cannot get the <?php echo $singularVar; ?> search form. Error Code<?php echo "'); ?>"; ?>: ' + response.status);
		}
	});
}

function SearchBy<?php echo $modelClass; ?>Name(value){
	var conditions = '\'<?php echo $modelClass; ?>.name LIKE\' => \'%' + value + '%\'';
	store_<?php echo $pluralVar; ?>.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function Refresh<?php echo $modelClass; ?>Data() {
	store_<?php echo $pluralVar;?>.reload();
}


if(center_panel.find('id', '<?php echo $singularVar; ?>-tab') != "") {
	var p = center_panel.findById('<?php echo $singularVar; ?>-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add({
		title: '<?php echo "<?php __('" . $pluralHumanName . "'); ?>"; ?>',
		closable: true,
		loadMask: true,
		stripeRows: true,
		id: '<?php echo $singularVar; ?>-tab',
		xtype: 'grid',
		store: store_<?php echo $pluralVar;?>,
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
								echo "\t\t\t{header: \"<?php __('" . Inflector::humanize($alias) . "'); ?>\", dataIndex: '" . Inflector::underscore($alias) . "', sortable: true}";
								break;
							}
						}
					}
					if ($isKey !== true) {
						echo "\t\t\t{header: \"<?php __('" . Inflector::humanize($field) . "'); ?>\", dataIndex: '{$field}', sortable: true}";
					}
					$started = true;
				}
?>

		],
<?php if(count($fields) > 2){ ?>
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "<?php echo Inflector::humanize(Inflector::pluralize($modelClass)); ?>" : "<?php echo Inflector::humanize($modelClass); ?>"]})'
        })
<?php } else { ?>
		viewConfig: {
			forceFit: true
		}
<?php } ?>,
		listeners: {
			celldblclick: function(){
				View<?php echo $modelClass; ?>(Ext.getCmp('<?php echo $singularVar; ?>-tab').getSelectionModel().getSelected().data.id);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
			singleSelect: false
		}),
		tbar: new Ext.Toolbar({
			
			items: [{
					xtype: 'tbbutton',
					text: '<?php echo "<?php __('Add'); ?>"; ?>',
					tooltip:'<?php echo "<?php __('<b>Add " . Inflector::humanize(Inflector::pluralize($modelClass)) . "</b><br />Click here to create a new " . Inflector::humanize($modelClass) . "'); ?>"; ?>',
					icon: 'img/table_add.png',
					cls: 'x-btn-text-icon',
					handler: function(btn) {
						Add<?php echo $modelClass; ?>();
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php echo "<?php __('Edit'); ?>"; ?>',
					id: 'edit-<?php echo $singularVar; ?>',
					tooltip:'<?php echo "<?php __('<b>Edit " . Inflector::humanize(Inflector::pluralize($modelClass)) . "</b><br />Click here to modify the selected " . Inflector::humanize($modelClass) . "'); ?>"; ?>',
					icon: 'img/table_edit.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							Edit<?php echo $modelClass; ?>(sel.data.id);
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbbutton',
					text: '<?php echo "<?php __('Delete'); ?>"; ?>',
					id: 'delete-<?php echo $singularVar; ?>',
					tooltip:'<?php echo "<?php __('<b>Delete " . Inflector::humanize(Inflector::pluralize($modelClass)) . "(s)</b><br />Click here to remove the selected " . Inflector::humanize($modelClass) . "(s)'); ?>"; ?>',
					icon: 'img/table_delete.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
						var sel = sm.getSelections();
						if (sm.hasSelection()){
							if(sel.length==1){
								Ext.Msg.show({
									title: '<?php echo "<?php __('"; ?>Remove <?php echo Inflector::humanize($modelClass); ?><?php echo "'); ?>"; ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php echo "<?php __('"; ?>Remove<?php echo "'); ?>"; ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											Delete<?php echo $modelClass; ?>(sel[0].data.id);
										}
									}
								});
							}else{
								Ext.Msg.show({
									title: '<?php echo "<?php __('"; ?>Remove <?php echo $modelClass; ?><?php echo "'); ?>"; ?>',
									buttons: Ext.MessageBox.YESNO,
									msg: '<?php echo "<?php __('"; ?>Remove the selected <?php echo Inflector::humanize(Inflector::pluralize($modelClass)); ?><?php echo "'); ?>"; ?>?',
									icon: Ext.MessageBox.QUESTION,
									fn: function(btn){
										if (btn == 'yes'){
											var sel_ids = '';
											for(i=0;i<sel.length;i++){
												if(i>0)
													sel_ids += '_';
												sel_ids += sel[i].data.id;
											}
											Delete<?php echo $modelClass; ?>(sel_ids);
										}
									}
								});
							}
						} else {
							Ext.Msg.alert('<?php echo "<?php __('"; ?>Warning<?php echo "'); ?>"; ?>', '<?php echo "<?php __('"; ?>Please select a record first<?php echo "'); ?>"; ?>');
						};
					}
				}, ' ', '-', ' ', {
					xtype: 'tbsplit',
					text: '<?php echo "<?php __('"; ?>View <?php echo Inflector::humanize($modelClass); ?><?php echo "'); ?>"; ?>',
					id: 'view-<?php echo $singularVar; ?>',
					tooltip:'<?php echo "<?php __('<b>View " . Inflector::humanize($modelClass) . "</b><br />Click here to see details of the selected " . Inflector::humanize($modelClass) . "'); ?>"; ?>',
					icon: 'img/table_view.png',
					cls: 'x-btn-text-icon',
					disabled: true,
					handler: function(btn) {
						var sm = p.getSelectionModel();
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
?>{
							text: '<?php echo "<?php __('View {$otherPluralHumanName}'); ?>"; ?>',
                            icon: 'img/table_view.png',
							cls: 'x-btn-text-icon',
							handler: function(btn) {
								var sm = p.getSelectionModel();
								var sel = sm.getSelected();
								if (sm.hasSelection()){
									ViewParent<?php echo Inflector::camelize($details['controller']); ?>(sel.data.id);
								};
							}
						}
<?php
	$started = true;
endforeach;
?>
						]
					}
				}, ' ', '-', <?php if($filter_field != '') { ?> '<?php echo "<?php __('" . Inflector::humanize($filter_field) . "'); ?>"; ?>: ', {
					xtype : 'combo',
					emptyText: 'All',
					store : new Ext.data.ArrayStore({
						fields : ['id', 'name'],
						data : [
							['-1', 'All'],
							<?php echo "<?php \$st = false;" .
								"foreach (\$" . strtolower(Inflector::pluralize($filter_field)) . " as \$item){" .
								"if(\$st) echo \",\n\t\t\t\t\t\t\t\";?>" .
								"['<?php echo \$item['" . Inflector::camelize($filter_field) . "']['id']; ?>' ,'<?php echo \$item['" . Inflector::camelize($filter_field) . "']['name']; ?>']" .
								"<?php \$st = true;" .
						"}?>"; ?>
						]
					}),
					displayField : 'name',
					valueField : 'id',
					mode : 'local',
					value : '-1',
					disableKeyFilter : true,
					triggerAction: 'all',
					listeners : {
						select : function(combo, record, index){
							store_<?php echo $pluralVar;?>.reload({
								params: {
									start: 0,
									limit: list_size,
									<?php echo strtolower($filter_field); ?>_id : combo.getValue()
								}
							});
						}
					}
				},
<?php } ?> '->', {
					xtype: 'textfield',
					emptyText: '<?php echo "<?php __('[Search By Name]'); ?>"; ?>',
					id: '<?php echo $singularVar;?>_search_field',
					listeners: {
						specialkey: function(field, e){
							if (e.getKey() == e.ENTER) {
								SearchBy<?php echo $modelClass; ?>Name(Ext.getCmp('<?php echo $singularVar;?>_search_field').getValue());
							}
						}
					}
				}, {
					xtype: 'tbbutton',
					icon: 'img/search.png',
					cls: 'x-btn-text-icon',
					text: '<?php echo "<?php __('GO'); ?>"; ?>',
                    tooltip:'<?php echo "<?php __('<b>GO</b><br />Click here to get search results'); ?>"; ?>',
					id: '<?php echo $singularVar;?>_go_button',
					handler: function(){
						SearchBy<?php echo $modelClass; ?>Name(Ext.getCmp('<?php echo $singularVar;?>_search_field').getValue());
					}
				}, '-', {
					xtype: 'tbbutton',
					icon: 'img/table_search.png',
					cls: 'x-btn-text-icon',
					text: '<?php echo "<?php __('Advanced Search'); ?>"; ?>',
                    tooltip:'<?php echo "<?php __('<b>Advanced Search...</b><br />Click here to get the advanced search form'); ?>"; ?>',
					handler: function(){
						Search<?php echo $modelClass; ?>();
					}
				}
		]}),
		bbar: new Ext.PagingToolbar({
			pageSize: list_size,
			store: store_<?php echo $pluralVar;?>,
			displayInfo: true,
			displayMsg: '<?php echo "<?php __('Displaying {0} - {1} of {2}'); ?>"; ?>',
			beforePageText: '<?php echo "<?php __('Page'); ?>"; ?>',
			afterPageText: '<?php echo "<?php __('of {0}'); ?>"; ?>',
			emptyMsg: '<?php echo "<?php __('No data to display'); ?>"; ?>'
		})
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
		p.getTopToolbar().findById('edit-<?php echo $singularVar; ?>').enable();
		p.getTopToolbar().findById('delete-<?php echo $singularVar; ?>').enable();
		p.getTopToolbar().findById('view-<?php echo $singularVar; ?>').enable();
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-<?php echo $singularVar; ?>').disable();
			p.getTopToolbar().findById('view-<?php echo $singularVar; ?>').disable();
		}
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
		if(this.getSelections().length > 1){
			p.getTopToolbar().findById('edit-<?php echo $singularVar; ?>').disable();
			p.getTopToolbar().findById('view-<?php echo $singularVar; ?>').disable();
			p.getTopToolbar().findById('delete-<?php echo $singularVar; ?>').enable();
		}
		else if(this.getSelections().length == 1){
			p.getTopToolbar().findById('edit-<?php echo $singularVar; ?>').enable();
			p.getTopToolbar().findById('view-<?php echo $singularVar; ?>').enable();
			p.getTopToolbar().findById('delete-<?php echo $singularVar; ?>').enable();
		}
		else{
			p.getTopToolbar().findById('edit-<?php echo $singularVar; ?>').disable();
			p.getTopToolbar().findById('view-<?php echo $singularVar; ?>').disable();
			p.getTopToolbar().findById('delete-<?php echo $singularVar; ?>').disable();
		}
	});
	center_panel.setActiveTab(p);
	
	store_<?php echo $pluralVar;?>.load({
		params: {
			start: 0,          
			limit: list_size
		}
	});
	
}
