<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\Education_details;
use App\Models\Employee\Personal_doc;
use App\Models\Employee\Personal_record;
use App\Models\Employee\Misc_doc;
use App\Models\Employee\Employee_pay_structure;
use App\Models\Employee\Emp_pay_structure;
use App\Models\Employee\Increment_history;
use App\Models\Employee\Leave_apply;
use App\Models\Employee\Macp_history;
use App\Models\Employee\Pay_scale_basic_master;
use App\Models\Employee\Process_attendance;
use App\Models\Employee\Promotion_history;
use App\Models\Employee\Salutation;
use App\Models\LeaveApprover\Pension;
use App\Models\Leave\Gpf_details;
use App\Models\Masters\Bank;
use App\Models\Masters\Bank_master;
use App\Models\Masters\Cast;
use App\Models\Masters\Department;
use App\Models\Masters\Designation;
use App\Models\Masters\Education_master;
use App\Models\Masters\Employee_type;
use App\Models\Masters\Grade;
use App\Models\Masters\Group_name_detail;
use App\Models\Masters\Pay_head_master;
use App\Models\Masters\Pay_scale_master;
use App\Models\Masters\Pay_type;
use App\Models\Masters\Rate_details;
use App\Models\Masters\Rate_master;
//use Illuminate\Contracts\Validation\Rule;
use App\Models\Masters\Religion;
use App\Models\Masters\Role_authorization;
use App\Models\Masters\State_master;
use App\Models\Masters\Sub_cast;
use App\Models\Role\Employee;
use Hash;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use view;
use App\Exports\EmployeeRetirementReport;

class EmployeeReportController extends Controller
{
    public function employeesByRetirement()
    {
        dd('abbas');
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Employee::orderBy('emp_designation')->select('emp_designation')->distinct('emp_designation')->get();
            $data['result'] = '';
            return view('employee.EmployeeListRetirementReport', $data);
        } else {
            return redirect('/');
        }
    }
}
