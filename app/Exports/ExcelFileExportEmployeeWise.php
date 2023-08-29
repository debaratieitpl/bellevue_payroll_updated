<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Attendance\Upload_attendence;
use App\Models\Role\Employee;
use App\Models\Payroll\Payroll_detail;
use DB;

class ExcelFileExportEmployeeWise implements FromCollection, WithHeadings
{
    private $month_yr;
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($month_yr,$emp_code)
    {
        $this->month_yr = $month_yr;
        $this->emp_code = $emp_code;
        
    }
    public function collection()
    {

        $arrMY = explode('/', $this->month_yr);
        $reportMonth = $arrMY[0];
        $reportYear = $arrMY[1];
        $reportFinancialYear = '';
        $reportMinYear = '';
        $reportMaxYear = '';
        if ($reportMonth < 4) {
            $reportFinancialYear = ($reportYear - 1) . '-' . $reportYear;
            $reportMinYear = ($reportYear - 1);
            $reportMaxYear = $reportYear;
        } else {
            $reportFinancialYear = $reportYear . '-' . ($reportYear + 1);
            $reportMinYear = $reportYear;
            $reportMaxYear = ($reportYear + 1);
        }


        $employee_rs = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select(
                    'payroll_details.id',
                    'payroll_details.employee_id',
                    'payroll_details.emp_name',
                    'payroll_details.emp_pf',
                    'payroll_details.emp_apf',
                    'payroll_details.emp_designation',
                    'employees.emp_pf_no',
                    'employees.emp_pension',
                    'employees.emp_pf_inactuals',
                    'employees.old_emp_code',
                    'employees.emp_department',
                    'payroll_details.emp_pf_employer',
                    'payroll_details.emp_pf_pension',
                    DB::raw("(SELECT sum(emp_pf) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $this->month_yr. "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_pf_mtd"),
                    DB::raw("(SELECT sum(emp_pf_employer) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $this->month_yr . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_pf_employer_mtd"),
                    DB::raw("(SELECT sum(emp_pf_pension) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $this->month_yr . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_pf_pension_mtd"),
                    DB::raw("(SELECT sum(emp_apf) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $this->month_yr. "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_apf_mtd"),
                    DB::raw("(SELECT 0) as opening_data"),
                    DB::raw("(SELECT basic_pay FROM employee_pay_structures WHERE employee_code=employees.emp_code) as basic_pay")
                )
                ->where('payroll_details.month_yr', '=', $this->month_yr)
                ->where('payroll_details.employee_id', '=', $this->emp_code)
                ->where('payroll_details.emp_pf', '>', '0')
                //->where('employees.emp_code', '=', '7257')
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();
               
             // dd($employee_rs);
            $h = 1;
            $total_calculation = 0;
            $subtotal_basic=0;
            $subtotal_apf=0;
            $subtotal_pf=0;
            $subtotal_pf_employer=0;
            $subtotal_pf_pension=0;
            $subtotal_opening=0;
            $subtotal_closing=0;
            $customer_array = array();

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                $subtotal_basic+=$record->basic_pay;
                $subtotal_apf+=$record->emp_apf;
                $total_calculation += $record->emp_apf+$record->emp_apf_mtd+$record->emp_pf_mtd + $record->emp_pf + $record->emp_pf_employer_mtd + $record->emp_pf_employer + $record->opening_data;
				$subtotal_closing=$total_calculation;
				$subtotal_pf+=$record->emp_pf; 
                $subtotal_pf_employer+=$record->emp_pf_employer;
                $subtotal_pf_pension+=$record->emp_pf_pension;
                $subtotal_opening+=$record->emp_apf_mtd+$record->emp_pf_mtd + $record->emp_pf_employer_mtd + $record->opening_data;
                $customer_array[] = array(
                    'Sl No' => $h,
                    'Month/Year' => $this->month_yr,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->emp_name,
                    'Employee PF A/C No'=>$record->emp_pf_no,
                    'Basic '=>$record->basic_pay,
                    'Employee APF Contribution'=>$record->emp_apf,
                    'Employee Contribution'=>$record->emp_pf,
                    'Employer Contribution'=>$record->emp_pf_employer,
                    'Pension Contribution'=>$record->emp_pf_pension,
                    'Opening Balance'=>$record->emp_apf_mtd+$record->emp_pf_mtd + $record->emp_pf_employer_mtd + $record->opening_data,
                    'Closing Balance'=>$record->emp_apf+$record->emp_apf_mtd+$record->emp_pf_mtd + $record->emp_pf + $record->emp_pf_employer_mtd + $record->emp_pf_employer + $record->opening_data,
                );
                $h++;
            }
                $customer_array[] = array(
                    'Sl No' => 'Sub Total',
                    'Month/Year'=>'',
                    'Employee Code'=>'',
                    'Employee Name'=>'',
                    'Employee PF A/C No'=>'',
                    'Basic '=>$subtotal_basic,
                    'Employee APF Contribution'=>$subtotal_apf,
                    'Employee Contribution'=>$subtotal_pf,
                    'Employer Contribution'=>$subtotal_pf_employer,
                    'Pension Contribution'=>$subtotal_pf_pension,
                    'Opening Balance'=>$subtotal_opening,
                    'Closing Balance'=>$subtotal_closing,

                );

                $number = $total_calculation;
                $no = round($number);
                $point = round($number - $no, 2) * 100;
                $hundred = null;
                $digits_1 = strlen($no);
                $i = 0;
                $str = array();
                $words = array('0' => '', '1' => 'one', '2' => 'two',
                    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                    '7' => 'seven', '8' => 'eight', '9' => 'nine',
                    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                    '13' => 'thirteen', '14' => 'fourteen',
                    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                    '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
                    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                    '60' => 'sixty', '70' => 'seventy',
                    '80' => 'eighty', '90' => 'ninety');
                $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
                while ($i < $digits_1) {
                    $divider = ($i == 2) ? 10 : 100;
                    $number = floor($no % $divider);
                    $no = floor($no / $divider);
                    $i += ($divider == 10) ? 1 : 2;
                    if ($number) {
                        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
                        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                        $str[] = ($number < 21) ? $words[$number] .
                        " " . $digits[$counter] . $plural . " " . $hundred
                        :
                        $words[floor($number / 10) * 10]
                            . " " . $words[$number % 10] . " "
                            . $digits[$counter] . $plural . " " . $hundred;
                    } else {
                        $str[] = null;
                    }
                
                }
                $str = array_reverse($str);
                $result = implode('', $str);
                $points = ($point) ?
                "." . $words[$point / 10] . " " .
                $words[$point = $point % 10] : '';

                $customer_array[] = array(
                    'Sl No' => 'Total in words: RUPEES '.strtoupper($result),
                    'Month/Year'=>'',
                    'Employee Code'=>'',
                    'Employee Name'=>'',
                    'Employee PF A/C No'=>'',
                    'Basic '=>'',
                    'Employee APF Contribution'=>'',
                    'Employee Contribution'=>'',
                    'Employer Contribution'=>'',
                    'Pension Contribution'=>'',
                    'Opening Balance'=>'',
                    'Closing Balance'=>$subtotal_closing,

                );


        }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No',
            'Month/Year',
            'Employee Code',
            'Employee Name',
            'Employee PF A/C No',
            'Basic ',
            'Employee APF Contribution',
            'Employee Contribution',
            'Employer Contribution',
            'Pension Contribution',
            'Opening Balance',
            'Closing Balance',
        ];
    }
}
