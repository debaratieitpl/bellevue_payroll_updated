<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bellevue - Payslip</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('img/logo-small.png') }}" type="image/x-icon"/>

  <style type="text/css" media="print"> @page { size: auto; /* auto is the initial value */
   	margin-top: 0;
    margin-bottom: 0; /* this affects the margin in the printer settings */ }
   </style>
   <style>
body {-webkit-print-color-adjust: exact;}
  	.payslip{font-family:cambria;}
	.payslip .pay-head h2 {font-size: 22px;color: #000;text-align:center;margin:0;}
	.payslip .pay-head h3{text-align:center;margin:0;}
	.payslip .pay-head h4 {font-size: 17px;text-align:center;margin:0;}
	.payslip .pay-month{text-align:center;}
	.payslip .pay-month h3{margin:0;color: #0099be;}
	.pay-logo img {max-width: 130px;}
	.emp-det{width:100%;}
	.emp-det thead tr th{text-align:center;}
	.emp-det thead tr th{border-bottom:none;}
	.emp-det thead tr th {border-bottom: none;background: #a7a8a9;color: #000;padding: 5px 10px;font-size: 16px;}
	.emp-det tbody tr td{padding:0.5px 10px;font-size:11.5px;}
	table.emp-det tr td span {font-weight: 600;}
	.sal-det tr th {background: #a7a8a9;padding: 5px 10px;border-bottom: none;color: #000;text-align:center;}
	.emp-det tr.part td{padding:5px;text-align:left;font-weight:600;border-top:none;background:#efefef;}
	.sal-det tr td{padding:7px 10px;text-align:left;}
	.sal-det tr td p{text-align:right;margin:0;}.mon{text-align: center;}.mon h3{color:#0099be;margin:0;font-size:25px;}.mon h4{margin:0;}
	.sal-det tr:nth-child(odd) {background-color: #f2f2f2;}
	.emp-det{border-bottom:none;}.total td{font-weight:600;}.leave{border-top:none;}
	.leave tr th{padding:5px 10px;text-align:left;}.leave{}.leave table tr td{text-align:center;}.part td i {font-size: 12px;}
	@media print
{
  table { page-break-after:auto !important; }
  tr    { page-break-inside:avoid !important; page-break-after:auto !important; }
  td    { page-break-inside:avoid !important; page-break-after:auto !important; }
  thead { display:table-header-group !important; }
  tfoot { display:table-footer-group !important; }
}
  </style>
</head>
<body>
@php
//echo count($payslipdata);
@endphp
<!-------------------payslip-body------------------------->
@foreach($payslipdata as $inx=>$record)
@php
//dd($record['company_rs']->company_address);
@endphp

<div class="payslip">

	<!-----------company-details----------->
	<table class="comp-det" style="width:100%;">
		<tr>

		<td width="20%">
			<div class="pay-logo">
			<img src="{{ asset('theme/images/bellevue-logo1.png') }}" alt="logo">
				</div>
			</td>
			<td style="text-align:center;" width="65%">
				@if(!empty($record['company_rs'] ))
				<div class="pay-head">
					<h2>Belle Vue Clinic</h2>
				    <h4 style="font-size: 15px;">{{$record['company_rs']->company_address}}</h4>
				</div>
               @endif
				<div class="mon">
					@php
                    $dt = $record['payroll_rs'][0]->month_yr;
                    $dtar = explode('/', $dt);
                    $paymonth = $monthName = strftime('%B', mktime(0, 0, 0, $dtar[0]));
                    @endphp
					<h4>Payslip for the month of <?php echo $paymonth . ' - ' . $dtar[1]; ?></h4>
				</div>
			</td><td width="15%"></td>
			</tr>
		</table>

		<table border="1" class="emp-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">
			<thead>
				<tr>
					<th colspan="6">Employee Details</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<td colspan="2" width="33.33%"><span>Employee Code :</span><br> {{$record['payroll_rs'][0]->old_emp_code}}</td>
					<td colspan="2" width="33.33%"><span>Employee Name :</span><br> {{$record['payroll_rs'][0]->emp_name}}</td>
					<td colspan="2" width="33.33%"><span>Department :</span><br> {{$record['payroll_rs'][0]->emp_department}}</td>
				</tr>

				<tr>
			    	<td colspan="2"><span>Designation :</span><br> {{$record['payroll_rs'][0]->emp_designation}}</td>
					<!--<td colspan="2"><span>Class :</span><br> {{$record['payroll_rs'][0]->group_name}}</td>-->
					<td colspan="2"><span>PAN	No.	:</span><br> {{$record['payroll_rs'][0]->emp_pan_no}} </td>
					<td colspan="2"><span>Bank	Name :</span><br> {{$record['payroll_rs'][0]->master_bank_name}}</td>
				<tr>

					<!--<td colspan="2"><span>Bank	Name :</span><br> {{$record['payroll_rs'][0]->master_bank_name}}</td>-->
					<td colspan="2"><span>Account No :</span><br> {{$record['payroll_rs'][0]->emp_account_no}}</td>
					<td colspan="2"><span>IFSC Code :</span><br> {{$record['payroll_rs'][0]->emp_ifsc_code}}</td>
					<td colspan="2"><span>Branch Name :</span><br> {{$record['payroll_rs'][0]->branch_name }} </td>
				</tr>
			</tbody>
		</table>
	<!------------------------------------------>

	<!------------Salary-details----------------->
	<table border="1" class="emp-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">
				<thead>
					<tr>
						<!-- <th colspan="2" width="33.33%">Standard Earnings</th> -->
						<th colspan="2" width="50%">Actual Earnings</th>
						<th colspan="2" width="50%">Deductions for this month</th>
					</tr>
				</thead>
				<tbody>
					<tr class="part">
						<!-- <td>Particulars</td>
						<td style="text-align:right;">Amount (<img src="{{ asset('theme/payslip-img/rupee.png') }}" alt="" style="width: 8px;vertical-align: middle;">)</td> -->
						<td width="30%">Particulars</td>
						<td style="text-align:right;" width="20%">Amount (<img src="{{ asset('theme/payslip-img/rupee.png') }}" alt="" style="width: 8px;vertical-align: middle;">)</td>
						<td width="30%">Particulars</td>
						<td style="text-align:right;" width="20%">Amount (<img src="{{ asset('theme/payslip-img/rupee.png') }}" alt="" style="width: 8px;vertical-align: middle;">)</td>
					</tr>
					<tr>
    					<!-- <td>Basic Pay</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_basic_pay)){{$actual_payroll->emp_actual_basic_pay}}@endif</td> -->

						<td rowspan="2">Basic Pay</td>
						<td style="text-align:right;" rowspan="2">{{number_format(($record['payroll_rs'][0]->emp_basic_pay),2)}}</td>
						<td>PROF TAX</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_prof_tax),2)}}</td>
					</tr>
					<tr>
						<!-- <td>DA</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_da)){{$actual_payroll->emp_actual_da}}@endif</td> -->
						<!--<td>DA</td>-->
						<!--<td style="text-align:right;">{{$record['payroll_rs'][0]->emp_da}}</td>-->
						<td>PF</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_pf),2)}}</td>
					</tr>
					<tr>
						<!-- <td>VDA</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_vda)){{$actual_payroll->emp_actual_vda}}@endif</td> -->
						<!--<td>VDA</td>-->
						<!--<td style="text-align:right;">{{$record['payroll_rs'][0]->emp_vda}}</td>-->
						<!--<td>PF INT</td>-->
						<!--<td style="text-align:right;">{{$record['payroll_rs'][0]->emp_pf_int}}</td>-->
						<td rowspan="2">HRA</td>
						<td style="text-align:right;" rowspan="2">{{number_format(($record['payroll_rs'][0]->emp_hra),2)}}</td>
						<td>APF</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_apf),2)}}</td>
					</tr>
					<tr>
						<!-- <td>HRA</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_hra)){{$actual_payroll->emp_actual_hra}}@endif</td> -->
						<!--<td>HRA</td>-->
						<!--<td style="text-align:right;">{{$record['payroll_rs'][0]->emp_hra}}</td>-->
						<!--<td>APF</td>-->
						<!--<td style="text-align:right;">{{$record['payroll_rs'][0]->emp_apf}}</td>-->
						<td>PF INT</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_pf_int),2)}}</td>
					</tr>
					<tr>
						<!-- <td>TIFF ALW.</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_tiff_alw)){{$actual_payroll->emp_actual_tiff_alw}}@endif</td> -->
						<td>TIFF ALW.</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_tiff_alw),2)}}</td>
						<td>I TAX</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_i_tax),2)}}</td>
					</tr>
					<tr>
						<!-- <td>OTH ALW</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_others_alw)){{$actual_payroll->emp_actual_others_alw}}@endif</td> -->
						<td>OTH ALW</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_others_alw),2)}}</td>
						<td>INSU PERM</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_insu_prem),2)}}</td>
					</tr>
					<tr>

						<!-- <td>CONV</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_conv)){{$actual_payroll->emp_actual_conv}}@endif</td> -->

                        <td>MISC ALW</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_misc_alw),2) }}</td>
                        <td>PF LOAN</td>
                        <td style="text-align:right;">{{ number_format(($record['payroll_rs'][0]->emp_pf_loan),2) }}</td>
						<!--<td>CONV</td>-->
						<!--<td style="text-align:right;">{{$record['payroll_rs'][0]->emp_conv}}</td>-->
						<!--<td>PF LOAN</td>-->
						<!--<td style="text-align:right;">{{$record['payroll_rs'][0]->emp_pf_loan}}</td>-->
					</tr>
					<tr>

						<!-- <td>MEDICAL</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_medical)){{$actual_payroll->emp_actual_medical}}@endif</td> -->

						<td>MEDICAL</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_medical),2)}}</td>
						<td>ESI</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_esi),2)}}</td>
					</tr>
					<tr>

						<!-- <td>MISC ALW</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_misc_alw)){{$actual_payroll->emp_actual_misc_alw}}@endif</td> -->

						 <td>Convey Alw.</td>
                        <td style="text-align:right;">{{ number_format(($record['payroll_rs'][0]->emp_conv),2) }}</td>
						<td>ADV</td>
                        <td style="text-align:right;">{{number_format(( $record['payroll_rs'][0]->emp_adv),2)}}</td>
					</tr>
					<tr>

						<!-- <td>OVER TIME</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_over_time)){{$actual_payroll->emp_actual_over_time}}@endif</td> -->

						<td>OVER TIME</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_over_time),2)}}</td>
						<td>HRD</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_hrd),2)}}</td>
					</tr>
					<tr>

						<!-- <td>BONUS</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_bouns)){{$actual_payroll->emp_actual_bouns}}@endif</td> -->

						<td>BONUS</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_bouns),2)}}</td>
						<td>CO-OP</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_co_op),2)}}</td>
					</tr>
					<tr>

						<!-- <td>LEAVE ENC</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_leave_inc)){{$actual_payroll->emp_actual_leave_inc}}@endif</td> -->

						<td>LEAVE ENC</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_leave_inc),2)}}</td>
						<td>FURNITURE</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_furniture),2)}}</td>
					</tr>
					<tr>

						<!-- <td>HTA</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_hta)){{$actual_payroll->emp_actual_hta}}@endif</td> -->

						<td>LTA</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_hta),2)}}</td>
						<td>MISE DED</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_misc_ded),2)}}</td>
					</tr>



					<tr>


						<!-- <td rowspan="2">Other </td>
						<td rowspan="2" style="text-align:right;">@if(isset($payroll_rs[0]->emp_actual_others_addition)){{$payroll_rs[0]->emp_actual_others_addition}}@endif</td> -->

						<td rowspan="2">Other </td>
						<td rowspan="2" style="text-align:right;">{{number_format(($record['payroll_rs'][0]->other_addition),2)}}</td>

						<td>Employer PF Contribution</td>
						<td style="text-align:right;">@if(isset($record['payroll_rs'][0]->emp_pf_employer)){{number_format(($record['payroll_rs'][0]->emp_pf_employer),2)}}@else 0 @endif</td>



					</tr>



					<tr>

						<td>Others</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->other_deduction),2)}}</td>

					</tr>

					<tr class="total">

						<!-- <td>Standard Gross Salary</td>
						<td style="text-align:right;">@if(isset($actual_payroll->emp_actual_gross_salary)){{$actual_payroll->emp_actual_gross_salary}}@endif</td> -->

						<td>Actual Gross Salary</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_gross_salary),2)}}</td>
						<td>Total Deductions</td>
						<td style="text-align:right;">{{number_format(($record['payroll_rs'][0]->emp_total_deduction),2)}}</td>
					</tr>
					<?php $number = $record['payroll_rs'][0]->emp_net_salary;
$no = round($number);
$point = round($number - $no, 2) * 100;
$hundred = null;
$digits_1 = strlen($no);
$i = 0;
$str = array();
$words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
while ($i < $digits_1) {
    $divider = ($i == 2) ? 10 : 100;
    $number = floor($no % $divider);
    $no = floor($no / $divider);
    $i += ($divider == 10) ? 1 : 2;
    if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str[] = ($number < 21) ? $words[$number] .
        " " . $digits[$counter] . $plural . " " . $hundred
        :
        $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
    } else {
        $str[] = null;
    }

}
$str = array_reverse($str);
$result = implode('', $str);
$point=abs($point);
$point=number_format($point,0);
$points = ($point) ?
"." . $words[$point / 10] . " " .
$words[$point = $point % 10] : '';
//echo $result . "Rupees  " . $points . " Paise"; ?>

<tr>
						<!--<td style="font-weight:500;" colspan="2"><b>No. of pay in days: <?php echo $no_of_pay_days = $record['current_month_days'] - $record['payroll_rs'][0]->emp_absent_days; ?> </b>-->

							<!--<p style="margin: 0">E. &amp; O.E. This is a computer generated payslip and does not need a signature</p></td>-->

						 <td colspan="2">
                            <table style="width: 100%;">
                                <tr style="width: 100%;">
                                    <td style="font-weight:500;"><b>Pay Day <br>
                                            <br><?php echo $no_of_pay_days = $record['current_month_days'] - $record['payroll_rs'][0]->emp_absent_days; ?> </b>
                                    </td>
                                    <td style="font-weight:500;"><b>T.Day <br>
                                            <br>{{ $record['payroll_rs'][0]->no_days_tiffalw }} </b>
                                    </td>
                                    <td style="font-weight:500;"><b>ADJ.<br>
                                            <br>{{ $record['payroll_rs'][0]->emp_adjust_days }} </b>
                                    </td>
                                </tr>
                            </table>
                        </td>
						<td style="font-weight:600;text-align:right;" colspan="2"><span style="float: left;">Net Salary :</span> <img src="{{ asset('theme/payslip-img/rupee.png') }}" alt="" style="width: 8px;vertical-align: middle;"> {{$record['payroll_rs'][0]->emp_net_salary}}<br>
                           <!--<span style="float: left;">RUPEES <?php echo strtoupper($result); ?></span>-->
						</td>
					</tr>

				</tbody>
			</table>



</div>
<div class="print">&nbsp;</div>
@endforeach


</body>
</html>
