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
                <h5 class="card-title">New Job Add</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Recruitment</a></li>
                                <li>/</li>
                                <li><a href="#">Job Lists</a></li>
                        <li>/</li>
                        <li class="active">Add New Job</li>
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
                        <form action="{{ url('recruitment/add-job-list') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ isset($recruitment_job_rs['id']) ? $recruitment_job_rs['id'] : '' }}">
                            <div class="clearfix"></div>
                            <div class="lv-due" style="border:none;">

                                <div class="row form-group lv-due-body">
                                    {{-- <div class="col-md-3">
                                        <label>Select Job Type</label>
                                        <select id="type" type="text" class="form-control input-border-bottom" required="" name="type" onchange="jobcheck(this.value);">
                                            <option value="" >&nbsp;</option>
                                         <option  value="new"  >New</option>
                                         <option  value="exiting"  >Existing</option>
                                       </select>
                                    </div> --}}
                                    @if ($recruitment_job_rs !='')
                                    <div class="col-md-3">
                                        <label>Job Code</label>
                                        <input id="inputFloatingLabel-soc-code" type="text" class="form-control input-border-bottom"  name="soc" value="{{ isset($recruitment_job_rs['soc']) ? $recruitment_job_rs['soc'] : '' }}" readonly>
                                    </div>
                                    @else
                                    <div class="col-md-3">
                                        <label>Job Code</label>
                                        <input id="inputFloatingLabel-soc-code" type="text" class="form-control input-border-bottom"  name="soc"  required>
                                    </div>
                                    @endif
                                   

                                    
                                    <div class="col-md-5">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Job Title  </label>
										<input id="inputFloatingLabel-job-title" type="text" class="form-control input-border-bottom" name="title" value="{{ isset($recruitment_job_rs['title']) ? $recruitment_job_rs['title'] : '' }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Department</label>
                                        <select id="socold" type="text" class="form-control input-border-bottom"  name="department" required>
                                            <option value="{{ isset($recruitment_job_rs['department']) ? $recruitment_job_rs['department'] : '' }}">{{ isset($recruitment_job_rs['department']) ? $recruitment_job_rs['department'] : '' }}</option>
                                           
                                           @foreach($department as $dept)
                                           <option>{{$dept->department_name}}</option>
                                            @endforeach  
                                           
                                       </select>
											
                                    </div>
                                    <div class="col-md-12">

                                    <div class=" form-group">
                                    <label for="editor"  class="placeholder">Job Descriptions</label>
                                    <textarea   rows="5" class="form-control"  required="" id="editor" name="des_job">{{ isset($recruitment_job_rs['des_job']) ? $recruitment_job_rs['des_job'] : '' }} </textarea>    
                                       
                                    
                                    
                                    </div>
                                </div>
                                   


                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4 btn-up">
                                        <button type="submit" class="btn btn-danger btn-sm">{{ !empty($recruitment_job_rs['id']) ? 'Update' : 'Submit' }}</button>
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
@endsection