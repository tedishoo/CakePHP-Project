<?php
class DatesController extends AppController {

	var $name = 'Dates';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('dates', $this->Date->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Date->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid date', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Date->recursive = 2;
		$this->set('date', $this->Date->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Date->create();
			$this->autoRender = false;
			if ($this->Date->save($this->data)) {
				$this->Session->setFlash(__('The date has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The date could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid date', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Date->save($this->data)) {
				$this->Session->setFlash(__('The date has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The date could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('date', $this->Date->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for date', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Date->delete($i);
                }
				$this->Session->setFlash(__('Date deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Date was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Date->delete($id)) {
				$this->Session->setFlash(__('Date deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Date was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>