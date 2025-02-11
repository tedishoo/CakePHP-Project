<?php 
$pluralVar = Inflector::underscore($pluralVar);
$singularVar = Inflector::underscore($singularVar);
?>
{
	success:true,
	results: <?php echo "<?php echo \$results; ?>"; ?>,
	rows: [
<?php echo "<?php \$st = false; foreach(\${$pluralVar} as \${$singularVar}){ if(\$st) echo \",\"; ?>"; ?>
			{
<?php
				$started = false;
				foreach ($fields as $field) {
					$isKey = false;
					if($started) echo ",\n";
					if (!empty($associations['belongsTo'])) {
						foreach ($associations['belongsTo'] as $alias => $details) {
							if ($field === $details['foreignKey']) {
								$isKey = true;
								echo "\t\t\t\t\"" . Inflector::underscore($alias) . "\":\"<?php echo \${$singularVar}['{$alias}']['{$details['displayField']}']; ?>\"";
								break;
							}
						}
					}
					if ($isKey !== true) {
						echo "\t\t\t\t\"{$field}\":\"<?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>\"";
					}
					$started = true;
				}
				?>
			}<?php echo "\n<?php \$st = true; } ?>"; ?>
		]
}