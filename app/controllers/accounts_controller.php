<?php
class AccountsController extends AppController {

	var $name = 'Accounts';
	
	function index() {
		
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('accounts', $this->Account->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Account->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid account', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Account->recursive = 2;
		$this->set('account', $this->Account->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->loadModel('FlexCube');			
			$query = "SELECT distinct customer_name,a.BRANCH_CODE ,a.ACCOUNT_NUMBER FROM ABYFCLIVE.CLTB_ACCOUNT_MASTER a,ABYFCLIVE.stvw_account_sumary b WHERE cust_no=customer_id and a.ACCOUNT_NUMBER = '". $this->data['Account']['account_ref_no']."'";		
			$customer = $this->FlexCube->query($query);				
			if(count($customer) == 1){					
				$this->Account->create();
				$this->autoRender = false;
				if($this->data['Account']['frequency_code'] == null){
					$this->data['Account']['frequency_code'] = 0;
				}
				if(empty($this->data['Account']['last_restructure_date'])){
					$this->data['Account']['last_restructure_date']  = null;
				}
				if ($this->Account->save($this->data)) {
					$this->Session->setFlash(__('The account has been saved and the customer name in Flex cube is '.$customer[0]['distinct ac_desc,a']['branch_code ,a'], true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The account could not be saved.', true), '');
					$this->render('/elements/failure');
				}
			}
			else if(count($customer) == 0){
				$this->Session->setFlash(__('The account reference number does not exist in Flex cube. Please, try another.', true), '');
				$this->render('/elements/failure');
			}
			else{
				$this->Session->setFlash(__('The account could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid account', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			//$this->loadModel('FlexCube');
			//$query = "SELECT distinct ac_desc,a.BRANCH_CODE ,a.ACCOUNT_NUMBER FROM ABYFCLIVE.CLTB_ACCOUNT_MASTER a,ABYFCLIVE.STTM_CUST_ACCOUNT b WHERE cust_no=customer_id and a.ACCOUNT_NUMBER = '". $this->data['Account']['account_ref_no']."'";		
			//$customer = $this->FlexCube->query($query);			
			//if(count($customer) == 1){
				$this->autoRender = false;
				if(empty($this->data['Account']['last_restructure_date'])){
					$this->data['Account']['last_restructure_date']  = null;
				}
				if ($this->Account->save($this->data)) {
					$this->Session->setFlash(__('The account has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The account could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			//}
		}
		$this->set('account', $this->Account->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for account', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Account->delete($i);
                }
				$this->Session->setFlash(__('Account deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Account was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Account->delete($id)) {
				$this->Session->setFlash(__('Account deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Account was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>