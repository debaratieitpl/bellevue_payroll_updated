<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportPayDetails implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
         //dd($row);
        //pf upate
        \DB::table('employee_pay_structures')
            ->where('employee_code', $row['emp_code'])
            ->update([
            'pf' => $row['pf'],
            'pf_type' => $row['pf_type'],
            'apf' => $row['apf'],
            'apf_type' => $row['apf_type'],
            'i_tax' => $row['itax'],
            'prof_tax' => $row['pftx'],
            'prof_tax_type' => $row['prof_tax_type'],
        ]);

        //dd($row);
        //Paystructure update
        // $emp_pf_inactuals = $row['basic'];
        // if ($emp_pf_inactuals > 15000) {
        //     $emp_pf_inactuals ='Y';
        // }else{
        //     $emp_pf_inactuals ='N';
        // }
        //dd($emp_pf_inactuals);

        // \DB::table('employee_pay_structures')
        // ->where('employee_code', $row['emp_code'])
        // ->update([
        //     'basic_pay' => $row['basic'],
        //     'apf_percent' => $row['apf'],
        //     'da' => $row['da'],
        //     'da_type' => $row['da_type'],
        //     'tiff_alw' => $row['tifa'],
        //     'tiff_alw_type' => $row['tifa_type'],
        //     'conv' => $row['cva'],
        //     'conv_type' => $row['cva_type'],
        //     'others_alw' => $row['otha'],
        //     'others_alw_type' => $row['otha_type'],
        //     'misc_alw' => $row['misc1'],
        //     'misc_alw_type' => $row['misc1_type'],
        //     'medical' => $row['mdalw'],
        //     'medical_type' => $row['mdalw_type'],
        //     'i_tax' => $row['itax'],
        //     'i_tax_type' => $row['itax_type'],
        //     'insu_prem' => $row['insp'],
        //     'insu_prem_type' => $row['insp_type'],
        //     'co_op' => $row['cops'],
        //     'co_op_type' => $row['cops_type'],
        //     'furniture' => $row['furn'],
        //     'furniture_type' => $row['furn_type'],
        // ]);
        // \DB::table('employees')
        // ->where('emp_code', $row['emp_code'])
        // ->update([
        //     'emp_pf_inactuals' => $emp_pf_inactuals,
        // ]);
    }
}
