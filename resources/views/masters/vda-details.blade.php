@extends('masters.layouts.master')

@section('title')
BELLEVUE - Masters Module
@endsection

@section('sidebar')
@include('masters.partials.sidebar')
@endsection

@section('header')
@include('masters.partials.header')
@endsection



@section('scripts')
@include('masters.partials.scripts')
@endsection

@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
    <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">VDA Details</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#"><?php if(empty($loan_details->id)){ ?>Add <?php } ?>Loannn</a></li>
                                
								<li>/</li>
                <li class="active"><a href="#">VDA Details</a></li>
                                
                                <li>/</li>
                                <li class="active">VDA Details</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">

                    <div class="card-header">
                    <div class="aply-lv">
                        <a href="{{ url('masters/add-vda-details') }}" class="btn btn-default">Add New VDA Details <i class="fa fa-plus"></i></a>
                    </div>
                    </div>

                    @include('include.messages')
                   
                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial no.</th>
                                    <th>Pay Month Year</th>
                                    <th>Employee Type</th>
                                    <th>VDA Current</th>
                                    <th>VDA Previous</th>
                                    <th>VDA Previous Previous</th>
                                    <th>OT VDA</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($vda_details as $vda)
                                <tr>
                                    
                                    <td><?php echo $i++; ?></td>
                                    <td>{{ $vda->pay_month_year }}</td>
                                    <td>{{ $vda->emp_type }}</td>
                                    <td>{{ $vda->vda_current }}</td>
                                    <td>{{ $vda->vda_previous }}</td>
                                    <td>{{ $vda->vda_previous_previous }}</td>
                                    <td>{{ $vda->ot_vda }}</td>
                                    <td>
                                        
                                        <a href="{{url('masters/del-vda-details/')}}/{{$vda->id}}" onclick="return confirm('Are you sure you want to delete this VDA Details?');"><i class="ti-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>


                    </div>

                </div>

            </div>



        </div>
        <!-- /Widgets -->



    </div>
    <!-- .animated -->
</div>
<!-- /.content -->
@endsection