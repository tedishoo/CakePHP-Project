
var store_collateralDetail_insurances = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','collateral_detail','estimated_value','date_estimated','insurance_company','type','date_insured','amount_insured','expire_date','policy_number','created','modified'		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'insurances', 'action' => 'list_data', $collateralDetail['CollateralDetail']['id'])); ?>'	})
});
		
<?php $collateralDetail_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Collateral', true) . ":</th><td><b>" . $collateralDetail['Collateral']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $collateralDetail['CollateralDetail']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Owner', true) . ":</th><td><b>" . $collateralDetail['CollateralDetail']['Owner'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Titledeed Or Platenumber', true) . ":</th><td><b>" . $collateralDetail['CollateralDetail']['titledeed_or_platenumber'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('City', true) . ":</th><td><b>" . $collateralDetail['CollateralDetail']['city'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Wereda Or Chasisnumber', true) . ":</th><td><b>" . $collateralDetail['CollateralDetail']['wereda_or_chasisnumber'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Kebele Or Motornumber', true) . ":</th><td><b>" . $collateralDetail['CollateralDetail']['kebele_or_motornumber'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Housenumber Or Yearofmake', true) . ":</th><td><b>" . $collateralDetail['CollateralDetail']['housenumber_or_yearofmake'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $collateralDetail['CollateralDetail']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $collateralDetail['CollateralDetail']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var collateralDetail_view_panel_1 = {
			html : '<?php echo $collateralDetail_html; ?>',
			frame : true,
			height: 80
		}
		var collateralDetail_view_panel_2 = new Ext.TabPanel({
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
				store: store_collateralDetail_insurances,
				title: '<?php __('Insurances'); ?>',
				enableColumnMove: false,
				listeners: {
					activate: function(){
						if(store_collateralDetail_insurances.getCount() == '')
							store_collateralDetail_insurances.reload();
					}
				},
				columns: [
					{header: "<?php __('Collateral Detail'); ?>", dataIndex: 'collateral_detail', sortable: true}
,					{header: "<?php __('Estimated Value'); ?>", dataIndex: 'estimated_value', sortable: true}
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
					store: store_collateralDetail_insurances,
					displayInfo: true,
					displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
					beforePageText: '<?php __('Page'); ?>',
					afterPageText: '<?php __('of'); ?> {0}',
					emptyMsg: '<?php __('No data to display'); ?>'
				})
			}			]
		});

		var CollateralDetailViewWindow = new Ext.Window({
			title: '<?php __('View CollateralDetail'); ?>: <?php echo $collateralDetail['CollateralDetail']['id']; ?>',
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
				collateralDetail_view_panel_1,
				collateralDetail_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					CollateralDetailViewWindow.close();
				}
			}]
		});
