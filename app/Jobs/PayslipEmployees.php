<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

//Import Models
use App\Models\Payroll\Payroll_detail;
use App\Models\Leave\Leave_allocation;
use App\Models\Masters\Company;
use App\Models\Employee\Emp_actual_paystructure;
use App\Models\Masters\Rate_master;

class PayslipEmployees implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
    */

    public $month_yr;
    public function __construct($month_yr)
    {
        $this->month_yr = $month_yr;
    }

    /**
     * Execute the job.
     *
     * @return void
    */
    public function handle()
    {
        //Get Employee Data
        $month_yr = $this->month_yr;
        $Payroll_details_rs = Payroll_detail::where('payroll_details.month_yr', '=', $month_yr)
        ->leftJoin('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
        ->leftJoin('users', 'users.employee_id', '=', 'employees.emp_code')
        ->select('payroll_details.*', 'employees.old_emp_code', 'users.name', 'users.email')
        ->whereNotNull('users.name')
        ->whereNotNull('users.email')
        ->get();

        foreach ($Payroll_details_rs as $payroll) {

            try {
                $emp_id = $payroll->employee_id;
                $pay_dtl_id = $payroll->id;
    
                $data['payroll_rs'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                ->join('banks', 'employees.bank_branch_id', '=','banks.id')
                ->join('monthly_employee_allowances', 'employees.emp_code','=','monthly_employee_allowances.emp_code' )
                ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                ->where('payroll_details.employee_id', '=', $emp_id)
                ->where('payroll_details.id', '=', $pay_dtl_id)
                ->select('payroll_details.*', 'employees.*', 'bank_masters.master_bank_name', 'group_name_details.group_name', 'banks.branch_name', 'monthly_employee_allowances.no_days_tiffalw')
                ->get();
    
                $data['leave_hand'] = Leave_allocation::join('leave_types', 'leave_allocations.leave_type_id', '=', 'leave_types.id')
                ->where('leave_allocations.employee_code', '=', $emp_id)
                ->where('leave_allocations.leave_allocation_status', '=', 'active')
                ->select('leave_allocations.*', 'leave_types.leave_type_name')
                ->get();
    
                $montharr = explode('/', $data['payroll_rs'][0]->month_yr);
                $calculate_month = $montharr[0] - 2;
    
                if (strlen($calculate_month) == 1) {
                    $leave_calculate = "0" . $calculate_month;
                } else {
                    $leave_calculate = $calculate_month;
                }
    
                $caculate_month_for_leave = $leave_calculate . "/" . $montharr[1];
    
                $data['current_month_days'] = date('t', strtotime($montharr[1] . '-' . $montharr[0] . '-01'));
    
                $data['actual_payroll'] = Emp_actual_paystructure::where('emp_code', '=', $emp_id)->first();
    
                $data['company_rs'] = Company::orderBy('id', 'desc')->first();
                $data['rate_master'] = Rate_master::get();
    
                // Generate PDF
                $pdfData = [];
                $pdf = PDF::loadView('payroll.pdf.payslip', $data);
    
                // Send Mail
                \Mail::send('payroll.mail.payslip-mail', [], function ($message) use ($pdf, $payroll) {
                    $message->to($payroll->email, $payroll->name)->subject('Laravel Basic Testing Mail');
                    $message->attachData($pdf->output(), 'Bellevue-Payslip.pdf');
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });
    
                \Log::alert('PAYSLIP SEND');
            } catch (\Throwable $th) {
                \Log::alert('SOMTHING WENT WRONG');
            }

        }
    }
}
