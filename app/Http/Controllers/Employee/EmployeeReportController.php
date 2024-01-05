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
use App\Exports\DepartmentwiseExcel;
use App\Exports\EmployeeIncrementReport;
use App\Exports\EmployeeConfarmationReport;
use App\Exports\EmployeeContractRenewReport;
use DB;
use Carbon\Carbon;

class EmployeeReportController extends Controller
{
    public function employeesByRetirement()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
                $nearRetirementDate = now()->addDays(7);

                $data['result'] = Employee::whereDate('emp_retirement_date', '>=', now()) // Today and future dates
                    ->where('emp_status', '!=', 'TEMPORARY')
                    ->where('emp_status', '!=', 'EX-EMPLOYEE')
                    ->orderByRaw('emp_retirement_date = CURDATE() DESC, emp_retirement_date ASC')
                    ->get();
                return view('employee.EmployeeListRetirementReport', $data);
        } else {
            return redirect('/');
        }
    }

    public function genderwisereport()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

                $data['result'] = Employee::where('emp_status', '!=', 'TEMPORARY')
                    ->where('emp_status', '!=', 'EX-EMPLOYEE')
                    ->orderByRaw('emp_retirement_date = CURDATE() DESC, emp_retirement_date ASC')
                    ->get();
                return view('employee.gender-wise-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function departmentwisecost()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();


                $data['result'] = Employee::join('employee_pay_structures', 'employee_pay_structures.employee_code', 'employees.emp_code')
                ->select(
                    DB::raw('(COALESCE(basic_pay, 0) + COALESCE(others_alw, 0) + COALESCE(tiff_alw, 0) + COALESCE(hra, 0) + COALESCE(misc_alw, 0) + COALESCE(medical, 0) + COALESCE(conv, 0) + COALESCE(over_time, 0) + COALESCE(leave_inc, 0) + COALESCE(bouns, 0) + COALESCE(hta, 0)) as total_salary'),
                    DB::raw('emp_department as department'),
                )
                ->groupBy('emp_department')
                ->get();
            
                return view('employee.employee-department-wise-cost', $data);
        } else {
            return redirect('/');
        }
    }

    public function entryWiseList(Request $request){
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

                $currentDate = Carbon::now();
                $firstDayOfMonth = $currentDate->firstOfMonth()->toDateString();
                $lastDayOfMonth = $currentDate->lastOfMonth()->toDateString();
                if($request->to_date ==null){
                $data['entry_list'] = Employee::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();
                }else{
                 $formDate=$request->form_date;
                 $toDate=$request->to_date;
                $data['entry_list'] = Employee::whereBetween('created_at', [$formDate, $toDate])->get();

                }
               
                return view('employee.employee-entry-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function exitWiseList(Request $request){
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

                $currentDate = Carbon::now();
                $firstDayOfMonth = $currentDate->firstOfMonth()->toDateString();
                $lastDayOfMonth = $currentDate->lastOfMonth()->toDateString();
                if($request->to_date ==null){
                $data['entry_list'] = Employee::whereBetween('updated_at', [$firstDayOfMonth, $lastDayOfMonth])->get();
                }else{
                 $formDate=$request->form_date;
                 $toDate=$request->to_date;
                $data['entry_list'] = Employee::whereBetween('updated_at', [$formDate, $toDate])->get();

                }
               
                return view('employee.employee-exit-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function employeesByIncrement(){
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
                $nearRetirementDate = now()->addDays(7);
                // dd($nearRetirementDate);
                $data['result'] = Employee::whereDate('emp_next_increament_date', '>=', now()) // Today and future dates
                    ->where('emp_status', '!=', 'TEMPORARY')
                    ->where('emp_status', '!=', 'EX-EMPLOYEE')
                    ->orderByRaw('emp_next_increament_date = CURDATE() DESC, emp_next_increament_date ASC')
                    ->get();
                return view('employee.EmployeeListIncrementReport', $data);
        } else {
            return redirect('/');
        }
    }

    public function employeeConfermation(){
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

                $nearRetirementDate = now()->addDays(7);
                // dd($nearRetirementDate);
                $data['result'] = Employee::whereDate('emp_from_date', '>=', now()) // Today and future dates
                    ->where('emp_status', '!=', 'TEMPORARY')
                    ->where('emp_status', '!=', 'EX-EMPLOYEE')
                    ->orderByRaw('emp_from_date = CURDATE() DESC, emp_from_date ASC')
                    ->get();
                return view('employee.EmployeeListConformationReport', $data);

        } else {
            return redirect('/');
        }
    }
    
    public function employeeContractRenew(){
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

                $nearRetirementDate = now()->addDays(7);
               
                $data['result'] = Employee::whereDate('contract_renew_date', '>=', now()) // Today and future dates
                    ->where('emp_status', '!=', 'TEMPORARY')
                    ->where('emp_status', '!=', 'EX-EMPLOYEE')
                    ->orderByRaw('contract_renew_date = CURDATE() DESC, contract_renew_date ASC')
                    ->get();
                return view('employee.EmployeeListContractRenewReport', $data);

        } else {
            return redirect('/');
        }
    }

    public function apprenticeNurce(){
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

                $today = date('Y-m-d');

                $nextjoiningThreeYears = date('Y-m-d', strtotime($today . ' +3 years'));
                // dd($nextjoiningThreeYears);
                

                $nextregisterThreeYears = date('Y-m-d', strtotime($today . ' +3 years'));

                $data = Employee::select('emp_doj','emp_code')->where('emp_code',0002)->get();

                foreach($data as $datas){
                    if('2024-01-04' <= '2024-01-05'){
                        echo "2027";
                    }else{
                        echo "no";
                    }
                   
                }
                
                // dd($data);

                
               
        } else {
            return redirect('/');
        }
    }

    public function departmentwisecoseexcel(){
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return Excel::download(new DepartmentwiseExcel(), 'departmentwisecoseexcel.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function emp_retirement_xlsexport(Request $request){
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return Excel::download(new EmployeeRetirementReport(), 'EmpRetirementReport.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function emp_increment_xlsexport(Request $request){
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return Excel::download(new EmployeeIncrementReport(), 'EmpIncrementReport.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function emp_confermation_xlsexport(Request $request){
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return Excel::download(new EmployeeConfarmationReport(), 'EmpconfermationReport.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function emp_contract_renew_xlsexport(Request $request){
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return Excel::download(new EmployeeContractRenewReport(), 'EmpcontractrenewReport.xlsx');
        } else {
            return redirect('/');
        }
    }
}
