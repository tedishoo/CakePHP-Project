
		
<?php $link_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Id', true) . ":</th><td><b>" . $link['Link']['id'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $link['Link']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Module', true) . ":</th><td><b>" . $link['Container']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Controller', true) . ":</th><td><b>" . $link['Link']['controller'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Action', true) . ":</th><td><b>" . $link['Link']['action'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Parameter', true) . ":</th><td><b>" . $link['Link']['parameter'] . "</b></td></tr>" . 
"</table>"; 
?>
		var link_view_panel_1 = {
			html : '<?php echo $link_html; ?>',
			id : 'link_view_panel_1',
			frame : true,
			height: 120
		}

		var linkViewWindow = new Ext.Window({
			title: '<?php __('View Module Activity'); ?>: <?php echo $link['Link']['name']; ?>',
			width: 500,
			height: 200,
			modal: true,
			resizable: false,
			collapsible: true,
			plain: true,
			bodyStyle: 'padding:5px;',
			buttonAlign: 'right',
			items: [ 
				link_view_panel_1
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					linkViewWindow.hide();
				}
			}]
		});
