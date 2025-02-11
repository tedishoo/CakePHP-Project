<?php
class CreditsController extends AppController {

	var $name = 'Credits';
	
	function index() {
		$accounts = $this->Credit->Account->find('all');
		$this->set(compact('accounts'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$account_id = (isset($_REQUEST['account_id'])) ? $_REQUEST['account_id'] : -1;
		if($id)
			$account_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($account_id != -1) {
            $conditions['Credit.account_id'] = $account_id;
        }
		
		$this->set('credits', $this->Credit->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Credit->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid credit', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Credit->recursive = 2;
		$this->set('credit', $this->Credit->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Credit->create();
			$this->autoRender = false;
			if ($this->Credit->save($this->data)) {
				$this->Session->setFlash(__('The credit has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The credit could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$accounts = $this->Credit->Account->find('list');
		$batches = $this->Credit->Batch->find('list');
		$this->set(compact('accounts', 'batches'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid credit', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Credit->save($this->data)) {
				$this->Session->setFlash(__('The credit has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The credit could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('credit', $this->Credit->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$accounts = $this->Credit->Account->find('list');
		$batches = $this->Credit->Batch->find('list');
		$this->set(compact('accounts', 'batches'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for credit', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Credit->delete($i);
                }
				$this->Session->setFlash(__('Credit deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Credit was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Credit->delete($id)) {
				$this->Session->setFlash(__('Credit deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Credit was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>