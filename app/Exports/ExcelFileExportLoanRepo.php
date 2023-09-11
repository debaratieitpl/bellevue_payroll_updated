<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Loan\Loan;
use DB;

class ExcelFileExportLoanRepo implements FromCollection, WithHeadings
{
    private $month_yr;
    private $loan_type;
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($month_yr,$loan_type)
    {
        
        $this->month_yr = $month_yr;
        $this->loan_type = $loan_type;
        
    }
    // public function collection()
    // {
    //     $employee_rs = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
    //         ->select('employees.salutation','employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname','employees.emp_status', 'employees.emp_designation', 'employees.old_emp_code','employees.emp_pf_no', 'loans.*', DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month <= '".$this->month_yr."') as recoveries"),DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$this->month_yr."') as payroll_deduction"), DB::raw("(SELECT  payroll_details.emp_pf_int FROM payroll_details WHERE payroll_details.employee_id =  employees.emp_code and payroll_details.month_yr = '".$this->month_yr."') as pf_iterest"))
    //         ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $this->month_yr)
    //         ->where('loan_type', '=', $this->loan_type)
    //         ->where('deduction', '=', 'Y')
    //         ->where('loans.loan_amount', '>', 0)
    //         ->where(DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$this->month_yr."')"), '>', 0)
    //             ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
    //         ->get();

    //     $h = 1;
    //     $customer_array = array();
        
    //     $total_loan_amount=0;
						
    //     $total_balance=0;
    //     $total_installment=0;
    //     $total_pf_interest=0;
    //     $total_deduction=0;
    //     $total_loanadjust=0;

    //     if (count($employee_rs) != 0) {
    //         if($this->loan_type=='PF'){
    //             foreach ($employee_rs as $record) {
    //                 $balance=0;
    //                 if($record->recoveries==null){
    //                     $balance = $record->loan_amount;
    //                 }else{
    //                     $balance = $record->loan_amount-$record->recoveries;
    //                 }
                    
    //                 $total_loan_amount=$total_loan_amount+$record->loan_amount;
    //                 $total_installment=$total_installment+$record->payroll_deduction;
    //                 $total_pf_interest=$total_pf_interest+$record->pf_iterest;
    //                 $total_deduction=$total_deduction+$record->payroll_deduction+$record->pf_iterest;
                   
    //                 $total_balance=$total_balance+$balance;
    //                 $total_loanadjust=$total_loanadjust+$record->adjust_amount;

    //                 $pf_interest=$record->pf_iterest;

    //                 $customer_array[] = array(
    //                     'Sl No'=> $h,
    //                     'Employee Code'=>$record->old_emp_code,
    //                     'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
    //                     'Loan ID'=>$record->loan_id,
    //                     'Employee type'=>$record->emp_status,
    //                     'PF Number'=>$record->emp_pf_no,
    //                     'PF Loan Outstanding'=>$record->loan_amount,
    //                     'PF Loan Deduction'=>$record->payroll_deduction,
    //                     'PF Interest'=>$pf_interest,
    //                     'Total Deduction'=>number_format(round($record->payroll_deduction+$pf_interest,1),2),
    //                     'PF Loan Balance'=>number_format(round($balance,1),2),
    //                     'Loan Adjust'=>number_format(round($record->adjust_amount,1),2),
    //                     'Final PF Loan Balance'=>number_format(round($balance-$record->adjust_amount,1),2),
        
    //                 );
    //                 $h++;
    //             }
    //             $customer_array[] = array(
    //                 'Sl No' => 'Grand',
    //                 'Employee Code' => 'Total',
    //                 'Employee Name'=> '',
    //                 'Loan ID'=> '',
    //                 'Employee type'=> '',
    //                 'PF Number'=>'',
    //                 'PF Loan Outstanding'=> number_format(round($total_loan_amount,1),2),
    //                 'PF Loan Deduction'=> number_format(round($total_installment,1),2),
    //                 'PF Interest'=> number_format(round($total_pf_interest,1),2),
    //                 'Total Deduction'=> number_format(round($total_deduction,1),2),
    //                 'PF Loan Balance'=> number_format(round($total_balance,1),2),
    //                 'Loan Adjust'=> number_format(round($total_loanadjust,1),2),
    //                 'Final PF Loan Balance'=> number_format(round(($total_balance-$total_loanadjust),1),2),
    //             );
                    
    //         }
    //         if($this->loan_type=='SA'){
    //             foreach ($employee_rs as $record) {
    //                 $balance=0;
    //                 if($record->recoveries==null){
    //                     $balance = $record->loan_amount;
    //                 }else{
    //                     $balance = $record->loan_amount-$record->recoveries;
    //                 }
                    
    //                 $total_loan_amount=$total_loan_amount+$record->loan_amount;
                   
    //                 $total_balance=$total_balance+$balance;
    //                 $total_installment=$total_installment+$record->payroll_deduction;
    //                 $total_loanadjust=$total_loanadjust+$record->adjust_amount;
    
    //                 $customer_array[] = array(
    //                     'Sl No' => $h,
    //                     'Employee Code'=>$record->old_emp_code,
    //                     'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
    //                     'Loan ID'=>$record->loan_id,
    //                     'Employee type'=>$record->emp_status,
    //                     'Outstanding Amount'=>$record->loan_amount,
    //                     'Deducted Amount'=>$record->payroll_deduction,
    //                     'Balance Amount'=>number_format(round($balance,1),2),
    //                     'Adjust Amount'=>number_format(round($record->adjust_amount,1),2),
    //                     'Final Balance Amount'=>number_format(round($balance-$record->adjust_amount,1),2),
        
    //                 );
    //                 $h++;
    //             }
    //             $customer_array[] = array(
    //                 'Sl No' => 'Grand',
    //                 'Employee Code' => 'Total',
    //                 'Employee Name' => '',
    //                 'Loan ID' => '',
    //                 'Employee type' => '',
    //                 'Outstanding Amount'=>$total_loan_amount,
    //                 'Deducted Amount'=>$total_installment,
    //                 'Balance Amount'=>number_format(round($total_balance,1),2),
    //                 'Adjust Amount'=>number_format(round($total_loanadjust,1),2),
    //                 'Final Balance Amount'=>number_format(round(($total_balance-$total_loanadjust),1),2),
    //             );
    
    //         }

    //     }
    //     return collect($customer_array);
    // }

    public function collection()
    {
        // $result = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
        //     ->select('employees.salutation','employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname','employees.emp_status', 'employees.emp_designation', 'employees.old_emp_code','employees.emp_pf_no', 'loans.*', DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month <= '".$this->month_yr."') as recoveries"),DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$this->month_yr."') as payroll_deduction"), DB::raw("(SELECT  payroll_details.emp_pf_int FROM payroll_details WHERE payroll_details.employee_id =  employees.emp_code and payroll_details.month_yr = '".$this->month_yr."') as pf_iterest"))
        //     ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $this->month_yr)
        //     ->where('loan_type', '=', $this->loan_type)
        //     ->where('deduction', '=', 'Y')
        //     ->where('loans.loan_amount', '>', 0)
        //     ->where(DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$this->month_yr."')"), '>', 0)
        //         ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
        //     ->get();

            $result = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
            ->select('employees.salutation', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname','employees.emp_status','employees.emp_designation', 'employees.old_emp_code', 'employees.emp_pf_no', 'employees.emp_department', 'loans.*', DB::raw("(SELECT IFNULL(SUM(loan_recoveries.amount), IFNULL((SELECT loan_amount FROM loans WHERE loans.id = employees.emp_code), 0)) FROM loan_recoveries WHERE loan_recoveries.loan_id = loans.id AND loan_recoveries.payout_month <= '".$this->month_yr."') as recoveries"), DB::raw("(SELECT SUM(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id = loans.id AND loan_recoveries.payout_month = '".$this->month_yr."') as payroll_deduction"), DB::raw("(SELECT IFNULL(payroll_details.emp_pf_int, 0) FROM payroll_details WHERE payroll_details.employee_id = employees.emp_code AND payroll_details.month_yr = '".$this->month_yr."') as pf_interest"))
            ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $this->month_yr)
            ->where('loan_type', '=', $this->loan_type)
            ->where('deduction', '=', 'Y')
            // ->where('loans.emp_code', '=', 2024)
            ->where('loans.loan_amount', '>', 0)
            ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
            ->get();

        $h = 1;
        $customer_array = array();
        
        $total_loan_amount=0;
						
        $total_balance=0;
        $total_installment=0;
        $total_pf_interest=0;
        $total_deduction=0;
        $total_loanadjust=0;

        if (count($result) != 0) {
            if($this->loan_type=='PF'){
                $employeeTotals = [];
				$index = 0; 
                foreach ($result as $record) {
                    $key = $record->emp_code;
						
								if (!isset($employeeTotals[$key])) {
									$employeeTotals[$key] = [
										'index' => ++$index,
										'emp_code' => $record->emp_code,
                                        'old_emp_code' => $record->old_emp_code,
                                        'emp_status' => $record->emp_status,
										'emp_name' => "{$record->salutation} {$record->emp_fname} {$record->emp_mname} {$record->emp_lname}",
										'loan_amount' => 0,
										'payroll_deduction' => 0,
										'pf_interest' => 0,
										'balance' => 0,
										'loanadjust' => 0,
									];
								}
						
								$balance = $record->recoveries === null ? $record->loan_amount : ($record->loan_amount - $record->recoveries);
								$employeeTotals[$key]['loan_amount'] += $record->loan_amount;
								$employeeTotals[$key]['payroll_deduction'] += $record->payroll_deduction;
								$employeeTotals[$key]['pf_interest'] += $record->pf_iterest;
								$employeeTotals[$key]['balance'] += $balance;
								$employeeTotals[$key]['loanadjust'] += $record->adjust_amount;
						
								$pf_interest = $record->pf_iterest;
                }

                foreach ($employeeTotals as $employee) {
                    $customer_array[] = array(
                        'Sl No'=> $h,
                        'Employee Code'=>$employee['old_emp_code'],
                        'Employee Name'=>$employee['emp_name'],
                        'Employee type'=>$employee['emp_status'],
                        'PF Loan Outstanding'=>number_format(round($employee['loan_amount'], 1),2),
                        'PF Loan Deduction'=>number_format(round($employee['payroll_deduction'], 1),2),
                        'PF Interest'=>number_format(round($employee['pf_interest'], 1),2),
                        'Total Deduction'=>number_format(round($employee['payroll_deduction'] + $employee['pf_interest'], 1),2),
                        'PF Loan Balance'=>number_format(round($employee['balance'], 1),2),
                        'Loan Adjust'=>number_format(round($employee['loanadjust'], 1),2),
                        'Final PF Loan Balance'=>number_format(round($employee['balance'] - $employee['loanadjust'], 1),2),
        
                    );
                    $h++;
                }

                    
                
                $customer_array[] = array(
                    'Sl No' => 'Grand',
                    'Employee Code' => 'Total',
                    'Employee Name'=> '',
                    'Employee type'=> '',
                    'PF Loan Outstanding'=> number_format(round(array_sum(array_column($employeeTotals, 'loan_amount')), 1),2),
                    'PF Loan Deduction'=> number_format(round(array_sum(array_column($employeeTotals, 'payroll_deduction')), 1),2),
                    'PF Interest'=> number_format(round(array_sum(array_column($employeeTotals, 'pf_interest')), 1),2),
                    'Total Deduction'=> number_format(round(array_sum(array_column($employeeTotals, 'payroll_deduction')) + array_sum(array_column($employeeTotals, 'pf_interest')), 1),2),
                    'PF Loan Balance'=> number_format(round(array_sum(array_column($employeeTotals, 'balance')), 1),2) ,
                    'Loan Adjust'=> number_format(round(array_sum(array_column($employeeTotals, 'loanadjust')), 1),2),
                    'Final PF Loan Balance'=> number_format(round(array_sum(array_column($employeeTotals, 'balance')) - array_sum(array_column($employeeTotals, 'loanadjust')), 1),2) ,
                );
                    
            }
            if($this->loan_type=='SA'){
                $consolidatedData = [];
                foreach ($result as $record) {
                    $empCode = $record->emp_code;
                        
                                if (!isset($consolidatedData[$empCode])) {
                                    $consolidatedData[$empCode] = [
                                        'recordCount' => 0,
                                        'total_loan_amount' => 0,
                                        'total_installment' => 0,
                                        'total_balance' => 0,
                                        'total_loanadjust' => 0,
                                        'emp_name' => "{$record->salutation} {$record->emp_fname} {$record->emp_mname} {$record->emp_lname}",
                                        'emp_status' => $record->emp_status,
                                        'old_emp_code' => $record->old_emp_code,
                                    ];
                                }
                        
                                $balance = $record->recoveries === null ? $record->loan_amount : ($record->loan_amount - $record->recoveries);
                        
                                $consolidatedData[$empCode]['recordCount']++;
                                $consolidatedData[$empCode]['total_loan_amount'] += $record->loan_amount;
                                $consolidatedData[$empCode]['total_installment'] += $record->payroll_deduction;
                                $consolidatedData[$empCode]['total_balance'] += $balance;
                                $consolidatedData[$empCode]['total_loanadjust'] += $record->adjust_amount;
                }
                foreach ($consolidatedData as $empCode => $employee) {
                    $customer_array[] = array(
                        'Sl No' => $h,
                        'Employee Code'=>$employee['old_emp_code'],
                        'Employee Name'=>$employee['emp_name'],
                        'Employee type'=>$employee['emp_status'],
                        'Outstanding Amount'=>number_format(round(round($employee['total_loan_amount'], 1),1),2),
                        'Deducted Amount'=>number_format(round($employee['total_installment'], 1),2),
                        'Balance Amount'=>number_format(round($employee['total_balance'], 1),2),
                        'Adjust Amount'=>number_format(round($employee['total_loanadjust'], 1),2),
                        'Final Balance Amount'=>number_format(round($employee['total_balance'] - $employee['total_loanadjust'], 1),2),
        
                    );
                    $h++;
                    
                }
                    
                
                $customer_array[] = array(
                    'Sl No' => 'Grand',
                    'Employee Code' => 'Total',
                    'Employee Name' => '',
                    'Employee type' => '',
                    'Outstanding Amount'=>number_format(round(array_sum(array_column($consolidatedData, 'total_loan_amount')), 1),2),
                    'Deducted Amount'=>number_format(round(array_sum(array_column($consolidatedData, 'total_installment')), 1),2),
                    'Balance Amount'=>number_format(round(array_sum(array_column($consolidatedData, 'total_balance')), 1),2),
                    'Adjust Amount'=>number_format(round(array_sum(array_column($consolidatedData, 'total_loanadjust')), 1),2),
                    'Final Balance Amount'=>number_format(round(array_sum(array_map(function($employee) {
                        return $employee['total_balance'] - $employee['total_loanadjust'];
                    }, $consolidatedData)), 1),2),
                );
    
            }

        }
        return collect($customer_array);
    }

    // public function headings(): array
    // {
    //     if($this->loan_type=='PF'){
    //         return [
    //             'Sl No',
    //             'Employee Code',
    //             'Employee Name',
    //             'Loan ID',
    //             'Employee Type',
    //             'PF Number',
    //             'PF Loan Outstanding',
    //             'PF Loan Deduction',
    //             'PF Interest',
    //             'Total Deduction',
    //             'PF Loan Balance',
    //             'Loan Adjust',
    //             'Final PF Loan Balance',
    //         ];
                
    //     }
    //     if($this->loan_type=='SA'){
    //         return [
    //             'Sl No',
    //             'Employee Code',
    //             'Employee Name',
    //             'Loan ID',
    //             'Employee Type',
    //             'Outstanding Amount',
    //             'Deducted Amount',
    //             'Balance Amount',
    //             'Adjust Amount',
    //             'Final Balance Amount',
    //         ];
    
    //     }
    // }
    public function headings(): array
    {
        if($this->loan_type=='PF'){
            return [
                'Sl No',
                'Employee Code',
                'Employee Name',
                'Employee Type',
                'PF Loan Outstanding',
                'PF Loan Deduction',
                'PF Interest',
                'Total Deduction',
                'PF Loan Balance',
                'Loan Adjust',
                'Final PF Loan Balance',
            ];
                
        }
        if($this->loan_type=='SA'){
            return [
                'Sl No',
                'Employee Code',
                'Employee Name',
                'Employee Type',
                'Outstanding Amount',
                'Deducted Amount',
                'Balance Amount',
                'Adjust Amount',
                'Final Balance Amount',
            ];
    
        }
    }
}
