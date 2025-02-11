//<script>
<?php
    $this->ExtForm->create('User');
    $this->ExtForm->defineFieldFunctions();
    $this->ExtForm->create('Person');
    $this->ExtForm->defineFieldFunctions();
?>

var UserAddForm = new Ext.form.FormPanel({
    baseCls: 'x-plain',
    labelWidth: 130,
    labelAlign: 'right',
    url:'<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'Add')); ?>',
    items: {
        xtype:'tabpanel',
        activeTab: 0,
        height: 325,
        id: 'add_user_tabs',
        tabWidth: 185,
        defaults:{ bodyStyle:'padding:10px'}, 
        items:[{
            title:'Account Information',
            layout:'form',
            defaultType: 'textfield',
            items: [
                <?php 
                    $this->ExtForm->create('User');
                    $options0 = array('anchor' => '70%');
                    $this->ExtForm->input('username', $options0);
                ?>,
                <?php 
                    $options1 = array('inputType' => 'password', 'anchor' => '70%');
                    $this->ExtForm->input('password', $options1);
                ?>,
                <?php 
                    $options2 = array('anchor' => '90%');
                    $this->ExtForm->input('email', $options2);
                ?>,
                <?php 
                    $options3 = array();
                    $this->ExtForm->input('is_active', $options3);
                ?>,
                <?php 
                    $options4 = array();
                    $this->ExtForm->input('security_question', $options4);
                ?>,
                <?php 
                    $options5 = array();
                    $this->ExtForm->input('security_answer', $options5);
                ?>,
                new Ext.form.CheckboxGroup({
                    id:'myGroup',
                    xtype: 'checkboxgroup',
                    fieldLabel: 'Select Group',
                    itemCls: 'x-check-group-alt',
                    columns: 3,
                    items: [
<?php
                    $st = false;
                    foreach($groups as $key => $value){
                        if($st) echo ",";
?>
                        {
                            boxLabel: '<?php echo Inflector::humanize($value); ?>', 
                            name: '<?php echo "data[Group][" . $key . "]"; ?>'
                        }
<?php
                        $st = true;
                    }
?>
                    ]
                })
            ]
        }, {
            title:'Personal Information',
            id: 'personal-info',
            layout:'form',
            defaultType: 'textfield',

            items: [
                <?php 
                    $this->ExtForm->create('Person');
                    $options6 = array('anchor' => '90%', 'fieldLabel' => 'Name');
                    $this->ExtForm->input('first_name', $options6);
                ?>,
                <?php 
                    $options7 = array('anchor' => '90%', 'fieldLabel' => 'Father Name');
                    $this->ExtForm->input('middle_name', $options7);
                ?>,
                <?php 
                    $options8 = array('anchor' => '90%', 'fieldLabel' => 'G/Father Name');
                    $this->ExtForm->input('last_name', $options8);
                ?>,
                <?php 
                    $options9 = array('anchor' => '50%');
                    $this->ExtForm->input('birthdate', $options9);
                ?>,
                <?php 
                    $options10 = array('anchor' => '80%');
                    $options10['items'] = $birth_locations;
                    $this->ExtForm->input('birth_location_id', $options10);
                ?>,
                <?php 
                    $options11 = array('anchor' => '80%');
                    $options11['items'] = $residence_locations;
                    $this->ExtForm->input('residence_location_id', $options11);
                ?>,
                <?php 
                    $options12 = array();
                    $this->ExtForm->input('kebele_or_farmers_association', $options12);
                ?>,
                <?php 
                    $options13 = array('anchor' => '50%');
                    $this->ExtForm->input('house_number', $options13);
                ?>	
            ]
        }],
        listeners: {
            tabchange: function(panel, tab) {
                if(tab.id == 'personal-info'){
                    UserAddWindow.buttons[0].enable();
                    UserAddWindow.buttons[1].enable();
                }
            }
        }
    }
});

var UserAddWindow = new Ext.Window({
    title: '<?php __('Add User'); ?>',
    width: 600,
    height:400,
    layout: 'fit',
    modal: true,
    resizable: false,
    plain:true,
    bodyStyle:'padding:5px;',
    buttonAlign:'right',
    items: UserAddForm,

    buttons: [{
        text: '<?php __('Save'); ?>',
        disabled: true,
        handler: function(btn){
            UserAddForm.getForm().submit({
                waitMsg: '<?php __('Submitting your data...'); ?>',
                waitTitle: '<?php __('Wait Please...'); ?>',
                success: function(f,a){
                    Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
                    UserAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
                    RefreshParentUserData();
<?php } else { ?>
                    RefreshUserData();
<?php } ?>
                },
                failure: function(f,a){
                    Ext.Msg.alert('<?php __('Warning'); ?>', a.result.errormsg);
                }
            });
        }
    },{
        text: '<?php __('Save & Close'); ?>',
        disabled: true,
        handler: function(btn){
            UserAddForm.getForm().submit({
                waitMsg: '<?php __('Submitting your data...'); ?>',
                waitTitle: '<?php __('Wait Please...'); ?>',
                success: function(f,a){
                    Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('Successfully saved!'); ?>');
                    UserAddWindow.close();
<?php if(isset($parent_id)){ ?>
                    RefreshParentUserData();
<?php } else { ?>
                    RefreshUserData();
<?php } ?>
                },
                failure: function(f,a){
                    Ext.Msg.alert('<?php __('Warning'); ?>', a.result.errormsg);
                }
            });
        }
    },{
        text: '<?php __('Reset'); ?>',
        handler: function(btn){
            UserAddForm.getForm().reset();
        }
    },{
        text: '<?php __('Cancel'); ?>',
        handler: function(btn){
            UserAddWindow.close();
        }
    }]
});
