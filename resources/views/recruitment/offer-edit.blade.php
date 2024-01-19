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
				 <form action="{{url('recruitment/update-offer-letter')}}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" value="<?php print_r($candidate_offer->id)?>">
					<div class="clearfix"></div>
					
					<div class="lv-due" style="border:none;">
					   <div class="row form-group lv-due-body">
						  <div class="col-md-4">
							 <label for="title" class="placeholder">Candidate Name</label>
                             <input type="text" id="offered_sal" class="form-control " value="<?php print_r($candidate_offer->name) ?>"  required="" name="name" readonly>
						  </div>
						  <div class="col-md-4">
								   <label for="title" class="placeholder">Offered Salary</label>
								   <input type="text" id="offered_sal" class="form-control " value="<?php print_r($candidate_offer->offered_sal) ?>"  required="" name="offered_sal">
						  </div>
						 
						  <div class="col-md-4">
							 <div class=" form-group">
								<label for="editor"  class="placeholder">Payment Type</label>
								<select id="payment_type" class="form-control "  required="" name="payment_type">
									<option value="">Select</option>
                                    <option value="Year" <?php if ($candidate_offer->payment_type == "Year") echo 'selected="selected"'; ?>>Year</option>
									 <option value="Month" <?php if ($candidate_offer->payment_type == "Month") echo 'selected="selected"'; ?>>Month</option>
									  <option value="Month" <?php if ($candidate_offer->payment_type == "Month") echo 'selected="selected"'; ?>>Month</option>
									   <option value="Week" <?php if ($candidate_offer->payment_type == "Week") echo 'selected="selected"'; ?>>Week</option>
										<option value="Day" <?php if ($candidate_offer->payment_type == "Day") echo 'selected="selected"'; ?>>Day</option>
										  <option value="Hour" <?php if ($candidate_offer->payment_type == "Hour") echo 'selected="selected"'; ?>>Hour</option>
							   </select>
							 </div>
						  </div>
						  <div class="col-md-4">
						   <div class=" form-group">
							  <label for="inputFloatingLabel-job-type" class="placeholder">Date Of Joining</label>	
							  <input type="date" id="date_jo" class="form-control" value="<?php print_r($candidate_offer->date_jo) ?>" required="" name="date_jo">
							 
						   </div>
						</div>
						<div class="col-md-4">
						   <div class=" form-group">
							  <label for="working_hour" class="placeholder">Reporting Authority</label>
							  <select class="form-control " id="selectFloatingLabelra" name="reportauthor" >
							  <option value="">Select</option>
							  @foreach($employeelists as $employeelist)
								<option value="{{$employeelist->emp_code}}" <?php if ($candidate_offer->reportauthor == $candidate_offer->reportauthor) echo 'selected="selected"'; ?>>{{$employeelist->emp_fname}} {{$employeelist->emp_mname}} {{$employeelist->emp_lname}} ({{$employeelist->emp_code}})</option>
							  @endforeach
							  </select>
						   </div>
						</div>
						<div class="col-md-4">
						   <div class=" form-group">
							  <label for="working_hour" class="placeholder">Address</label>
							  <input type="text" class="form-control" name="address" value="<?php print_r($candidate_offer->address) ?>" placeholder="Address">
						   </div>
						</div>
						<div class="col-md-4">
						   <div class=" form-group">
							  <label for="working_hour" class="placeholder">Pincode</label>
							  <input type="number" class="form-control" name="pincode" value="<?php print_r($candidate_offer->pincode) ?>" placeholder="Pincode">
						   </div>
						</div>
						<div class="col-md-4">
						   <div class=" form-group">
							  <label for="working_hour" class="placeholder">State</label>
							  <input type="text" class="form-control" name="state" value="<?php print_r($candidate_offer->state) ?>" placeholder="Pincode">
						   </div>
						</div>
						<div class="col-md-4">
						   <div class=" form-group">
							  <label for="working_hour" class="placeholder">Method Type</label>
							  <select class="form-control " id="selectFloatingLabelra" name="method_type" >
							  <option value="">Select</option>
							  <option value="Bellevue" <?php if ($candidate_offer->method_type == "Bellevue") echo 'selected="selected"'; ?>>Bellevue Hospital</option>
							  <option value="Nursing" <?php if ($candidate_offer->method_type == "Nursing") echo 'selected="selected"'; ?>>Nursing Collage</option>
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