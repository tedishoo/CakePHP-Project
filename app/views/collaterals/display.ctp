<?php $output = '
		<style>
   table {border-collapse:collapse; table-layout:fixed;width:100%;}
   table th {width:80px; word-wrap:break-word;}
   </style>
		
	<h1 align="center"><img src="http://localhost/AbayERP/app/webroot/img/logo.png" /></h1>			
	<h4>&nbsp;</h4>
	<h2 align="center">Insurance</h2>
	<h4 align="center">' .$this->data['Collateral']['title'].'</h4>			
	<p align="left"> Until Date :<b>'. $until.'</b></p>	
	<table width="100%" border="1">
	<tr bgcolor="#ccccdd">
		<th>Full Name</th>
        <th>Account n<u>o</u></th>
		<th>Collateral Type</th>
		<th>Owner</th>
		<th>Insurance Company</th>
		<th>Insurance Type</th>
		<th>Date Insured</th>
		<th>Amount Insured</th>
		<th>Expire Date</th>
	</tr>';   	
		for($i=0;$i<count($result);$i++)
		{
			if($i%2 == 0){
				$output.='<tr bgcolor="">';
			}
			else{
				$output.='<tr bgcolor="#E0F8F1">';
			}
			$output.='
			<td>'.$result[$i][0].'</td>
			<td>'.$result[$i][1].'</td>
			<td>'.$result[$i][2].'</td>
			<td>'.$result[$i][3].'</td>
			<td>'.$result[$i][4].'</td>
			<td>'.$result[$i][5].'</td>
			<td>'.$result[$i][6].'</td>
			<td>'.$result[$i][7].'</td>
			<td>'.$result[$i][8].'</td>
			</tr>';
		}
    $output.='</table>';

if ($this->data['Collateral']['type'] == 'HTML') {				
	echo $output;
}
 if ($this->data['Collateral']['type'] == 'EXCEL') {
	$file = date("F",strtotime($date)) . ".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $output;
 }
 if ($this->data['Collateral']['type'] == 'PDF') { 
	$file = date("F",strtotime($date)) . ".pdf";
	header("Content-type:application/pdf");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Disposition:inline;filename=$file");
	require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
	$h2p = new HTML2PDF('L', 'A4', 'en');	
	$h2p->writeHTML($output); 	
	$h2p->Output($file);  
	readfile($h2p);	
 }			
