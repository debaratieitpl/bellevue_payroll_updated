@extends('employee.layouts.master')

@section('title')
Employee List Designation Wise
@endsection

@section('sidebar')
@include('employee.partials.sidebar')
@endsection

@section('header')
@include('employee.partials.header')
@endsection

@section('scripts')
@include('employee.partials.scripts')
@endsection


@section('content')
<style>
	#bootstrap-data-table th {
		vertical-align: middle;
	}

	tr.spl td {
		font-weight: 600;
	}

	table#bootstrap-data-table tr td {
		font-size: 12px;
		padding: 8px 10px;
	}
    .card-icon form {
    padding: 10px 0;

}
</style>
<!-- Content -->
<div class="content">
	<!-- Animated -->
	<div class="animated fadeIn">
	<div class="row" style="border:none;">
            <div class="col-md-6">
            <h5 class="card-title">Employee Designation Report</h5>
</div>
<div class="col-md-6">

                        <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Employee</a></li>
                                <li>/</li>

                                <li class="active"> Designation Report</li>
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

					<div class="card-body card-block">
						<form method="post" action="{{ url('employees/designation-export-report') }}" enctype="multipart/form-data" style="width:98%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
							{{ csrf_field() }}
							<div class="row form-group">
								<div class="col-md-10">
									<label for="text-input" class=" form-control-label" style="text-align:right;">Select Designation</label>
                                    <div>
                                    <select data-placeholder="Choose Designation.." name="designation" id="designation" class="form-control select2_el" required>
                                        <option value="" selected disabled > Select </option>
                                        @foreach ($monthlist as $month)
                                        <option value="<?php echo $month->emp_designation; ?>"><?php echo $month->emp_designation; ?></option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('month'))
                                    <div class="error" style="color:red;">{{ $errors->first('month') }}</div>
                                    @endif
                                    </div>
								</div>


								<div class="col-md-2">
                                    <br>
									<button type="submit" class="btn btn-success" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;height: 32px; margin:5px;">Go</button>
								</div>
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
@include('loan.partials.scripts')


<script>


$(document).ready(function(){
	$("#bootstrap-data-table").dataTable().fnDestroy();
	$('#bootstrap-data-table').DataTable({
		lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
		initComplete: function(settings, json) {
			//doSumCoop();
			//doSumInsu();
			//doSumMisc();
			//cal_sum();
		}
	});
	//cal_sum();
});



</script>
@endsection
