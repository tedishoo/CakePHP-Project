<?php
class CollateralDetailsController extends AppController {

	var $name = 'CollateralDetails';
	
	function index() {
		$collaterals = $this->CollateralDetail->Collateral->find('all');
		$this->set(compact('collaterals'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$collateral_id = (isset($_REQUEST['collateral_id'])) ? $_REQUEST['collateral_id'] : -1;
		if($id)
			$collateral_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($collateral_id != -1) {
            $conditions['CollateralDetail.collateral_id'] = $collateral_id;
        }
		
		$this->set('collateral_details', $this->CollateralDetail->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CollateralDetail->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid collateral detail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CollateralDetail->recursive = 2;
		$this->set('collateralDetail', $this->CollateralDetail->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->CollateralDetail->create();
			$this->autoRender = false;
			if ($this->CollateralDetail->save($this->data)) {
				$this->Session->setFlash(__('The collateral detail has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The collateral detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$collaterals = $this->CollateralDetail->Collateral->find('list');
		$this->set(compact('collaterals'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid collateral detail', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->CollateralDetail->save($this->data)) {
				$this->Session->setFlash(__('The collateral detail has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The collateral detail could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('collateral__detail', $this->CollateralDetail->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$collaterals = $this->CollateralDetail->Collateral->find('list');
		$this->set(compact('collaterals'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for collateral detail', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CollateralDetail->delete($i);
                }
				$this->Session->setFlash(__('Collateral detail deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Collateral detail was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CollateralDetail->delete($id)) {
				$this->Session->setFlash(__('Collateral detail deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Collateral detail was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>