//<script>
    mytoolbar.removeAll();
    mytoolbar.addText('<b>Abay Bank <font color=red>Credit Information Center Helper </font><font color=blue>Pro</font></b>');
    mytoolbar.addSeparator();
    <?php
    if ($this->Session->check('Auth')) {
        ?>
        mytoolbar.addFill();
        mytoolbar.addText('Records Per Page:');
        mytoolbar.addField({
            xtype: 'combo',
            id: 'list_size_combo',
            store : new Ext.data.ArrayStore({
                fields : ['id', 'name'],
                data : [
                    ['20', '20'],
                    ['30' ,'30'],
                    ['40' ,'40'],
                    ['50' ,'50'],
                    ['100' ,'100'],
                    ['200' ,'200'],
                    ['300' ,'300']
                ]
            }),
            displayField : 'name',
            valueField : 'id',
            mode : 'local',
            value : '40',
            disableKeyFilter : true,
            triggerAction: 'all',
            listeners : {
                select : function(combo, record, index){
                    list_size = combo.getValue();
                }
            }
        });
        mytoolbar.addField({
            xtype: 'textfield',
            emptyText: '<?php __('[Function Name]'); ?>',
            id: 'container_function_field',
            listeners: {
                specialkey: function(field, e){
                    if (e.getKey() == e.ENTER) {
                        var the_url = getUrl(Ext.getCmp('container_function_field').getValue());
                        if(the_url == Ext.getCmp('container_function_field').getValue()) {
                            Ext.Msg.alert('Error', 'Function ' + the_url + ' is incorrect or you have no access to.');
                        } else {
                            Ext.Ajax.request({
                                url: the_url,
                                success: function(response, opts) {
                                    var my_data = response.responseText;
                                    var center_panel = Ext.getCmp('mainViewPort').findById('centerPanel');

                                    eval(my_data);
                                },
                                failure: function(response, opts) {
                                    Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Unable to open link:'); ?> ' + the_url + '. Error code: ' + response.status);
                                }
                            });
                        }
                    }
                }
            }
        });
        mytoolbar.addText('Welcome <b><?php echo $this->Session->read('Auth.User.username'); ?></b>');
        mytoolbar.addButton({
            xtype: 'tbbutton',
            text: 'Logout',
            handler: function(btn){
                Ext.Ajax.request({
                    url: '<?php echo $this->Html->url(array("controller" => "users", "action" => "logout")); ?>',
                    success: function(response, opts) {
                        Ext.Msg.alert('', '');
                        Ext.Msg.show({
                            title: '<?php __('Thanks'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: 'Thanks for using Credit Information Center Helper!',
                            icon: Ext.MessageBox.INFO,
                            fn: function() {
                                location = '<?php echo $this->Html->url(array('controller' => 'pages', 'action' => 'display')); ?>';
                                exit();
                            }
                        });
                    },
                    failure: function(response, opts) {
                        Ext.Msg.alert('Cannot be logged out. Error code: ' + response.status);
                    }
                });
            }
        });
        mytoolbar.addSeparator();
        mytoolbar.addButton({
            xtype: 'tbbutton',
            text: 'My Profile',
            handler: function(btn){
                EditUserProfile();
            }
        });
        mytoolbar.addText(' ');
        mytoolbar.addText(' ');

        <?php
    } else {
        ?>
        mytoolbar.addFill();
        mytoolbar.addButton({
            xtype: 'tbbutton',
            text: 'Login',
            handler: function(btn){
                loginWindow.show();
            }
        });
        mytoolbar.addSeparator();
        mytoolbar.addButton({
            xtype: 'tbbutton',
            text: 'Forgot Password?',
            handler: function(btn){
                forgotPasswordWindow.show();
            }
        });
        mytoolbar.addText(' ');
        mytoolbar.addText(' ');
        <?php
    }
    ?>

    function EditUserProfile() {
        Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'edit_profile')); ?>',
            success: function(response, opts) {
                var user_profile_data = response.responseText;

                eval(user_profile_data);

                UserEditProfileWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the user edit form. Error code'); ?>: ' + response.status);
            }
        });
    }
 