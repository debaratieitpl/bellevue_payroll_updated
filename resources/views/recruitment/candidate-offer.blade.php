@extends('recruitment.layouts.master')
@section('title')
BELLEVUE - Interview
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
            <h5 class="card-title">Generate Offer Letter</h5>
         </div>
         <div class="col-md-6">
            <span class="right-brd" style="padding-right:15x;">
               <ul class="">
                  <li><a href="#">Recruitment</a></li>
                  <li>/</li>
                  <li><a href="#">Generate Offer Letter</a></li>
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
                              {{-- 
                              <th>Job Code</th>
                              --}}
                              <th>Job Title</th>
                              <th>Candidate</th>
                              <th>Email</th>
                              <th>Contact Number</th>
                              <th>Status</th>
                              <th>Date</th>
                              <th>Offered Salary</th>
							  <th>Date Of Joining </th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $ij = 1; ?>
                           @foreach($candidate_rs as $candidate)
                           <tr>
                              {{-- <td>{{ $candidate->job_code }}</td> --}}
                              <td>{{ $candidate->job_title }}</td>
                              <td>{{ $candidate->name }}</td>
                              <td>{{ $candidate->email }}</td>
                              <td>{{ $candidate->phone }}</td>
                              <td>Offer Letter Generated</td>
                              <td>
                                 <?php
                                    echo date('d/m/Y',strtotime($candidate->cr_date));
                                    ?>
                              </td>
                              <td>{{ $candidate->offered_sal }}</td>
                              <td>
                                 <?php
                                    echo date('d/m/Y',strtotime($candidate->date_jo));
                                    ?>
                              </td>
                              <td class="drp">
                                 <div class="dropdown">
                                    <button class="btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                       <a download class="dropdown-item" href="{{asset('public/pdf/'.$candidate->dom_pdf)}}"><i class="fa fa-download"></i>&nbsp; Download</a> 
                                       {{-- <a class="dropdown-item" href="{{url('recruitment/send-letter/'.base64_encode($candidate->id))}}"><i class="fas fa-paper-plane"></i>&nbsp; Send</a>  --}}
                                       <!--<a class="dropdown-item" href="{{url('recruitment/offer-down-letter/'.base64_encode($candidate->id))}}"><i class="fas fa-eye"></i>&nbsp; View</a>-->
                                       <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal<?=$ij;?>"><i class="fa fa-eye"></i>&nbsp; View</a>
                                    </div>
                                 </div>
                              </td>
                              <!--            <td><a href="{{asset('public/pdf/'.$candidate->dom_pdf)}}" download title="Download"><img  style="width: 23px;" src="{{ asset('assets/img/download.png')}}"></a>-->
                              <!--<a href="{{url('recruitment/send-letter/'.base64_encode($candidate->id))}}" title="Send"><img  style="width: 23px;" src="{{ asset('assets/img/send.png')}}"></a>-->
                              <!--	&nbsp &nbsp	<a href="{{url('recruitment/offer-down-letter/'.base64_encode($candidate->id))}}" target="_blank" title="View"><img  style="width: 23px;" src="{{ asset('assets/img/view.png')}}"></a>-->
                              <!--											</td>-->
                           </tr>
                           <?php
                              $ij ++;
                              ?>
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

    <?php $ij = 1; ?>
    @foreach($candidate_rs as $candidate)
    <?php

    // $email = Session::get('emp_email');
    // $Roledata = DB::table('registrations')      
    // ->where('email','=',$email) 
    // ->first();
    $job_d=DB::table('company_jobs')->where('id', '=',$candidate->job_id )->first();
    
    $employee='';
    $name='';
    $num='';
    $email='';
    $desig='';
    if(!empty($candidate->reportauthor)){

    $employee=DB::table('employees')->where('emp_code', '=',$candidate->reportauthor)->first();
    $name=$employee->emp_fname.' '.$employee->emp_mname.' '.$employee->emp_lname;
    $num=$employee->emp_ps_phone;
    $email=$employee->emp_ps_email;
    $desig=$employee->emp_designation;
    }else{
    $name=$job_d->author;
    $num=$job_d->con_num;
    $email=$job_d->email;
    $desig=$job_d->desig; 
    }

    ?>
<!-- /.content -->
<!-----offer-letter-modal----------------->

<div class="modal fade" id="exampleModal<?=$ij;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:1000px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Offer Letter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table style="width:100%;">
    <thead>
      <tr>
           <td>Date :{{date('d/m/Y', strtotime($candidate->cr_date))}}
         </td>
        {{-- <td style="color: #29b9ff;font-size: 20px;">{{ $Roledata->com_name }}</td> --}}
        {{-- <td style="    text-align: right;"><img width="100" src="http://workpermitcloud.co.uk/hrms/public/{{ $Roledata->logo }}" alt="" /></td> --}}
      </tr>
    </thead>
  </table>
  <table style="width:100%;border: 3px solid #28b0f3;padding: 0 20px;">
    <tr>
       
      <td>
        <p style="text-align: right;"> {{ $candidate->name }}</p>
         <p style="text-align: right;"> {{ $candidate->location }} @if(!empty($candidate->zip)),{{ $candidate->zip }} @endif </p>
        <p>{{date('d/m/Y', strtotime($candidate->cr_date))}}</p>
         {{-- <p>{{ $Roledata->com_name }} </p> --}}
         {{-- <p>{{ $Roledata->address.','.$Roledata->address2.','.$Roledata->road.','.$Roledata->city.','.$Roledata->zip.','.$Roledata->country}} </p> --}}
        <p>Dear  {{ $candidate->name }},</p>
        
      <p>  Following your recent interview, I am writing to offer you the post of {{ $candidate->job_title }}  at the salary of {{ $candidate->offered_sal }} per {{ $candidate->payment_type}}, starting on {{ date('d/m/Y',strtotime($candidate->date_jo))}}.
      
   </p>
   <p>Full details of the post’s terms and conditions of employment are in your attached Employment Contract.</p>
        <p>As explained during the interview, this job offer is made subject to satisfactory results from necessary pre-employment checks.  There will also be a probationary period of three months which will have to be completed satisfactorily.<p>
        
       
        <p> This is a {{ $job_d->job_type }} .On starting, you will report to {{ $name }}.</p>
        
  <p>If you have any queries on the contents of this letter, the attached Employment Contractor the pre-employment checks, please do not hesitate to contact me on 0{{$num}}.</p>
  
  <p>To accept this offer, please sign and date the attached copy of this letter in the spaces indicated, scan it in legible format and send it back to us by replying to   {{$email}}.</p>
  <p>We are delighted to offer you this opportunity and look forward to you joining the organisation and working with you.</p>
  <p>This letter is part of your contract of employment.</p>
  
  <p>Yours sincerely,</p>
  
  <h5 style="margin-bottom:0;color: #29b9ff;font-size: 16px;">{{$name}}</h5>
  <p style="margin-top:0;margin-bottom:0;">{{$desig}}</p>
  <p><b>I am very pleased to accept the job offer on the terms and conditions detailed in this letter and the Written Statement of Terms and Conditions of Employment</b></p>
  <p><b>Signed and date ………………………………………………………………………………………………</b><p>
     <p><b> [Successful candidate to write their signature with date]</b><p>
  
  
  
   <p><b>Name ……………………………………………………………………………………………………………….</b> </p>
  
   <p><b>[Successful candidate to print their full name in capital letters]</b><p>
  
  
      </td>
    </tr>
  </table>
        </div>
        <div class="modal-footer">
         
          <button type="button" class="btn btn-primary" onclick="$('#div1<?=$ij;?>').print();"><i class="fa fa-print" aria-hidden="true"></i> Print Offer Letter</button>
           <button type="button" class="btn" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!----------------------------------------->
  <!----------------print-preview------------->
<div id="div1<?=$ij;?>" style="display:none;">
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="icon" href="https://workpermitcloud.co.uk/hrms/img/favicon.png" type="image/x-icon"/>
    
    <title>Bellevue</title>
    </head>
    
    <body>
    <table style="width:100%;">
      <thead>
      <tr>
             <td>Date :{{date('d/m/Y', strtotime($candidate->cr_date))}}
           </td>
          {{-- <td style="color: #29b9ff;font-size: 20px;">{{ $Roledata->com_name }}</td> --}}
          {{-- <td style="    text-align: right;"><img width="100" src="http://workpermitcloud.co.uk/hrms/public/{{ $Roledata->logo }}" alt="" /></td> --}}
        </tr>
      </thead>
    </table>
    <table style="width:100%;border: 3px solid #28b0f3;padding: 0 20px;">
      <tr>
         
        <td>
          <p style="text-align: right;"> {{ $candidate->name }}</p>
           <p style="text-align: right;"> {{ $candidate->location }} @if(!empty($candidate->zip)),{{ $candidate->zip }} @endif </p>
          <p>{{date('d/m/Y', strtotime($candidate->cr_date))}}</p>
           {{-- <p>{{ $Roledata->com_name }} </p> --}}
           {{-- <p>{{ $Roledata->address.','.$Roledata->address2.','.$Roledata->road.','.$Roledata->city.','.$Roledata->zip.','.$Roledata->country}} </p> --}}
          <p>Dear  {{ $candidate->name }},</p>
          
        <p>  Following your recent interview, I am writing to offer you the post of {{ $candidate->job_title }}  at the salary of {{ $candidate->offered_sal }} per {{ $candidate->payment_type}}, starting on {{ date('d/m/Y',strtotime($candidate->date_jo))}}.
        
     </p>
     <p>Full details of the post’s terms and conditions of employment are in your attached Employment Contract.</p>
          <p>As explained during the interview, this job offer is made subject to satisfactory results from necessary pre-employment checks.  There will also be a probationary period of three months which will have to be completed satisfactorily.<p>
          
         
          <p> This is a {{ $job_d->job_type }} .On starting, you will report to {{ $name }}.</p>
          
    <p>If you have any queries on the contents of this letter, the attached Employment Contractor the pre-employment checks, please do not hesitate to contact me on 0{{$num}}.</p>
    
    <p>To accept this offer, please sign and date the attached copy of this letter in the spaces indicated, scan it in legible format and send it back to us by replying to   {{$email}}.</p>
    <p>We are delighted to offer you this opportunity and look forward to you joining the organisation and working with you.</p>
    <p>This letter is part of your contract of employment.</p>
    
    <p>Yours sincerely,</p>
    
    <h5 style="margin-bottom:0;color: #29b9ff;font-size: 16px;">{{$name}}</h5>
    <p style="margin-top:0;margin-bottom:0;">{{$desig}}</p>
    <p><b>I am very pleased to accept the job offer on the terms and conditions detailed in this letter and the Written Statement of Terms and Conditions of Employment</b></p>
    <p><b>Signed and date ………………………………………………………………………………………………</b><p>
       <p><b> [Successful candidate to write their signature with date]</b><p>
    
    
    
     <p><b>Name ……………………………………………………………………………………………………………….</b> </p>
    
     <p><b>[Successful candidate to print their full name in capital letters]</b><p>
    
    
        </td>
      </tr>
    </table>
    </body>
    </html>
    </div>
      <?php
                                            $ij ++;
                                            ?>
                                        @endforeach  
    <!------------------------------------------>
<div class="clearfix"></div>
@endsection