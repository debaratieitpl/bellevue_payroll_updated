@extends('recruitment.layouts.master')

@section('title')
BELLEVUE Candidate- Edit
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
                <h5 class="card-title">Candidate Edit</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Recruitment</a></li>
                                <li>/</li>
                                <li><a href="#">Job Applied</a></li>
                        <li>/</li>
                        <li class="active">Candidate Edit</li>
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
                        <form action="{{url('recruitment/edit-candidate')}}" method="post" enctype="multipart/form-data">
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
                                     <h5>Candidate Address:<span>{{$job->location}} @if(!empty($job->zip)) , {{$job->zip}} @endif</span></h5>
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
                               <!--<div class="col-md-4">-->
                               <!--	<div class="app-form-text">-->
                               <!--		<h5>Skill level:<span>{{$job->skill_level}}</span></h5>-->
                               <!--	</div>-->
                               <!--</div>-->
                               <div class="col-md-4">
                                  <div class="app-form-text">
                                     <h5>Most Recent Employer:<span>{{$job->cur_or}}</span></h5>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="app-form-text">
                                     <h5>Most Recent Job Title:<span>{{$job->cur_deg}}</span></h5>
                                  </div>
                               </div>
                               <!--<div class="col-md-4">-->
                               <!--		<div class="app-form-text">-->
                               <!--			<h5>Current Salary:<span> @if($job->sal!='') {{ number_format($job->sal,2)}} @endif</span></h5>-->
                               <!--		</div>-->
                               <!--</div>-->
                               <div class="col-md-4">
                                  <div class="app-form-text">
                                     <h5>Expected Salary (GBP):<span> @if($job->exp_sal!='') {{ number_format($job->exp_sal,2)}}  @endif</span></h5>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class="app-form-text">
                                     <h5>Application Date:<span> <?php
                                        // 											echo date('d/m/Y',strtotime($job->date));
                                           // if($job->date>='2021-02-22'){
                                              //  echo ' '.date('h:i A ',strtotime($job->date));
                                           // }
                                               ?>
                                        <input type="date" name="application_date" id="application_date" value="{{date('Y-m-d',strtotime($job->date))}}" class="form-control">	
                                        </span>
                                     </h5>
                                  </div>
                               </div>
                            </div>
                            <!--------------------  -->
                            <div class="row form-group" style="padding: 3px 0 15px;">
                               <div class="col-md-4">
                                  <div class=" form-group current-stage">
                                     <label  >Current Stage of Recruitment</label>
                                     <select class="form-control" required="" name="status"  style="margin-top: 10px;" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                        }
                                        
                                        ?>
                                        >
                                        <option value=""><?php  if($job->status!=''){ echo $job->status;  } ?></option>
                                        <option value="Short listed"  <?php  if($job->status!=''){  if($job->status=='Short listed'){ echo 'selected';} } ?> >Short listed</option>
                                        <option value="Rejected" <?php  if($job->status!=''){  if($job->status=='Rejected'){ echo 'selected';} } ?>>Rejected</option>
                                     </select>
                                  </div>
                               </div>
                               @if($job->recruited!='')
                               <div class="col-md-6">
                                  <div class="app-form-text">
                                     <h5>Are  there suitable settled workers available to be recruited for this role ?:<span>{{ $job->recruited }} @if($job->recruited=='Yes')( {{ $job->other }} ) @endif</span></h5>
                                  </div>
                               </div>
                               @endif
                               <div class="col-md-4">
                                  <div class="form-group current-stage">
                                     <label  >How the candidate applied ? </label>
                                     <select class="form-control" required="" name="apply"  style="margin-top: 10px;" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                        }
                                        
                                        ?>
                                        >
                                        <?php  if($job->apply==''){?>	   
                                        <option value="">Online</option>
                                        <?php } ?>
                                        <option value="Internal Job"  <?php  if($job->apply!=''){  if($job->apply=='Internal Job '){ echo 'selected';} } ?> >Internal Job</option>
                                        <option value="External Job" <?php  if($job->apply!=''){  if($job->apply=='External Job'){ echo 'selected';} } ?>>External Job</option>
                                     </select>
                                  </div>
                               </div>
                               <div class="col-md-4" style="margin-top:35px;">
                                  <button class="btn btn-info download" type="button" style=""><a href="{{asset('public/'.$job->resume)}}" download>Download Resume</a></button>
                               </div>
                               <div class="col-md-4">
                                  <?php  if($job->cover_letter!=''){   ?>
                                  <button class="btn btn-info download" type="button" style="    margin: 11px 0 0;"><a href="{{asset('public/'.$job->cover_letter)}}" download>Download Cover Letter</a></button>
                                  <?php
                                     }
                                     
                                     ?>
                               </div>
                            </div>
                            <div class="row form-group" style="    padding: 9px 0 15px;">
                               <div class="col-md-6">
                                  <div class=" form-group">
                                     <label>Remarks</label>	
                                     <input type="text" class="form-control" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                        }
                                        
                                        ?> value="<?php  if($job->remarks!=''){  echo $job->remarks; } ?>"  name="remarks">
                                     <!--<label for="inputFloatingLabel-remarks" class="placeholder remarks"></label>-->
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class=" form-group">
                                     <label>Date</label>	
                                     <input type="date" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                        }
                                        
                                        ?> class="form-control" required=""  value="<?php  if( isset($job_details ) && !empty($job_details) ){  echo date('Y-m-d', strtotime($job_details->date)); }?>"  name="date"  >
                                     <!--<label for="inputFloatingLabel-date" class="placeholder remarks">Date</label>-->
                                  </div>
                               </div>
                            </div>
                            <div class="row form-group" style="margin-top: 25px;background:none">
                               <?php  if($job->status!=''){  
                                  if($job->status=='Application Received'){ ?>
                               <div class="col-md-12">
                                  <button class="btn btn-default sub" type="submit">Submit</button>
                               </div>
                               <?php }
                                  else{
                                  ?>
                               <!-- <div class="col-md-12">
                                  <button class="btn btn-default sub" type="button" onclick="goBack()">Back</button>
                                  </div> -->
                               <div class="col-md-12">
                                  <button class="btn btn-primary sub" type="submit">Submit</button>
                               </div>
                               <?php
                                  }
                                  }
                                  ?>
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