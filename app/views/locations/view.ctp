//<script>
    var store_classification_childClassifications = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','parent','lft','rght'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'publications', 'action' => 'list_data', $classification['Classification']['id'])); ?>'	})
    });
    var store_classification_publications = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','title','isbn','barcode','edition','number_of_copies','detail','remark','category','classification','location','lendable','library','publisher','publication_type'		]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'publications', 'action' => 'list_data', $classification['Classification']['id'])); ?>'	})
    });
		
    <?php
    $classification_html = "<table cellspacing=3>" . "<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $classification['Classification']['name'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Parent Classification', true) . ":</th><td><b>" . $classification['ParentClassification']['name'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Lft', true) . ":</th><td><b>" . $classification['Classification']['lft'] . "</b></td></tr>" .
            "<tr><th align=right>" . __('Rght', true) . ":</th><td><b>" . $classification['Classification']['rght'] . "</b></td></tr>" .
            "</table>";
    ?>
    var classification_view_panel_1 = {
        html : '<?php echo $classification_html; ?>',
        frame : true,
        height: 80
    }
    var classification_view_panel_2 = new Ext.TabPanel({
        activeTab: 0,
        anchor: '100%',
        height:190,
        plain:true,
        defaults:{autoScroll: true},
        items:[
            {
                xtype: 'grid',
                loadMask: true,
                store: store_classification_childClassifications,
                title: '<?php __('ChildClassifications'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_classification_childClassifications.getCount() == '')
                            store_classification_childClassifications.reload();
                    }
                },
                columns: [
                    {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true}
                    ,					{header: "<?php __('Parent'); ?>", dataIndex: 'parent', sortable: true}
                    ,					{header: "<?php __('Lft'); ?>", dataIndex: 'lft', sortable: true}
                    ,					{header: "<?php __('Rght'); ?>", dataIndex: 'rght', sortable: true}
		
                ],
                bbar: new Ext.PagingToolbar({
                    pageSize: view_list_size,
                    store: store_classification_childClassifications,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of'); ?> {0}',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            },
            {
                xtype: 'grid',
                loadMask: true,
                store: store_classification_publications,
                title: '<?php __('Publications'); ?>',
                enableColumnMove: false,
                listeners: {
                    activate: function(){
                        if(store_classification_publications.getCount() == '')
                            store_classification_publications.reload();
                    }
                },
                columns: [
                    {header: "<?php __('Title'); ?>", dataIndex: 'title', sortable: true}
                    ,					{header: "<?php __('Isbn'); ?>", dataIndex: 'isbn', sortable: true}
                    ,					{header: "<?php __('Barcode'); ?>", dataIndex: 'barcode', sortable: true}
                    ,					{header: "<?php __('Edition'); ?>", dataIndex: 'edition', sortable: true}
                    ,					{header: "<?php __('Number Of Copies'); ?>", dataIndex: 'number_of_copies', sortable: true}
                    ,					{header: "<?php __('Detail'); ?>", dataIndex: 'detail', sortable: true}
                    ,					{header: "<?php __('Remark'); ?>", dataIndex: 'remark', sortable: true}
                    ,					{header: "<?php __('Category'); ?>", dataIndex: 'category', sortable: true}
                    ,					{header: "<?php __('Location'); ?>", dataIndex: 'location', sortable: true}
                    ,					{header: "<?php __('Lendable'); ?>", dataIndex: 'lendable', sortable: true}
                    ,					{header: "<?php __('Library'); ?>", dataIndex: 'library', sortable: true}
                    ,					{header: "<?php __('Publisher'); ?>", dataIndex: 'publisher', sortable: true}
                    ,					{header: "<?php __('Publication Type'); ?>", dataIndex: 'publication_type', sortable: true}
		
                ],
                bbar: new Ext.PagingToolbar({
                    pageSize: view_list_size,
                    store: store_classification_publications,
                    displayInfo: true,
                    displayMsg: '<?php __('Displaying'); ?> {0} - {1} <?php __('of'); ?> {2}',
                    beforePageText: '<?php __('Page'); ?>',
                    afterPageText: '<?php __('of'); ?> {0}',
                    emptyMsg: '<?php __('No data to display'); ?>'
                })
            }			]
    });

    var ClassificationViewWindow = new Ext.Window({
        title: '<?php __('View Classification'); ?>: <?php echo $classification['Classification']['name']; ?>',
        width: 500,
        height:345,
        minWidth: 500,
        minHeight: 345,
        modal: true,
        resizable: false,
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'center',
        items: [ 
            classification_view_panel_1,
            classification_view_panel_2
        ],

        buttons: [{
                text: '<?php __('Close'); ?>',
                handler: function(btn){
                    ClassificationViewWindow.hide();
                }
            }]
    });
