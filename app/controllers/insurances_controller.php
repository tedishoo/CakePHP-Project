<?php
class InsurancesController extends AppController {

	var $name = 'Insurances';
	
	function index() {
		$collateral_details = $this->Insurance->CollateralDetail->find('all');
		$this->set(compact('collateral_details'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$collateraldetail_id = (isset($_REQUEST['collateraldetail_id'])) ? $_REQUEST['collateraldetail_id'] : -1;
		if($id)
			$collateraldetail_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($collateraldetail_id != -1) {
            $conditions['Insurance.collateral_detail_id'] = $collateraldetail_id;
        }
		
		$this->set('insurances', $this->Insurance->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Insurance->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid insurance', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Insurance->recursive = 2;
		$this->set('insurance', $this->Insurance->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Insurance->create();
			$this->autoRender = false;
			if ($this->Insurance->save($this->data)) {
				$this->Session->setFlash(__('The insurance has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The insurance could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$collateral_details = $this->Insurance->CollateralDetail->find('list');
		$this->set(compact('collateral_details'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid insurance', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Insurance->save($this->data)) {
				$this->Session->setFlash(__('The insurance has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The insurance could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('insurance', $this->Insurance->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$collateral_details = $this->Insurance->CollateralDetail->find('list');
		$this->set(compact('collateral_details'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for insurance', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Insurance->delete($i);
                }
				$this->Session->setFlash(__('Insurance deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Insurance was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Insurance->delete($id)) {
				$this->Session->setFlash(__('Insurance deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Insurance was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>