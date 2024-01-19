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
    <!-- Content -->
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">
            <div class="row" style="border:none;">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">

                    <span class="right-brd" style="padding-right:15x;">
                        <ul class="">
                            <li><a href="#">Report Module</a></li>
                            <li>/</li>
                            <li class="active">Employee Wise Exit</li>

                        </ul>
                    </span>
                </div>
            </div>

            <!-- Widgets  -->
            <div class="row">
                <div class="main-card">
                    <div class="card">
                        <!-- <div class="card-header"> <strong>Employeewise Payslip</strong> </div> -->
                        @include('include.messages')
                        <div class="card-body card-block">

                            <!--Search Payslip-->
                            <form style="padding: 5px 10px 15px 20px !important;" action="{{ url('employees/exit-wise-list') }}" method="post">
                              <h5 class="card-title">Employee Wise Exit</h5>
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label for="text-input" class=" form-control-label">Form Date
                                            <span>(*)</span></label>
                                       <input type="date" class="form-control" name="form_date">
                                        @if ($errors->has('month_yr'))
                                            <div class="error" style="color:red;">{{ $errors->first('month_yr') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label class=" form-control-label">To Date <span>(*)</span></label>
                                        <input type="date" class="form-control" name="to_date">
                                        @if ($errors->has('emp_code'))
                                            <div class="error" style="color:red;">{{ $errors->first('emp_code') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-4 btn-up">
                                        <button type="submit" class="btn btn-danger btn-sm">View </button>
                                    </div>
                                </div>
                            </form>
                            <!--End-->

                           

                        </div>
                    </div>

                    <h5 class="card-title">View Exit</h5> <br>
                    <div class="card">

                        <br />
                        <div class="clear-fix">
                            <div class="card-body card-block">
                                <div class="table-responsive">
                                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                        <thead style="text-align:center;vertical-align: middle;">
                                            <tr style="font-size:11px;text-align:center">
                                            <th>Sl. No.</th>
                                            <th>Employee Code</th>
                                            <th>Employee Name</th>
                                            <th>Employee Department</th>
                                            <th>Designation</th>
                                            <th>Date</th>
                                            <th>Joining Date</th>
                                            <th>Retirement date</th>
                                            <th>Date of Exit </th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($entry_list as $record)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$record->old_emp_code}}</td>
                                                <td>{{$record->salutation}} {{$record->emp_fname}} {{$record->emp_mname}} {{$record->emp_lname}}</td>
                                                <td>{{ucwords($record->emp_department)}}</td>
                                                <td>{{ucwords($record->emp_designation)}}</td>
                                                <td>{{ ucfirst(\Carbon\Carbon::parse($record->created_at)->format('Y-m-d')) }}</td>
                                                <td>{{ucwords($record->emp_doj)}}</td>
                                                <td>{{$record->emp_retirement_date}}</td>
                                                <td>{{$record->date_of_exit}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Widgets -->
        </div>
        <!-- .animated -->
    </div>
    <!-- /.content -->
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
