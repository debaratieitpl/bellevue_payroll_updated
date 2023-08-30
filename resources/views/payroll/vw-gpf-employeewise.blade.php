@extends('payroll.layouts.master')

@section('title')
Payroll Information System-PTAX
@endsection

@section('sidebar')
	@include('payroll.partials.sidebar')
@endsection

@section('header')
	@include('payroll.partials.header')
@endsection



@section('content')


  	<!-- Content -->
  	<div class="content">
	    <!-- Animated -->
	    <div class="animated fadeIn">
		<div class="row" style="border:none;">
            <div class="col-md-6">
            <h5 class="card-title">PF Statement Employeewise</h5>
</div>
<div class="col-md-6">

<span class="right-brd" style="padding-right:15x;">
<ul class="">
	<li><a href="#">Report Module</a></li>
	<li>/</li>
	<li class="active">PF Statement Employeewise</li>

</ul>
</span>
</div>
</div>
	      <!-- Widgets  -->
	      <div class="row">
	        <div class="main-card">
	          <div class="card">
	            <!-- <div class="card-header"> <strong>GPF Statement Employeewise</strong> </div> -->
	            <div class="card-body card-block">
                      @include('include.messages')
	            <form action="{{ url('payroll/vw-gpf-file-show')}}" method="post" style="width: 100%;margin: 0 auto;">
	              	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                <div class="row form-group">

					<div class="col-md-4">
					<label>Select Month</label>
						<select data-placeholder="Choose Month..." name="from_month" class="form-control" required>
							<option value="" selected disabled > Select </option>
							<?php foreach ($monthlist as $month) {?>
							<option value="<?php echo $month->month_yr; ?>" @if(isset($result) && $result==$month->month_yr) selected @endif><?php echo $month->month_yr; ?></option>
							<?php }?>
                        </select>
					</div>

	                <!-- <div class="col-md-4">
					<label>Select To Month</label>
						<select data-placeholder="Choose Month..." name="to_month" class="form-control" required>
							<option value="" selected disabled > Select </option>
							<?php //foreach ($monthlist as $month) {?>
							<option value="<?php //echo $month->month_yr; ?>"  @if(isset($month_yr_to) && $month_yr_to==$month->month_yr) selected @endif><?php //echo $month->month_yr; ?></option>
							<?php //}?>
                        </select>
					</div> -->


					<div class="col-md-4">
					<label>Select Employee</label>
						<select data-placeholder="Choose Employee..." name="emp_code" class="form-control select2_el" required>
							<option value="" selected disabled > Select </option>
							<?php foreach ($employeeslist as $employee) {?>
							<option value="<?php echo $employee->emp_code; ?>"  @if(isset($emp_code) && $emp_code==$employee->emp_code) selected @endif><?php echo $employee->emp_fname . " " . $employee->emp_mname . " " . $employee->emp_lname . " (" . $employee->old_emp_code . ") "; ?></option>
							<?php }?>
                        </select>
					</div>

	                  <div class="col-md-4 btn-up">
	                    <button type="submit" class="btn btn-danger btn-sm" id="showbankstatement">Show </button>
                        {{-- <a href="{{route('payroll.vm-employee-wise')}}"><button class="btn btn-warning btn-sm">Reset </button></a> --}}
	                  </div>
	                </div>


	              </form>

                  @if ($result!='')
                        <div style="display:inline-flex;float:left;" class="card-icon">
                                <form  method="post" action="{{ url('payroll/employeewise-payroll-report') }}" enctype="multipart/form-data" style="padding: 0px !important;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="from_month" value="{{ $result }}">
                                    <input type="hidden" name="emp_code" value="{{ $emp_code }}">
                                    <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                                </form>
                                <form  method="post" action="{{url('payroll/vw-gpf-emplyeewise')}}" enctype="multipart/form-data" target="_blank" style="padding: 0px !important;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="from_month" value="{{ $result }}">
                                    <input type="hidden" name="emp_code" value="{{ $emp_code }}">
                                    <button data-toggle="tooltip" data-placement="bottom" title="Download Pdf" class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/print-button.jpg')}}"></button>
                                </form>
							<a href="{{route('payroll.vm-employee-wise')}}" style="padding: 10px !important;"><button class="btn btn-warning btn-sm">Reset </button></a>
                        </div>
                 @endif
                
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
	@include('payroll.partials.scripts')
	<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        initailizeSelect2();
    });
    // Initialize select2
    function initailizeSelect2() {

        $(".select2_el").select2();
    }
</script>


<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click','#showbankstatement',function(){
			$('#View_Bank_Statement').css('display','block');
		});
	})

</script>
@endsection