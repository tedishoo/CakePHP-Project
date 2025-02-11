//<script>
<?php
    $this->ExtForm->create('User');
    $this->ExtForm->defineFieldFunctions();
    $this->ExtForm->create('Person');
    $this->ExtForm->defineFieldFunctions();
?>

function ConfirmationPasswords(val){
    msg = "";

    new_pwd = Ext.getCmp('data[User][new_password]').getValue();
    con_pwd = Ext.getCmp('data[User][confirm_password]').getValue();

    if(new_pwd != con_pwd)
        msg += 'New password and its confirmation must match.<br />';

    if(msg == '') {
        Ext.getCmp('data[User][new_password]').clearInvalid();
        Ext.getCmp('data[User][confirm_password]').clearInvalid();
        return true; 
    }
    else
        return msg; 
}

var UserEditProfileForm = new Ext.form.FormPanel({
    baseCls: 'x-plain',
    labelWidth: 130,
    labelAlign: 'right',
    url: "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'edit_profile')); ?>",
    defaultType: 'textfield',
    items:{
        xtype:'tabpanel',
        activeTab: 0,
        height: 325,
        id: 'edit_user_tabs',
        tabWidth: 185,
        defaults:{ bodyStyle:'padding:10px'}, 
        items:[{
            title:'Account Information',
            layout:'form',
            defaultType: 'textfield',
            items: [
                <?php $this->ExtForm->create('User'); ?>
                <?php $this->ExtForm->input('id', array('hidden' => $user['User']['id'])); ?>,
                <?php $this->ExtForm->input('person_id', array('hidden' => $user['User']['person_id'])); ?>,
                <?php $this->ExtForm->input('is_active', array('xtype' => 'hidden', 'value' => $user['User']['is_active']? 'on': 'off')); ?>,
                <?php
                    $options1 = array();
                    $options1['value'] = $user['User']['username'];
                    $options1['disabled'] = 'true';
                    $this->ExtForm->input('username', $options1);
                ?>,
                <?php 
                    $options2 = array();
                    $options2['value'] = $user['User']['email'];
                    $this->ExtForm->input('email', $options2);
                ?>,
                <?php 
                    $options3 = array('inputType' => 'password', 'anchor' => '70%');
                    $this->ExtForm->input('old_password', $options3);
                ?>,
                <?php 
                    $options4 = array('inputType' => 'password', 'anchor' => '70%');
                    $options4['validator'] = 'ConfirmationPasswords';
                    $options4['id'] = 'data[User][new_password]';
                    $this->ExtForm->input('new_password', $options4);
                ?>,
                <?php 
                    $options5 = array('inputType' => 'password', 'anchor' => '70%');
                    $options5['validator'] = 'ConfirmationPasswords';
                    $options5['id'] = 'data[User][confirm_password]';
                    $this->ExtForm->input('confirm_password', $options5);
                ?>,
                <?php 
                    $options6 = array();
                    $options6['value'] = $user['User']['security_question'];
                    $this->ExtForm->input('security_question', $options6);
                ?>,
                <?php 
                    $options7 = array();
                    $options7['value'] = $user['User']['security_answer'];
                    $this->ExtForm->input('security_answer', $options7);
                ?>		
            ]
        },{
            title:'Personal Information',
            id: 'personal-info',
            layout:'form',
            defaultType: 'textfield',

            items: [
                <?php $this->ExtForm->create('Person'); ?>
                <?php $this->ExtForm->input('id', array('hidden' => $user['Person']['id'])); ?>,
                <?php
                    $options8 = array('anchor' => '90%');
                    $options8['value'] = $user['Person']['first_name'];
                    $options8['disabled'] = 'true';
                    $this->ExtForm->input('first_name', $options8);
                ?>,
                <?php 
                    $options9 = array('anchor' => '90%');
                    $options9['value'] = $user['Person']['middle_name'];
                    $options9['disabled'] = 'true';
                    $this->ExtForm->input('middle_name', $options9);
                ?>,
                <?php 
                    $options10 = array('anchor' => '90%');
                    $options10['value'] = $user['Person']['last_name'];
                    $options10['disabled'] = 'true';
                    $this->ExtForm->input('last_name', $options10);
                ?>,
                <?php 
                    $options11 = array('anchor' => '50%');
                    $options11['value'] = $user['Person']['birthdate'];
                    $options11['disabled'] = 'true';
                    $this->ExtForm->input('birthdate', $options11);
                ?>,
                <?php 
                    $options12 = array('anchor' => '80%');
                    $options12['items'] = $birth_locations;
                    $options12['value'] = $user['Person']['birth_location_id'];
                    $options12['disabled'] = 'true';
                    $this->ExtForm->input('birth_location_id', $options12);
                ?>,
                <?php 
                    $options13 = array('anchor' => '80%');
                    $options13['items'] = $residence_locations;
                    $options13['value'] = $user['Person']['residence_location_id'];
                    $this->ExtForm->input('residence_location_id', $options13);
                ?>,
                <?php 
                    $options14 = array();
                    $options14['value'] = $user['Person']['kebele_or_farmers_association'];
                    $this->ExtForm->input('kebele_or_farmers_association', $options14);
                ?>,
                <?php 
                    $options15 = array('anchor' => '50%');
                    $options15['value'] = $user['Person']['house_number'];
                    $this->ExtForm->input('house_number', $options15);
                ?>
            ]
        }],
        listeners: {
            tabchange: function(panel, tab) {
                if(tab.id == 'personal-info'){
                    UserEditProfileWindow.buttons[0].enable();
                }
            }
        }
    }
});

var UserEditProfileWindow = new Ext.Window({
    title: "<?php __('Edit My Profile'); ?>",
    width: 600,
    height:400,
    layout: 'fit',
    modal: true,
    resizable: false,
    plain:true,
    bodyStyle:'padding:5px;',
    buttonAlign:'right',
    items: UserEditProfileForm,

    buttons: [{
        text: "<?php __('Save'); ?>",
        disabled: true,
        handler: function(btn){
            UserEditProfileForm.getForm().submit({
                waitMsg: "<?php __('Submitting your data...'); ?>",
                waitTitle: "<?php __('Wait Please...'); ?>",
                success: function(f,a){
                    Ext.Msg.alert("<?php __('Success'); ?>", "'<?php __('Your profile saved successfully!'); ?>");
                    UserEditProfileWindow.close();
                },
                failure: function(f,a){
                    Ext.Msg.alert("<?php __('Warning'); ?>", a.result.errormsg);
                }
            });
        }
    },{
        text: "<?php __('Reset'); ?>",
        handler: function(btn){
            UserEditProfileForm.getForm().reset();
        }
    },{
        text: "<?php __('Cancel'); ?>",
        handler: function(btn){
            UserEditProfileWindow.close();
        }
    }]
});
