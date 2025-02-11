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
 * @package       abvs
 * @subpackage    nma.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
            <?php __('CIC - Helper'); ?>
    </title>
    <style>
        /* style rows on mouseover */
        .x-grid3-row-over .x-grid3-cell-inner {
            font-weight: bold;
        }
    </style>
	<?php
            echo $this->Html->meta('icon');

            echo $this->Html->css('default') . "\n";
            echo $this->Html->css('extjs/resources/css/ext-all') . "\n";
            //echo $this->Html->css('extjs/resources/css/xtheme-access') . "\n";
            echo $this->Html->css('extjs/ux/css/ux-all') . "\n";

            echo $this->Html->script('extjs/adapter/ext/ext-base') . "\n";
            echo $this->Html->script('extjs/ext-all') . "\n";
            
            
	?>
	<script>
	Ext.onReady(function() {
		Ext.QuickTips.init();
		Ext.History.init();
		
		var list_size = 40;
		var view_list_size = 10;
		var editWin = null;
		Ext.Ajax.timeout = 60000;
        
		Ext.apply(Ext.form.VTypes, {
                    Currency:  function(v) {
                        return /^\d+\.\d{2}$/.test(v);
                    },
                    CurrencyText: 'Must be an amount of money.',
                    CurrencyMask: /[\d\.]/i
		});
		
		Ext.apply(Ext.form.VTypes, {
                    Decimal:  function(v) {
                        return /^\d+\.?\d*$/.test(v);
                    },
                    DecimalText: 'Must be a decimal.',
                    DecimalMask: /[\d\.]/i
		});

		function RefreshTopToolbar() {
                    Ext.Ajax.request({
                        url: "<?php echo $this->Html->url(array('controller' => 'pages', 'action' => 'toptoolbar')); ?>",
                        success: function(response, opts) {
                            var toolbar_data = response.responseText;
                            var mytoolbar = Ext.getCmp('mainViewPort').findById('north-panel').getBottomToolbar();

                            eval(toolbar_data);

                            Ext.getCmp('mainViewPort').findById('north-panel').getBottomToolbar().doLayout();
                            Ext.getCmp('mainViewPort').doLayout();
                        },
                        failure: function(response, opts) {
                            Ext.Msg.alert('Error', 'Cannot get the toolbar data. Error code: ' + response.status);
                        }
                    });
		}
		
		function BuildContainer() {
                    Ext.Ajax.request({
                        url: "<?php echo $this->Html->url(array('controller' => 'containers', 'action' => 'active_containers')); ?>",
                        success: function(response, opts) {
                            var container_data = response.responseText;
                            var mycontainer_panel = Ext.getCmp('mainViewPort').findById('west-panel');

                            eval(container_data);

                            if(Ext.getCmp('west-panel').getRootNode().hasChildNodes())
                                Ext.getCmp('west-panel').getRootNode().item(0).expand();

                            Ext.getCmp('mainViewPort').findById('west-panel').doLayout();
                            Ext.getCmp('mainViewPort').doLayout();
                        },
                        failure: function(response, opts) {
                            Ext.Msg.alert('Error', 'Cannot get the menu data. Error code: ' + response.status);
                        }
                    });
		}
		
            function getUrl(function_name) {
                switch (function_name) {
<?php foreach($permittedContainers as $permittedContainer) { ?>
<?php 		foreach($permittedContainer['links'] as $clink) { ?>
                    case "<?php echo $clink['function_name']; ?>":
                        return "<?php echo $this->Html->url(array('controller' => $clink['controller'], 'action' => $clink['action'], $clink['parameter'])); ?>";
                        break;
<?php 		} ?>
<?php } ?>
                    default : return function_name;
                }
            }

            function getFunctionName(url) {
                switch (url) {
<?php foreach($permittedContainers as $permittedContainer) { ?>
<?php 		foreach($permittedContainer['links'] as $clink) { ?>
                    case "<?php echo $this->Html->url(array('controller' => $clink['controller'], 'action' => $clink['action'], $clink['parameter'])); ?>":
                        return "<?php echo $clink['function_name']; ?>";
                        break;
<?php 		} ?>
<?php } ?>
                    default : return url;
                }
            }		
		
            var viewport = new Ext.Viewport({
                    layout: "border",
                    id: 'mainViewPort',
                    renderTo: Ext.getBody(),
                    items: [{
                        region: "north",
                        xtype: 'panel',
                        id: 'north-panel',
                        html: '<div id="header">&nbsp;<div>',
                        height: 28,
                        bbar: new Ext.Toolbar({
                            id: 'top-toolbar',
                            items: [
                            ]
                        })
                    }, {
                        xtype: 'treepanel',
                        id:'west-panel',
                        region:'west',
                        title: '<?php __('Main Menu'); ?>',
                        split:true,
                        width: 175,
                        minSize: 175,
                        maxSize: 300,
                        collapsible: true,
                        margins:'0 0 5 5',
                        cmargins:'0 5 5 5',
                        rootVisible:false,
                        lines:false,
                        autoScroll:true,
                        root: new Ext.tree.TreeNode('Main Menu'),
                        collapseFirst:false,
                        singleExpand: true,
                        animate: true,
                        useArrows: true
                    }, {
                        region: 'center',
                        id: 'centerPanel',
                        xtype: 'tabpanel',
                        resizeTabs: true,
                        minTabWidth: 150,
                        tabWidth:150,
                        enableTabScroll:true,
                        margins: '0 0 0 0',
                        plugins: new Ext.ux.TabCloseMenu(),
                        activeTab: 0,
                        items: [<?php echo $content_for_layout; ?>]
                    }, {
                        region: 'south',
                        xtype: 'panel',
                        html: '<center>Abay Bank &copy; 2009-2013 - www.abaybank.com.et</center>'
                    }]
		}); 
		
		RefreshTopToolbar();
		BuildContainer();
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
        
                echo $this->Html->script('handleamharic') . "\n";
                
		echo $scripts_for_layout . "\n";
	?>
</body>
</html>