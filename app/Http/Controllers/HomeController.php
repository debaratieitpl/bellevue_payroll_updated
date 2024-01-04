<?php

namespace App\Http\Controllers;

use App\Models\Masters\Role_authorization;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use view;

class HomeController extends Controller
{
    /**
     * Function Name :  getlogin
     * Purpose       :  This function use for show the login page.
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  NIL
     * Return Value  :  loads login page
     */

    public function getlogin()
    {
        if (!empty(Session::get('admin'))) {
            return redirect('dashboard');
        } else {
            return view('home/login');
        }
    }

    /**
     * Function Name :  DoLogin
     * Purpose       :  This function use for login the user.
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  Request $request
     * Return Value  :  loads login information on success and load add page for any error during the operation
     */

    public function DoLogin(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'psw' => 'required',

            ],
            [
                'email.required' => 'Email Required',
                'psw.required' => 'Password Required',
            ]
        );

        if ($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        } else {
            $user = User::where('email', '=', $request->input('email'))
                ->where('user_type', '=', 'user')
                ->first();

            $useradmin = User::where('email', '=', $request->input('email'))
                ->where('user_type', '=', 'admin')
                ->first();

                $userEmployee=User::where('email','=',$request->input('email'))
                ->where('user_type','=','employee')
                ->first();
                // dd($userEmployee);
            if (!empty($user)) {
                if (Hash::check($request->input('psw'), $user->password)) {

                    Session::put('adminusernmae', $request->email);
                    Session::put('adminpassword', $request->psw);
                    Session::put('admin', $user);
                    return redirect()->intended('dashboard');
                } else {
                    Session::flash('error', 'Your email and password wrong!!');
                    return redirect('/');
                }
            } else if (!empty($useradmin)) {
                if (Hash::check($request->input('psw'), $useradmin->password)) {
                    Session::put('adminusernmae', $request->email);
                    Session::put('adminpassword', $request->psw);
                    Session::put('admin', $useradmin);
                    return redirect()->intended('dashboard');
                } else {
                    Session::flash('error', 'Your email and password wrong!!');
                    return redirect('/');
                }
            }else if (!empty($userEmployee)) {
                if (Hash::check($request->input('psw'), $userEmployee->password)) {
                    Session::put('employeeusername', $request->email); // Fix the typo here
                    Session::put('employeepassword', $request->psw);
                    Session::put('employee', $userEmployee);
                    return redirect('employee-dashboard'); // Fix the typo in the URL here
                } else {
                    Session::flash('error', 'Your email and password are wrong!!'); // Fix the grammar in the error message
                    return redirect('/');
                }
            }else {
                Session::flash('error', 'Your email and password wrong!!');
                return redirect('/');
            }
        }
    }

    /**
     * Function Name :  Dashboard
     * Purpose       :  This function use for show the dashboard .
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  NIL
     * Return Value  :  loads dashboard page
     */
    public function Dashboard()
    {

        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            return view('home/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function EmployeeDashbord(){
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
                // dd("hello");
            return view('user-employee/dashbord', $data);
        } else {
            return redirect('/');
        }
    }
    /**
     * Function Name :  Logout
     * Purpose       :  This function use logout from admin.
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  Request $request
     * Return Value  :  logout from admin.
     */

    public function Logout(Request $request)
    {
        Session::forget('admin');
        Session::forget('role');
        Session::forget('token');
        Session::flash('message', 'You have successfully logged out.');
        return redirect('/');
    }

    /**
     * Function Name :  add
     * Purpose       :  changepassword function renders the add form
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  N/A
     * Return Value  :  return to add page
     */

    public function changepassword()
    {
        if (!empty(Session::get('admin'))) {

            return view('home/change-password');
        } else {
            return redirect('/');
        }
    }

    /**
     * Function Name :  savechangepassword
     * Purpose       :  This function use for change the password.
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  Request $request
     * Return Value  :  loads listing page on success and load add page for any error during the operation

     */

    public function savechangepassword(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $user_name = Session::get('adminusernmae');
            $current_password = Session::get('adminpassword');

            if ($request['old_pass'] != $current_password) {
                // The passwords matches
                Session::flash('message', 'Your current password does not matches with the password you provided. Please try again.');
                return redirect()->back();
            } else if (strcmp($request['new_pass'], $request['confirm_pass']) == 1) {
                Session::flash('message', 'New Password doesnot match with confirm password.');
                return redirect()->back();
            } else {

                $password = Hash::make($request['new_pass']);
                User::where('email', '=', $user_name)->update(['password' => $password]);
                Session::flash('message', 'Password changed successfully !');
                return redirect()->back();
            }
        } else {
            return redirect('/');
        }
    }

    /**
     * Function Name :  Masters Dashboard
     * Purpose       :  This function use for show the dashboard .
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  NIL
     * Return Value  :  loads dashboard page
     */
    public function mastersdashboard()
    {

        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            return view('masters/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function hcmdashboard()
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            return View('dashboard/hcm-dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function FinanceDashboard()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return View('finance/finance-dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function testfigure()
    {
       // dd(number_format(round(14500.86, 1), 2));
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            return View('testview', $data);
        } else {
            return redirect('/');
        }
    }
}