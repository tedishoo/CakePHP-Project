<?php
/**
 * Bake Template for Controller action generation.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.console.libs.template.objects
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
	
	function <?php echo $admin ?>index() {
<?php $compact = array(); ?>
<?php $filter_item = ''; ?>
<?php
	foreach (array('belongsTo') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = Inflector::underscore(Inflector::slug($this->_pluralName($associationName)));
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('all');\n";
				$compact[] = "'{$otherPluralName}'";
				$filter_item = strtolower($associationName);
				break;
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
	}
	
<?php if(count($modelObj->belongsTo) > 0){ ?>
	function <?php echo $admin ?>index2($id = null) {
		$this->set('parent_id', $id);
	}
<?php } ?>

	function <?php echo $admin ?>search() {
	}
	
	function <?php echo $admin ?>list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
<?php if($filter_item != '') { ?>
		$<?php echo $filter_item; ?>_id = (isset($_REQUEST['<?php echo $filter_item; ?>_id'])) ? $_REQUEST['<?php echo $filter_item; ?>_id'] : -1;
		if($id)
			$<?php echo $filter_item; ?>_id = ($id) ? $id : -1;
<?php } ?>
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
<?php if($filter_item != '') { ?>
		if ($<?php echo $filter_item; ?>_id != -1) {
            $conditions['<?php echo $currentModelName ?>.<?php echo $filter_item; ?>_id'] = $<?php echo $filter_item; ?>_id;
        }
<?php } ?>
		
		$this->set('<?php echo $pluralName ?>', $this-><?php echo $currentModelName ?>->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this-><?php echo $currentModelName ?>->find('count', array('conditions' => $conditions)));
	}

	function <?php echo $admin ?>view($id = null) {
		if (!$id) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__('Invalid <?php echo strtolower($singularHumanName) ?>', true));
			$this->redirect(array('action' => 'index'));
<?php else: ?>
			$this->flash(__('Invalid <?php echo strtolower($singularHumanName); ?>', true), array('action' => 'index'));
<?php endif; ?>
		}
		$this-><?php echo $currentModelName; ?>->recursive = 2;
		$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->read(null, $id));
	}

<?php $compact = array(); ?>
	function <?php echo $admin ?>add($id = null) {
		if (!empty($this->data)) {
			$this-><?php echo $currentModelName; ?>->create();
			$this->autoRender = false;
			if ($this-><?php echo $currentModelName; ?>->save($this->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved', true), '');
				$this->render('/elements/success');
<?php else: ?>
				$this->flash(__('<?php echo ucfirst(strtolower($currentModelName)); ?> saved.', true), array('action' => 'index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
<?php endif; ?>
			}
		}
<?php if($filter_item != ''){ ?>
		if($id)
			$this->set('parent_id', $id);
<?php } ?>
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = Inflector::underscore(Inflector::slug($this->_pluralName($associationName)));
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
				$compact[] = "'{$otherPluralName}'";
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
	}

<?php $compact = array(); ?>
	function <?php echo $admin; ?>edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__('Invalid <?php echo strtolower($singularHumanName); ?>', true), '');
			$this->redirect(array('action' => 'index'));
<?php else: ?>
			$this->flash(sprintf(__('Invalid <?php echo strtolower($singularHumanName); ?>', true)), array('action' => 'index'));
<?php endif; ?>
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this-><?php echo $currentModelName; ?>->save($this->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved', true), '');
				$this->render('/elements/success');
<?php else: ?>
				$this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.', true), array('action' => 'index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
<?php endif; ?>
			}
		}
		$this->set('<?php echo strtolower(Inflector::underscore(Inflector::slug($singularHumanName))); ?>', $this-><?php echo $currentModelName; ?>->read(null, $id));
		
<?php if($filter_item != ''){ ?>
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
<?php } ?>
			
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = Inflector::underscore(Inflector::slug($this->_pluralName($associationName)));
					echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
					$compact[] = "'{$otherPluralName}'";
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?>
	}

	function <?php echo $admin; ?>delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__('Invalid id for <?php echo strtolower($singularHumanName); ?>', true), '');
			$this->render('/elements/failure');
<?php else: ?>
			$this->flash(sprintf(__('Invalid <?php echo strtolower($singularHumanName); ?>', true)), array('action' => 'index'));
<?php endif; ?>
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this-><?php echo $currentModelName; ?>->delete($i);
                }
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted', true), '');
				$this->render('/elements/success');
<?php else: ?>
				$this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted', true), array('action' => 'index'));
<?php endif; ?>
            }
            catch (Exception $e){
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted', true), '');
<?php else: ?>
				$this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted', true), array('action' => 'index'));
<?php endif; ?>
				$this->render('/elements/failure');
            }
        } else {
            if ($this-><?php echo $currentModelName; ?>->delete($id)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted', true), '');
				$this->render('/elements/success');
<?php else: ?>
				$this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted', true), array('action' => 'index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted', true), '');
<?php else: ?>
				$this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted', true), array('action' => 'index'));
<?php endif; ?>
				$this->render('/elements/failure');
			}
        }
	}