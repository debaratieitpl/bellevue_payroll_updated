@extends('incometax.layouts.master')

@section('title')
BELLEVUE - Income Tax Module
@endsection

@section('sidebar')
@include('incometax.partials.sidebar')
@endsection

@section('header')
@include('incometax.partials.header')
@endsection


@section('content')

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Edit Savings Type Master</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Savings Type Master</a></li>
                        <li>/</li>
                        <li><a href="#">Edit Savings Type Master</a></li>
                    </ul>
                </span>
            </div>
        </div>

        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    
                    <div class="card-body card-block">

                        <form action="{{ url('itax/update-saving-type') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $saving_type->id }}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Financial Year <span>(*)</span></label>
                                    <input type="text" required id="financial_year" name="financial_year" class="form-control" value="{{ $saving_type->financial_year }}" readonly>
                                    
                                    @if ($errors->has('financial_year'))
                                    <div class="error" style="color:red;">{{ $errors->first('financial_year') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Income Tax Type <span>(*)</span></label>
                                    <select name="i_tax_type" class="form-control">
                                        <option value="">Select</option>
                                        @foreach($income_tax as $tax)
                                        <option value='{{ $tax->id }}' <?php  if ($saving_type->i_tax_type == $tax->id) { echo 'selected'; } ?>>{{ $tax->tax_desc }}</option>

                                        @endforeach
                                    </select>
                                    @if ($errors->has('i_tax_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('i_tax_type') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Saving Type Description <span>(*)</span></label>
                                    <input type="text" required id="saving_type_desc" name="saving_type_desc" class="form-control" value="{{ $saving_type->saving_type_desc }}">
                                    @if ($errors->has('saving_type_desc'))
                                    <div class="error" style="color:red;">{{ $errors->first('saving_type_desc') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">ITax Report Ref.</label>
                                    @php
                                        $itaxRepoRef=\Helpers::getRefItaxRepo();
                                    @endphp
                                    <select name="income_tax_repo_ref"  id="income_tax_repo_ref" class="form-control" >
                                        <option value="" selected disabled>Select</option>
                                        @foreach($itaxRepoRef as $val)
                                        <option value='{{ $val }}' @if($val==$saving_type->income_tax_repo_ref) selected @endif >{{ $val }}</option>

                                        @endforeach
                                    </select>
                                    @if ($errors->has('income_tax_repo_ref'))
                                    <div class="error" style="color:red;">{{ $errors->first('income_tax_repo_ref') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Form 16 Ref.</label>
                                    @php
                                        $formXVIRef=\Helpers::getRefFormXVIRepo();
                                    @endphp
                                    <select name="form_xvi_ref"  id="form_xvi_ref" class="form-control" >
                                        <option value="" selected disabled>Select</option>
                                        @foreach($formXVIRef as $val)
                                        <option value='{{ $val }}'  @if($val==$saving_type->form_xvi_ref) selected @endif>{{ $val }}</option>

                                        @endforeach
                                    </select>
                                    @if ($errors->has('form_xvi_ref'))
                                    <div class="error" style="color:red;">{{ $errors->first('form_xvi_ref') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Maximum Amount <span>(*)</span></label>
                                    <input type="number" step="any" required id="max_amount" name="max_amount" class="form-control" value="{{ $saving_type->max_amount }}">
                                    @if ($errors->has('max_amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_amount') }}</div>
                                    @endif
                                    <p>Input numeric ZERO if there is not ceiling.</p>
                                </div>

                            </div>
                            <p>(*) marked fields are mandatory</p>
                            <button type="submit" class="btn btn-danger btn-sm">Submit
                            </button>

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
<?php //include("footer.php"); 
?>
</div>
<!-- /#right-panel -->






@endsection

@section('scripts')
@include('incometax.partials.scripts')

@endsection
