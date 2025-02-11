
var web_files_store = [
<?php $st = false; foreach($web_files as $web_file) { echo $st? ',': ''; $st = true; ?>
	['<?php echo $web_file; ?>']
<?php } ?>
];

var store_web_files = new Ext.data.ArrayStore({
	fields: [
	   {name: 'name'}
	]
});

store_web_files.loadData(web_files_store);

var gridWebFiles = new Ext.grid.GridPanel({
	store: store_web_files,
	columns: [ 
		{ header: 'File Name', sortable: true, dataIndex: 'name'}
	],
	viewConfig: {
		forceFit: true
	},
	stripeRows: true,
	autoExpandColumn: 'company',
	height: 100,
	title: 'Array Grid',
	// config options for stateful behavior
	stateful: true,
	stateId: 'grid'
});

var WebFolderViewWindow = new Ext.Window({
	title: '<?php __('Add Web Folder Special'); ?>',
	width: 500,
	height: 400,
	layout: 'fit',
	modal: true,
	resizable: true,
	collapsible: true,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'right',
	items: gridWebFiles,

	buttons: [{
		text: '<?php __('Close'); ?>',
		handler: function(btn){
			WebFolderViewWindow.close();
		}
	}]
});
