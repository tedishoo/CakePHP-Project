<?php $output = '
		<style>
   table {border-collapse:collapse; width:100%;}
   table th {width:100px; word-wrap:break-word;}
   </style>		
		
	<p align="left"> Date:<b> '. $date.'</b></p>	
	<h4 align="center">' .$this->data['ImsCard']['title'].'</h4>

<table width="100%" border="1">
    <tr bgcolor="#ccccdd">
        <th colspan=3>Name of Customer</th>
		
		<th>Record Type Indicator</th>
		<th>Branch ID</th>
		<th width="100%">Account Reference Number</th>
		<th>Date Account Opened</th>
		<th>Reporting Date</th>
		<th>Opening Balance/Credit Limit</th>
		<th>Opening Balance Indicator Code</th>
		<th>Credit Type Code</th>
		<th>Product Type Code</th>
		<th>Maturity Date</th>
		<th>Payment Due Date</th>
		<th>Repayment Frequency Code</th>
		<th>Total Installment Amount</th>
		<th>Installment Amount</th>
		<th>Last Date Active</th>
		<th>Number of Instalments</th>
		<th>Original Loan Term (In Days)</th>
		<th>Admin Fee Amount</th>
		<th>Interest Amount</th>
		<th>Current Balance Amount</th>
		<th>Current Balance Indicator</th>
		<th>Date of Last Payment Received</th>
		<th>Credit Account Status Code</th>
		<th>Date Settled</th>
		<th>Last Status Change Date of Credit Account</th>
		<th>Account Closure Date</th>
		<th>Account Arrears Date</th>
		<th>Overdue Balance</th>
		<th>Number of Days in Arrears</th>
		<th>Account Closure Reason Code</th>
		<th>Risk Classification Code</th>
		<th>Resturcture Flag Code</th>
		<th>Last Restructure Date</th>
		<th>Restructured Credit Account Ref No.</th>
		<th>Industry Sector Code</th>
		<th>Industry Sub Sector Code</th>
		<th>Export Credit Guarantee Scheme Flag</th>
		<th>Consent Flag Code</th>
		<th>Outstanding Balance of Loan in Arrears</th>
		<th>Approved Amount</th>
		<th>Arrears Late Interest Amount Due</th>
		<th>Arrears Collected Ind Code</th>
		<th>Number of Days Uncollected Arrears Interest Due</th>
	</tr>';
	for($i=0;$i<count($results);$i++)
		{	
			
				$output.='<tr>				
					<td>'.$results[$i]['Name of Customer'].'</td>
					<td>'.$results[$i]['Middle Name'].'</td>
					<td>'.$results[$i]['Last Name'].'</td>
					<td>'.$results[$i]['Record Type Indicator'].'</td>
					<td>'.$results[$i]['Branch ID'].'</td>
					<td>'.$results[$i]['Account Reference Number'].'</td>			
					<td>'.$results[$i]['Date Account Opened'].'</td>
					<td>'.$results[$i]['Reporting Date'].'</td>
					<td>'.$results[$i]['Opening Balance/Credit Limit'].'</td>
					<td>'.$results[$i]['Opening Balance Indicator Code'].'</td>					
					<td>'.$results[$i]['Credit Type Code'].'</td>
					<td>'.$results[$i]['Product Type Code'].'</td>					
					<td>'.$results[$i]['Maturity Date'].'</td>				
					<td>'.$results[$i]['Payment Due Date'].'</td>
					<td>'.$results[$i]['Repayment Frequency Code'].'</td>
					<td>'.$results[$i]['Total Installment Amount'].'</td>
					<td>'.$results[$i]['Installment Amount'].'</td>
					<td>'.$results[$i]['Last Date Active'].'</td>
					<td>'.$results[$i]['Number of Instalments'].'</td>
					<td>'.$results[$i]['Original Loan Term (In Days)'].'</td>
					<td>'.$results[$i]['Admin Fee Amount'].'</td>
					<td>'.$results[$i]['Interest Amount'].'</td>
					<td>'.$results[$i]['Current Balance Amount'].'</td>
					<td>'.$results[$i]['Current Balance Indicator'].'</td>
					<td>'.$results[$i]['Date of Last Payment Received'].'</td>
					<td>'.$results[$i]['Credit Account Status Code'].'</td>
					<td>'.$results[$i]['Date Settled'].'</td>
					<td>'.$results[$i]['Last Status Change Date of Credit Account'].'</td>
					<td>'.$results[$i]['Account Closure Date'].'</td>
					<td>'.$results[$i]['Account Arrears Date'].'</td>
					<td>'.$results[$i]['Overdue Balance'].'</td>
					<td>'.$results[$i]['Number of Days in Arrears'].'</td>
					<td>'.$results[$i]['Account Closure Reason Code'].'</td>
					<td>'.$results[$i]['Risk Classification Code'].'</td>
					<td>'.$results[$i]['Resturcture Flag Code'].'</td>
					<td>'.$results[$i]['Last Restructure Date'].'</td>
					<td>'.$results[$i]['Restructured Credit Account Ref No.'].'</td>
					<td>'.$results[$i]['Industry Sector Code'].'</td>
					<td>'.$results[$i]['Industry Sub Sector Code'].'</td>
					<td>'.$results[$i]['Export Credit Guarantee Scheme Flag'].'</td>
					<td>'.$results[$i]['Consent Flag Code'].'</td>
					<td>'.$results[$i]['Outstanding Balance of Loan in Arrears'].'</td>
					<td>'.$results[$i]['Approved Amount'].'</td>
					<td>'.$results[$i]['Arrears Late Interest Amount Due'].'</td>
					<td>'.$results[$i]['Arrears Collected Ind Code'].'</td>
					<td>'.$results[$i]['Number of Days Uncollected Arrears Interest Due'].'</td></tr>';
				
		}
    $output.='  
</table><br/><br/>';

if ($this->data['ImsCard']['type'] == 'HTML') {				
	echo $output;
}
 if ($this->data['ImsCard']['type'] == 'EXCEL') {
	$file = $this->data['ImsCard']['title'] . ".xlsx";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $output;
 }
 if ($this->data['ImsCard']['type'] == 'PDF') { 
	$file = $this->data['ImsCard']['title'].".pdf";
	header("Content-Type:application/pdf");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Disposition:inline;filename=$file");
	require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
	$h2p = new HTML2PDF('L', 'A4', 'en');	
	$h2p->writeHTML($output); 	
	$h2p->Output($file);  
	readfile($h2p);	
 }			
