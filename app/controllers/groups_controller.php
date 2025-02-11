<?php

/**
 * GroupsController
 * 
 * @package nma
 * @author Behailu
 * @copyright 2011
 * @version $Id$
 * @access public
 */
class GroupsController extends AppController {

	var $name = 'Groups';
	
	function index() {
	}
	
	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if($id) {
			$conditions['Permission.id'] = $id;
			$groups = $this->Group->Permission->find('first', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
			$groups = $groups['Group'];
			$this->set('groups', array('Group' => $groups));
			$this->set('results', count($groups));
		} else {
			$this->set('groups', $this->Group->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
			$this->set('results', $this->Group->find('count', array('conditions' => $conditions)));
		}
	}
	
	function list_data2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if($id) {
			$conditions['Permission.id'] = $id;
			$groups = $this->Group->Permission->find('first', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
			$groups = $groups['Group'];
			$this->set('groups', $groups);
			$this->set('results', count($groups));
		} else {
			$this->set('groups', $this->Group->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
			$this->set('results', $this->Group->find('count', array('conditions' => $conditions)));
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid group', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Group->recursive = 2;
		$this->set('group', $this->Group->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$permissions = explode(",", $this->data['Group']['Permission']);
            
			$this->data['Permission'] = array('Permission' => $permissions);
			
			$this->Group->create();
			$this->autoRender = false;
			if ($this->Group->save($this->data)) {
				$this->Session->setFlash(__('The group has been saved', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.', true));
				$this->render('/elements/failure');
			}
		}
		$permissions = $this->Group->Permission->find('list');
		$this->set(compact('permissions'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid group', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			
			$permissions = explode(",", $this->data['Group']['Permission']);
            
			$this->data['Permission'] = array('Permission' => $permissions);
			
			if ($this->Group->save($this->data)) {
				$this->Session->setFlash(__('The group has been saved', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.', true));
				$this->render('/elements/failure');
			}
		}
		$this->set('group', $this->Group->read(null, $id));

		$permissions = $this->Group->Permission->find('list');
		$this->set(compact('permissions'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for group', true));
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Group->delete($i);
                }
				$this->Session->setFlash(__('Group deleted', true));
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Group was not deleted', true));
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Group->delete($id)) {
				$this->Session->setFlash(__('Group deleted', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Group was not deleted', true));
				$this->render('/elements/failure');
			}
        }
	}
}
?>