@extends('loan.layouts.master')

@section('title')
Loan Information System - Loan Report
@endsection

@section('sidebar')
@include('loan.partials.sidebar')
@endsection

@section('header')
@include('loan.partials.header')
@endsection


@section('content')
<style>
	#bootstrap-data-table th {
		vertical-align: middle;
	}

	tr.spl td {
		font-weight: 600;
	}

	table#bootstrap-data-table tr td {
		font-size: 12px;
		padding: 8px 10px;
	}
    .card-icon form {
    padding: 10px 0;

}
</style>
<!-- Content -->
<div class="content">
	<!-- Animated -->
	<div class="animated fadeIn">
	<div class="row" style="border:none;">
            <div class="col-md-6">
            <h5 class="card-title">Monthly Loan Report</h5>
</div>
<div class="col-md-6">

                        <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Loans</a></li>
                                <li>/</li>

                                <li class="active">Monthly Loan Report</li>
                            </ul>
                        </span>
</div>
</div>
		<!-- Widgets  -->
		<div class="row">
			<div class="main-card">
				<div class="card">
                    <div class="card-header">

                        @include('include.messages')
                    </div>

					<div class="card-body card-block">
						<form action="{{url('loans/vw-loan-report')}}" method="post" enctype="multipart/form-data" style="width:98%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
							{{ csrf_field() }}
							<div class="row form-group">
								<div class="col-md-5">
									<label for="text-input" class=" form-control-label" style="text-align:right;">Select Month</label>
                                    <div>
                                    <select data-placeholder="Choose Month..." name="month" id="month" class="form-control" required>
                                        <option value="" selected disabled > Select </option>
                                        @foreach ($monthlist as $month)
                                        <option value="<?php echo $month->month_yr; ?>" @if(isset($req_month) && $req_month==$month->month_yr) selected @endif><?php echo $month->month_yr; ?></option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('month'))
                                    <div class="error" style="color:red;">{{ $errors->first('month') }}</div>
                                    @endif
                                    </div>
								</div>
								<div class="col-md-5">
                                    <label for="text-input" class=" form-control-label" style="text-align:right;">Loan Type</label>
                                    <select id="loan_type" name="loan_type"
                                            class="form-control employee select2_el" required>
                                            <option selected disabled value="">Select</option>
                                            <option value="PF" @if(isset($req_type) && $req_type=='PF') selected @endif>PF Loan</option>
                                            <option value="SA" @if(isset($req_type) && $req_type=='SA') selected @endif>Salary Advance</option>
                                        </select>
								</div>

								<div class="col-md-2">
                                    <br>
									<button type="submit" class="btn btn-success" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;height: 32px;">Go</button>
								</div>
							</div>
						</form>
					</div>
				</div>
                @if($result!='')
				<div class="card">
					<!----------------view----------------->
                    <div class="card-header" style="background:#fff;">
					    <div style="display:inline-flex;float:right;" class="card-icon">
                            <form  method="post" action="{{ url('loans/xls-export-loan-report') }}" enctype="multipart/form-data" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="month_yr" value="{{ $req_month }}">
                                <input type="hidden" name="loan_type" value="{{ $req_type }}">
                                <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                            </form>
                            <form  method="post" action="{{ url('loans/prn-loan-report') }}" enctype="multipart/form-data" target="_blank">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="month" value="{{ $req_month }}">
                                <input type="hidden" name="loan_type" value="{{ $req_type }}">
                                <button data-toggle="tooltip" data-placement="bottom" title="Download " class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/print-button.jpg')}}"></button>
                            </form>
                        </div>
                    </div>
					<div class="card-body card-block">
						<div class="payroll-table table-responsive" style="width:100%;margin:0 auto;">
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
										'emp_name' => "{$record->salutation} {$record->emp_fname} {$record->emp_mname} {$record->emp_lname}",
										'loan_amount' => 0,
                                        'pre_recoveries' => 0,
										'payroll_deduction' => 0,
										'pf_interest' => 0,
										'balance' => 0,
										'loanadjust' => 0,
									];
								}
                                $opening_amount =  $record->pre_recoveries === null ? $record->loan_amount : ($record->loan_amount - $record->pre_recoveries);
								$balance = $record->recoveries === null ? $record->loan_amount : ($record->loan_amount - $record->recoveries);
								$employeeTotals[$key]['loan_amount'] += $record->loan_amount;
                                $employeeTotals[$key]['pre_recoveries'] += $opening_amount;
								$employeeTotals[$key]['payroll_deduction'] += $record->payroll_deduction_sa;
								$employeeTotals[$key]['pf_interest'] += $record->pf_iterest;
								$employeeTotals[$key]['balance'] += $balance;
								$employeeTotals[$key]['loanadjust'] += $record->loan_adjust;

								$pf_interest = $record->pf_iterest;
							@endphp
						@endforeach

						<table id="bootstrap-data-table" class="table table-striped table-bordered">
							<thead style="text-align:center;vertical-align:middle;">
								<tr>
									<th >Sl. No.</th>
									<th >Employee Code</th>
									<th>Employee Name</th>
                                    {{-- <th>Employee Type</th> --}}
									<th style="width:5%;">PF Total Loan Amount</th>
                                    <th style="width:5%;">PF Opening Loan Amount</th>
									<th style="width:5%;">PF Loan Deduction</th>
									{{-- <th style="width:5%;">PF Interest</th>
									<th style="width:5%;">Total Deduction</th> --}}
									<th style="width:5%;">PF Loan Balance</th>
									<th style="width:5%;">Loan Adjust</th>
									<th style="width:5%;">Final PF Loan Balance</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($employeeTotals as $employee)
									<tr>
										<td>{{ $employee['index'] }}</td>
										<td>{{ $employee['old_emp_code'] }}</td>
										<td>{{ $employee['emp_name'] }}</td>
                                        {{-- <td>{{ $employee['emp_status'] }}</td> --}}
										<td>{{ number_format(round($employee['loan_amount'], 1),2) }}</td>
                                        <td>{{ number_format(round($employee['pre_recoveries'], 1),2) }}</td>
										<td>{{ number_format(round($employee['payroll_deduction'], 1),2) }}</td>
										{{-- <td>{{ number_format(round($employee['pf_interest'], 1),2)}}</td>
										<td>{{ number_format(round($employee['payroll_deduction'] + $employee['pf_interest'], 1),2) }}</td> --}}
										{{-- <td>{{ number_format(round($employee['balance'], 1),2) }}</td> --}}
                                        <td>{{ number_format(round($employee['pre_recoveries'] - $employee['payroll_deduction'], 1), 2) }}</td>
										<td>{{ number_format(round($employee['loanadjust'], 1),2)}}</td>
										<td>{{ number_format(round($employee['balance'], 1),2) }}</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<td colspan="3" style="font-weight:700;">Grand Total</td>
									<td>{{ number_format(round(array_sum(array_column($employeeTotals, 'loan_amount')), 1),2) }}</td>
                                    <td>{{ number_format(round(array_sum(array_column($employeeTotals, 'pre_recoveries')), 1),2) }}</td>
									<td>{{ number_format(round(array_sum(array_column($employeeTotals, 'payroll_deduction')), 1),2) }}</td>
									{{-- <td>{{ number_format(round(array_sum(array_column($employeeTotals, 'pf_interest')), 1),2) }}</td>
									<td>{{ number_format(round(array_sum(array_column($employeeTotals, 'payroll_deduction')) + array_sum(array_column($employeeTotals, 'pf_interest')), 1),2) }}</td> --}}
                                    <td>{{ number_format(round(array_sum(array_column($employeeTotals, 'pre_recoveries')) - array_sum(array_column($employeeTotals, 'payroll_deduction')), 1),2) }}</td>
									<td>{{ number_format(round(array_sum(array_column($employeeTotals, 'loanadjust')), 1),2) }}</td>
									<td>{{ number_format(round(array_sum(array_column($employeeTotals, 'balance')), 1),2) }}</td>
								</tr>
							</tfoot>
						</table>
							@endif
							@if($req_type=='SA')
                            @php
                                $consolidatedData = [];

                                foreach ($result as $record) {
                                    $empCode = $record->emp_code;

                                    if (!isset($consolidatedData[$empCode])) {
                                        $consolidatedData[$empCode] = [
                                            'recordCount' => 0,
                                            'total_loan_amount' => 0,
                                            'total_installment' => 0,
                                            'total_balance' => 0,
                                            'total_loanadjust' => 0,
                                            'pre_recoveries' => 0,
                                            'salutation' => $record->salutation,
                                            'emp_fname' => $record->emp_fname,
                                            'emp_mname' => $record->emp_mname,
                                            'emp_lname' => $record->emp_lname,
                                            'emp_status' => $record->emp_status,
                                            'old_emp_code' => $record->old_emp_code,
                                        ];
                                    }
                                    $opening_amount =  $record->pre_recoveries === null ? $record->loan_amount : ($record->loan_amount - $record->pre_recoveries);
                                    $balance = $record->recoveries === null ? $record->loan_amount : ($record->loan_amount - $record->recoveries);

                                    $consolidatedData[$empCode]['recordCount']++;
                                    $consolidatedData[$empCode]['total_loan_amount'] += $record->loan_amount;
                                    $consolidatedData[$empCode]['total_installment'] += $record->payroll_deduction_sa;
                                    $consolidatedData[$empCode]['total_balance'] += $balance;
                                    $consolidatedData[$empCode]['pre_recoveries'] += $opening_amount;
                                    $consolidatedData[$empCode]['total_loanadjust'] += $record->loan_adjust;
                                }
                            @endphp

                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead style="text-align:center;vertical-align:middle;">
                                <tr>
                                    <th style="width:8%;">Sl. No.</th>
                                    <th style="width:12%;">Employee Code</th>
                                    {{-- <th style="width:12%;">Employee New Code</th> --}}
                                    <th>Employee Name</th>
                                    {{-- <th style="width:10%;">Loan ID</th> --}}
                                    {{-- <th style="width:5%;">Employee type</th> --}}
                                    <th style="width:5%;">Total Loan Amount</th>
                                    <th style="width:5%;">Opening Amount</th>
                                    <th>Deducted Amount</th>
                                    <th style="width:5%;">Balance Amount</th>
                                    <th style="width:5%;">Adjust Amount</th>
                                    <th style="width:5%;">Final Balance Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rowNumber = 1; @endphp
                                @foreach ($consolidatedData as $empCode => $employee)
                                    <tr>
                                        <td>{{ $rowNumber++ }}</td>
                                        <td>{{ $employee['old_emp_code'] }}</td>
                                        {{-- <td>{{ $employee['emp_code'] }}</td> --}}
                                        <td>{{ $employee['salutation'] }} {{ $employee['emp_fname'] }} {{ $employee['emp_mname'] }} {{ $employee['emp_lname'] }}</td>
                                        {{-- <td>Consolidated Loan ID</td>  --}}
                                        {{-- <td>{{ $employee['emp_status'] }}</td> --}}
                                        <td>{{ number_format(round($employee['total_loan_amount'], 1), 2) }}</td>
                                        <td>{{ number_format(round($employee['pre_recoveries'], 1), 2) }}</td>
                                        <td>{{ number_format(round($employee['total_installment'], 1), 2) }}</td>
                                        <td>{{ number_format(round($employee['pre_recoveries'] - $employee['total_installment'], 1), 2) }}</td>
                                        <td>{{ number_format(round($employee['total_loanadjust'], 1), 2) }}</td>
                                        <td>{{ number_format(round($employee['total_balance'], 1), 2)  }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="font-weight:700;">
                                        Grand Total
                                    </td>
                                    <td>
                                        <div class="total_loan_amount" style="font-weight:700;">{{ number_format(round(array_sum(array_column($consolidatedData, 'total_loan_amount')), 1),2) }}</div>
                                    </td>
                                    <td>
                                        <div class="total_balance" style="font-weight:700;">{{ number_format(round(array_sum(array_column($consolidatedData, 'total_installment')), 1),2) }}</div>
                                    </td>
                                    <td>
                                        <div class="total_balance" style="font-weight:700;">{{ number_format(round(array_sum(array_column($consolidatedData, 'total_balance')), 1),2) }}</div>
                                    </td>
                                    <td>
                                        <div class="total_balance" style="font-weight:700;">{{ number_format(round(array_sum(array_column($consolidatedData, 'total_loanadjust')), 1),2) }}</div>
                                    </td>
                                    <td>
                                        <div class="total_balance" style="font-weight:700;">{{ number_format(round(array_sum(array_map(function($employee) {
                                            return $employee['total_balance'] - $employee['total_loanadjust'];
                                        }, $consolidatedData)), 1),2) }}</div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

							@endif
						</div>
					</div>
					<!------------------------------->

				</div>
                @endif
			</div>
		</div>
	</div>
	<!-- /Widgets -->
</div>
<!-- .animated -->
</div>
<!-- /.content -->
<div class="clearfix"></div>


@endsection

@section('scripts')
@include('loan.partials.scripts')
<script>


$(document).ready(function(){
	$("#bootstrap-data-table").dataTable().fnDestroy();
	$('#bootstrap-data-table').DataTable({
		lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
		initComplete: function(settings, json) {
			//doSumCoop();
			//doSumInsu();
			//doSumMisc();
			//cal_sum();
		}
	});
	//cal_sum();
});
function doSumCoop() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(6).nodes();
    var total = table.column(6 ).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
   	$(".total_coop").html(total);
}
function doSumInsu() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(7).nodes();
    var total = table.column(7).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
	$(".total_insu").html(total);
}
function doSumMisc() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(8).nodes();
    var total = table.column(8).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
	$(".total_misc").html(total);
}


// function cal_sum(){
//     var sum = 0;
//     var sum_in = 0;
//     $(".sm_d_coop").each(function(){
//         sum += +$(this).val();
//     });
//     $(".total_coop").html(sum);

//     $(".sm_d_insup").each(function(){
//         sum_in += +$(this).val();
//     });
//     $(".total_insu").html(sum_in);

// }


</script>
@endsection
