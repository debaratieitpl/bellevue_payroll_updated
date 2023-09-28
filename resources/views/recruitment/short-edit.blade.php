@extends('recruitment.layouts.master')
@section('title')
BELLEVUE Short Listing  Details
@endsection
@section('sidebar')
@include('recruitment.partials.sidebar')
@endsection
@section('header')
@include('recruitment.partials.header')
@endsection
@section('content')
<!-- Content -->
<div class="content">
   <!-- Animated -->
   <div class="animated fadeIn">
      <div class="row" style="border:none;">
         <div class="col-md-6">
            <h5 class="card-title">Short Listing  Details</h5>
         </div>
         <div class="col-md-6">
            <span class="right-brd" style="padding-right:15x;">
               <ul class="">
                  <li><a href="#">Recruitment</a></li>
                  <li>/</li>
                  <li><a href="#">Job Applied</a></li>
                  <li>/</li>
                  <li class="active">Short Listing  Details</li>
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
                  @include('include.messages')
                  <form action="{{url('recruitment/edit-short-listing')}}" method="post" enctype="multipart/form-data">
                     {{csrf_field()}}
                     <input id="id" type="hidden"  name="id" class="form-control input-border-bottom" required="" value="<?php   echo $job->id;  ?>" >
                     <input id="id" type="hidden"  name="job_id" class="form-control input-border-bottom" required="" value="<?php   echo $job->job_id;  ?>" >
                     <div class="row form-group">
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Job Title:<span>{{$job->job_title}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Candidate Name:<span>{{$job->name}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Email:<span>{{$job->email}}</span></h5>
                           </div>
                        </div>
                        @if($job->dob!='')
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Date Of Birth:<span>{{ date('d/m/Y',strtotime($job->dob))}}</span></h5>
                           </div>
                        </div>
                        @endif
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Contact Number:<span>+{{$job->phone}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Gender:<span>{{$job->gender}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Total Year of Experience:<span>{{$job->exp}} Years {{$job->exp_month}} Months</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Education Qualification:<span>{{$job->edu}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Skill Set:<span>{{$job->skill}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Skill level:<span>{{$job->skill_level}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Current Organization:<span>{{$job->cur_or}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Current Job Title:<span>{{$job->cur_deg}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Current Salary:<span> @if($job->sal!='')  {{ number_format($job->sal,2)}}  @endif</span></h5>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="app-form-text">
                              <h5>Current Location / Address:<span>{{$job->location}} @if(!empty($job->zip)) ,{{$job->zip}} @endif</span></h5>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="app-form-text">
                              <h5>Expected Salary:<span>@if($job->exp_sal!='') {{ number_format($job->exp_sal,2)}} @endif</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Apply Date:<span> <?php
                                 echo date('d/m/Y',strtotime($job->date));
                                 if($job->date>='2021-02-22'){
                                 echo ' '.date('h:i A ',strtotime($job->date));
                                 }
                                 ?></span></h5>
                           </div>
                        </div>
                        @if($job->apply!='')
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>How the candidate applied ?:<span>{{ $job->apply }}</span></h5>
                           </div>
                        </div>
                        @endif
                     </div>
                     <!--------------------  -->
                     <div class="row form-group" style="padding: 3px 0 15px;">
                        <div class="col-md-4">
                           <div class=" form-group current-stage">
                              <label  >Are  there suitable settled workers available to be recruited for this role ?</label>
                              <select class="form-control" required="" name="recruited"  style="margin-top: 10px;"  onchange="trade_epmloyee(this.value);">
                                 <option value=""   >Select</option>
                                 <option value="Yes"  <?php  if($job->recruited!=''){  if($job->recruited=='Yes'){ echo 'selected';} } ?> >Yes</option>
                                 <option value="No" <?php  if($job->recruited!=''){  if($job->recruited=='No'){ echo 'selected';} } ?>>No</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4 " id="criman_new" <?php  if($job->recruited=='Yes'){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }  ?>>
                           <div class="form-group">
                              <label for="other" class="placeholder">Give Details </label>
                              <input id="other" type="text" class="form-control input-border-bottom" name="other"  value=" @if($job->other){{  $job->other }}@endif ">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class=" form-group current-stage">
                              <label>Current Stage of Recruitment</label>
                              <select class="form-control" required="" name="status"  style="margin-top: 10px;">
                                 <option value=""><?php  if($job->status!=''){ echo $job->status;  } ?></option>
                                 <option value="Interview"  <?php  if($job->status!=''){  if($job->status=='Interview'){ echo 'selected';} } ?> >Interview</option>
                                 <option value="Hold" <?php  if($job->status!=''){  if($job->status=='Hold'){ echo 'selected';} } ?>>Hold</option>
                              </select>
                              <!--<label for="inputFloatingLabel-recruitment" class="placeholder">Current Stage of Recruitment</label>-->
                           </div>
                        </div>
                        <div class="col-md-8" style="    padding-top: 25px;">
                           <div class=" form-group">
                              <input type="text" placeholder="Remarks" style="margin-top:9px" class="form-control" value="<?php  if($job->remarks!='') {  if($job->status=='Hold' || $job->status=='Interview'){  echo $job->remarks;} } ?>" name="remarks">
                           </div>
                        </div>
                     </div>
                     <div class="row form-group">
                        <div class="col-md-4">
                           <div class="form-group" style="margin: 7px 0 15px;">
                              <label>Date </label>	
                              <input type="date" class="form-control" required=""  value="<?php  if(!empty($job_details)){ if($job->status=='Hold' || $job->status=='Interview'){  echo $job_details->date;} } ?>"  name="date">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group" style="margin: 7px 0 15px;">
                              <label>From Time </label>	
                              <input type="time" class="form-control" required=""  value="<?php  if(!empty($job_details)){ if($job->status=='Hold' || $job->status=='Interview'){  echo $job_details->from_time;} } ?>"  name="from_time">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group" style="margin: 7px 0 15px;">
                              <label>To Time </label>	
                              <input type="time" class="form-control" required=""  value="<?php  if(!empty($job_details)){ if($job->status=='Hold' || $job->status=='Interview'){  echo $job_details->to_time;} } ?>"  name="to_time">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class=" form-group" style="margin: 7px 0 15px;">
                              <input type="text" placeholder="Interview Place" style="margin-top:9px" class="form-control" value="<?php  if($job->place!='') {  if($job->status=='Hold' || $job->status=='Interview'){  echo $job->place;} } ?>"  name="place">
                           </div>
                        </div>
                        <div class="col-md-6" >
                           <div class=" form-group" style="margin: 7px 0 15px;">
                              <input type="text" placeholder="Interview Panel " style="margin-top:9px" class="form-control" value="<?php  if($job->panel!='') {  if($job->status=='Hold' || $job->status=='Interview'){  echo $job->panel;} } ?>"  name="panel">
                           </div>
                        </div>
                     </div>
                     <div class="row form-group" style="margin-top:15px;background:none;">
                        <div class="col-md-12">
                           <button class="btn btn-info sub" type="submit">Submit</button>
                        </div>
                     </div>
                  </form>
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
<div class="clearfix"></div>
@endsection
@section('scripts')
@include('recruitment.partials.scripts')
<script>CKEDITOR.replace( 'editor' );</script>
@endsection