<?php

namespace App\Http\Controllers\LeaveManagement;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use App\Models\LeaveManagement\Leave_type;

use View;
use Validator;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LeaveTypeController extends Controller
{
	public function viewdashboard()
	{
		if (!empty(Session::get('admin'))) {

				$data['Roledata']= Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', Session::get('adminusernmae'))
				->get();
	return View('leavemanagement/dashboard',$data);
		} else {
			return redirect('/');
		}
	}

	public function getLeaveType()
	{
		
		if (!empty(Session::get('admin'))) {

				$data['Roledata']= Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', Session::get('adminusernmae'))
				->get();
		$data['leave_type_rs']=Leave_type::orderBy('id', 'DESC')->get();
		return view('leavemanagement/manage-leave-type', $data);	
			} else {
			return redirect('/');
		}
	}
	
	
	public function viewAddLeaveType()
	{
	if (!empty(Session::get('admin'))) {

				$data['Roledata']= Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', Session::get('adminusernmae'))
				->get();
		return view('leavemanagement/manage-new-leave-type',$data);
		} else {
			return redirect('/');
		}
	}
	
	public function saveLeaveType(Request $request)
	{
if (!empty(Session::get('admin'))) {

				$data['Roledata']= Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', Session::get('adminusernmae'))
				->get();

       
	 $data=['leave_type_name' => trim(strtoupper($request->leave_type_name)), 'alies' => trim(strtoupper($request->alies)),'remarks' => $request->remarks];
       
		
		$leave_type = trim(strtoupper($request->leave_type_name));
		$alias = trim(strtoupper($request->alies));
		$validate = Validator::make($data,[
		'leave_type_name'=>['required',
						Rule::unique('leave_types')->where(function ($query) use($leave_type,$alias) {
						return $query->where('leave_type_name', $leave_type)
						->where('alies', $alias);
						}),
					],	
		'alies'=>'required',
        ],
          [
                'leave_type_name.required' =>'Leave Type required',
				'leave_type_name.unique'=>'Leave Type and Alias already exists',
                'alies.required'=>'Alias is required',
            ]);
		if ($validate->fails()) {
            return redirect('leave-management/leave-type-listing')
                        ->withErrors($validate)
                        ->withInput();
        }
       //$data = request()->except(['_token']);
	   
        $leave_type = new Leave_type;
		$leave_type->leave_type_name=trim(strtoupper($request->leave_type_name));
		$leave_type->alies=trim(strtoupper($request->alies));
		$leave_type->remarks=$request->remarks;
				$leave_type->leave_type_status='active';
			$leave_type->created_at=date('Y-m-d H:i:s');
				$leave_type->updated_at=date('Y-m-d H:i:s');
				
     $leave_type->save();
			

       
		Session::flash('message','Leave Type Added Successfully');  
		return redirect('leave-management/leave-type-listing');
		} else {
			return redirect('/');
		}
		
	}
	
}
