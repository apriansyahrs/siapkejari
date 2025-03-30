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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('position_id');
            $table->string('nik', 16);
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('marital_status');
            $table->string('npwp');
            $table->string('phone_number');
            $table->string('health_insurance_number');
            $table->integer('health_insurance_id');
            $table->string('account_number')->nullable();
            $table->string('employment_contract');
            $table->unsignedTinyInteger('number_of_dependants');
            $table->boolean('is_active');
            $table->boolean('is_free_radius')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
