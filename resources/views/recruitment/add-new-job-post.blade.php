@extends('recruitment.layouts.master')
@section('title')
BELLEVUE Job - Add 
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
            <h5 class="card-title">{{ !empty($job_details['id']) ? 'Update Post' : 'Add New Job Post' }}</h5>
         </div>
         <div class="col-md-6">
            <span class="right-brd" style="padding-right:15x;">
               <ul class="">
                  <li><a href="#">Recruitment</a></li>
                  <li>/</li>
                  <li><a href="#">Job Post</a></li>
                  <li>/</li>
                  <li class="active">{{ !empty($job_details['id']) ? 'Update Post' : 'Add New Job Post' }}</li>
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
                  <form action="" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <input type="hidden" name="id" value="{{ isset($job_details['id']) ? $job_details['id'] : '' }}">
                     <div class="clearfix"></div>
                     <div class="lv-due" style="border:none;">
                        <div class="row form-group lv-due-body">
                           {{-- 
                           <div class="col-md-3">
                              <label>Select Job Type</label>
                              <select id="type" type="text" class="form-control input-border-bottom" required="" name="type" onchange="jobcheck(this.value);">
                                 <option value="" >&nbsp;</option>
                                 <option  value="new"  >New</option>
                                 <option  value="exiting"  >Existing</option>
                              </select>
                           </div>
                           --}}
                           <div class="col-md-3">
                              <label>Job Code</label>
                              <select id="soc" class="form-control input-border-bottom" required="" name="soc"  onchange="chngdepartment(this.value);">
                                 <option value="">&nbsp;</option>
                                 @foreach($jobs_list as $dept)
                                 <option value="{{$dept->id}}" <?php  if(isset($job_details['id'])){  if($job_details['soc']==$dept->id){ echo 'selected';} } ?>>{{$dept->soc}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="col-md-5">
                              <?php   if(isset($_GET['id'])){
                                 ?>
                              
                                 <label for="title" class="placeholder">Job Title</label>
                                 <input id="title" type="text"  name="title" class="form-control input-border-bottom" required=""  value="<?php if(isset($_GET['id'])){  echo $job_details['title'];  }?>{{ old('title') }}" >
                              <?php
                                 }else{
                                     ?>
                                    <label for="title" class="placeholder">Job Title</label>
                                    <select id="title" class="form-control input-border-bottom" required="" name="title"  onchange="chngdepartmentdesp(this.value);">
                                       <option value="">&nbsp;</option>
                                    </select>
                              <?php
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="col-md-4">
                              <label>Department</label>
                              <input id="department" type="text" class="form-control input-border-bottom" required="" name="department" value="<?php if(isset($_GET['id'])){  echo $job_details['department'];  }?>{{ old('department') }}" <?php if(isset($_GET['id'])){ echo 'readonly';}?>>
                           </div>
                           <div class="col-md-12">
                              <div class=" form-group">
                                 <label for="editor"  class="placeholder">Job Descriptions</label>
                                 <textarea id="editor" name="job_desc" type="text"  rows="5" class="form-control"  required="" <?php if(isset($_GET['id'])){ echo '';}?>><?php if(isset($_GET['id'])){  ?>  {!! $job_details['job_desc'] !!} <?php  }?>  </textarea>  
                              </div>
                           </div>
                           <div class="col-md-4">
                            <div class=" form-group">
                               <label for="inputFloatingLabel-job-type" class="placeholder">Job Type</label>	
                               <select id="inputFloatingLabel-job-type" name="job_type" type="text" class="form-control input-border-bottom" required="">
                                  <option value="">&nbsp;</option>
                                  <option value="Full Time"  <?php  if(request()->get('id')!=''){  if($job_details['job_type']=='Full Time'){ echo 'selected';} } ?>>Full Time</option>
                                  <option value="Part Time"  <?php  if(request()->get('id')!=''){  if($job_details['job_type']=='Part Time'){ echo 'selected';} } ?>>Part Time</option>
                                  <option value="Contractual"  <?php  if(request()->get('id')!=''){  if($job_details['job_type']=='Contractual'){ echo 'selected';} } ?>>Contractual</option>
                               </select>
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class=" form-group">
                               <label for="working_hour" class="placeholder">Working Hours (Weekly)</label>
                               <select id="working_hour" name="working_hour" class="form-control input-border-bottom" required="">
                                  <option value="">&nbsp;</option>
                                  @for ($i = 1; $i <= 80; $i+=0.5)
                                  <option value="{{ $i }}" <?php  if(request()->get('id')!=''){  if($job_details['working_hour']==$i){ echo 'selected';}}  ?>>{{ $i }}</option>
                                  @endfor
                               </select>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <label for="inputFloatingLabel-salary" class="placeholder">Job Experience</label>
                            <div class="row">
                               <div class="col-md-4">
                                  <div class=" form-group">
                                     <select id="inputFloatingLabel-selaect-salary" name="work_min"  class="form-control input-border-bottom" required="">
                                        <option value="">Min</option>
                                        @for ($i = 0; $i <= 15; $i++)
                                        <option value="{{ $i }}" <?php  if(request()->get('id')!=''){  if($job_details['work_min']==$i){ echo 'selected';}}  ?>>{{ $i }}</option>
                                        @endfor
                                     </select>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class=" form-group">
                                     <select id="inputFloatingLabel-selaect-salary" name="work_max"   class="form-control input-border-bottom" required="">
                                        <option  value="">Max</option>
                                        @for ($j = 0; $j <= 50; $j++)
                                        <option value="{{ $j }}" <?php  if(request()->get('id')!=''){  if($job_details['work_max']==$j){ echo 'selected';}}  ?>>{{ $j }}</option>
                                        @endfor
                                     </select>
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="row">
                               <div class="col-md-4">
                                  <div class=" form-group">
                                     <label for="basic_min" class="placeholder">Min(Basic Salary)</label>
                                     <input id="basic_min" type="text" class="form-control input-border-bottom" required="" name="basic_min"  value="<?php if(isset($_GET['id'])){  echo $job_details['basic_min'];  }?>{{ old('basic_min') }}">
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class=" form-group">	
                                     <label for="basic_max" class="placeholder">Max(Basic Salary)</label>	
                                     <input id="basic_max" type="text" class="form-control input-border-bottom" required="" name="basic_max"  value="<?php if(isset($_GET['id'])){  echo $job_details['basic_max'];  }?>{{ old('basic_max') }}">
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class=" form-group">
                                     <label for="time_pre" class="placeholder"> Period </label>	
                                     <select class="form-control input-border-bottom" id="time_pre" required="" name="time_pre">
                                        <option value="">&nbsp;</option>
                                        <option value="Annually" <?php  if(request()->get('id')!=''){  if($job_details['time_pre']=='Annually'){ echo 'selected';} } ?>>Annually</option>
                                        <option value="Monthly"  <?php  if(request()->get('id')!=''){  if($job_details['time_pre']=='Monthly'){ echo 'selected';} } ?>>Monthly</option>
                                        <option value="Hourly"  <?php  if(request()->get('id')!=''){  if($job_details['time_pre']=='Hourly'){ echo 'selected';} } ?>>Hourly</option>
                                     </select>
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class=" form-group">	
                               <label for="inputFloatingLabel-add-1" class="placeholder">Number Of Vacancies</label>				
                               <input id="inputFloatingLabel-add-1" type="number" class="form-control input-border-bottom" required="" name="no_vac"  value="<?php if(isset($_GET['id'])){  echo $job_details['no_vac'];  }?>{{ old('no_vac') }}">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class=" form-group">	
                               <label for="inputFloatingLabel-add-2" class="placeholder">Job Location</label>
                               <input id="inputFloatingLabel-add-2" type="text" class="form-control input-border-bottom" required="" name="job_loc"  value="<?php if(isset($_GET['id'])){  echo $job_details['job_loc'];  }?>{{ old('job_loc') }}">
                            </div>
                         </div>
                         <div class="col-md-12">
                            <h5 style="color:#1269db">Desired Candidate</h5>
                         </div>
                         <div class="col-md-4">
                            <div class=" form-group">	
                               <label for="inputFloatingLabel-qualification" class="placeholder">Qualifications</label>	
                               <input id="inputFloatingLabel-qualification" type="text" class="form-control input-border-bottom" required="" name="quli"  value="<?php if(isset($_GET['id'])){  echo $job_details['quli'];  }?>{{ old('quli') }}">
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class=" form-group">	
                               <label for="inputFloatingLabel-skill-set" class="placeholder">Skill Set</label>	
                               <input id="inputFloatingLabel-skill-set" type="text" class="form-control input-border-bottom" name="skill"  value="<?php if(isset($_GET['id'])){  echo $job_details['skill'];  }?>{{ old('skill') }}">
                            </div>
                         </div>
                         <div class="col-md-4">
                            <label for="inputFloatingLabel-age" class="placeholder">Age</label>
                            <input id="skil_set" type="hidden" class="form-control input-border-bottom" required="" name="skil_set" value="<?php if(isset($_GET['id'])){  echo $job_details['skil_set'];  }?>{{ old('skil_set') }}" >
                            <div class="row">
                               <div class="col-md-4">
                                  <div class=" form-group">
                                     <select id="inputFloatingLabel-age"  name="age_min" class="form-control input-border-bottom" required="">
                                        <option value="">Min</option>
                                        @for ($k = 15; $k <= 35; $k++)
                                        <option value="{{ $k }}" <?php  if(request()->get('id')!=''){  if($job_details['age_min']==$k){ echo 'selected';}}  ?>>{{ $k }}</option>
                                        @endfor
                                     </select>
                                  </div>
                               </div>
                               <div class="col-md-4">
                                  <div class=" form-group">
                                     <select id="inputFloatingLabel-age" name="age_max"  class="form-control input-border-bottom" required="">
                                        <option value="">Max</option>
                                        @for ($l = 30; $l <= 70; $l++)
                                        <option value="{{ $l }}" <?php  if(request()->get('id')!=''){  if($job_details['age_max']==$l){ echo 'selected';}}  ?>>{{ $l }}</option>
                                        @endfor
                                     </select>
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class=" form-group">
                               <!-- 	<input id="inputFloatingLabel-gender" type="text" class="form-control input-border-bottom" required="" style="margin-top: 22px;">
                                  <label for="inputFloatingLabel-gender" class="placeholder">Gender</label> -->
                               <h6>Gender</h6>
                               <input type="checkbox" id="gender_male" name="gender_male" value="Male" <?php  if(request()->get('id')!=''){  if($job_details['gender_male']=='Male'){ echo 'checked';} } ?>>
                               <label for="vehicle1">Male</label>&nbsp &nbsp &nbsp
                               <input type="checkbox" id="gender" name="gender" value="Female" <?php  if(request()->get('id')!=''){  if($job_details['gender']=='Female'){ echo 'checked';} } ?>>
                               <label for="vehicle1">Female</label>
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class=" form-group">
                               <label for="inputFloatingLabel-job-posting-date"  class="placeholder">Job Posting Date</label>
                               <input id="inputFloatingLabel-job-posting-date"  type="date"  class="form-control input-border-bottom" required="" name="post_date"  value="<?php if(isset($_GET['id'])){  echo $job_details['post_date'];  }?>{{ old('post_date') }}" <?php if(isset($_GET['id'])){ ?> readonly  <?php }else{?> max="{{date('Y-m-d')}}" <?php } ?> >
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class=" form-group">
                               <label for="inputFloatingLabel-end-date"  class="placeholder">Closing Date</label>
                               <input id="inputFloatingLabel-end-date"  type="date"  class="form-control input-border-bottom" required="" name="clos_date"  value="<?php if(isset($_GET['id'])){  echo $job_details['clos_date'];  }?>{{ old('clos_date') }}">
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class=" form-group">
                               <label for="author" class="placeholder"> Authorising Officer</label>
                               <input id="author" type="text" class="form-control input-border-bottom" required="" name="author"  value="<?php if(isset($_GET['id'])){  echo $job_details['author'];  }?>{{ old('author') }}">
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class=" form-group">
                               <label for="desig" class="placeholder"> Authorising Officer’s Designation</label>
                               <input id="desig" type="text" class="form-control input-border-bottom" required=""  name="desig"  value="<?php if(isset($_GET['id'])){  echo $job_details['desig'];  }?>{{ old('desig') }}">
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class=" form-group">
                               <label for="inputFloatingLabel-mail" class="placeholder"> Contact Number</label>
                               <input id="inputFloatingLabel-mail" type="tel" class="form-control input-border-bottom" required=""  name="con_num"  value="<?php if(isset($_GET['id'])){  echo $job_details['con_num'];  }?>{{ old('con_num') }}">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class=" form-group">
                               <label for="inputFloatingLabel-number" class="placeholder">Email</label>
                               <input id="inputFloatingLabel-number" type="email" class="form-control input-border-bottom" required="" name="email"  value="<?php if(isset($_GET['id'])){  echo $job_details['email'];  }?>{{ old('email') }}">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class=" form-group">
                               <label for="role" class="placeholder">Is this a new role</label>
                               <select class="form-control input-border-bottom" id="role" required="" name="role">
                                  <option value="">&nbsp;</option>
                                  <option value="Yes" <?php  if(request()->get('id')!=''){  if($job_details['role']=='Yes'){ echo 'selected';} } ?>>Yes</option>
                                  <option value="No"  <?php  if(request()->get('id')!=''){  if($job_details['role']=='No'){ echo 'selected';} } ?>>No</option>
                               </select>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class=" form-group">
                               <label for="english_pro" class="placeholder">Language Requirements
                               </label>		
                               <select class="form-control input-border-bottom" id="english_pro"  name="english_pro" required="" onchange="trade_epmloyee(this.value);">
                                  <option value="">&nbsp;</option>
                                  <option value="English Proficiency - Minimum of  UKVI IELTS 4 or  equivalent for international candidates only" <?php  if(request()->get('id')!=''){  if($job_details['english_pro']=='English Proficiency - Minimum of  UKVI IELTS 4 or  equivalent for international candidates only'){ echo 'selected';} } ?>>English Proficiency - Minimum of  UKVI IELTS 4 or  equivalent for international candidates only</option>
                                  <option value="Not Required" <?php  if(request()->get('id')!=''){  if($job_details['english_pro']=='Not Required'){ echo 'selected';} } ?>>Not Required</option>
                                  <option value="Others" <?php  if(request()->get('id')!=''){  if($job_details['english_pro']=='Others'){ echo 'selected';} } ?>>Others</option>
                               </select>
                            </div>
                         </div>
                         <div class="col-md-4 " id="criman_new" <?php   if(request()->get('id')!=''){ if($job_details['english_pro']=='Others'){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }}else{ ?> style="display:none;" <?php  }  ?>>
                            <div class="form-group">
                               <label for="other" class="placeholder">Give Details </label>
                               <input id="other" type="text" class="form-control input-border-bottom" name="other"  value="@if(request()->get('id')!='') @if($job_details['other']){{  $job_details[0]->other }}@endif @endif">
                            </div>
                         </div>
                         <?php  if(request()->get('id')!=''){
                            ?>
                         <div class="col-md-4">
                            <div class=" form-group">
                               <label for="status" class="placeholder">Status</label>		
                               <select class="form-control input-border-bottom" id="status" required="" name="status">
                                  <option value="">&nbsp;</option>
                                  <option value="Job Created" <?php  if(request()->get('id')!=''){  if($job_details['status']=='Job Created'){ echo 'selected';} } ?>>Job Created</option>
                                  <option value="Published"  <?php  if(request()->get('id')!=''){  if($job_details['status']=='Published'){ echo 'selected';} } ?>>Published</option>
                               </select>
                            </div>
                         </div>
                         <?php } ?>
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
<script>
   function chngdepartment(empid){
           // alert(empid);
           $.ajax({
           type:'GET',
           url:'{{url('pis/getjobpostByIdlkkk')}}/'+empid,
           cache: false,
           success: function(response){
           document.getElementById("title").innerHTML = response;  
           }
       });
   }
   function chngdepartmentdesp(empid){
   var soc=$( "#soc option:selected" ).val();
   
   	$.ajax({
   type:'GET',
   url:'{{url('pis/getjobpostByIdlkkkll')}}/'+empid+'/'+soc,
       cache: false,
   success: function(response){
   console.log(response);
   var obj = jQuery.parseJSON(response);
   var job_desc=obj.des_job;
    var department=obj.department;
   
   
      $("#job_desc").val(job_desc);
      $("#skil_set").val(obj.skil_set);
      $("#department").val(department);
      $("#job_desc").val(job_desc);
      CKEDITOR.instances['editor'].setData(job_desc);
      $("#department").attr("readonly", true);
   
   }
   });
   }
</script>
@endsection