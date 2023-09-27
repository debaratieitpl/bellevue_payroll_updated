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
            <h5 class="card-title">{{ !empty($designation[0]->id) ? 'Update Job Published' : 'Add New Job Published' }}</h5>
         </div>
         <div class="col-md-6">
            <span class="right-brd" style="padding-right:15x;">
               <ul class="">
                  <li><a href="#">Recruitment</a></li>
                  <li>/</li>
                  <li><a href="#">Job Published</a></li>
                  <li>/</li>
                  <li class="active">{{ !empty($designation[0]->id) ? 'Update Job Published' : 'Add New Job Published' }}</li>
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
                     <input type="hidden" name="id" value="{{ isset($designation[0]->id) ? $designation[0]->id : '' }}">
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
                              <select id="job_id" class="form-control input-border-bottom" required="" name="job_id"  onchange="chngdepartment(this.value);">
                                 <option value="">&nbsp;</option>
                                 @foreach($department_rs as $dept)
                                 <?php
                                    if(isset($_GET['id'])){
                                      
                                     if($designation[0]->job_id==$dept->id){
                                         ?>
                                 <option value="{{$dept->id}}" <?php  if(isset($_GET['id'])){  if($designation[0]->job_id==$dept->id){ echo 'selected';} } ?>>{{$dept->soc}}</option>
                                 <?php
                                    }
                                    }else{
                                     $deptgf= DB::table('company_jobs')      
                                    ->where('soc','=',$dept->id) 
                                    ->first();
                                    ?>
                                 <option value="{{$dept->id}}" >{{$dept->soc}}</option>
                                 <?php
                                    }
                                    ?>
                                 @endforeach
                              </select>
                           </div>
                           <?php   if(isset($_GET['id'])){
                              ?>
                           <div class="col-md-4">
                              <label for="title" class="placeholder">Job Title</label>
                              <input id="title" type="text"  name="title" class="form-control input-border-bottom" required=""  value="<?php if(isset($_GET['id'])){  echo $designation[0]->title;  }?>{{ old('title') }}" 	<?php if(isset($_GET['id'])){ echo 'readonly';}?>>
                           </div>
                           <?php
                              }else{
                                  ?>
                           <div class="col-md-4">
                              <div class=" form-group">
                                 <label for="title" class="placeholder">Job Title</label>
                                 <select id="title" class="form-control input-border-bottom" required="" name="title"  onchange="chngdepartmentdesp(this.value);">
                                    <option value="">&nbsp;</option>
                                 </select>
                              </div>
                           </div>
                           <?php
                              }
                              ?>
                           <div class="col-md-4">
                              <div class=" form-group">
                                 <label for="department" class="placeholder">Department</label>
                                 <input id="department" type="text" class="form-control input-border-bottom" required="" name="department" value="<?php if(isset($_GET['id'])){  echo $designation[0]->department;  }?>{{ old('title') }}" <?php if(isset($_GET['id'])){ echo 'readonly';}?>>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class=" form-group">
                                 <label for="editor"  class="placeholder">Job Descriptions</label>
                                 <textarea id="editor" name="job_desc" type="text"  rows="5" class="form-control"  required="" <?php if(isset($_GET['id'])){ echo '';}?>><?php if(isset($_GET['id'])){  ?>  {!! $designation[0]->job_desc !!} <?php  }?>  </textarea>  
                              </div>
                           </div>
                           <div class="col-md-12">
                              <h5 style="color:#1269db;border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px;">Published websites</h5>
                           </div>
                        </div>
                        <div id="education_fields">
                           <?php if(isset($_GET['id'])){ ?> 
                           <?php   $trupload_id=0;
                              $rr=1;
                                $deptgfhh= DB::table('job_posts')      
                                      
                                       ->where('job_id','=',$designation[0]->job_id) 
                                       ->where('title','=',$designation[0]->title) 
                                       ->get();
                                  
                              $countpayuppas= count($deptgfhh)			;?>
                           @if ($countpayuppas!=0)
                           @foreach($deptgfhh as $empuprs)
                           @if($empuprs->url!='')
                           <div class="row form-group">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    @if($trupload_id==0)
                                    <label class="placeholder">Published websites url/link   </label>
                                    @endif
                                    <input type="text" class="form-control input-border-bottom" id="url_{{ $empuprs->id}}"  name="url_{{ $empuprs->id}}" value="{{ $empuprs->url}}" >
                                    <input  type="hidden" class="form-control input-border-bottom" name="id_up_doc[]" value="{{ $empuprs->id}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    @if($trupload_id==0)
                                    <label for="other_doc_input_{{ $empuprs->id}}">Upload Document  </label>
                                    @endif
                                    @if($empuprs->scren!='')
                                    <a href="{{ asset('public/'.$empuprs->scren) }}" target="_blank" download  style="text-align: right;
                                       float: right;
                                       position: relative;
                                       top: 23px;
                                       right: 72px;"><i class="fa fa-download"></i></a>
                                    @endif
                                    <input type="file" class="form-control-file" id="docu_nat_{{ $empuprs->id}}" name="scren_{{ $empuprs->id}}"  onchange="Filevalidation({{ $empuprs->id}})">
                                 </div>
                                 @if($trupload_id==0)
                                 <span>*Document Size not more than 2 MB</span>
                                 @endif
                              </div>
                           </div>
                           @endif	
                           @endforeach   
                           <div class="row form-group">
                              <div class="col-md-2">
                                 <div class="input-group-btn">
                                    <button class="btn btn-success" type="button"  onclick="education_fields();"> <i class="fa fa-plus"></i> </button>
                                 </div>
                              </div>
                           </div>
                           @endif
                           <?php }else{?>
                           <div class="row form-group">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="placeholder">Published websites url/link   </label>
                                    <input type="text" class="form-control input-border-bottom" id="url_1" name="url[]"  >
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <label for="other_doc_input_1">Upload Document  </label>
                                 <input type="file" class="form-control-file" id="docu_nat_1" name="scren[]"  onchange="Filevalidation(1)">
                                 <span>*Document Size not more than 2 MB</span>
                              </div>
                           </div>
                           <div class="row form-group">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="placeholder">Published websites url/link   </label>
                                    <input type="text" class="form-control input-border-bottom" id="url_2" name="url[]"  >
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group" style="margin-top: 30px">
                                    <input type="file" class="form-control-file" id="docu_nat_2" name="scren[]"  onchange="Filevalidation(2)"  >
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="input-group-btn" style="margin-top: 33px;">
                                    <button class="btn btn-success" type="button"  onclick="education_fields();"> <i class="fa fa-plus"></i> </button>
                                 </div>
                              </div>
                           </div>
                           <?php } ?>
                        </div>
                        <div class="row form-group">
                           <div class="col-md-4 btn-up">
                              <button type="submit" class="btn btn-danger btn-sm">{{ !empty($designation[0]->id) ? 'Update' : 'Submit' }}</button>
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
<script>
   CKEDITOR.replace( 'editor' );
   var room = 3;
            function education_fields() {
            // alert(room);
            
               room++;
               var objTo = document.getElementById('education_fields')
               var divtest = document.createElement("div");
            divtest.setAttribute("class", "form-group removeclass"+room);
            var rdiv = 'removeclass'+room;
               divtest.innerHTML = '<div class="row form-group"><div class="col-md-6"><div class="form-group"><label class="placeholder">Published websites url/link   </label><input type="text" class="form-control input-border-bottom" id="url_'+ room +'"  name="url[]"  ></div></div><div class="col-md-4" id="other_doc'+ room +'" style="display:none"><div class="form-group"><input type="text"  id="newdoc_'+ room +'" class="form-control input-border-bottom"   name="other_doc[]"></div></div><div class="col-md-4"><div class="form-group" style="margin-top:30px;"><input type="file" class="form-control-file" required id="docu_nat_'+ room +'" name="scren[]"  onchange="Filevalidation('+ room +')"></div></div><div class="col-md-2" style="margin-top:30px;"><div class="input-group-btn"><button class="btn btn-success" style="margin-right: 15px;margin-bottom:0;" type="button"  onclick="education_fields();"> <i class="fa fa-plus"></i> </button><button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"><i class="fa fa-minus"></i></button></div></div></div>';
               
               objTo.appendChild(divtest)
            }
              function remove_education_fields(rid) {
               $('.removeclass'+rid).remove();
              }
   function chngdepartment(empid){
               
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
               var soc=$( "#job_id option:selected" ).val();
              
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
                              CKEDITOR.instances['editor'].setData(job_desc);
            				
            				 $("#job_desc").attr("readonly", true);
            				  $("#department").attr("readonly", true);
            		
            	}
            	});
              }
</script>
@endsection