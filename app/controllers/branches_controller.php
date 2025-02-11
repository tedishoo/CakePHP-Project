<?php
class BranchesController extends AppController {

	var $name = 'Branches';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('branches', $this->Branch->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Branch->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid branch', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Branch->recursive = 2;
		$this->set('branch', $this->Branch->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->loadModel('FlexCube');
			$query = "select branch_code,branch_name from abyfclive.fbtm_branch_info where branch_code = '". $this->data['Branch']['flex_code']."'";
			$branch = $this->FlexCube->query($query);
			
			foreach($branch as &$row){
				$row = Set::flatten($row);
			}
			if(count($branch) == 1){
				$this->Branch->create();
				$this->autoRender = false;
				if ($this->Branch->save($this->data)) {
					$this->Session->setFlash(__('The branch has been saved and flex branch name is '.$row['.'], true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The branch could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			}
			else if(count($branch) == 0){
				$this->Session->setFlash(__('The branch code does not exist in Flex cube. Please, try another.', true), '');
				$this->render('/elements/failure');
			}
			else{
				$this->Session->setFlash(__('The branch could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid branch', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->loadModel('FlexCube');
			$query = "select branch_code,branch_name from abyfclive.fbtm_branch_info where branch_code = '". $this->data['Branch']['flex_code']."'";
			$branch = $this->FlexCube->query($query);
			
			foreach($branch as &$row){
				$row = Set::flatten($row);
			}
			if(count($branch) == 1){
				$this->autoRender = false;
				if ($this->Branch->save($this->data)) {
					$this->Session->setFlash(__('The branch has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The branch could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			}
		}
		$this->set('branch', $this->Branch->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for branch', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Branch->delete($i);
                }
				$this->Session->setFlash(__('Branch deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Branch was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Branch->delete($id)) {
				$this->Session->setFlash(__('Branch deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Branch was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>