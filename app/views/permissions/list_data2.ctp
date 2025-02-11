
[
<?php
	$st = false;
	
	foreach($permissions as $c){
		if($st) echo ",";
		CreateNode($c, $sel_permissions);
		$st = true;
	}
	
	function CreateNode($node, $sel_permissions){
		echo "{\n";
		echo "id:'" . $node['id'] . "',\n";
		echo "text:'" . $node['name'] . ($node['prerequisite'] > 0? " ( >>>" . $node['prerequisite'] . ">>> " . $node['prerequisite2'] . ")": '') . "',\n";
		echo "qtip:'<b>Description</b><br>" . $node['description'] . " <br/><b>Prereqisite: " . $node['prerequisite2'] . "</b>',\n";
		if(count($node['children']) > 0){
			echo "children:[\n";
			$started = false;
			foreach($node['children'] as $cnode){
				if($started) echo ",\n";
				CreateNode($cnode, $sel_permissions);
				$started = true;
			}
			echo "],\n";
		} else {
			echo "leaf: true,\n";
			echo in_array($node['id'], $sel_permissions)? "checked: true": "checked: false\n";
		}
		echo "}\n";
	}
?>
]