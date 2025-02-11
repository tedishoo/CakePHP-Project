
var popUpWin=0;

function popUpWindow(URLStr, left, top, width, height) {
  if(popUpWin){
    if(!popUpWin.closed) popUpWin.close();
  }
  popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

function UploadWebFolderSpecial() {
	url = '<?php echo $this->Html->url(array('controller' => 'web_folders', 'action' => 'upload_special')); ?>';
	
    popUpWindow(url, 400, 300, 400, 200);
}

function UploadWebFolder(id) {
	url = '<?php echo $this->Html->url(array('controller' => 'web_folders', 'action' => 'upload')); ?>/'+id;
	
    popUpWindow(url, 400, 300, 400, 200);
}

function AddWebFolder(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'web_folders', 'action' => 'create_dir')); ?>/'+id,
		success: function(response, opts) {
			var web_folder_data = response.responseText;
			
			eval(web_folder_data);
			
			WebFolderAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the warning add form. Error code'); ?>: ' + response.status);
		}
	});
}

function AddWebFolderSpecial() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'web_folders', 'action' => 'create_dir_special')); ?>',
		success: function(response, opts) {
			var web_folder_data = response.responseText;
			
			eval(web_folder_data);
			
			WebFolderAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the warning add form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewWebFolder(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'web_folders', 'action' => 'web_files')); ?>/'+id,
		success: function(response, opts) {
			var web_folder_data = response.responseText;
			
			eval(web_folder_data);
			
			WebFolderViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the web Folder View form. Error code'); ?>: ' + response.status);
		}
	});
}

var selected_item_id = 0;
var selected_item_name = '';

if(center_panel.find('id', 'web_folder-tab') != "") {
	var p = center_panel.findById('web_folder-tab');
	center_panel.setActiveTab(p);
} else {
	var p = center_panel.add(
		new Ext.ux.tree.TreeGrid({
			title: '<?php __('Web Folders'); ?>',
			closable: true,
			id: 'web_folder-tab',
			forceFit:true,
			columns:[
				{header: 'Web Folder', width: 1000, dataIndex: 'name'}
			],
			dataUrl: '<?php echo $this->Html->url(array('controller' => 'web_folders', 'action' => 'list_data')); ?>',
			listeners: {
				click: function(n) {
					selected_item_id = n.attributes.id;
					selected_item_name = n.attributes.name;
					p.getTopToolbar().findById('upload_web_folder').enable();
					p.getTopToolbar().findById('add_web_folder').enable();
					p.getTopToolbar().findById('view_web_folder').enable();
				}
			},
			tbar: new Ext.Toolbar({
				items:[
					{
						xtype: 'tbbutton',
						text: '<?php __('Upload'); ?>',
						id: 'upload_web_folder',
						tooltip:'<?php __('Upload a file in the selected Web Folder'); ?>',
						icon: 'img/table_add.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								UploadWebFolder(selected_item_id);
							}
						}
					}, ' ', {
						xtype: 'tbbutton',
						text: '<?php __('Add New'); ?>',
						id: 'add_web_folder',
						tooltip:'<?php __('Add a new folder in the selected Web Folder'); ?>',
						icon: 'img/table_add.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								AddWebFolder(selected_item_id);
							}
						}
					}, ' ', {
						xtype: 'tbbutton',
						text: '<?php __('Upload Special'); ?>',
						id: 'upload_web_folder_special',
						tooltip:'<?php __('Upload a file in a specified Web Folder'); ?>',
						icon: 'img/table_add.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
								UploadWebFolderSpecial();
						}
					}, ' ', {
						xtype: 'tbbutton',
						text: '<?php __('Add New Special'); ?>',
						id: 'add_web_folder_special',
						tooltip:'<?php __('Add a new folder in a specified Web Folder'); ?>',
						icon: 'img/table_add.png',
						cls: 'x-btn-text-icon',
						handler: function(btn) {
							AddWebFolderSpecial();
						}
					}, ' ', '-', ' ', {
						xtype: 'tbbutton',
						text: '<?php __('View Files'); ?>',
						id: 'view_web_folder',
						tooltip:'<?php __('Add a new folder in a specified Web Folder'); ?>',
						icon: 'img/table_view.png',
						cls: 'x-btn-text-icon',
						disabled: true,
						handler: function(btn) {
							if (selected_item_id != 0){
								ViewWebFolder(selected_item_id);
							}
						}
					}
					
				]
			})
		})
	);
	
	center_panel.setActiveTab(p);
}
