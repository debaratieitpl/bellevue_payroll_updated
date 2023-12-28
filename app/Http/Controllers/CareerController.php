<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Http\Request;
use Session;
use view;

class CareerController extends Controller
{
    public function viewdash($career_id)
    {
        // dd('hello',base64_decode($career_id));
            $data['job']=DB::table('company_jobs')->where('id','=',base64_decode($career_id))->first();
          
            return View('career/career',$data);
    }
    public function viewapp($career_id)
    {
        try {

            $data['job']= DB::table('company_jobs')->where('id', '=', base64_decode($career_id))->first();
           
            // $data['cuurenci_master']= DB::table('currencies')->get();
            // dd($data['cuurenci_master']);
            return View('career/application',$data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveapp(Request $request)
    {
       
            $ckeck_dept= DB::table('candidates')->where('job_id', $request->job_id)->where('email', $request->email)->first();
            
            if (!empty($ckeck_dept)) {
                Session::flash('message', 'You are Already Applied For this Post.');
                return redirect('career/application/' . base64_encode($request->job_id));
            } else {
          
            if ($request->has('resume')) {

                $file = $request->file('resume');
                
                $extension = $request->resume->extension();
                
               $imageName = time() . '.' . $file->getClientOriginalExtension();
                $paths =$file->move(public_path('/candidate_resume'), $imageName);
               $path='candidate_resume'.'/'.$paths->getFilename();
               
            }
           
                if ($request->dob != '') {
                    $dob = date('Y-m-d', strtotime($request->dob));
                } else {
                    $dob = '';
                }
                $data = array(
                    'job_id' => $request->job_id,
                    'job_title' => $request->job_title,
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'exp_month' => $request->exp_month,
                    'skill_level' => $request->skill_level,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'exp' => $request->exp,
                    'cur_or' => $request->cur_or,
                    'cur_deg' => $request->cur_deg,
                    'country' => $request->country,
                    'dob' => $dob,
                    'zip' => $request->zip,
                    'location' => $request->location,
                    'exp_sal' => trim($request->exp_sal),
                    'sal' => trim($request->sal),
                    'status' => 'Application Received',
                    'edu' => $request->edu,
                    'skill' => $request->skill,
                    'date' => date('Y-m-d H:i:s'),
                    'resume' => $path,
                    'createDate'=>date('Y-m-d'),
                    'updateDate'=>date('Y-m-d'),
                );
                DB::table('candidates')->insert($data);

                return redirect('thank-you');

            }
    }

    public function appthankyou()
    {
        try {
            return View('career/thank-you');
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

}
