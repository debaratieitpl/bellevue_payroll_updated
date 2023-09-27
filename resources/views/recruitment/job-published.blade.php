@extends('recruitment.layouts.master')
@section('title')
BELLEVUE - Job Published
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
            <h5 class="card-title">Job Published</h5>
         </div>
         <div class="col-md-6">
            <span class="right-brd" style="padding-right:15x;">
               <ul class="">
                  <li><a href="#">Recruitment</a></li>
                  <li>/</li>
                  <li><a href="#">Job Published</a></li>
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
                     <a href="{{ url('recruitment/add-job-published') }}" class="btn btn-default">Add New Job Published <i class="fa fa-plus"></i></a>
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
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i = 1; ?>
                           @foreach($company_job_rs as $deptgf)
                           <?php
                              $recruitment_job= DB::table('company_job_lists')      
                              ->where('id','=',$deptgf->job_id) 
                              ->first();
                              $deptgfhh= DB::table('company_job_lists')      
                              ->where('soc','=',$recruitment_job->soc) 
                              ->where('title','=',$deptgf->title) 
                              ->first();
                              ?>
                           <tr>
                              <td><?php echo $i++; ?></td>
                              <td>{{ $deptgfhh->soc }}</td>
                              <td>{{ $deptgfhh->title }}</td>
                              <td><a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{url('recruitment/add-job-published/')}}?id={{$deptgf->id}}"><i class="ti-pencil-alt"></i></a>
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