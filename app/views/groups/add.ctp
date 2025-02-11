	<?php
		$this->ExtForm->create('Group');
		$this->ExtForm->defineFieldFunctions();
	?>
	
	var tree = new Ext.tree.TreePanel({
        title: 'Permissions',
        height: 320,
        width: '100%',
        useArrows:true,
        autoScroll:true,
        animate:true,
        enableDD:true,
        containerScroll: true,
        rootVisible: false,
        frame: true,
        root: {
            nodeType: 'async'
        },
        
        // auto create TreeLoader
        dataUrl: '<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'list_data2')); ?>',
        
        listeners: {
            'checkchange': function(node, checked){
				var prer = '0';
				if(node.text.indexOf(">>>") > 0)
					var prer = node.text.split(">>>")[1];
				
				if(checked){
                    node.getUI().addClass('complete');
					if(prer > 0){
						node.fireEvent('checkchange', tree.getNodeById(prer), true);
					}
                }else{
                    node.getUI().removeClass('complete');
					if(prer > 0){
						node.fireEvent('checkchange', tree.getNodeById(prer), false);
					}
                }
            }
        }
    });

    tree.getRootNode().expand(true);
	
	var GroupAddForm = new Ext.form.FormPanel({
		baseCls: 'x-plain',
		labelWidth: 100,
		labelAlign: 'right',
		url:'<?php echo $this->Html->url(array('controller' => 'groups', 'action' => 'add')); ?>',
		defaultType: 'textfield',

		items: [
			<?php 
				$options = array();
				$this->ExtForm->input('name', $options);
			?>,
			<?php
				$options = array();
				$this->ExtForm->input('description', $options);
			?>,
			tree,
			<?php
				$options = array('hidden' => '', 'id' => 'data[Group][Permission]');
				$this->ExtForm->input('Permission', $options);
			?>
		]
	});
	
	var GroupAddWindow = new Ext.Window({
		title: '<?php __('Add Group'); ?>',
		width: 570,
		height: 450,
		layout: 'fit',
		modal: true,
		resizable: true,
		collapsible: true,
		plain:true,
		bodyStyle:'padding:5px;',
		buttonAlign:'right',
		items: GroupAddForm,

		buttons: [{
			text: '<?php __('Save'); ?>',
			handler: function(btn){
				var msg = '', selNodes = tree.getChecked();
                Ext.each(selNodes, function(node){
                    if(msg.length > 0){
                        msg += ',';
                    }
                    msg += node.id;
                });
				Ext.getCmp('data[Group][Permission]').setValue(msg);
				GroupAddForm.getForm().submit({
					waitMsg: '<?php __('Submitting your data...'); ?>',
					waitTitle: '<?php __('Wait Please...'); ?>',
					success: function(f,a){
						Ext.Msg.show({
							title: '<?php __('Success'); ?>',
							buttons: Ext.MessageBox.OK,
							msg: a.result.msg,
                            icon: Ext.MessageBox.INFO
						});
						GroupAddForm.getForm().reset();
						RefreshGroupData();
					},
					failure: function(f,a){
						switch (a.failureType) {
							case Ext.form.Action.CLIENT_INVALID:
								Ext.Msg.show({
									title: '<?php __('Failure'); ?>',
									buttons: Ext.MessageBox.OK,
									msg: 'Form fields may not be submitted with invalid values' ,
									icon: Ext.MessageBox.ERROR
								});
								break;
							case Ext.form.Action.CONNECT_FAILURE:
								Ext.Msg.show({
									title: '<?php __('Failure'); ?>',
									buttons: Ext.MessageBox.OK,
									msg: 'Ajax communication failed' ,
									icon: Ext.MessageBox.ERROR
								});
								break;
							case Ext.form.Action.SERVER_INVALID:
								Ext.Msg.show({
									title: '<?php __('Failure'); ?>',
									buttons: Ext.MessageBox.OK,
									msg: action.result.msg ,
									icon: Ext.MessageBox.ERROR
								});
						}
					}
				});
			}
		}, {
			text: '<?php __('Save & Close'); ?>',
			handler: function(btn){
				var msg = '', selNodes = tree.getChecked();
                Ext.each(selNodes, function(node){
                    if(msg.length > 0){
                        msg += ',';
                    }
                    msg += node.id;
                });
				Ext.getCmp('data[Group][Permission]').setValue(msg);
				GroupAddForm.getForm().submit({
					waitMsg: '<?php __('Submitting your data...'); ?>',
					waitTitle: '<?php __('Wait Please...'); ?>',
					success: function(f,a){
						Ext.Msg.show({
							title: '<?php __('Success'); ?>',
							buttons: Ext.MessageBox.OK,
							msg: a.result.msg,
                            icon: Ext.MessageBox.INFO
						});
						GroupAddWindow.close();
						RefreshGroupData();
					},
					failure: function(f,a){
						switch (a.failureType) {
							case Ext.form.Action.CLIENT_INVALID:
								Ext.Msg.show({
									title: '<?php __('Failure'); ?>',
									buttons: Ext.MessageBox.OK,
									msg: 'Form fields may not be submitted with invalid values' ,
									icon: Ext.MessageBox.ERROR
								});
								break;
							case Ext.form.Action.CONNECT_FAILURE:
								Ext.Msg.show({
									title: '<?php __('Failure'); ?>',
									buttons: Ext.MessageBox.OK,
									msg: 'Ajax communication failed' ,
									icon: Ext.MessageBox.ERROR
								});
								break;
							case Ext.form.Action.SERVER_INVALID:
								Ext.Msg.show({
									title: '<?php __('Failure'); ?>',
									buttons: Ext.MessageBox.OK,
									msg: action.result.msg ,
									icon: Ext.MessageBox.ERROR
								});
						}
					}
				});
			}
		},{
			text: '<?php __('Cancel'); ?>',
			handler: function(btn){
				GroupAddWindow.close();
			}
		}]
	});
