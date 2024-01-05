@extends('recruitment.layouts.master')
@section('title')
BELLEVUE - Job Lists
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
            <h5 class="card-title">Job Applied</h5>
         </div>
         <div class="col-md-6">
            <span class="right-brd" style="padding-right:15x;">
               <ul class="">
                  <li><a href="#">Recruitment</a></li>
                  <li>/</li>
                  <li><a href="#">Job Applied</a></li>
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
               </div>
               <div class="card-body">
                  <div class="srch-rslt" style="overflow-x:scroll;">
                     <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              {{-- <th>Job Code</th> --}}
                              <th>Job Title</th>
                              <th>Candidate</th>
                              <th>Email</th>
                              <th>Contact Number</th>
                              <th>Status</th>
                              <th>Date</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i = 1;
                              ?>
                           @foreach($candidate_rs as $candidate)
                           <tr>
                              {{-- <td>{{ $candidate->soc_code }}</td> --}}
                              <td>{{ $candidate->job_title }}</td>
                              <td>{{ $candidate->name }}</td>
                              <td>{{ $candidate->email }}</td>
                              <td>{{ $candidate->phone }}</td>
                              <td>{{ $candidate->status }}</td>
                              <td>
                                 <?php
                                    $job_details=DB::table('candidate_historys')->where('user_id', '=', $candidate->id )->orderBy('id', 'DESC')->first();


                                    if(!empty($job_details)){

                                    echo date('d/m/Y ',strtotime($job_details->date));



                                    }
                                    else{
                                    echo date('d/m/Y',strtotime($candidate->date));
                                    if($candidate->date>='2021-02-22'){
                                    echo ' '.date('h:i A ',strtotime($candidate->date));
                                    }
                                    }?>
                              <td class="drp">
                                 <div class="dropdown">
                                    <button class="btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                       <a class="dropdown-item" href="{{url('recruitment/edit-candidate/'.base64_encode($candidate->id))}}"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                       <a download class="dropdown-item" href="{{asset($candidate->resume)}}"><i class="fa fa-download"></i>&nbsp; Download</a>
                                       {{-- @if($candidate->status=='Application Received')
                                       <a class="dropdown-item" href="{{url('recruitment/send-letter-job-applied/'.base64_encode($candidate->id))}}"><i class="fa fa-paper-plane"></i>&nbsp; Send</a>
                                       @endif --}}
                                    </div>
                                 </div>
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
