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
                <h5 class="card-title">Job Apply</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Recruitment</a></li>
                                <li>/</li>
                                <li><a href="#">Job Lists</a></li>
                        <li>/</li>
                        <li class="active">Job Apply</li>
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
                        <form action="{{ url('recruitment/saveapply') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="clearfix"></div>
                            <div class="lv-due" style="border:none;">

                                <div class="row form-group lv-due-body">
                                    
                                    <div class="col-md-4">
                                        <label>Job Title <span style="color:red">*</span></label>
                                        <select class="form-control" name="job_title" id="jobTitleSelect" required="">
                                            <option value="">Select Job Title</option>
                                            @foreach($jobs as $job)
                                                <option value="{{ $job->title }}" data-job-id="{{ $job->id }}">{{ $job->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                        <input type="hidden" class="form-control" name="job_id" id="jobIdInput" >
                                    <div class="col-md-4">
                                        <label>Name<span style="color:red">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name" required="">
                                    </div>
                                
                             
                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Email ID  </label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Contact No  </label>
                                        <input type="tel" class="form-control" name="phone">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Gender</label>
                                        <select class="form-control" name="gender" >
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Date Of Birth</label>
                                        <input type="date" class="form-control" name="dob">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Experience in Year</label>
										<select class="form-control" name="exp" id="experience-year" >
							   <option value="">Select</option>
                                @for ($i = 0; $i <= 20; $i++)

                                    <option value="{{ $i }}" >{{ $i }}</option>
                                @endfor

							  </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Experience in Months</label>
										<select class="form-control" name="exp_month" id="experience-month" >
											 <option value="">Select</option>
			   @for ($j = 0; $j <= 11; $j++)

                <option value="{{ $j }}" >{{ $j }}</option>
                @endfor
										  </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Educational Qualification</label>
                                        <input type="text" class="form-control" name="edu" >

                                    </div>

                                    <input type="hidden" class="form-control" name="skill_level" >
								    <input type="hidden" class="form-control" name="sal" >

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Skill Set</label>
                                        <input type="text" class="form-control" name="skill" >

                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Most Recent Employer</label>
                                        <input type="text" class="form-control" name="cur_or" >

                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Most Recent job Title</label>
                                        <input type="text" class="form-control" name="cur_deg">

                                    </div>

                                    <!-- <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Most Recent job Title</label>
										<input id="inputFloatingLabel-job-title" type="text" class="form-control input-border-bottom" name="title"  required>
                                    </div> -->

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Current Post code</label>
                                        <input type="text" class="form-control" name="zip" id="zip" onchange="getcode();">

                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Current Location / Address</label>
                                        <input type="text" class="form-control" name="location" id="location">

                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Expected salary</label>
										<input type="number" class="form-control" name="exp_sal" >
                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Uplaod Cover Letter</label>
                                        <input type="file" class="form-control" accept="application/pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  name="cover_letter"  >

                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputFloatingLabel-job-title" class="placeholder">Uplaod Resume <span>*</span></label>
                                        <input type="file" class="form-control" accept="application/pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  name="resume"  required="">

                                    </div>
                                    

                                    
                                   


                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4 btn-up">
                                        <button type="submit" class="btn btn-danger btn-sm">Submit</button>
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
    // Add a change event listener to the job title select box
    document.getElementById('jobTitleSelect').addEventListener('change', function () {
        // Get the selected job title option
        var selectedOption = this.options[this.selectedIndex];

        // Get the job ID from the data attribute
        var jobId = selectedOption.getAttribute('data-job-id');

        // Set the job ID in the job ID input box
        document.getElementById('jobIdInput').value = jobId;
    });
</script>
@endsection