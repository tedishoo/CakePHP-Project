<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       AbayGAPro
 * @subpackage    AbayGAPro.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php __('Login to CIC Helper'); ?>
        </title>
        <?php
            echo $this->Html->meta('icon');

            echo $this->Html->css('default') . "\n";
            echo $this->Html->css('extjs/resources/css/ext-all') . "\n";
            echo $this->Html->css('extjs/ux/css/ux-all') . "\n";

            echo $this->Html->script('extjs/adapter/ext/ext-base') . "\n";
            echo $this->Html->script('extjs/ext-all') . "\n";

        ?>
        <script>
            Ext.onReady(function() {
                Ext.QuickTips.init();
                Ext.History.init();
		
                Ext.Ajax.timeout = 60000;		
                if(Ext.isIE) {
                    var the_message = 'Sorry! Credit Information Center Helper is not working on Internet Explorer. <br/>';
                    the_message += '<br/>Please use Mozilla Firefox above 3.x and above, or any other browser.<br/><br/>Thank You';
                    
                    Ext.Msg.show({
                        title: 'Ah! Sorry!',
                        buttons: Ext.MessageBox.OK,
                        msg: the_message,
                        icon: Ext.MessageBox.ERROR
                    });
                } else {
                    var loginForm = new Ext.form.FormPanel({
                        baseCls: 'x-plain',
                        labelWidth: 55,
                        labelAlign: 'right',
                        url: "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login')); ?>",
                        defaultType: 'textfield',

                        items: [{
                            fieldLabel: 'Username',
                            name: 'data[User][username]',
                            allowBlank: false,
                            id: 'userName',
                            anchor:'100%'
                        },{
                            inputType: 'password',
                            fieldLabel: 'Password',
                            name: 'data[User][passwd]',
                            allowBlank: false,
                            anchor: '100%',
                            listeners: {
                                specialkey: function(field, e){
                                    if (e.getKey() == e.ENTER) {
                                        handleLogin();
                                    }
                                }
                            }
                        }]
                    });
                    
                    var loginWindow = new Ext.Window({
                        title: 'Login to Credit Information Center Helper',
                        width: 360,
                        autoHeight: true,
                        layout: 'fit',
                        modal: false,
                        resizable: false,
                        closable: false,
                        plain: true,
                        bodyStyle:'padding:5px;',
                        buttonAlign: 'right',
                        defaultButton: 0,
                        items: loginForm,

                        buttons: [{
                            text: 'Login',
                            type: 'submit',
                            handler: function(btn){
                                handleLogin();
                            }
                        }]
                    });
                    
                    function handleLogin() {
                        loginForm.getForm().submit({
                            waitMsg: "<?php __('Submitting your data...'); ?>",
                            waitTitle: "<?php __('Wait Please...'); ?>",
                            success: function(f,a){
                                Ext.Msg.show({
                                    title: "<?php __('Welcome'); ?>",
                                    buttons: Ext.MessageBox.OK,
                                    msg: 'Welcome to Credit Information Center Helper',
                                    icon: Ext.MessageBox.INFO
                                });
                                loginWindow.hide();
                                location = "<?php echo $this->Html->url(array('controller' => 'back_office', 'action' => 'index')); ?>";
                                exit();
                            },
                            failure: function(f,a){
                                Ext.Msg.show({
                                    title: "<?php __('Cannot Be Logged In'); ?>",
                                    buttons: Ext.MessageBox.OK,
                                    msg: a.result.errormsg,
                                    icon: Ext.MessageBox.ERROR
                                });
                            }
                        });
                    }
                    loginWindow.show();
                    Ext.getCmp('userName').focus();
                }
            });
        </script>
    </head>
    <body>

        <form id="history-form" class="x-hidden">
            <input type="hidden" id="x-history-field" />
            <iframe id="x-history-frame"></iframe>
        </form>
        <span id="app-msg" class="x-hidden"></span>

        <?php
        echo $this->Html->script('extjs/ux/ux-all') . "\n";
        echo $this->Html->script('ext_validators') . "\n";
        echo $this->Html->script('calendar-all') . "\n";
        echo $this->Html->script('calendar-list') . "\n";

        echo $scripts_for_layout . "\n";
        ?>
    </body>
</html>