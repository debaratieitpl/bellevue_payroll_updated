@extends('employee.layouts.master')
@section('title')
Employee Retirement Report
@endsection
@section('sidebar')
@include('employee.partials.sidebar')
@endsection
@section('header')
@include('employee.partials.header')
@endsection
@section('scripts')
@include('employee.partials.scripts')
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
            <h5 class="card-title">Department Wise Cost Report</h5>
         </div>
         <div class="col-md-6">
            <span class="right-brd" style="padding-right:15x;">
               <ul class="">
                  <li><a href="#">Employee</a></li>
                  <li>/</li>
                  <li class="active"> Department Wise Net Report</li>
               </ul>
            </span>
         </div>
      </div>
      <!-- Widgets  -->
      <div class="row">
         <div class="main-card">
            @if($result!='')
            <div class="card">
               <div class="card-header">
                  <form  method="post" action="{{ url('employees/excel-export-report') }}" enctype="multipart/form-data" >
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <input type="hidden" value="<?php print_r($result['0']->emp_department) ?>" name="department">
                     <button data-toggle="tooltip" data-placement="bottom" title="Download Retirement Report" class="btn btn-default" style="background:none !important;padding: 10px 15px;margin-top: -30px;float:right;margin-right: 15px;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                  </form>
                  @include('include.messages')
               </div>
               <!----------------view----------------->
               <div class="card-body card-block">
                  <div class="payroll-table table-responsive" style="width:100%;margin:0 auto;">
                     <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead style="text-align:center;vertical-align:middle;"> 
                           <tr>
                              <th>Sl. No.</th>
                              <th>Emp_Code</th>
                              <th>Name</th>
                              <th>Department</th>
                              <th>Designation</th>
                              <th>Gross Salary</th>
                              <!-- <th>Salary Deduction</th> -->
                              <th>Net Salary</th>
                           </tr>
                        </thead>
                        <tbody>
                
                           @foreach ($result as $record)
                           <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$record->old_emp_code}}</td>
                              <td>{{$record->emp_fname}} {{$record->emp_mname}} {{$record->emp_lname}}</td>
                              <td>{{$record->emp_department}}</td>
                              <td>{{$record->emp_designation}}</td>
                              <td>
                                @php
                                    $sumBasicPay = $record->basic_pay + $record->hra + $record->tiff_alw + $record->others_alw + $record->misc_alw + $record->medical + $record->conv + $record->conv + $record->over_time + $record->bouns + $record->leave_inc;
                                    echo $sumBasicPay;
                                @endphp
                            </td>
                            <!-- <td>
                                @php
                                    $sumBasicdeduction = $record->prof_tax + $record->pf + $record->pf_int + $record->apf + $record->i_tax + $record->insu_prem + $record->pf_loan + $record->esi + $record->adv + $record->hrd + $record->co_op + $record->furniture + $record->misc_ded;
                                    echo $sumBasicdeduction;
                                @endphp
                            </td> -->
                            <td>
                            <!-- $sumBasicPay = -->
                            {{ $record->basic_pay + $record->hra + $record->tiff_alw + $record->others_alw + $record->misc_alw + $record->medical + $record->conv + $record->conv + $record->over_time + $record->bouns + $record->leave_inc - ($record->prof_tax + $record->pf + $record->pf_int + $record->apf + $record->i_tax + $record->insu_prem + $record->pf_loan + $record->esi + $record->adv + $record->hrd + $record->co_op + $record->furniture + $record->misc_ded) }}
                            <!-- $sumBasicdeduction = $record->prof_tax + $record->pf + $record->pf_int + $record->apf + $record->i_tax + $record->insu_prem + $record->pf_loan + $record->esi + $record->adv + $record->hrd + $record->co_op + $record->furniture + $record->misc_ded;
                            $netSalary=$sumBasicPay - $sumBasicdeduction;
                            echo $netSalary; -->
                            </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
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





</script>
@endsection
