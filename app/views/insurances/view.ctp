
		
<?php $insurance_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Collateral Detail', true) . ":</th><td><b>" . $insurance['CollateralDetail']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Estimated Value', true) . ":</th><td><b>" . $insurance['Insurance']['estimated_value'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Estimated', true) . ":</th><td><b>" . $insurance['Insurance']['date_estimated'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Insurance Company', true) . ":</th><td><b>" . $insurance['Insurance']['insurance_company'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Type', true) . ":</th><td><b>" . $insurance['Insurance']['type'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date Insured', true) . ":</th><td><b>" . $insurance['Insurance']['date_insured'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Amount Insured', true) . ":</th><td><b>" . $insurance['Insurance']['amount_insured'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Expire Date', true) . ":</th><td><b>" . $insurance['Insurance']['expire_date'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Policy Number', true) . ":</th><td><b>" . $insurance['Insurance']['policy_number'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Created', true) . ":</th><td><b>" . $insurance['Insurance']['created'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Modified', true) . ":</th><td><b>" . $insurance['Insurance']['modified'] . "</b></td></tr>" . 
"</table>"; 
?>
		var insurance_view_panel_1 = {
			html : '<?php echo $insurance_html; ?>',
			frame : true,
			height: 80
		}
		var insurance_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var InsuranceViewWindow = new Ext.Window({
			title: '<?php __('View Insurance'); ?>: <?php echo $insurance['Insurance']['id']; ?>',
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
				insurance_view_panel_1,
				insurance_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					InsuranceViewWindow.close();
				}
			}]
		});
