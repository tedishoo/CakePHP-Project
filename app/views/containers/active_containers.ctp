mycontainer_panel.root.removeAll();

function logout_user() {
    Ext.Ajax.request({
        url: '<?php echo $this->Html->url(array("controller" => "users", "action" => "logout")); ?>',
        success: function(response, opts) {
                location = "<?php echo $this->Html->url(array('controller' => 'back_office', 'action' => 'index')); ?>";
                exit();
        },
        failure: function(response, opts) {
                Ext.Msg.alert('Cannot be logged out. Error code: ' + response.status);
        }
    });
}
<?php

if($this->Session->check('PermittedContainers')) {
    $permittedContainers = $this->Session->read('PermittedContainers');
    foreach($permittedContainers as $permittedContainer) {
        if(count($permittedContainer['links']) == 0)
            continue;
?>
mycontainer_panel.root.appendChild(
    new Ext.tree.TreeNode({
        text: "<?php echo $permittedContainer['name']; ?>",
        id: "node<?php echo Inflector::camelize($permittedContainer['name']); ?>",
        cls: 'feeds-node ',
        singleClickExpand: true,
        expanded: true
    })
);

mycontainer_panel.getNodeById("node<?php echo Inflector::camelize($permittedContainer['name']); ?>").appendChild([
<?php $started = false; ?>
<?php foreach($permittedContainer['links'] as $clink) { ?>
<?php 	if($started) echo ","; ?>
            new Ext.tree.TreeNode({
                text: "<?php echo $clink['name']; ?>",
                iconCls: 'add32',
                listeners: {
                    click: function(btn) {
                        var the_function_name = getFunctionName("<?php echo $this->Html->url(array('controller' => $clink['controller'], 'action' => $clink['action'], $clink['parameter'])); ?>");
                        if(the_function_name == "<?php echo $this->Html->url(array('controller' => $clink['controller'], 'action' => $clink['action'], $clink['parameter'])); ?>") {
                            Ext.Msg.alert('Error', 'Function ' + the_function_name + ' is incorrect or you have no access to.');
                        } else {
                            Ext.getCmp('container_function_field').setValue(the_function_name);
                            Ext.Ajax.request({
                                url: "<?php echo $this->Html->url(array('controller' => $clink['controller'], 'action' => $clink['action'], $clink['parameter'])); ?>",
                                success: function(response, opts) {
                                    var my_data = response.responseText;
                                    var center_panel = Ext.getCmp('mainViewPort').findById('centerPanel');

                                    eval(my_data);
                                },
                                failure: function(response, opts) {
                                    if(response.status == 403) {
                                        Ext.Msg.alert("<?php __('Error'); ?>", "<?php __('Your Session has been expired. You should relog again.'); ?>");
                                        Ext.Msg.show({
                                            title:'Oooops!',
                                            msg: "<?php __('Your Session has been expired. You should relog again.'); ?>",
                                            buttons: Ext.Msg.OK,
                                            fn: logout_user,
                                            icon: Ext.Msg.ERROR
                                        });

                                    } else {
                                        Ext.Msg.alert("<?php __('Error'); ?>", "<?php __('Unable to open link:'); ?> <?php echo $clink['name']; ?>. Error code: " + response.status);
                                    }
                                }
                            });
                        }
                    }
                }
            })
        <?php 	if(!$started) { $started = true; } ?>
    <?php } ?>
]);
<?php
	}
?>

<?php
}
?>

