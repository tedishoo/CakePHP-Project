<?php
//$return = '<A HREF="/categories/sid:'.$data['Category']['id'].'">';
//$return .= $data['Category']['name']."</A>";

$model = array_keys($data);
echo $html->link($data[$model[0]]['name'] . ' [' . $data[$model[1]]['name'] . ']', 
    array('action' => 'index', ($data[$model[0]]['id'] == $location_id)? '': $data[$model[0]]['id']),
    array('class' => ($data[$model[0]]['id'] == $location_id)? 'selected': ''));
?>