
		
<?php $adjustment_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Mobile', true) . ":</th><td><b>" . $adjustment['Adjustment']['mobile'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date', true) . ":</th><td><b>" . $adjustment['Adjustment']['date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $adjustment['Adjustment']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $adjustment['Adjustment']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var adjustment_view_panel_1 = {
			html : '<?php echo $adjustment_html; ?>',
			frame : true,
			height: 80
		}
		var adjustment_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var AdjustmentViewWindow = new Ext.Window({
			title: '<?php __('View Adjustment'); ?>: <?php echo $adjustment['Adjustment']['id']; ?>',
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
				adjustment_view_panel_1,
				adjustment_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					AdjustmentViewWindow.close();
				}
			}]
		});
