<?php
echo $this->Html->script('tiny_mce/tiny_mce.js');
?>

<?php
    echo $this->Html->scriptBlock(
        "function fileBrowserCallBack(field_name, url, type, win) {
            browserField = field_name;
            browserWin = win;
            window.open('" . Helper::url(array('controller' => 'images'))."', 'browserWindow', 'modal,width=600,height=400,scrollbars=yes');
        }"
    );
?>

<script type="text/javascript">
    tinyMCE.init({
        theme : "advanced",
        mode : "textareas",
        theme_advanced_toolbar_location : "top",
        //theme_advanced_buttons1 : 'forecolor, bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,undo,redo,|,link,unlink,|,image,emotions,code',
        //theme_advanced_buttons2 : '',
        //theme_advanced_buttons3 : '',
        //theme_advanced_toolbar_align : 'left',
        theme_advanced_path_location : 'bottom',
        extended_valid_elements : 'a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]',
        file_browser_callback: 'fileBrowserCallBack',
        convert_urls : false,
        relative_urls : false
    });
</script>