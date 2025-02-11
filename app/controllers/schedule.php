<?php
class CollateralsController extends AppController {

	var $name = 'Collaterals';	
	
	function main() {
		$this->layout = 'ajax';
        $this->loadModel('Adjustment'); 
		$adjustments = $this->Adjustment->find('all');
		foreach($adjustments as $adjustment){
			$date=date("Y-m-d");
			$date1 = str_replace('-', '/', $date);
			$date1 = date('Y-m-d',strtotime($date1 . "+1".$adjustment['Adjustment']['date']." days"));
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			
			$this->loadModel('Insurance'); 
			$this->Insurance->recursive =3;			
			$conditions =array('Insurance.expire_date <' => $tomorrow);
						 
			$insurances = $this->Insurance->find('all', array('conditions' => $conditions));
			
			if(count($insurances) > 0){
				$sup_tel=$adjustment['Adjustment']['mobile'];
				$message=urlencode('there are '.count($insurances).' insurances that are going to expire within '.$adjustment['Adjustment']['date'].' days.');
				file_get_contents('http://10.1.85.10/sms_manager/send.php?to='.$sup_tel.'&msg='.$message);
			}
			
		}
        			
    }
}
?>