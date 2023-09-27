@extends('recruitment.layouts.master')
@section('title')
BELLEVUE - Job Posts
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
            <h5 class="card-title">Job Posts</h5>
         </div>
         <div class="col-md-6">
            <span class="right-brd" style="padding-right:15x;">
               <ul class="">
                  <li><a href="#">Recruitment</a></li>
                  <li>/</li>
                  <li><a href="#">Job Posts</a></li>
               </ul>
            </span>
         </div>
      </div>
      <!-- Widgets  -->
      <div class="row">
         <div class="main-card">
            <div class="card">
               <div class="card-header">
                  @include('include.messages')
                  <div class="aply-lv" style="padding-right: 36px;">
                     <a href="{{ url('recruitment/add-job-post') }}" class="btn btn-default">Add New Job Post <i class="fa fa-plus"></i></a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="srch-rslt" style="overflow-x:scroll;">
                     <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th>Sl. No.</th>
                              <th>SOC Code</th>
                              <th>Job Title</th>
                              <th>Job Link</th>
                              <th>Vacancy</th>
                              <th>Job Location</th>
                              <th>Job Posted Date</th>
                              <th>Closing Date</th>
                              <th>Email</th>
                              <th>Phone No.</th>
                              <th>Status</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i = 1; ?>
                           @foreach($company_job_rs as $recruitment_job)
                           <tr>
                              <td><?php echo $i++; ?></td>
                              <td>{{ $recruitment_job->soc }}</td>
                              <td>{{ $recruitment_job->title }}</td>
                              <td style="text-align:center" id="myInput">
                                 @if( $recruitment_job->post_date<=date('Y-m-d') && $recruitment_job->clos_date>=date('Y-m-d'))
                                 <a target="_blank" href="{{ $recruitment_job->job_link }}">
                                 @endif {{ $recruitment_job->job_link }}</a>
                                 @if( $recruitment_job->post_date<=date('Y-m-d') && $recruitment_job->clos_date>=date('Y-m-d'))
                                 <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="{{ $recruitment_job->job_link }}" title="Copy Link">
                                    <!-- icon from google's material design library -->
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 24 24">
                                       <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" />
                                    </svg>
                                 </button>
                                 @endif
                              </td>
                              <td>{{ $recruitment_job->no_vac }}</td>
                              <td>{{ $recruitment_job->job_loc }}</td>
                              <td>{{ date('d/m/Y',strtotime($recruitment_job->post_date)) }}</td>
                              <td>{{ date('d/m/Y',strtotime($recruitment_job->clos_date)) }}</td>
                              <td>{{ $recruitment_job->email }}</td>
                              <td>{{ $recruitment_job->con_num }}</td>
                              <td>{{ $recruitment_job->status }}</td>
                              <td><a data-toggle="tooltip" data-placement="bottom" title="Edit"  href="{{url('recruitment/add-job-post/')}}?id={{$recruitment_job->id}}"><i class="ti-pencil-alt"></i></a>
                              </td>
                           </tr>
                           @endforeach  
                        </tbody>
                     </table>
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