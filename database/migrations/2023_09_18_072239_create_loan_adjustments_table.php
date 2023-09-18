<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_adjustments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('loan_id')->default(null);
            $table->bigInteger('emp_code')->default(null);
            $table->string('loan_type')->default(null);
            $table->decimal('amount')->default(null);
            $table->string('payout_month')->default(null);
            $table->text('remarks')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_adjustments');
    }
}
