@extends('rota.layouts.master')

@section('title')
BELLEVUE Configuration - User
@endsection

@section('sidebar')
@include('rota.partials.sidebar')
@endsection

@section('header')
@include('rota.partials.header')
@endsection

@section('content')
<!-- Content -->
<div class="content">
	<!-- Animated -->
	<div class="animated fadeIn">
	<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Duty Roster (Employee wise)</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Time Shift Management</a></li>
                                
								<li>/</li>
								<li><a href="#">Duty Roster</a></li>
								<li>/</li>
                                <li class="active">Duty Roster (Employee wise)</li>
						
                            </ul>
                        </span>
</div>
</div>
		<!-- Widgets  -->
		<div class="row">
			<div class="main-card">
				<div class="card">
					<!-- <div class="card-header"><strong class="card-title">Duty Roster (Employee wise)</strong></div> -->
					<div class="card-body">

						@include('include.messages')
						<form action="{{ url('rota/save-employee-duty') }}" method="post" enctype="multipart/form-data" class="form-horizontal" >
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="row form-group">

								<!-- <div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Select Month <span>(*)</span></label>
									<select data-placeholder="Choose an Month..." class="form-control" name="month_yr" id="month_yr" required>
										<option value="" selected disabled> Select </option>

									</select>
									@if ($errors->has('month_yr'))
									<div class="error" style="color:red;">{{ $errors->first('month_yr') }}</div>
									@endif
								</div> -->

								<div class="col-md-4">
									<label>Select Department</label>
									<select class="form-control" id="emp_code" required name="department" onchange="chngdepartment(this.value);">
										<option value="">Select</option>

										@foreach($departs as $dept)
										<option value='{{ $dept->id }}' <?php if (app('request')->input('id')) {
																			if ($shift_management->department == $dept->id) {
																				echo 'selected';
																			}
																		} ?>>{{ $dept->department_name }}</option>
										@endforeach
									</select>
								</div>

								<div class="col-md-4">
									<label>Select Designation</label>
									<select class="form-control" id="designation" required name="designation" onchange="chngdepartmentshift(this.value);">
										<option value="">Select</option>
									</select>
								</div>

								<div class="col-md-4">
									<label>Employee Code</label>
									<select class="form-control" id="employee_id" required name="employee_id">
									<option value="">Select</option>
									</select>
								</div>




							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<label>From Date</label>
									<input type="date" name="start_date" value="" class="form-control" required>
								</div>

								<div class="col-md-4">
									<label>To Date</label>
									<input type="date" name="end_date" value="" class="form-control" required>
								</div>
								<div class="col-md-4">
								<label>Shift Code</label>
								<select class="form-control" id="shift_code" required name="shift_code">
								<option value="">Select</option>
									</select>
								</div>
							</div>
							<div class="row form-group">
                            <div class="col-md-4 btn-up">
										<button type="submit" class="btn btn-danger btn-sm">Submit</button>
										<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>

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
@include('rota.partials.scripts')

<script>
	function del(i, head) {
		//alert(i);
		//alert(head);
		var classrow = head + '' + i;

		/*
		if (rowid != ''){
			//alert(rowid);
			//$('#add'+rowid).prop('disabled', false);
			//$('#add'+rowid).removeAttr('disabled');
			alert("DEL"+i);
			$('#addrow'+rowid).attr('disabled',false);
		}
		*/

		$(".row" + classrow).html('');
	}
</script>

<script>
	function chngdepartment(empid) {

		$.ajax({
			type: 'GET',
			url: '{{url('rota/getEmployeedesigByshiftId')}}/'+empid,
			cache: false,
			success: function(response) {


				document.getElementById("designation").innerHTML = response;
			}
		});
	}

	// function chngdepartmentshift(empid) {



	// 	$.ajax({
	// 		type: 'GET',
	// 		url: '{{url('rota/getEmployeedailyattandeaneshightById')}}/'+empid,
	// 		cache: false,
	// 		success: function(response) {


	// 			document.getElementById("employee_code").innerHTML = response;
	// 		}
	// 	});
	// }

	function chngdepartmentshift(empid){
	  
	  $.ajax({
   type:'GET',
   url:'{{url('rota/getEmployeedesigBydutytshiftId')}}/'+empid,
   cache: false,
   success: function(response){
	   
	   
	   document.getElementById("shift_code").innerHTML = response;
   }
   });
	   $.ajax({
   type:'GET',
   url:'{{url('rota/getEmployeedailyattandeaneshightdutyById')}}/'+empid,
   cache: false,
   success: function(response){
	   
	   
	   document.getElementById("employee_id").innerHTML = response;
   }
   });
   
}
</script>
@endsection