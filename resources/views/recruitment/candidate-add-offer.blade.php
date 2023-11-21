@extends('recruitment.layouts.master')
@section('title')
BELLEVUE - Interview
@endsection
@section('sidebar')
@include('recruitment.partials.sidebar')
@endsection
@section('header')
@include('recruitment.partials.header')
@endsection
@section('scripts')
@include('recruitment.partials.scripts')
@endsection
@section('content')
<style>
   .body{background:#f5f6fa;}
   .card-header{background:none;}
   .card{margin-top:0;}
</style>
<!-- Content -->
<div class="content">
   <!-- Animated -->
   <div class="animated fadeIn">
      <div class="row" style="border:none;">
         <div class="col-md-6">
            <h5 class="card-title">Hired</h5>
         </div>
         <div class="col-md-6">
            <span class="right-brd" style="padding-right:15x;">
               <ul class="">
                  <li><a href="#">Recruitment</a></li>
                  <li>/</li>
                  <li><a href="#">Hired</a></li>
               </ul>
            </span>
         </div>
      </div>
      <!-- Widgets  -->
	  <div class="row">
		<div class="main-card">
		   <div class="card">
			  <!-- <div class="card-header"><strong class="card-title">User Config</strong></div> -->
			  <div class="card-body">
				 <!-- @if(Session::has('message'))
					<div class="alert alert-success" style="text-align:center;color: #ff0000;"><i class="fa fa-check" aria-hidden="true"></i><em > {{ Session::get('message') }}</em></div>
					@endif	 -->
				 @include('include.messages')
				 <form action="{{url('recruitment/edit-offer-letter')}}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" value="{{ isset($job_details['id']) ? $job_details['id'] : '' }}">
					<div class="clearfix"></div>
					
					<div class="lv-due" style="border:none;">
					   <div class="row form-group lv-due-body">
						  <div class="col-md-4">
							 <label for="title" class="placeholder">Select Candidate</label>
							 <select class="form-control  " required="" name="user_id"  id="user_id" onchange="canuser(this.value);">
								<option value="">Select</option>
							   <?php foreach($employees as $employee){ ?>
								 <option value="<?php echo $employee->user_id; ?>"  ><?php echo $employee->name; ?></option>
							  <?php } ?>
							   </select> 
						  </div>
						  <div class="col-md-4">
								   <label for="title" class="placeholder">Offered Salary</label>
								   <input type="text" id="offered_sal" class="form-control "  required="" name="offered_sal">
						  </div>
						 
						  <div class="col-md-4">
							 <div class=" form-group">
								<label for="editor"  class="placeholder">Payment Type</label>
								<select id="payment_type" class="form-control "  required="" name="payment_type">
									<option value="">Select</option>
								   <option value="Year">Year</option>
									 <option value="Month">Month</option>
									  <option value="Month">Month</option>
									   <option value="Week">Week</option>
										<option value="Day">Day</option>
										  <option value="Hour">Hour</option>
							   </select>
							 </div>
						  </div>
						  <div class="col-md-4">
						   <div class=" form-group">
							  <label for="inputFloatingLabel-job-type" class="placeholder">Date Of Joining</label>	
							  <input type="date" id="date_jo" class="form-control "  required="" name="date_jo">
							 
						   </div>
						</div>
						<div class="col-md-4">
						   <div class=" form-group">
							  <label for="working_hour" class="placeholder">Reporting Authority</label>
							  <select class="form-control " id="selectFloatingLabelra" name="reportauthor" >
							  <option value="">Select</option>
							  @foreach($employeelists as $employeelist)
								<option value="{{$employeelist->emp_code}}" >{{$employeelist->emp_fname}} {{$employeelist->emp_mname}} {{$employeelist->emp_lname}} ({{$employeelist->emp_code}})</option>
							  @endforeach
							  </select>
						   </div>
						</div>
					   </div>
					   <div class="row form-group">
						  <div class="col-md-4 btn-up">
							 <button type="submit" class="btn btn-danger btn-sm">{{ !empty($job_details['id']) ? 'Update' : 'Submit' }}</button>
							 {{-- <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i>
							 Reset</button> --}}
						  </div>
						  <div class="clearfix"></div>
					   </div>
					   <!--
						  <div id="rowid">
						  
						  </div>
						  -->
					</div>
				 </form>
			  </div>
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