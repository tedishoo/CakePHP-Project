{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($accounts as $account){ if($st) echo ","; ?>			{
				"id":"<?php echo $account['Account']['id']; ?>",
				"first_name":"<?php echo $account['Account']['first_name']; ?>",
				"middle_name":"<?php echo $account['Account']['middle_name']; ?>",
				"last_name":"<?php echo $account['Account']['last_name']; ?>",
				"account_ref_no":"<?php echo $account['Account']['account_ref_no']; ?>",
				"date_account_opened":"<?php echo $account['Account']['date_account_opened']; ?>",
				"opening_balance_indicator":"<?php echo $account['Account']['opening_balance_indicator'] == 1?'Credit Limit':'Opening Balance'; ?>",
				"credit_type_code":"<?php if($account['Account']['credit_type_code'] ==1) echo 'Line of Credit';
											else if($account['Account']['credit_type_code']==2) echo 'Revolving Credit';
											else if($account['Account']['credit_type_code']==3) echo 'Installment Credit';
											else echo 'Overdraft'; ?>",
				"product_type_code":"<?php if($account['Account']['product_type_code']==3) echo 'Student Loan';
												else if($account['Account']['product_type_code']==4) echo 'Over draft';
												else if($account['Account']['product_type_code']==7) echo 'Installment Credit';
												else if($account['Account']['product_type_code']==8) echo 'Revolving Installment Credit';?>",
				"frequency_code":"<?php if($account['Account']['frequency_code']==7) echo 'Bullet (One lump sum upon maturity)';
												else if($account['Account']['frequency_code']==9) echo 'Revolving';
												else if($account['Account']['frequency_code']==10) echo 'Overdraft';?>",
				"admin_fee":"<?php echo $account['Account']['admin_fee']; ?>",
				"credit_account_status_code":"<?php if($account['Account']['credit_account_status_code']==1) echo 'Outstanding and in Arrears';
												else if($account['Account']['credit_account_status_code']==2) echo 'Restructured Credit Facility';
												else if($account['Account']['credit_account_status_code']==3) echo 'Foreclosure';
												else if($account['Account']['credit_account_status_code']==4) echo 'Write-Off';
												else if($account['Account']['credit_account_status_code']==5) echo 'Settled in Full - Normal';
												else if($account['Account']['credit_account_status_code']==6) echo 'Current and within Terms';
												else if($account['Account']['credit_account_status_code']==7) echo 'Early Settlement';
												else if($account['Account']['credit_account_status_code']==8) echo 'Settled in Full - Foreclosure';
												else if($account['Account']['credit_account_status_code']==9) echo 'Account Closed in Error. Account Re-Opened';?>",
				"restructured_credit_account_ref_no":"<?php echo $account['Account']['restructured_credit_account_ref_no']; ?>",
				"last_restructure_date":"<?php echo $account['Account']['last_restructure_date']; ?>",
				"industry_sector_code":"<?php if($account['Account']['industry_sector_code']==1) echo 'Agriculture';
												else if($account['Account']['industry_sector_code']==2) echo 'Industries';
												else if($account['Account']['industry_sector_code']==3) echo 'Domestic Trade and Service';
												else if($account['Account']['industry_sector_code']==4) echo 'International Trade';
												else if($account['Account']['industry_sector_code']==5) echo 'Housing and Construction';
												else if($account['Account']['industry_sector_code']==6) echo 'Financial Institutions';
												else if($account['Account']['industry_sector_code']==7) echo 'Consumer Loan';?>",
				"industry_sub_sector":"<?php if($account['Account']['industry_sub_sector'] ==1) echo 'Temporary Crops';
												else if($account['Account']['industry_sub_sector'] ==2) echo 'Permanent Crops or Plantation';
												else if($account['Account']['industry_sub_sector'] ==3) echo 'Animal Husbandry';
												else if($account['Account']['industry_sub_sector'] ==4) echo 'Other Activity';
												else if($account['Account']['industry_sub_sector'] ==5) echo 'Large Scale';
												else if($account['Account']['industry_sub_sector'] ==6) echo 'Medium Scale';
												else if($account['Account']['industry_sub_sector'] ==7) echo 'Small Scale';
												else if($account['Account']['industry_sub_sector'] ==8) echo 'Mining and Quarrying';
												else if($account['Account']['industry_sub_sector'] ==9) echo 'Domestic Trade';
												else if($account['Account']['industry_sub_sector'] ==10) echo 'Transport Service';
												else if($account['Account']['industry_sub_sector'] ==11) echo 'Hotel and Tourism';
												else if($account['Account']['industry_sub_sector'] ==12) echo 'Rental Services';
												else if($account['Account']['industry_sub_sector'] ==13) echo 'Others';
												else if($account['Account']['industry_sub_sector'] ==14) echo 'Export';
												else if($account['Account']['industry_sub_sector'] ==15) echo 'Import';
												else if($account['Account']['industry_sub_sector'] ==16) echo 'Residential Building';
												else if($account['Account']['industry_sub_sector'] ==17) echo 'Commercial Building';
												else if($account['Account']['industry_sub_sector'] ==18) echo 'Other Constructions';
												else if($account['Account']['industry_sub_sector'] ==19) echo 'Banks / Insurance';
												else if($account['Account']['industry_sub_sector'] ==20) echo 'Micro Finance';
												else if($account['Account']['industry_sub_sector'] ==21) echo 'Personal Loan';
												else if($account['Account']['industry_sub_sector'] ==22) echo 'Condominium Loan';
												else if($account['Account']['industry_sub_sector'] ==23) echo 'Staff Mortgage Loan';
												else if($account['Account']['industry_sub_sector'] ==24) echo 'Other Mortgage Loan';?>",
				"export_credit_guarante":"<?php echo $account['Account']['export_credit_guarante']==1?'Yes':'No'; ?>",
				"created":"<?php echo $account['Account']['created']; ?>",
				"modified":"<?php echo $account['Account']['modified']; ?>"			}
<?php $st = true; } ?>		]
}