<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;

class RenewContractCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renewCommand:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now();
        $oneYearLater = $today->addYear();
        $lastMonth = $oneYearLater->subMonth();
        $lastDayOfMonth = $lastMonth->endOfMonth();
        $formattedDate = $lastDayOfMonth->format('Y-m-d');

        $today = date('Y-m-d');
        
        $data=array(
            'contract_renew_date'=>$formattedDate
        );
        DB::table('employees')->where('contract_renew_date',$today)->where('emp_status', '!=', 'EX-EMPLOYEE')->update($data);
    }
}
