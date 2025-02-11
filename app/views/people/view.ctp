
		
<?php $person_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('First Name', true) . ":</th><td><b>" . $person['Person']['first_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Middle Name', true) . ":</th><td><b>" . $person['Person']['middle_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Last Name', true) . ":</th><td><b>" . $person['Person']['last_name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Birthdate', true) . ":</th><td><b>" . $person['Person']['birthdate'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Birth Location', true) . ":</th><td><b>" . $person['BirthLocation']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Residence Location', true) . ":</th><td><b>" . $person['ResidenceLocation']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Nationality', true) . ":</th><td><b>" . $person['Nationality']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Kebele Or Farmers Association', true) . ":</th><td><b>" . $person['Person']['kebele_or_farmers_association'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('House Number', true) . ":</th><td><b>" . $person['Person']['house_number'] . "</b></td></tr>" . 
"</table>"; 
?>
		var person_view_panel_1 = {
			html : '<?php echo $person_html; ?>',
			frame : true,
			height: 80
		}
		var person_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var PersonViewWindow = new Ext.Window({
			title: '<?php __('View Person'); ?>: <?php echo $person['Person']['id']; ?>',
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
				person_view_panel_1,
				person_view_panel_2
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PersonViewWindow.close();
				}
			}]
		});
