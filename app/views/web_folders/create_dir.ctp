
var WebFolderAddForm = new Ext.form.FormPanel({
	baseCls: 'x-plain',
	labelWidth: 100,
	labelAlign: 'right',
	url:'<?php echo $this->Html->url(array('controller' => 'web_folders', 'action' => 'create_dir', $id)); ?>',
	defaultType: 'textfield',

	items: [{
			xtype: 'textfield',
			fieldLabel: 'New Dir Name',
			name: 'data[new_dir]',
			anchor: '80%',
			allowBlank: false,
			blankText: 'Your input is invalid.'
		}
	]
});

var WebFolderAddWindow = new Ext.Window({
	title: '<?php __('Add Web Folder'); ?>',
	width: 500,
	height: 160,
	layout: 'fit',
	modal: true,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'right',
	items: WebFolderAddForm,

	buttons: [  {
		text: '<?php __('Save'); ?>',
		handler: function(btn){
			WebFolderAddForm.getForm().submit({
				waitMsg: '<?php __('Submitting your data...'); ?>',
				waitTitle: '<?php __('Wait Please...'); ?>',
				success: function(f,a){
					Ext.Msg.show({
						title: '<?php __('Success'); ?>',
						buttons: Ext.MessageBox.OK,
						msg: a.result.msg,
						icon: Ext.MessageBox.INFO
					});
					WebFolderAddWindow.close();
				},
				failure: function(f,a){
					Ext.Msg.show({
						title: '<?php __('Warning'); ?>',
						buttons: Ext.MessageBox.OK,
						msg: a.result.errormsg,
						icon: Ext.MessageBox.ERROR
					});
				}
			});
		}
	},{
		text: '<?php __('Cancel'); ?>',
		handler: function(btn){
			WebFolderAddWindow.close();
		}
	}]
});
