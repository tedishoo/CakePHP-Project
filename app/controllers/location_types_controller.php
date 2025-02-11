<?php
class LocationTypesController extends AppController {

	var $name = 'LocationTypes';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('locationTypes', $this->LocationType->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->LocationType->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid location type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->LocationType->recursive = 2;
		$this->set('locationType', $this->LocationType->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->LocationType->create();
			$this->autoRender = false;
			if ($this->LocationType->save($this->data)) {
				$this->Session->setFlash(__('The location type has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The location type could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid location type', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->LocationType->save($this->data)) {
				$this->Session->setFlash(__('The location type has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The location type could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('location__type', $this->LocationType->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for location type', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->LocationType->delete($i);
                }
				$this->Session->setFlash(__('Location type deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Location type was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->LocationType->delete($id)) {
				$this->Session->setFlash(__('Location type deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Location type was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>