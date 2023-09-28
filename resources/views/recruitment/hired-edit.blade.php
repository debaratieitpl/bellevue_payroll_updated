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
            <h5 class="card-title">Hired Details</h5>
         </div>
         <div class="col-md-6">
            <span class="right-brd" style="padding-right:15x;">
               <ul class="">
                  <li><a href="#">Recruitment</a></li>
                  <li>/</li>
                  <li><a href="#">Hired</a></li>
                  <li>/</li>
                  <li class="active">Hired  Details</li>
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
                  <form action="#" method="post" enctype="multipart/form-data">
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
                              <h5>Current Salary:<span> @if($job->sal!='') {{ number_format($job->sal,2)}} @endif</span></h5>
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="app-form-text">
                              <h5>Current Location / Address:<span>{{$job->location}} @if(!empty($job->zip)), {{$job->zip}} @endif</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Expected Salary:<span>@if($job->sal!='') {{ number_format($job->exp_sal,2)}}  @endif</span></h5>
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
                        @if($job->recruited!='')
                        <div class="col-md-6">
                           <div class="app-form-text">
                              <h5>Are  there suitable settled workers available to be recruited for this role ?:<span>{{ $job->recruited }} @if($job->recruited=='Yes')( {{ $job->other }} ) @endif</span></h5>
                           </div>
                        </div>
                        @endif
                        <div class="col-md-4">
                           <div class="app-form-text">
                              <h5>Current Stage of Recruitment:<span>{{ $job->status}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="app-form-text">
                              <h5>Remarks:<span>{{ $job_details->remarks}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="app-form-text">
                              <h5>Date:<span>{{  date('d/m/Y',strtotime($job_details->date))}}</span></h5>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <?php  if($job->upload_sh!=''){   ?>
                           <button class="btn btn-primary download" type="button" style="    margin: 11px 0 0;"><a href="{{asset('public/'.$job->upload_sh)}}" download>Download Interview Sheet</a></button>
                           <?php
                              }
                              
                              ?>
                        </div>
                     </div>
                     <div class="row form-group" style="background:none;margin-top:15px">
                        <div class="col-md-12">
                           <button class="btn btn-info sub" type="button" onclick="goBack()">Back</button>
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
<script>
CKEDITOR.replace( 'editor' );
function goBack() {
  window.history.back();
}
</script>
@endsection