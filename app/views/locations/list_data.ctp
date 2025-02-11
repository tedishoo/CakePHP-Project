
[
<?php
	$st = false;
	foreach($locations as $c){
		if($st) echo ",";
		CreateNode($c);
		$st = true;
	}
	
	function CreateNode($node){
		echo "{\n";
		echo "id:'" . $node['id'] . "',\n";
		echo "name:'" . $node['name'] . "',\n";
		echo "location_type:'" . $node['location_type'] . "',\n";
		echo "is_rural:'" . ($node['is_rural']? 'True': 'False') . "',\n";
		if(count($node['children']) > 0){
			echo "expanded: true,\n";
			echo "children:[\n";
			$started = false;
			foreach($node['children'] as $cnode){
				if($started) echo ",\n";
				CreateNode($cnode);
				$started = true;
			}
			echo "],\n";
		} else {
			echo "leaf:true\n";
		}
		echo "}\n";
	}
?>
]