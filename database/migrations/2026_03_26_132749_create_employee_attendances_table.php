<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('employee_attendances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');
            $table->string('employee_name');
            $table->string('employee_code');

            $table->string('year');   // 2026
            $table->string('month');  // March

            $table->integer('total_days')->default(0);
            $table->integer('present_days')->default(0);

            $table->integer('sick_leave')->default(0);
            $table->integer('casual_leave')->default(0);
            $table->integer('paid_leave')->default(0);

            $table->integer('absent_days')->default(0);
            $table->integer('payable_days')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_attendances');
    }
};
