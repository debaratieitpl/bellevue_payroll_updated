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



@section('scripts')
	@include('payroll.partials.scripts')
@endsection

@section('content')


  	<!-- Content -->
  	<div class="content">
	    <!-- Animated -->
	    <div class="animated fadeIn">
		<div class="row" style="border:none;">
            <div class="col-md-6">
            <h5 class="card-title">PF Statement</h5>
</div>
<div class="col-md-6">

<span class="right-brd" style="padding-right:15x;">
<ul class="">
	<li><a href="#">Report Module</a></li>
	<li>/</li>
	<li class="active">PF Statement</li>

</ul>
</span>
</div>
</div>
	      <!-- Widgets  -->
	      <div class="row">
	        <div class="main-card">
	          <div class="card">
	            <!-- <div class="card-header"> <strong>GPF Statement</strong> </div> -->
	            <div class="card-body card-block">
                @include('include.messages')
	              <form action="{{ url('payroll/vw-gpf-employee-file-show')}}" method="post" style="width: 70%;margin: 0 auto;">
	              	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                <div class="row form-group">

					<div class="col-md-4">
					<label>Select Month</label>
						<select data-placeholder="Choose Month..." name="month_yr" id="month" class="form-control" required>
							<option value="" selected disabled > Select </option>
							<?php foreach ($monthlist as $month) {?>
							<option value="<?php echo $month->month_yr; ?>" @if(isset($result) && $result==$month->month_yr) selected @endif><?php echo $month->month_yr; ?></option>
							<?php }?>
                        </select>
					</div>


	                  <div class="col-md-4 btn-up">
	                    <button type="submit" class="btn btn-danger btn-sm" id="showbankstatement">Show </button>
						
	                  </div>
	                </div>
	              </form>
				  @if ($result!='')
				  <div style="display:inline-flex;float:left;" class="card-icon">
						  <form  method="post" action="{{ url('payroll/monthlywise-payroll-report') }}" enctype="multipart/form-data"  style="padding: 0px !important;">
							  <input type="hidden" name="_token" value="{{ csrf_token() }}">
							  <input type="hidden" name="from_month" value="{{ $result }}">
							  <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
						  </form>
						  <form  method="post" action="{{url('payroll/vw-gpf-wise-report')}}" enctype="multipart/form-data" target="_blank" style="padding: 0px !important;">
							  <input type="hidden" name="_token" value="{{ csrf_token() }}">
							  <input type="hidden" name="month_yr" value="{{ $result }}">
							  <button data-toggle="tooltip" data-placement="bottom" title="Download Pdf" class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/print-button.jpg')}}"></button>
						  </form>
						<a href="{{route('payroll.vm-monthly-wise')}}" style="padding: 10px !important;"><button class="btn btn-warning btn-sm">Reset </button></a>
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


<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click','#showbankstatement',function(){
			$('#View_Bank_Statement').css('display','block');
		});
	})

</script>
@endsection