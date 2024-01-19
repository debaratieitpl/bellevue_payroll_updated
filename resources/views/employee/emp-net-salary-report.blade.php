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
                  <form  method="post" action="{{ url('employees/department-net-salary-export') }}" enctype="multipart/form-data" >
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                              <th>Department</th>
                              <th>Gross Salary</th>
                              <th>Total Deduction</th>
                              <th>Net Pay</th>
                           </tr>
                        </thead>
                        <tbody>
                
                           @foreach ($result as $record)
                           <tr>
                              <td>{{$loop->iteration}}</td>
                              <td><a href="{{url('employee/department-wise-cost-filter/'.$record->department)}}" style="color:blue;">{{$record->department}}</a></td>
                              <td>{{$record->total_salary}}</td>
                              <td>{{$record->total_deduction}}</td>
                              <td>{{$record->netSalary}}</td>
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
