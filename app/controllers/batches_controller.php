<?php
class BatchesController extends AppController {

	var $name = 'Batches';
	
	function index() {
	}
	
	function report($id = null) {
		$this->set('reportId',$id);
	}
	
	function report_1($id = null) {	
		$this->layout = 'ajax';
        if (!empty($this->data)) {
            $date=$this->data['Batch']['date'];			
			$date = date_create($date);
			$date = date_format($date, 'Y-M-d');
			$monthY = date('M-Y', strtotime($date));
			$this->Batch->recursive =-1;
			$conditions =array('Batch.id' => $id);  			
			$Batch = $this->Batch->read(null,$id);
			$month = date('n', strtotime($date));
			$year = date('Y', strtotime($date));
			
			if ($month == $Batch['Batch']['month'] and $year == $Batch['Batch']['year']) {
				$this->loadModel('FlexCube');
				$query = "select 
								nvl(table_4_5.\"liab_branch\",table_1_1.\"2BI\") \"2-Branch ID\"
								,nvl(table_4_5.\"user_refno\",table_1_1.\"3ARN\") \"3-Account Reference Number\"
								,to_char(nvl(table_4_5.\"line_start_date\",table_1_1.\"4DAO\"),'yyyymmdd') \"4-Date Account Opened\"
								,to_char(nvl(null,table_1_1.\"6OBCL\"),'999999999999.00') \"6-Opening Balance/Credit limit\"
								,to_char(nvl(table_4_5.\"line_expiry_date\",table_1_1.\"10MD\"),'yyyymmdd') \"10-Maturity Date\"
								,to_char(nvl(null,table_1_1.\"11PDD\"),'yyyymmdd') \"11-Payment Due Date\"
								,case table_2_3.\"12RFC\" when 'W' then '8' when 'H' then '5' 
								  when 'M' then '3' when 'Q' then '4'
									when 'D' then '2' when 'Y' then '6' when 'B' then '7'
									  else (select '10' from dual)
								  END \"12-Repayment Frequency Code\"
								,to_char(nvl(table_4_5.\"limit_amount\",table_2_3.\"13TIA\"),'999999999999.99') \"13-Total Installment Amount\"
								,to_char(nvl(null,table_2_3.\"14IA\"),'999999999999.99') \"14-Installment Amount\"
								,nvl(table_2_3.\"16NOI\",(select '180' from dual)) \"16-Number of Installment\"
								,/*table_1_1.\"17OLT\"*/
								case table_2_3.\"12RFC\" 
								  when 'M' then (table_2_3.\"16NOI\"*30) 
									when 'Q' then (table_2_3.\"16NOI\"*90) 
									  when 'Y' then (table_2_3.\"16NOI\"*365) 
										else (select 180 from dual)
										  End  \"17-Original Loan Term(in Days)\"
								,to_char(nvl(table_2_3.\"19IA\",(select '0' from dual)),'999999999999.00') \"19-Interest Amount\"
								,table_4_5.\"20OSB\" \"20-Current Balance Amount\"
								,to_char(nvl(table_4_5.\"LATEST_TXN_DATE\",table_1_1.\"22DPR\"),'yyyymmdd') \"22-DateofLast Payment Received\"
								,case table_1_1.\"23CASC\" 
								 when 'NORM' then '1' when 'SPA' then '2' 
								  when 'PASS' then '1' when 'SUBS' then '3'
									when 'DOUB' then '4' when 'LOSS' then '5'
									  else NULL
								  END \"23-Credit Account Status Code\"
								,to_char(nvl(null,table_1_1.\"24DS\"),'yyyymmdd') \"24-Date Settled\"
								,to_char(table_1_1.\"25LSC\",'yyyymmdd') \"25-Last Status Change\"---not done
								,to_char(nvl(table_4_5.\"DATE_OF_LAST_OD\",table_1_1.\"24DS\"),'yyyymmdd') \"26-Account Closure Date\" 
								,to_char(nvl(table_4_5.\"limit_amount\",table_2_3.\"39OLA\"),'999999999999.00') \"39-OutstandingLoanArrears\"
								,to_char(nvl(table_4_5.\"limit_amount\",table_1_1.\"40AA\"),'999999999999.00') \"40-Approved Amount\"

									from (
								select 
								K.branch_code \"2BI\",
								K.account_number \"3ARN\",
								K.original_st_date \"4DAO\",
								K.amount_disbursed \"6OBCL\",
								k.MATURITY_DATE \"10MD\",
								(

								select MIN(SCHEDULE_DUE_DATE) from abyfclive.CLTB_ACCOUNT_SCHEDULES w
								 where  W.component_name='PRINCIPAL' and  W.amount_settled=0 AND w.account_number=K.ACCOUNT_NUMBER

								) \"11PDD\",
								(
								K.maturity_date-K.original_st_date
								) \"17OLT\",  
								K.user_defined_status \"23CASC\",
								(select MATURITY_DATE  from abyfclive.CLTB_ACCOUNT_MASTER jj where jj.account_status='L' and jj.ACCOUNT_NUMBER=k.ACCOUNT_NUMBER
								)\"26ACD\"  ,
								K.amount_financed \"40AA\",tb_25.ldt \"22DPR\",
								(select max(b.value_date)zz from abyfclive.CLTB_EVENT_ENTRIES b
								where K.ACCOUNT_STATUS='L' and K.ACCOUNT_NUMBER=b.account_number 
								group by K.account_number

								) \"24DS\" ,
								(
								select max(value_date) vd from abyfclive.CLTB_EVENT_ENTRIES B 
								where event_code='STCH' 
								and  K.ACCOUNT_NUMBER=b.account_number 


								) \"25LSC\" 




								 from
								abyfclive.CLTB_ACCOUNT_MASTER K 
								left join
								(
								select distinct account_number, max(value_date)ldt  from abyfclive.CLTB_EVENT_ENTRIES t_2 
								where amount_tag='PRINCIPAL_LIQD' group by t_2.ACCOUNT_NUMBER
								)tb_25
								on(k.account_number=tb_25.account_number)

								where k.VALUE_DATE <= '{$date}'  
								)table_1_1

								full join

								(
								select
								w.account_number,


								(select sum(v.emi_amount) from abyfclive.CLTB_ACCOUNT_SCHEDULES v 
								where w.account_number=v.account_number group by v.account_number) \"13TIA\",
								(select max(v.emi_amount) from abyfclive.CLTB_ACCOUNT_SCHEDULES v 
								where w.account_number=v.account_number group by v.account_number) \"14IA\",
								(select sum(amount_due)mint from abyfclive.CLTB_ACCOUNT_SCHEDULES x
								where component_name='MAIN_INT' and w.account_number=x.account_number) \"19IA\",
								(select sum(amount_due)-sum(amount_settled) from abyfclive.CLTB_ACCOUNT_SCHEDULES arr where arr.account_number=w.account_number
								and   arr.schedule_due_date <= '{$date}'  
								 )\"39OLA\",
								c.unit  \"12RFC\",
								( select count(account_number) from abyfclive.CLTB_ACCOUNT_SCHEDULES Where account_number=w.account_number and component_name='PRINCIPAL')\"16NOI\" from abyfclive.CLTB_ACCOUNT_SCHEDULES W 

								full join

								 abyfclive.CLTB_ACCOUNT_COMP_SCH C 
								on(c.account_number=w.account_number)
								where /*c.unit!='B' and c.unit!='D'
								and*/ c.no_of_schedules=(select max(jaz.no_of_schedules) from abyfclive.CLTB_ACCOUNT_COMP_SCH jaz where jaz.account_number=c.account_number)
								and w.schedule_due_date <= '{$date}' 

								 group by w.account_number,c.unit,c.no_of_schedules
								)table_2_3

								on
								(table_1_1.\"3ARN\"=table_2_3.account_number)
								full join
								(select  distinct 
									nvl(d.liab_branch,bi.branch_code) \"liab_branch\",
									nvl(d.user_refno,bi.account_number) \"user_refno\",
									d.line_start_date \"line_start_date\",
									d.LIMIT_AMOUNT \"LIMIT_AMOUNT\",
									d.line_expiry_date \"line_expiry_date\",
									d.limit_amount \"limit_amount\",
									d.LATEST_TXN_DATE \"LATEST_TXN_DATE\",
									d.DATE_OF_LAST_OD \"DATE_OF_LAST_OD\",
									bi.MAX_OUST_AMT \"20OSB\"
									from
									ABYFCLIVE.CLVWS_MONTHLY_ACC_OUT_BAL bi full join abyfclive.GEVW_UTIL_DETAILS d 
									on(d.USER_REFNO=bi.account_number)
									where bi.max_oust_mon_yr = '{$monthY}')table_4_5

									on(table_1_1.\"3ARN\"=table_4_5.\"user_refno\")";							
								

				$loan = $this->FlexCube->query($query);				
				$result = array();
				$count =0;
				$this->loadModel('Account');
				$this->loadModel('Branch');
				for($i=0;$i<count($loan);$i++){
					
					$conditions =array('Account.account_ref_no' =>$loan[$i]['K']['3arn']);
					$this->Account->recursive = -1;
					$account = $this->Account->find('first', array('conditions' => $conditions));
					
					if(!empty($account)){
						$result[$count]['Name of Customer'] = preg_replace('/\s\s+/', ' ', $account['Account']['first_name']);
						$result[$count]['Middle Name'] = preg_replace('/\s\s+/', ' ', $account['Account']['middle_name']);
						$result[$count]['Last Name'] = preg_replace('/\s\s+/', ' ', $account['Account']['last_name']);
						
						$result[$count]['Record Type Indicator'] = 'D';
						
						
						$conditions =array('Branch.flex_code' =>$loan[$i][0]['2BI']);
						$this->Branch->recursive = -1;
						$branch = $this->Branch->find('first', array('conditions' => $conditions));					
						$result[$count]['Branch ID'] = $branch['Branch']['nbe_code'];
						
						$result[$count]['Account Reference Number'] = $loan[$i]['K']['3arn'];
						
						$dao = date_create($account['Account']['date_account_opened']);
						$dao = date_format($dao, 'Ymd');
						$result[$count]['Date Account Opened'] = $dao;
						
						$rd = date_create($date);
						$rd = date_format($rd, 'Ymd');
						$result[$count]['Reporting Date'] = $rd;
						
						$result[$count]['Opening Balance/Credit Limit'] = str_replace(' ', '', $loan[$i]['K']['6obcl']);
						$result[$count]['Opening Balance Indicator Code'] = $account['Account']['opening_balance_indicator'];
						$result[$count]['Credit Type Code'] = $account['Account']['credit_type_code'];
						$result[$count]['Product Type Code'] = $account['Account']['product_type_code'];
						$result[$count]['Maturity Date'] = $loan[$i]['k']['10md'];
						$result[$count]['Payment Due Date'] = $loan[$i][0]['11PDD'];
						/*if($account['Account']['account_ref_no'] == '247DTMS163031405')
						{
							pr($loan[$i]);
						}*/
						
						if($account['Account']['frequency_code'] == 0){
							$result[$count]['Repayment Frequency Code'] = $loan[$i][0]['17OLT'];
						}
						else {
							$result[$count]['Repayment Frequency Code'] = $account['Account']['frequency_code'];
						}						
						
						$result[$count]['Current Balance Amount'] = $loan[$i]['0']['account_number'];
						
						if($loan[$i][0]['11PDD'] == ''){
							$result[$count]['Total Installment Amount'] = number_format((float)0,2);
							$result[$count]['Installment Amount'] = number_format((float)0,2);
							$result[$count]['Interest Amount'] = number_format((float)0,2);
							$result[$count]['Current Balance Amount'] = number_format((float)0,2);
							
						}
						else{
							$result[$count]['Total Installment Amount'] = str_replace(' ', '', $loan[$i]['K']['23casc']);
							$ia = $loan[$i]['(select MATURITY_DATE  from abyfclive']['cltb_account_master jj where jj'];
							$result[$count]['Installment Amount'] = number_format(str_replace(' ', '', $loan[$i]['K']['6obcl']) / $loan[$i]['K']['22dpr'],2,'.','');
							$result[$count]['Interest Amount'] = number_format(($result[$count]['Total Installment Amount']) - ($result[$count]['Installment Amount']),2,'.','');
							//$result[$count]['Interest Amount'] = str_replace(' ', '', $loan[$i][0]['account_number']);
							$obla = str_replace(' ', '', $loan[$i]['sum(c']['no_of_schedules) 16noi from abyfclive']);
							
							//$result[$count]['Outstanding Balance of Loan in Arrears'] = number_format((float)$obla,2,'.','');
							
						}					
						
						
						if ($result[$count]['Current Balance Amount'] == 0 and $result[$count]['Repayment Frequency Code'] == 10){
							$result[$count]['Current Balance Indicator'] = 2;
						}						
						else if ($result[$count]['Repayment Frequency Code'] == 10) {
							$result[$count]['Current Balance Indicator'] = 1;
						}
						else if($loan[$i][0]['11PDD'] == ''){
							$result[$count]['Current Balance Indicator'] = 2;
						}
						else {
							$result[$count]['Current Balance Indicator'] = 1;
						}
						
						
						if($result[$count]['Current Balance Indicator'] == 1)
						{
							$result[$count]['Date Settled'] = '';
							$result[$count]['Account Closure Date'] = '';
						}
						else if($result[$count]['Current Balance Indicator'] == 2)
						{	
							if($result[$count]['Repayment Frequency Code'] != 10)
							{
								if(empty($loan[$i][0]['19IA'])){
									$result[$count]['Date Settled'] = $rd;
									$result[$count]['Account Closure Date'] = $rd;
								}
								else {
									$result[$count]['Date Settled'] = $loan[$i][0]['19IA'];
									$result[$count]['Account Closure Date'] = $loan[$i][0]['19IA'];
									//$result[$count]['Account Closure Date'] = $loan[$i]['c']['12rfc'];
								}
								
							}
							else
							{
								$result[$count]['Date Settled'] = $rd;
								$result[$count]['Account Closure Date'] = $rd;
							}
						}						
						
						if($result[$count]['Repayment Frequency Code'] == 9 or $result[$count]['Repayment Frequency Code'] == 10)
						{
							$result[$count]['Last Date Active'] = $rd;
						}
						
						$result[$count]['Number of Instalments'] = $loan[$i]['K']['22dpr'];						
						$result[$count]['Original Loan Term (In Days)'] = $loan[$i]['(select max(b']['value_date)zz from abyfclive'];
						$result[$count]['Admin Fee Amount'] = $account['Account']['admin_fee'];	
						$dlpr = date_create($loan[$i][0]['13TIA']);
						$dlpr = date_format($dlpr, 'Ymd');
						if($dlpr > $rd){
							$result[$count]['Date of Last Payment Received'] = $rd;
						}
						else $result[$count]['Date of Last Payment Received'] = $loan[$i][0]['13TIA'];
						
						$result[$count]['Credit Account Status Code'] = $account['Account']['credit_account_status_code'];
						$result[$count]['Risk Classification Code'] = $loan[$i][0]['14IA'];
						
						//$result[$count]['Last Status Change Date of Credit Account'] = $loan[$i]['(select sum(amount_due)-sum(amount_settled) from abyfclive']['cltb_account_schedules arr where arr'];
						$result[$count]['Last Status Change Date of Credit Account'] = $rd;
						
						if($loan[$i][0]['14IA'] == 1){
							
						}
						$result[$count]['Restructured Credit Account Ref No.'] = $account['Account']['restructured_credit_account_ref_no'];
						$result[$count]['Last Restructure Date'] = $account['Account']['last_restructure_date'];
						$result[$count]['Industry Sector Code'] = $account['Account']['industry_sector_code'];
						$result[$count]['Industry Sub Sector Code'] = $account['Account']['industry_sub_sector'];
						$result[$count]['Export Credit Guarantee Scheme Flag'] = $account['Account']['export_credit_guarante'];	
						if($account['Account']['restructured_credit_account_ref_no'] != ''){
							$result[$count]['Consent Flag Code'] = 1;
							$result[$count]['Resturcture Flag Code'] = 1;
						}
						else 
						{
							$result[$count]['Consent Flag Code'] = '';
							$result[$count]['Resturcture Flag Code'] = 2;
						}	
						
						if(str_replace(' ', '', $loan[$i]['0']['user_refno']) < str_replace(' ', '', $loan[$i]['K']['6obcl'])){
							$result[$count]['Approved Amount'] = '';
						}
						else $result[$count]['Approved Amount'] = str_replace(' ', '', $loan[$i]['0']['user_refno']);
						
						if($result[$count]['Credit Account Status Code'] == 1){
							$datem = new DateTime($rd);
							$interval = new DateInterval('P1M');

							$datem->sub($interval);
							$backmonth = $datem->format('Ymd');
							
							$result[$count]['Account Arrears Date'] = $backmonth;

							$result[$count]['Overdue Balance'] = number_format($result[$count]['Total Installment Amount'] * $result[$count]['Risk Classification Code'],2,'.','');
							
							if($result[$count]['Risk Classification Code'] > 1){
								$datearrears = new DateTime($rd);
								$rcc = $result[$count]['Risk Classification Code'] - 1;
								$interval = new DateInterval('P'.$rcc.'M');

								$datearrears->sub($interval);
								$backmontharrears = $datearrears->format('Ymd');
								
								$startTimeStamp = strtotime($backmontharrears);
								$endTimeStamp = strtotime($rd);

								$timeDiff = abs($endTimeStamp - $startTimeStamp);

								$numberDays = $timeDiff/86400;  // 86400 seconds in one day

								// and you might want to convert to integer
								$numberDays = intval($numberDays);
								
								$result[$count]['Number of Days in Arrears'] = $numberDays;
							}
							
							$result[$count]['Outstanding Balance of Loan in Arrears'] = $result[$count]['Current Balance Amount'];
							
						}
						else {
							$result[$count]['Account Arrears Date'] = '';
							$result[$count]['Overdue Balance'] = '';
							$result[$count]['Number of Days in Arrears'] = '';
							$result[$count]['Outstanding Balance of Loan in Arrears'] = '';
							if($result[$count]['Credit Account Status Code'] == 5){
								$result[$count]['Account Closure Reason Code'] = 3;
							}
							else if($result[$count]['Credit Account Status Code'] == 7){
								$result[$count]['Account Closure Reason Code'] = 5;
							}							
							else if($result[$count]['Credit Account Status Code'] == 3){
								$result[$count]['Account Closure Reason Code'] = 2;
							}
							else if($result[$count]['Credit Account Status Code'] == 4){
								$result[$count]['Account Closure Reason Code'] = 4;
							}
							else if($result[$count]['Credit Account Status Code'] == 8){
								$result[$count]['Account Closure Reason Code'] = 2;
							}
						}
						
						$count++;
					}
				}
				
				////////////////////////////////// depending on frequency code ///////////////////////////////////////////////////////////
					/*$conditionsa =array('Account.frequency_code' =>array(7,9,10));
					$this->Account->recursive = -1;
					$accountf = $this->Account->find('all', array('conditions' => $conditionsa));
					foreach($accountf as $af){
						$result[$count]['Name of Customer'] = preg_replace('/\s\s+/', ' ', $af['Account']['first_name']);
						$result[$count]['Middle Name'] = preg_replace('/\s\s+/', ' ', $af['Account']['middle_name']);
						$result[$count]['Last Name'] = preg_replace('/\s\s+/', ' ', $af['Account']['last_name']);
						
						$result[$count]['Record Type Indicator'] = 'D';						
						
						$queryaf = "SELECT BRANCH_CODE FROM ABYFCLIVE.STTM_CUST_ACCOUNT WHERE CUST_AC_NO =  '". $af['Account']['account_ref_no']."'";		
						$customeraf = $this->FlexCube->query($queryaf);						
						$conditionsb =array('Branch.flex_code' =>$customeraf[0][0]['BRANCH_CODE']);
						$this->Branch->recursive = -1;
						$branchc = $this->Branch->find('first', array('conditions' => $conditionsb));					
						$result[$count]['Branch ID'] = $branchc['Branch']['nbe_code'];
						
						$result[$count]['Account Reference Number'] = $af['Account']['account_ref_no'];
						
						$dao1 = date_create($af['Account']['date_account_opened']);
						$dao1 = date_format($dao1, 'Ymd');
						$result[$count]['Date Account Opened'] = $dao1;
						
						$rd1 = date_create($date);
						$rd1 = date_format($rd1, 'Ymd');
						$result[$count]['Reporting Date'] = $rd1;
						
						$result[$count]['Opening Balance/Credit Limit'] = '';
						$result[$count]['Opening Balance Indicator Code'] = $af['Account']['opening_balance_indicator'];
						$result[$count]['Credit Type Code'] = $af['Account']['credit_type_code'];
						$result[$count]['Product Type Code'] = $af['Account']['product_type_code'];
						$result[$count]['Maturity Date'] = '';
						$result[$count]['Payment Due Date'] = '';
						$result[$count]['Repayment Frequency Code'] = $af['Account']['frequency_code'];
						if($result[$count]['Payment Due Date'] == ''){
							$result[$count]['Total Installment Amount'] = number_format((float)0,2);
							$result[$count]['Installment Amount'] = number_format((float)0,2);
							$result[$count]['Interest Amount'] = number_format((float)0,2);
							$result[$count]['Outstanding Balance of Loan in Arrears'] = '';
						}
						else{
							$result[$count]['Total Installment Amount'] = '';							
							$result[$count]['Installment Amount'] = '';
							$result[$count]['Interest Amount'] = '';							
							$result[$count]['Outstanding Balance of Loan in Arrears'] = '';
						}
						
						if($af['Account']['frequency_code'] == 9 or $af['Account']['frequency_code'] == 10){
							$result[$count]['Last Date Active'] = $rd1;
						}
						$result[$count]['Number of Instalments'] = '';
						$result[$count]['Original Loan Term (In Days)'] = '';
						$result[$count]['Admin Fee Amount'] = $af['Account']['admin_fee'];
						if($result[$count]['Current Balance Amount'] == '0.00'){
							$result[$count]['Current Balance Indicator'] = 2;
						}
						else $result[$count]['Current Balance Indicator'] = 1;
						$result[$count]['Date of Last Payment Received'] = '';
						$result[$count]['Credit Account Status Code'] = '';
						$result[$count]['Date Settled'] = '';
						$result[$count]['Last Status Change Date of Credit Account'] = '';
						$result[$count]['Account Closure Date'] = '';
						$result[$count]['Restructured Credit Account Ref No.'] = $af['Account']['restructured_credit_account_ref_no'];
						$result[$count]['Industry Sector Code'] = $af['Account']['industry_sector_code'];
						$result[$count]['Industry Sub Sector Code'] = $af['Account']['industry_sub_sector'];
						$result[$count]['Export Credit Guarantee Scheme Flag'] = $af['Account']['export_credit_guarante'];						
						$result[$count]['Approved Amount'] = '';
						
						$count++;
					}*/
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$this->set('results',$result);
				$this->set('date',$date);
			}
			else {
				$this->Session->setFlash(__('The date selected does not belong to the batch. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		else{
			$this->Session->setFlash(__('please fill the required fields first.', true), '');
			$this->render('/elements/failure');
		}
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('batches', $this->Batch->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Batch->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid batch', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Batch->recursive = 2;
		$this->set('batch', $this->Batch->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$conditions =array('Batch.month' => $this->data['Batch']['month'],'Batch.year' => $this->data['Batch']['year']);  			
			$Batch = $this->Batch->find('all', array('conditions' => $conditions));
			if(count($Batch) == 0){
				$this->Batch->create();
				$this->autoRender = false;
				if ($this->Batch->save($this->data)) {
					$this->Session->setFlash(__('The batch has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The batch could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			}
			else if(count($Batch) > 0){
				$this->Session->setFlash(__('The batch could not be saved. already created.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid batch', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$conditions =array('Batch.month' => $this->data['Batch']['month'],'Batch.year' => $this->data['Batch']['year']);  			
			$Batch = $this->Batch->find('all', array('conditions' => $conditions));
			if(count($Batch) == 0){
				$this->autoRender = false;
				if ($this->Batch->save($this->data)) {
					$this->Session->setFlash(__('The batch has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The batch could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
			}
			else if(count($Batch) > 0){
				$this->Session->setFlash(__('The batch could not be saved. already created.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('batch', $this->Batch->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for batch', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Batch->delete($i);
                }
				$this->Session->setFlash(__('Batch deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Batch was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Batch->delete($id)) {
				$this->Session->setFlash(__('Batch deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Batch was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>