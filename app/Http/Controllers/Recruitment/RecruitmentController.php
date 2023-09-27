<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recruitment\Recruitment;
use App\Models\Recruitment\CompanyJobList;
use App\Models\Recruitment\CompanyJob;
use App\Models\Masters\Role_authorization;
use App\Models\Masters\Department;
use App\Models\Recruitment\JobPost;
use App\Models\Recruitment\Candidate;
use Session;
use DB;


class RecruitmentController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Recruitment';
        $this->_routePrefix = 'recruitment';
        $this->_model       = new Recruitment();
    }
    public function viewdash(Request $request){
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            return view($this->_routePrefix.'.dashboard',$data);
        } else {
            return redirect('/');
        }
        
    }
    public function viewjoblist()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['recruitment_job_rs'] = CompanyJobList::get();
            return view($this->_routePrefix.'.job-list', $data);
        } else {
            return redirect('/');
        }

    }
    public function viewAddNewJobList(Request $request)
    {

        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
               $id = $request->id;
               $data['recruitment_job_rs'] ='';
               if($id !=''){
                $data['recruitment_job_rs'] = CompanyJobList::where('id',$id)->first();
               }
               $data['department'] =  Department::where('department_status','active')->get();
                return view($this->_routePrefix.'.add-new-job-list', $data);
        } else {
            return redirect('/');
        }

    }
    public function saveJobListData(Request $request)
    {
        //dd($request->all());
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
                
            $id = $request->id;
            $soc = strtoupper(trim($request->soc));
            $data = [
                'soc' => $soc,
                'department' => $request->department,
                'title' => $request->title,
                'des_job' => $request->des_job,
            ];
            $job = CompanyJobList::find($id);
            if ($job) {
                $res = $job->update($data);
                if ($res){
                    Session::flash('message', 'Job List Information Successfully Updated.');
                }else{
                    Session::flash('error', 'Something Went Wrong.'); 
                }
            }else{
                $job = CompanyJobList::where('soc',$request->soc)->get();
                // if($job){
                //     Session::flash('error', 'Job Code already exists.'); 
                //     return redirect()->back();
                // }
                $res = CompanyJobList::create($data);
                if ($res ){
                    Session::flash('message', 'Job List Information Successfully Saved.');
                }else{
                    Session::flash('error', 'Something Went Wrong.'); 
                }
            }
            return redirect($this->_routePrefix.'.job-list');
        } else {
            return redirect('/');
        }
    }
    public function viewjobpost()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

                $data['company_job_rs'] = CompanyJob::join('company_job_lists', 'company_jobs.soc', '=', 'company_job_lists.id')
                ->select('company_jobs.*', 'company_job_lists.soc')
                ->get();
                // dd($data['company_job_rs']);

            return view($this->_routePrefix.'.job-post', $data);
        } else {
            return redirect('/');
        }
    }
    public function viewAddNewJobPost(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            // $data['cuurenci_master'] = DB::table('country_new')->get();
            // $data['location'] = DB::table('location_uk')->get();
            if ($request->id) {
                $data['job_details'] = CompanyJob::join('company_job_lists', 'company_jobs.soc', '=', 'company_job_lists.id')
                ->where('company_jobs.id', $request->id)
                ->select('company_jobs.*','company_job_lists.soc as csoc')
                ->first();
                $data['jobs_list'] = CompanyJobList::get();
                $data['department'] =  Department::where('department_status','active')->get();
                //dd($data['job_details']);
                return view($this->_routePrefix.'.add-new-job-post', $data);
            } else {
                $data['job_details']='';
                $data['jobs_list'] = CompanyJobList::get();
                $data['department'] =  Department::where('department_status','active')->get();
                return view($this->_routePrefix.'.add-new-job-post', $data);
            }
        } else {
            return redirect('/');
        }
    }
    public function saveJobPostData(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            if ($request->id) {
                // $ckeck_dept = DB::table('company_jobs')->where('job_code', strtoupper(trim($request->job_code)))->where('id', '!=', $request->id)->first();
                // dd($ckeck_dept);
                // if (!empty($ckeck_dept)) {
                //     Session::flash('message', 'Job Code  Already Exists.');
                //     return redirect('recruitment/job-post');
                // }

                $data = array(
                    'soc' => $request->soc,
                    'title' => $request->title,
                    'department' => $request->department,
                    'job_code' => strtoupper(trim($request->job_code)),
                    'job_desc' => $request->job_desc,
                    'job_type' => $request->job_type,
                    'work_min' => $request->work_min,
                    'work_max' => $request->work_max,
                    'basic_min' => $request->basic_min,
                    'basic_max' => $request->basic_max,
                    'no_vac' => $request->no_vac,
                    'job_loc' => $request->job_loc,
                    'quli' => $request->quli,
                    'skill' => $request->skill,
                    'age_min' => $request->age_min,
                    'age_max' => $request->age_max,
                    'gender' => $request->gender,
                    'role' => $request->role,
                    'author' => $request->author,
                    'desig' => $request->desig,
                    'english_pro' => $request->english_pro,
                    'other' => $request->other,
                    'post_date' => date('Y-m-d', strtotime($request->post_date)),
                    'clos_date' => date('Y-m-d', strtotime($request->clos_date)),
                    'email' => $request->email,
                    'con_num' => $request->con_num,
                    'status' => $request->status,
                    'gender_male' => $request->gender_male,
                    'working_hour' => $request->working_hour,
                    'skil_set' => $request->skil_set,
                    'time_pre' => $request->time_pre,
                );
              

                DB::table('company_jobs')->where('id', $request->id)->update($data);
                $datajoblist = array(

                    'des_job' => $request->job_desc,

                );

                DB::table('company_job_lists')->where('id', $request->soc)->update($datajoblist);
                Session::flash('message', 'Job Post Information Successfully Updated.');
                return redirect('recruitment/job-post');
            } else {
                // $ckeck_dept = DB::table('company_jobs')->where('job_code', strtoupper(trim($request->job_code)))->first();
                // if (!empty($ckeck_dept)) {
                //     Session::flash('message', 'Job Code  Already Exists.');
                //     return redirect('recruitment/job-post');
                // }
                $last_dept = DB::table('company_jobs')->orderBy('id', 'DESC')->first();
               
                if (!empty($last_dept)) {
                    $l_id = $last_dept->id;
                } else {
                    $l_id = 6;
                }

                $data = array(
                    'soc' => $request->soc,

                    'department' => $request->department,
                    'title' => $request->title,
                    'job_code' => strtoupper(trim($request->job_code)),
                    'job_desc' => $request->job_desc,
                    'job_type' => $request->job_type,
                    'work_min' => $request->work_min,
                    'work_max' => $request->work_max,
                    'basic_min' => $request->basic_min,
                    'basic_max' => $request->basic_max,
                    'no_vac' => $request->no_vac,
                    'job_loc' => $request->job_loc,
                    'quli' => $request->quli,
                    'skill' => $request->skill,
                    'age_min' => $request->age_min,
                    'age_max' => $request->age_max,
                    'gender' => $request->gender,
                    'role' => $request->role,
                    'author' => $request->author,
                    'desig' => $request->desig,
                    'english_pro' => $request->english_pro,
                    'other' => $request->other,
                    'post_date' => date('Y-m-d', strtotime($request->post_date)),
                    'clos_date' => date('Y-m-d', strtotime($request->clos_date)),
                    'email' => $request->email,
                    'con_num' => $request->con_num,
                    // 'job_link' => env("BASE_URL") . 'career/' . base64_encode(($l_id)),
                    // 'emid' => $Roledata->reg,
                    'status' => 'Job Created',
                    'gender_male' => $request->gender_male,
                    'working_hour' => $request->working_hour,
                    'skil_set' => $request->skil_set,
                    'time_pre' => $request->time_pre,

                );
                // print_r($data);die;

               $isertId=DB::table('company_jobs')->insertGetId($data);
               $arrayvalu=[
                "job_link"=>env("BASE_URL") . 'career/' . base64_encode(($isertId)),
               ];
               DB::table('company_jobs')->where('id',$isertId)->update($arrayvalu);
                $datajoblist = array(

                    'des_job' => $request->job_desc,

                );

                DB::table('company_job_lists')->where('id', $request->soc)->update($datajoblist);

                Session::flash('message', 'Job Post Information Successfully saved.');

                return redirect('recruitment/job-post');
            }

        } else {
            return redirect('/');
        }

    }
    public function viewjobpublished()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['company_job_rs'] = JobPost::all();
           // dd($data['company_job_rs']);
            return view('recruitment/job-published', $data);
        } else {
            return redirect('/');
        }
    }
    public function viewAddNewpublished(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['department_rs'] = DB::Table('company_job_lists')->get();
            if ($request->id) {
                $data['designation'] = DB::Table('job_posts')
                    ->where('id', '=', $request->id)
                    ->get();

                return view('recruitment/add-new-job-published', $data);
            } else {

                return view('recruitment/add-new-job-published', $data);
            }
        } else {
            return redirect('/');
        }
    }
    public function saveJobpublishedData(Request $request)
    {
        // dd($request->all());
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            if ($request->id) {

                if (!empty($request->id_up_doc)) {

                    $tot_item_nat_edit = count($request->id_up_doc);

                    foreach ($request->id_up_doc as $valuee) {

                        if ($request->has('scren_' . $valuee)) {
                            $size = $request->file('scren_' . $valuee)->getSize();
                            $extension_doc_edit_up = $request->file('scren_' . $valuee)->extension();
                            $path_quli_doc_edit_up = $request->file('scren_' . $valuee)->store('job_posts', 'public');
                            $dataimgeditup = array(
                                'scren' => $path_quli_doc_edit_up,
                            );
                            DB::table('job_posts')
                                ->where('id', $valuee)
                                ->update($dataimgeditup);
                        }
                        $datauploadedit = array(
                            'url' => $request->input('url_' . $valuee),
                        );
                        DB::table('job_posts')
                            ->where('id', $valuee)
                            ->update($datauploadedit);
                    }
                }
                if (!empty($request->url)) {
                    $tot_item_nat = count($request->url);
                    for ($i = 0; $i < $tot_item_nat; $i++) {
                        if ($request->url[$i] != '') {
                            if (!empty($request->scren[$i])) {

                                $extension_upload_doc = $request->scren[$i]->extension();
                                $path_upload_doc = $request->scren[$i]->store('job_posts', 'public');

                            } else {
                                $path_upload_doc = '';
                            }

                            $data = array(
                                'job_id' => $request->job_id,
                                'title' => $request->title,
                                'emid' => NULL,
                                'url' => $request->url[$i],
                                'scren' => $path_upload_doc,
                                'department' => $request->department,
                                'job_desc' => $request->job_desc,

                            );
                            DB::table('job_posts')->insert($data);

                        }

                    }
                }

                Session::flash('message', 'Job Published Information Successfully Updated.');
                return redirect('recruitment/job-published');
            } else {
                if (!empty($request->url)) {
                    $tot_item_nat = count($request->url);

                    for ($i = 0; $i < $tot_item_nat; $i++) {
                        if ($request->url[$i] != '') {
                            if (!empty($request->scren[$i])) {

                                $extension_upload_doc = $request->scren[$i]->extension();
                                $path_upload_doc = $request->scren[$i]->store('job_posts', 'public');

                            } else {
                                $path_upload_doc = '';
                            }

                            $data = array(
                                'job_id' => $request->job_id,
                                'title' => $request->title,
                                'emid' => NULL,
                                'url' => $request->url[$i],
                                'scren' => $path_upload_doc,
                                'department' => $request->department,
                                'job_desc' => $request->job_desc,
                            );
                            DB::table('job_posts')->insert($data);

                        }

                    }
                }
                Session::flash('message', 'Job Published Information Successfully saved.');

                return redirect('recruitment/job-published');
            }

        } else {
            return redirect('/');
        }

    }
    public  function viewcandidate(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            if ($request->has('go')) {
                $formDate = $request->get('formDate');
                $formdateArray=$formDate;
                $toDate = $request->get('toDate'); 
                $check=$request->get('checklist');
                $toCheck=$check;
                $todateArray=$toDate;
                $data['candidate_rs']= DB::table('candidates')
                ->join('company_jobs', 'candidates.job_id', '=', 'company_jobs.id')
                ->whereBetween('date', [$formDate, $toDate])->get();
            }else{
                $data['candidate_rs'] = DB::Table('candidates')
                    ->join('company_jobs', 'candidates.job_id', '=', 'company_jobs.id')
                    ->select('candidates.*', 'company_jobs.job_code')
                    ->get();
            }
            dd($data['candidate_rs']);
            return view('recruitment/candidate-list', $data);
        } else {
            return redirect('/');
        }
    }
  


    //Ajax fetch function

   public function getDepartment(Request $request,$empid){
        $desig_rs = CompanyJobList::where('id', $empid)->first();
        $employee_rs = CompanyJobList::where('soc', $desig_rs->soc)->get();
        $result = '';
        $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
        foreach ($employee_rs as $bank) {
            $result_status1 .= '<option value="' . $bank->title . '">' . $bank->title . '</option>';
        }

        echo $result_status1;
    }
    public function getJobdetails(Request $request,$empid,$soc){  
        $desig_rs = CompanyJobList::where('id', $soc)->first();
        $employee_rs = CompanyJobList::where('soc', $desig_rs->soc)
        ->where('title', $empid)
        ->first();
        return json_encode($employee_rs);
    }
 

}
