
var store_collateral_collateralDetails = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','collateral','type','Owner','titledeed_or_platenumber','city','wereda_or_chasisnumber','kebele_or_motornumber','housenumber_or_yearofmake','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'collateralDetails', 'action' => 'list_data', $collateral['Collateral']['id'])); ?>'	})
});
var store_collateral_insurances = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','collateral','estimated_value','date_estimated','insurance_company','type','date_insured','amount_insured','expire_date','policy_number','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'list_data', $collateral['Collateral']['id'])); ?>'	})
});
		
<?php $collateral_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Account', true) . ":</th><td><b>" . $collateral['Account']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $collateral['Collateral']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $collateral['Collateral']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var collateral_view_panel_1 = {
			html : '<?php echo $collateral_html; ?>',
			frame : true,
			height: 80
		}
		var collateral_view_panel_2 = new Ext.TabPanel({
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
				store: store_collateral_collateralDetails,
				title: '<?php __('CollateralDetails'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_collateral_collateralDetails.getCount() == '')
							store_collateral_collateralDetails.reload();
					}
				},
				columns: [
					{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true}
,					{header: "<?php __('Owner'); ?>", dataIndex: 'Owner', sortable: true}
,					{header: "<?php __('Titledeed Or Platenumber'); ?>", dataIndex: 'titledeed_or_platenumber', sortable: true}
,					{header: "<?php __('City'); ?>", dataIndex: 'city', sortable: true}
,					{header: "<?php __('Wereda Or Chasisnumber'); ?>", dataIndex: 'wereda_or_chasisnumber', sortable: true}
,					{header: "<?php __('Kebele Or Motornumber'); ?>", dataIndex: 'kebele_or_motornumber', sortable: true}
,					{header: "<?php __('Housenumber Or Yearofmake'); ?>", dataIndex: 'housenumber_or_yearofmake', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_collateral_collateralDetails,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			},
{
				xtype: 'grid',
				loadMask: true,
				stripeRows: true,
				store: store_collateral_insurances,
				title: '<?php __('Insurances'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_collateral_insurances.getCount() == '')
							store_collateral_insurances.reload();
					}
				},
				columns: [
					{header: "<?php __('Estimated Value'); ?>", dataIndex: 'estimated_value', sortable: true}
,					{header: "<?php __('Date Estimated'); ?>", dataIndex: 'date_estimated', sortable: true}
,					{header: "<?php __('Insurance Company'); ?>", dataIndex: 'insurance_company', sortable: true}
,					{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true}
,					{header: "<?php __('Date Insured'); ?>", dataIndex: 'date_insured', sortable: true}
,					{header: "<?php __('Amount Insured'); ?>", dataIndex: 'amount_insured', sortable: true}
,					{header: "<?php __('Expire Date'); ?>", dataIndex: 'expire_date', sortable: true}
,					{header: "<?php __('Policy Number'); ?>", dataIndex: 'policy_number', sortable: true}
,					{header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true}
,					{header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}
		
				],
				viewConfig: {
					forceFit: true
				},
				bbar: new Ext.PagingToolbar({
					pageSize: view_list_size,
					store: store_collateral_insurances,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var CollateralViewWindow = new Ext.Window({
			title: '<?php __('View Collateral'); ?>: <?php echo $collateral['Collateral']['id']; ?>',
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
				collateral_view_panel_1,
				collateral_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CollateralViewWindow.close();
				}
			}]
		});
