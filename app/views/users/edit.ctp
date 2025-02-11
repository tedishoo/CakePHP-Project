//<script>
<?php
    $this->ExtForm->create('User');
    $this->ExtForm->defineFieldFunctions();
    $this->ExtForm->create('Person');
    $this->ExtForm->defineFieldFunctions();
?>
				
var UserEditForm = new Ext.form.FormPanel({
	baseCls: 'x-plain',
	labelWidth: 130,
	labelAlign: 'right',
	url:'<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'Edit')); ?>',
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
                            <?php
                                $options0 = array('disabled' => 'true');
                                $options0['value'] = $user['User']['username'];
                                $this->ExtForm->input('username', $options0);
                            ?>,
                            <?php 
                                $options1 = array();
                                $options1['value'] = $user['User']['email'];
                                $this->ExtForm->input('email', $options1);
                            ?>,
                            <?php 
                                $options2 = array();
                                $options2['value'] = $user['User']['is_active'];
                                $this->ExtForm->input('is_active', $options2);
                            ?>,
                            <?php 
                                $options3 = array();
                                $options3['value'] = $user['User']['security_question'];
                                $this->ExtForm->input('security_question', $options3);
                            ?>,
                            <?php 
                                $options4 = array();
                                $options4['value'] = $user['User']['security_answer'];
                                $this->ExtForm->input('security_answer', $options4);
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
                                    $found = false;
                                    foreach($user['Group'] as $g){
                                        if($g['id'] == $key){
                                            $found = true;
                                            break;
                                        }
                                    }
?>
                                    { boxLabel: '<?php echo Inflector::humanize($value); ?>', name: '<?php echo "data[Group][" . $key . "]"; ?>', checked: <?php echo $found? 'true': 'false'; ?>}
<?php
                                    $st = true;
                                }
?>
                                ]
                            })	
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
					$options5 = array('anchor' => '90%');
					$options5['value'] = $user['Person']['first_name'];
					$this->ExtForm->input('first_name', $options5);
				?>,
				<?php 
					$options6 = array('anchor' => '90%');
					$options6['value'] = $user['Person']['middle_name'];
					$this->ExtForm->input('middle_name', $options6);
				?>,
				<?php 
					$options7 = array('anchor' => '90%');
					$options7['value'] = $user['Person']['last_name'];
					$this->ExtForm->input('last_name', $options7);
				?>,
				<?php 
					$options8 = array('anchor' => '50%');
					$options8['value'] = $user['Person']['birthdate'];
					$this->ExtForm->input('birthdate', $options8);
				?>,
				<?php 
					$options9 = array('anchor' => '80%');
					$options9['items'] = $birth_locations;
					$options9['value'] = $user['Person']['birth_location_id'];
					$this->ExtForm->input('birth_location_id', $options9);
				?>,
				<?php 
					$options10 = array('anchor' => '80%');
					$options10['items'] = $residence_locations;
					$options10['value'] = $user['Person']['residence_location_id'];
					$this->ExtForm->input('residence_location_id', $options10);
				?>,
				<?php 
					$options11 = array();
					$options11['value'] = $user['Person']['kebele_or_farmers_association'];
					$this->ExtForm->input('kebele_or_farmers_association', $options11);
				?>,
				<?php 
					$options12 = array('anchor' => '50%');
					$options12['value'] = $user['Person']['house_number'];
					$this->ExtForm->input('house_number', $options12);
				?>	
			]
		}],
		listeners: {
			tabchange: function(panel, tab) {
				if(tab.id == 'personal-info'){
					UserEditWindow.buttons[0].enable();
				}
			}
		}
	}
    });

    var UserEditWindow = new Ext.Window({
	title: '<?php __('Edit User'); ?>',
	width: 600,
	height:400,
	layout: 'fit',
	modal: true,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'right',
	items: UserEditForm,

	buttons: [{
            text: '<?php __('Save'); ?>',
            disabled: true,
            handler: function(btn){
                UserEditForm.getForm().submit({
                    waitMsg: '<?php __('Submitting your data...'); ?>',
                    waitTitle: '<?php __('Wait Please...'); ?>',
                    success: function(f,a){
                        Ext.Msg.show({
                            title: '<?php __('Success'); ?>',
                            buttons: Ext.MessageBox.OK,
                            msg: a.result.msg,
                            icon: Ext.MessageBox.INFO
                        });
                        UserEditWindow.close();
<?php if(isset($parent_id)){ ?>
                        RefreshParentUserData();
<?php } else { ?>
                        RefreshUserData();
<?php } ?>
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
            text: '<?php __('Reset'); ?>',
            handler: function(btn){
                UserEditForm.getForm().reset();
            }
	},{
            text: '<?php __('Cancel'); ?>',
            handler: function(btn){
                UserEditWindow.close();
            }
	}]
    });
