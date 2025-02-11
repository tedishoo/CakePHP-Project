
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
var store_<?php echo $singularVar; ?>_<?php echo $otherPluralVar; ?> = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			<?php
				$started = false;
				foreach ($details['fields'] as $field) {
					if($started) echo ",";
					if(strpos($field, '_id') !== false)
						echo "'" . substr($field, 0, -3) . "'";
					else
						echo "'{$field}'";
					$started = true;
				}
			?>
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: <?php echo "'<?php echo \$this->Html->url(array('controller' => '" . $otherPluralVar . "', 'action' => 'list_data', \${$singularVar}['{$modelClass}']['id'])); ?>'"; ?>
	})
});
<?php 
endforeach;
?>
		
<?php
		echo "<?php \${$singularVar}_html = \"<table cellspacing=3>\" . ";
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t\"<tr><th align=right>\" . __('" . Inflector::humanize(Inflector::underscore($alias)) . "', true) . \":</th><td><b>\" . \${$singularVar}['{$alias}']['{$details['displayField']}'] . \"</b></td></tr>\" . \n";
						break;
					}
				}
			}
			if ($isKey !== true && $field != $primaryKey) {
				echo "\t\t\"<tr><th align=right>\" . __('" . Inflector::humanize($field) . "', true) . \":</th><td><b>\" . \${$singularVar}['{$modelClass}']['{$field}'] . \"</b></td></tr>\" . \n";
			}
		}
		echo "\"</table>\"; \n";
		echo "?>\n";
?>
		var <?php echo $singularVar; ?>_view_panel_1 = {
			html : '<?php echo "<?php echo \${$singularVar}_html; ?>"; ?>',
			frame : true,
			height: 80
		}
		var <?php echo $singularVar; ?>_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
			<?php
$started = false;
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
	$otherPluralVar = Inflector::pluralize($otherSingularVar);
	if($started) echo ",\n";
	?>{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_<?php echo $singularVar; ?>_<?php echo $otherPluralVar; ?>,
				title: '<?php echo "<?php __('" . Inflector::humanize($otherPluralVar) . "'); ?>"; ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_<?php echo $singularVar; ?>_<?php echo $otherPluralVar; ?>.getCount() == '')
							store_<?php echo $singularVar; ?>_<?php echo $otherPluralVar; ?>.reload();
					}
				},
				columns: [
<?php
				$started2 = false;
				foreach ($details['fields'] as $field) {
					if($field == 'id' || $field == $singularVar . '_id')
						continue;
					if($started2) echo ",";
					if(strpos($field, '_id')){
?>
					{header: "<?php echo "<?php __('" . Inflector::humanize(substr($field, 0, -3)) . "'); ?>"; ?>", dataIndex: '<?php echo substr($field, 0, -3); ?>', sortable: true}
<?php
					}else{
?>
					{header: "<?php echo "<?php __('" . Inflector::humanize($field) . "'); ?>"; ?>", dataIndex: '<?php echo $field; ?>', sortable: true}
<?php
					}
					$started2 = true;
				}
?>		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_<?php echo $singularVar; ?>_<?php echo $otherPluralVar; ?>,
					displayInfo: true,
					displayMsg: '<?php echo "<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}"; ?>',
					beforePageText: '<?php echo "<?php __('Page'); ?>"; ?>',
					afterPageText: '<?php echo "<?php __('of'); ?> {0}"; ?>',
					emptyMsg: '<?php echo "<?php __('No data to display'); ?>"; ?>'
				})
			}<?php
	$started = true;
endforeach;
?>
			]
		});

		var <?php echo $modelClass; ?>ViewWindow = new Ext.Window({
			title: '<?php echo "<?php __('"; ?>View <?php echo Inflector::humanize($singularVar); ?><?php echo "'); ?>" ?>: <?php echo "<?php echo \${$singularVar}['{$modelClass}']['{$displayField}']; ?>"; ?>',
			width: 500,
			height:345,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				<?php echo $singularVar; ?>_view_panel_1,
				<?php echo $singularVar; ?>_view_panel_2
			],

			buttons: [{
				text: '<?php echo "<?php __('"; ?>Close<?php echo "'); ?>"; ?>',
				handler: function(btn){
					<?php echo $modelClass; ?>ViewWindow.close();
				}
			}]
		});
