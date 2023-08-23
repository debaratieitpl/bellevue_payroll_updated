<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bellevue</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css" media="print"> @page { size: auto; /* auto is the initial value */
   	margin-top: 0;
    margin-bottom: 0; /* this affects the margin in the printer settings */ }
   </style>
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <style>
body {-webkit-print-color-adjust: exact;}
  	.payslip{font-family:cambria;}
	.payslip .pay-head h2 {font-size: 35px;color: #000;text-align:center;margin:0;}
	.payslip .pay-head h4 {font-size: 19px;text-align:right;margin:0;}
	.payslip .pay-month{text-align:right;}
	.payslip .pay-month h3{margin:0;color: #0099be;}
	.pay-logo img {max-width: 80px;}
	.pay-head h5{margin:0;text-align:right;font-size:15px;}
	.emp-det{width:100%;}
	.emp-det thead tr th{text-align:center;}
	.emp-det thead tr th{border-bottom:none;}
	.emp-det thead tr th {border-bottom: none;background: #0099be;color: #fff;padding: 5px;font-size: 18px;}
	.emp-det tbody tr td{padding:10px;}
	table.emp-det tr td span {font-weight: 600;}
	.sal-det tr th {background: #a9a4a4;padding: 5px 10px;border-bottom: none;color: #000;text-align:center;}
	.sal-det tr.part td{padding:7px 10px;text-align:left;border-top:none;}
	.sal-det tr td{padding:7px 10px;text-align:left;}
	.sal-det tr td p{text-align:right;margin:0;}.mon{text-align:right;}.mon h3{color:#0099be;margin:0;font-size:25px;}.mon h4{margin:0;font-size: 24px;text-align: center;}
	.sal-det tr:nth-child(odd) {background-color: #f2f2f2;}
	.emp-det{margin-bottom:15px;}.total td{font-weight:600;}.leave{border-top:none;}
	.leave tr th{padding:7px 10px;text-align:left;}
  </style>
</head>
<body>
<!-------------------payslip-body------------------------->
<div class="payslip">
	<!-----------company-details----------->
		<table class="comp-det" style="width:100%;">
		<tr>
			<td>
			<div class="pay-logo">
				<img src="{{ asset('theme/images/bellevue-logo1.png') }}" alt="logo">
			</div>
			</td>
			<td>
				
				<div class="mon">
					
					<h4><?php echo ($req_type=='SA')? "Salary Advance" : "PF Loan"; ?> Recovery Report for <?php echo $req_month; ?> </h4>

				</div>
			</td>

			</tr>
		</table>
		@if($req_type=='PF')
            @php
            $employeeTotals = [];
            $index = 0; 
            @endphp
        
            @foreach ($result as $record)
                @php
                    $key = $record->emp_code;
            
                    if (!isset($employeeTotals[$key])) {
                        $employeeTotals[$key] = [
                            'index' => ++$index,
                            'emp_code' => $record->emp_code,
                            'old_emp_code' => $record->old_emp_code,
                            'emp_status' => $record->emp_status,
                            'emp_department' => $record->emp_department,
                            'emp_name' => "{$record->salutation} {$record->emp_fname} {$record->emp_mname} {$record->emp_lname}",
                            'loan_amount' => 0,
                            'payroll_deduction' => 0,
                            'pf_interest' => 0,
                            'balance' => 0,
                            'loanadjust' => 0,
                        ];
                    }
            
                    $balance = $record->recoveries === null ? $record->loan_amount : ($record->loan_amount - $record->recoveries);
                    $employeeTotals[$key]['loan_amount'] += $record->loan_amount;
                    $employeeTotals[$key]['payroll_deduction'] += $record->payroll_deduction;
                    $employeeTotals[$key]['pf_interest'] += $record->pf_iterest;
                    $employeeTotals[$key]['balance'] += $balance;
                    $employeeTotals[$key]['loanadjust'] += $record->adjust_amount;
            
                    $pf_interest = $record->pf_iterest;
                @endphp
            @endforeach
			<table border="1" class="sal-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">
				<thead>
                <tr>
					<th style="width:5%;">Sl. No.</th>
					<th style="width:12%;">Employee Code</th>
                    <th >Employee Department</th>
					<th>Employee Name</th>
					<th>Final PF Loan Balance</th>
				</tr>
				</thead>
                <tbody>
                    @foreach ($employeeTotals as $employee)
					    <tr>
                            <td>{{ $employee['index'] }}</td>
                            <td>{{ $employee['old_emp_code'] }}</td>
                            <td>{{ $employee['emp_department'] }}</td>
                            <td>{{ $employee['emp_name'] }}</td>
                            <td>{{ number_format($employee['balance'] - $employee['loanadjust'], 2) }}</td>
                   
					    </tr>
                    @endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" style="font-weight:700;">
						Grand Total
						</td>
						
						<td>
							<div class="total_balance" style="font-weight:700;">{{ number_format(array_sum(array_column($employeeTotals, 'balance')) - array_sum(array_column($employeeTotals, 'loanadjust')), 2) }}</div>
						</td>
					</tr>
				</tfoot>
			</table>
		@endif
		@if($req_type=='SA')

            @php
                $consolidatedData = [];
                $index = 0; 
            
                foreach ($result as $record) {
                    $empCode = $record->emp_code;
            
                    if (!isset($consolidatedData[$empCode])) {
                        $consolidatedData[$empCode] = [
                            'total_loan_amount' => 0,
                            'total_installment' => 0,
                            'total_balance' => 0,
                            'total_loanadjust' => 0,
                            'index' => ++$index,
                            'emp_code' => $record->emp_code,
                            'old_emp_code' => $record->old_emp_code,
                            'emp_status' => $record->emp_status,
                            'emp_department' => $record->emp_department,
                            'emp_name' => "{$record->salutation} {$record->emp_fname} {$record->emp_mname} {$record->emp_lname}",
                        ];
                    }
            
                    $balance = $record->recoveries === null ? $record->loan_amount : ($record->loan_amount - $record->recoveries);
            
                    // $consolidatedData[$empCode]['recordCount']++;
                    $consolidatedData[$empCode]['total_loan_amount'] += $record->loan_amount;
                    $consolidatedData[$empCode]['total_installment'] += $record->payroll_deduction;
                    $consolidatedData[$empCode]['total_balance'] += $balance;
                    $consolidatedData[$empCode]['total_loanadjust'] += $record->adjust_amount;
                }
            @endphp
			<table border="1" class="sal-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">
				<thead>
				<tr>
					<th style="width:5%;">Sl. No.</th>
					<th style="width:12%;">Employee Code</th>
                    <th >Employee Department</th>
					<th>Employee Name</th>
					<th>Final Balance Amount</th>
				</tr>
				</thead>
                <tbody>
					
                    @foreach ($consolidatedData as $empCode => $employee)
                        <tr>
                            <td>{{ $employee['index'] }}</td>
                            <td>{{ $employee['old_emp_code'] }}</td>
                            <td>{{ $employee['emp_department'] }}</td>
                            <td>{{ $employee['emp_name'] }}</td>
                            <td>{{ number_format($employee['total_balance'] - $employee['total_loanadjust'], 2) }}</td>
                            
                        </tr>
				    @endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" style="font-weight:700;">
						Grand Total
						</td>
						<td>
                            <div class="total_balance" style="font-weight:700;">{{ number_format(array_sum(array_map(function($employee) {
                                return $employee['total_balance'] - $employee['total_loanadjust'];
                            }, $consolidatedData)), 2) }}</div>
                        </td>
						
						
						
					</tr>
				</tfoot>
			</table>
		@endif
	<!------------------------------------->
</div>

<!---------------------------------------------------->


<!---------------------js------------------------------------->
<!-------------------------------------------------------->
</body>
</html>
