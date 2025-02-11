<?php
class PeopleController extends AppController {

	var $name = 'People';
	
	function index() {
		$birthLocations = $this->Person->BirthLocation->find('all');
		$this->set(compact('birthLocations'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$birthlocation_id = (isset($_REQUEST['birthlocation_id'])) ? $_REQUEST['birthlocation_id'] : -1;
		if($id)
			$birthlocation_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($birthlocation_id != -1) {
            $conditions['Person.birthlocation_id'] = $birthlocation_id;
        }
		
		$this->set('people', $this->Person->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Person->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid person', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Person->recursive = 2;
		$this->set('person', $this->Person->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Person->create();
			$this->autoRender = false;
			if ($this->Person->save($this->data)) {
				$this->Session->setFlash(__('The person has been saved', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.', true));
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$birthLocations = $this->Person->BirthLocation->find('list');
		$residenceLocations = $this->Person->ResidenceLocation->find('list');
		$nationalities = $this->Person->Nationality->find('list');
		$this->set(compact('birthLocations', 'residenceLocations', 'nationalities'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid person', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Person->save($this->data)) {
				$this->Session->setFlash(__('The person has been saved', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.', true));
				$this->render('/elements/failure');
			}
		}
		$this->set('person', $this->Person->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$birthLocations = $this->Person->BirthLocation->find('list');
		$residenceLocations = $this->Person->ResidenceLocation->find('list');
		$nationalities = $this->Person->Nationality->find('list');
		$this->set(compact('birthLocations', 'residenceLocations', 'nationalities'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for person', true));
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Person->delete($i);
                }
				$this->Session->setFlash(__('Person deleted', true));
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Person was not deleted', true));
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Person->delete($id)) {
				$this->Session->setFlash(__('Person deleted', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Person was not deleted', true));
				$this->render('/elements/failure');
			}
        }
	}
}
?>