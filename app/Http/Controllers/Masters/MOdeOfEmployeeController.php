<?php

namespace App\Http\Controllers\Masters;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EmployeeType;
use App\Models\Masters\Company;
use App\Models\Masters\ModeOfEmployee;
use View;
use Validator;
use Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

class MOdeOfEmployeeController extends Controller
{
	//
	public function addEmployeeMode()
	{
		if (!empty(Session::get('admin'))) {

			$company_rs = Company::where('company_status', '=', 'active')->select('id', 'company_name')->get();
			return view('masters/employee-mode', compact('company_rs'));
		} else {
			return redirect('/');
		}
	}



	public function saveEmployeeMode(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			$name = strtoupper(trim($request->name));

			if (is_numeric($name) == 1) {
				Session::flash('error', 'Employee Mode Should not be numeric.');
				return redirect('masters/vw-employee-mode');
			}
			$employee_type = ModeOfEmployee::where('name', $request->name)->first();
			if (!empty($employee_type)) {
				Session::flash('error', 'Employee Mode Alredy Exists.');
				return redirect('masters/vw-employee-type');
			}

			$validator = Validator::make(
				$request->all(),
				[
					'name' => 'required|max:255'
				],
				['name.required' => 'Employee Mode Name required']
			);

			if ($validator->fails()) {
				return redirect('masters/employee-mode')->withErrors($validator)->withInput();
			}

			//$data=request()->except(['_token']);

			$employee_type = new ModeOfEmployee();



			ModeOfEmployee::insert(
				['name' => $name, 'status' => 'Active']
			);


			Session::flash('message', 'Employee Mode Information Successfully saved.');

			return redirect('masters/vw-employee-mode');
		} else {
			return redirect('/');
		}
	}


	public function updateModeType(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			$name = strtoupper(trim($request->name));

			if (is_numeric($name) == 1) {
				Session::flash('error', 'Employee Mode Should not be numeric.');
				return redirect('masters/vw-employee-mode');
			}
			$employee_type = ModeOfEmployee::where('name', $request->name)->where('id', '!=', $request->id)->first();
			if (!empty($employee_type)) {
				Session::flash('error', 'Employee Mode Alredy Exists.');
				return redirect('masters/vw-employee-mode');
			}

			$validator = Validator::make(
				$request->all(),
				[
					'name' => 'required|max:255'
				],
				['name.required' => 'Employee Mode Name required']
			);

			if ($validator->fails()) {
				return redirect('masters/employee-mode')->withErrors($validator)->withInput();
			}

			//$data=request()->except(['_token']);

			$employee_type = new ModeOfEmployee();


			ModeOfEmployee::where('id', $request->id)
				->update(['name' => $name]);
			Session::flash('message', 'Employee Mode Information Successfully Saved.');
			return redirect('masters/vw-employee-mode');
		} else {
			return redirect('/');
		}
	}

	public function getEmployeeMode()
	{
		if (!empty(Session::get('admin'))) {

			$employee_mode= ModeOfEmployee::get();

			return view('masters/view-employee-mode', compact('employee_mode'));
		} else {
			return redirect('/');
		}
	}

	public function getModeById($id)
	{
		if (!empty(Session::get('admin'))) {

			$data['employee_mode'] = ModeOfEmployee::where('id', $id)->first();
			return view('masters/edit-employee-mode', $data);
		} else {
			return redirect('/');
		}
	}
}
