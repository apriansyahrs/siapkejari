<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->date('period');
            $table->string('employment_contract');
            $table->unsignedInteger('salary');
            $table->unsignedInteger('pph_21_allowance')->default(0);
            $table->unsignedInteger('pph_21_deduction')->default(0);
            $table->unsignedInteger('health_insurance_contribution')->default(0);
            $table->unsignedInteger('other_family_health_insurance_contribution')->default(0);
            $table->unsignedTinyInteger('other_family_health_insurance')->default(0);
            $table->unsignedInteger('total_deduction');
            $table->unsignedInteger('net_salary');
            $table->string('account_number');
            $table->date('payment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
