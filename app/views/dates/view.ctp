
var store_date_outstandingBalances = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','account','date','balance','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'outstandingBalances', 'action' => 'list_data', $date['Date']['id'])); ?>'	})
});
		
<?php $date_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $date['Date']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $date['Date']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $date['Date']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var date_view_panel_1 = {
			html : '<?php echo $date_html; ?>',
			frame : true,
			height: 80
		}
		var date_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
			{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_date_outstandingBalances,
				title: '<?php __('OutstandingBalances'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_date_outstandingBalances.getCount() == '')
							store_date_outstandingBalances.reload();
					}
				},
				columns: [
					{header: "<?php __('Account'); ?>", dataIndex: 'account', sortable: true}
,					{header: "<?php __('Balance'); ?>", dataIndex: 'balance', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_date_outstandingBalances,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var DateViewWindow = new Ext.Window({
			title: '<?php __('View Date'); ?>: <?php echo $date['Date']['id']; ?>',
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
				date_view_panel_1,
				date_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					DateViewWindow.close();
				}
			}]
		});
