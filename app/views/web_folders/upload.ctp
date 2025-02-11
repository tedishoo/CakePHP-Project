
var WebFolderUploadForm = new Ext.form.FormPanel({
	baseCls: 'x-plain',
	labelWidth: 100,
    fileUpload: true,
    standardSubmit: true,
	labelAlign: 'right',
	url:'<?php echo $this->Html->url(array('controller' => 'web_folders', 'action' => 'upload', $id)); ?>',
	defaultType: 'textfield',

	items: [{
        xtype: 'fileuploadfield',
        id: 'upload_web_file',
        emptyText: 'Select a file',
        fieldLabel: 'File',
		anchor: '100%',
        name: 'data[upload_file]',
        buttonText: '',
        buttonCfg: {
            iconCls: 'upload-icon'
        }
    }]
});

var WebFolderUploadWindow = new Ext.Window({
	title: '<?php __('Upload File'); ?>',
	width: 400,
	height: 200,
	layout: 'fit',
    bodyBorder: false,
    border: false,
    closable: false,
    draggable: false,
	modal: true,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'right',
	items: WebFolderUploadForm,

	buttons: [{
        text: '<?php __('Save'); ?>',
        handler: function(btn){
            if(WebFolderUploadForm.getForm().isValid()){
                WebFolderUploadForm.getForm().submit();
            }
        }
	},{
        text: '<?php __('Cancel'); ?>',
        handler: function(btn){
            window.close();
        }
	}]
});

WebFolderUploadWindow.show();