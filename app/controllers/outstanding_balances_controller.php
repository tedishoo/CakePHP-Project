<?php
class OutstandingBalancesController extends AppController {

	var $name = 'OutstandingBalances';
	
	function index() {
		$accounts = $this->OutstandingBalance->Account->find('all');
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
            $conditions['OutstandingBalance.account_id'] = $account_id;
        }
		
		$this->set('outstandingBalances', $this->OutstandingBalance->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->OutstandingBalance->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid outstanding balance', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->OutstandingBalance->recursive = 2;
		$this->set('outstandingBalance', $this->OutstandingBalance->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->OutstandingBalance->create();
			$this->autoRender = false;
			if ($this->OutstandingBalance->save($this->data)) {
				$this->Session->setFlash(__('The outstanding balance has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The outstanding balance could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$accounts = $this->OutstandingBalance->Account->find('list');
		$dates = $this->OutstandingBalance->Date->find('list');
		$this->set(compact('accounts', 'dates'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid outstanding balance', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->OutstandingBalance->save($this->data)) {
				$this->Session->setFlash(__('The outstanding balance has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The outstanding balance could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('outstanding__balance', $this->OutstandingBalance->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$accounts = $this->OutstandingBalance->Account->find('list');
		$dates = $this->OutstandingBalance->Date->find('list');
		$this->set(compact('accounts', 'dates'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for outstanding balance', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->OutstandingBalance->delete($i);
                }
				$this->Session->setFlash(__('Outstanding balance deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Outstanding balance was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->OutstandingBalance->delete($id)) {
				$this->Session->setFlash(__('Outstanding balance deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Outstanding balance was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>