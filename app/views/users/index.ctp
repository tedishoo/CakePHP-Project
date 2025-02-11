//<script>
    var store_users = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','username','password','email',
                'is_active','security_question',
                'security_answer','person', 
                'person_id','created','modified'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'list_data')); ?>'
	}),	
	sortInfo:{field: 'username', direction: "ASC"},
	groupField: 'is_active'
    });


    function AddUser() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'add')); ?>',
            success: function(response, opts) {
                var user_data = response.responseText;

                eval(user_data);

                UserAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the user add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditUser(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'edit')); ?>/'+id,
            success: function(response, opts) {
                var user_data = response.responseText;

                eval(user_data);

                UserEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the user edit form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewUser(id) {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'view')); ?>/'+id,
            success: function(response, opts) {
                var user_data = response.responseText;

                eval(user_data);

                UserViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the user view form. Error code'); ?>: ' + response.status);
            }
        });
    }


    function DeleteUser(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('User successfully deleted!'); ?>');
                RefreshUserData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the user add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchUser(){
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'search')); ?>',
            success: function(response, opts){
                var user_data = response.responseText;

                eval(user_data);

                userSearchWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>','<?php __('Cannot get the user search form. Error Code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByUserName(value){
	var conditions = '\'User.name LIKE\' => \'%' + value + '%\'';
	store_users.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshUserData() {
	store_users.reload();
    }


    if(center_panel.find('id', 'user-tab') != "") {
	var p = center_panel.findById('user-tab');
	center_panel.setActiveTab(p);
    } else {
	var p = center_panel.add({
            title: '<?php __('Users'); ?>',
            closable: true,
            loadMask: true,
            stripeRows: true,
            id: 'user-tab',
            xtype: 'grid',
            store: store_users,
            columns: [
                    {header: "<?php __('Username'); ?>", dataIndex: 'username', sortable: true},
                    {header: "<?php __('Full Name'); ?>", dataIndex: 'person', sortable: true},
                    {header: "<?php __('Email'); ?>", dataIndex: 'email', sortable: true},
                    {header: "<?php __('Is Active'); ?>", dataIndex: 'is_active', sortable: true},
                    {header: "<?php __('Security Question'); ?>", dataIndex: 'security_question', sortable: true, hidden: true},
                    {header: "<?php __('Security Answer'); ?>", dataIndex: 'security_answer', sortable: true, hidden: true},
                    {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true, hidden: true},
                    {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true, hidden: true}
            ],		
            view: new Ext.grid.GroupingView({
                forceFit:true,
                groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Users" : "User"]})'
            }),
            listeners: {
                celldblclick: function(){
                    ViewUser(Ext.getCmp('user-tab').getSelectionModel().getSelected().data.id);
                }
            },
            sm: new Ext.grid.RowSelectionModel({
                singleSelect: false
            }),
            tbar: new Ext.Toolbar({
                items: [
                    {
                        xtype: 'tbbutton',
                        text: '<?php __('Add'); ?>',
                        tooltip:'<?php __('Add User'); ?>',
                        icon: 'img/table_add.png',
                        cls: 'x-btn-text-icon',
                        handler: function(btn) {
                                AddUser();
                        }
                    },' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Edit'); ?>',
                        id: 'edit-user',
                        tooltip:'<?php __('Edit User'); ?>',
                        icon: 'img/table_edit.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                    EditUser(sel.data.id);
                            };
                        }
                    },' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('Delete'); ?>',
                        id: 'delete-user',
                        tooltip:'<?php __('Delete User'); ?>',
                        icon: 'img/table_delete.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelections();
                            if (sm.hasSelection()){
                                if(sel.length==1){
                                    Ext.Msg.show({
                                        title: '<?php __('Remove User'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                DeleteUser(sel[0].data.person_id);
                                            }
                                        }
                                    });
                                }else{
                                    Ext.Msg.show({
                                        title: '<?php __('Remove User'); ?>',
                                        buttons: Ext.MessageBox.YESNO,
                                        msg: '<?php __('Remove the selected Users'); ?>?',
                                        fn: function(btn){
                                            if (btn == 'yes'){
                                                var sel_ids = '';
                                                for(i=0;i<sel.length;i++){
                                                    if(i>0)
                                                        sel_ids += '_';
                                                    sel_ids += sel[i].data.person_id;
                                                }
                                                DeleteUser(sel_ids);
                                            }
                                        }
                                    });
                                }
                            } else {
                                Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
                            };
                        }
                    },' ', '-', ' ', {
                        xtype: 'tbbutton',
                        text: '<?php __('View User'); ?>',
                        id: 'view-user',
                        tooltip:'<?php __('View User'); ?>',
                        icon: 'img/table_view.png',
                        cls: 'x-btn-text-icon',
                        disabled: true,
                        handler: function(btn) {
                            var sm = p.getSelectionModel();
                            var sel = sm.getSelected();
                            if (sm.hasSelection()){
                                ViewUser(sel.data.id);
                            };
                        }
                    },' ', '-', '->', {
                        xtype: 'textfield',
                        emptyText: '<?php __('[Search By Name]'); ?>',
                        id: 'user_search_field',
                        listeners: {
                            specialkey: function(field, e){
                                if (e.getKey() == e.ENTER) {
                                    SearchByUserName(Ext.getCmp('user_search_field').getValue());
                                }
                            }
                        }
                    }, {
                        xtype: 'tbbutton',
                        icon: 'img/search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('GO'); ?>',
                        id: 'user_go_button',
                        handler: function(){
                            SearchByUserName(Ext.getCmp('user_search_field').getValue());
                        }
                    },'-', {
                        xtype: 'tbbutton',
                        icon: 'img/table_search.png',
                        cls: 'x-btn-text-icon',
                        text: '<?php __('Advanced Search'); ?>',
                        handler: function(){
                            SearchUser();
                        }
                    }
                ]
            }),
            bbar: new Ext.PagingToolbar({
                pageSize: list_size,
                store: store_users,
                displayInfo: true,
                displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
                beforePageText: '<?php __('Page'); ?>',
                afterPageText: '<?php __('of {0}'); ?>',
                emptyMsg: '<?php __('No data to display'); ?>'
            })
	});
	p.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
            p.getTopToolbar().findById('edit-user').enable();
            p.getTopToolbar().findById('delete-user').enable();
            p.getTopToolbar().findById('view-user').enable();
            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('edit-user').disable();
                p.getTopToolbar().findById('view-user').disable();
            }
	});
	p.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
            if(this.getSelections().length > 1){
                p.getTopToolbar().findById('edit-user').disable();
                p.getTopToolbar().findById('view-user').disable();
                p.getTopToolbar().findById('delete-user').enable();
            }
            else if(this.getSelections().length == 1){
                p.getTopToolbar().findById('edit-user').enable();
                p.getTopToolbar().findById('view-user').enable();
                p.getTopToolbar().findById('delete-user').enable();
            }
            else{
                p.getTopToolbar().findById('edit-user').disable();
                p.getTopToolbar().findById('view-user').disable();
                p.getTopToolbar().findById('delete-user').disable();
            }
	});
	center_panel.setActiveTab(p);
	
	store_users.load({
            params: {
                start: 0,          
                limit: list_size
            }
	});
	
}
