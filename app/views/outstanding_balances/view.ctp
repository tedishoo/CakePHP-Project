
		
<?php $outstandingBalance_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Account', true) . ":</th><td><b>" . $outstandingBalance['Account']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $outstandingBalance['Date']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Balance', true) . ":</th><td><b>" . $outstandingBalance['OutstandingBalance']['balance'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $outstandingBalance['OutstandingBalance']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $outstandingBalance['OutstandingBalance']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var outstandingBalance_view_panel_1 = {
			html : '<?php echo $outstandingBalance_html; ?>',
			frame : true,
			height: 80
		}
		var outstandingBalance_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var OutstandingBalanceViewWindow = new Ext.Window({
			title: '<?php __('View OutstandingBalance'); ?>: <?php echo $outstandingBalance['OutstandingBalance']['']; ?>',
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
				outstandingBalance_view_panel_1,
				outstandingBalance_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					OutstandingBalanceViewWindow.close();
				}
			}]
		});
