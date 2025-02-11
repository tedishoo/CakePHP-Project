
		
<?php $setting_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Setting Key', true) . ":</th><td><b>" . $setting['Setting']['setting_key'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Setting Value', true) . ":</th><td><b>" . $setting['Setting']['setting_value'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date From', true) . ":</th><td><b>" . $setting['Setting']['date_from'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Date To', true) . ":</th><td><b>" . $setting['Setting']['date_to'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Remark', true) . ":</th><td><b>" . $setting['Setting']['remark'] . "</b></td></tr>" . 
"</table>"; 
?>
		var setting_view_panel_1 = {
			html : '<?php echo $setting_html; ?>',
			frame : true,
			height: 80
		}
		var setting_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var SettingViewWindow = new Ext.Window({
			title: '<?php __('View Setting'); ?>: <?php echo $setting['Setting']['id']; ?>',
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
				setting_view_panel_1,
				setting_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					SettingViewWindow.close();
				}
			}]
		});
