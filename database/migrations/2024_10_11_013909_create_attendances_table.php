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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->date('checkin_date');
            $table->time('checkin_time');
            $table->string('checkin_latitude')->nullable();
            $table->string('checkin_longitude')->nullable();
            $table->string('checkin_photo')->nullable();
            $table->unsignedInteger('checkin_late')->nullable();
            $table->date('checkout_date');
            $table->time('checkout_time')->nullable();
            $table->string('checkout_latitude')->nullable();
            $table->string('checkout_longitude')->nullable();
            $table->string('checkout_photo')->nullable();
            $table->unsignedInteger('checkout_early')->nullable();
            $table->unsignedInteger('working_hour')->nullable();
            $table->string('status');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
