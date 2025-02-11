<?php
class CollateralsController extends AppController {

	var $name = 'Collaterals';
	
	function index() {
		$accounts = $this->Collateral->Account->find('all');
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
            $conditions['Collateral.account_id'] = $account_id;
        }
		
		$this->set('collaterals', $this->Collateral->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Collateral->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid collateral', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Collateral->recursive = 2;
		$this->set('collateral', $this->Collateral->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Collateral->create();
			$this->autoRender = false;
			if ($this->Collateral->save($this->data)) {
				$this->Session->setFlash(__('The collateral has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The collateral could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$accounts = $this->Collateral->Account->find('all');
		$this->set(compact('accounts'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid collateral', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Collateral->save($this->data)) {
				$this->Session->setFlash(__('The collateral has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The collateral could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('collateral', $this->Collateral->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$accounts = $this->Collateral->Account->find('all');
		$this->set(compact('accounts'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for collateral', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Collateral->delete($i);
                }
				$this->Session->setFlash(__('Collateral deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Collateral was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Collateral->delete($id)) {
				$this->Session->setFlash(__('Collateral deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Collateral was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function index_expired_insurance(){
		
	}
	
	function display($id = null) {
		$this->layout = 'ajax';
        if (!empty($this->data)) {
			$date=$this->data['Collateral']['date'];			
			$date1 = str_replace('-', '/', $date);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			
			$this->loadModel('Insurance'); 
			$this->Insurance->recursive =3;
			
			$conditions =array('Insurance.expire_date <' => $tomorrow);  
						 
			$insurance = $this->Insurance->find('all', array('conditions' => $conditions));
			
			$result = array();
			for($j=0;$j<count($insurance);$j++){			
						
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$result[$j][0] = $insurance[$j]['CollateralDetail']['Collateral']['Account']['first_name'].' '.$insurance[$j]['CollateralDetail']['Collateral']['Account']['middle_name'].' '.$insurance[$j]['CollateralDetail']['Collateral']['Account']['last_name'];
				$result[$j][1] = $insurance[$j]['CollateralDetail']['Collateral']['Account']['account_ref_no'];
				$result[$j][2] = $insurance[$j]['CollateralDetail']['type'];
				$result[$j][3] = $insurance[$j]['CollateralDetail']['Owner'];
				$result[$j][4] = $insurance[$j]['Insurance']['insurance_company'];				
				$result[$j][5] = $insurance[$j]['Insurance']['type'];
				$result[$j][6] = $insurance[$j]['Insurance']['date_insured'];
				$result[$j][7] = $insurance[$j]['Insurance']['amount_insured'];
				$result[$j][8] = $insurance[$j]['Insurance']['expire_date'];
			}
				
				$this->set('until',$date);
				$this->set('result',$result);
        }			
    }
}
?>