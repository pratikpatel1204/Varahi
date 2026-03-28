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
        Schema::create('salary_loan_deductions', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('loan_id');

            // Period (IMPORTANT → storing NAME not ID)
            $table->integer('year');      // e.g. 2026
            $table->string('month');      // e.g. March

            // Deduction
            $table->decimal('deduction_amount', 10, 2)->default(0);

            $table->timestamps();

            // Optional Index (Recommended 🚀)
            $table->unique(['employee_id', 'loan_id', 'year', 'month'], 'loan_unique');

            // Optional Foreign Keys
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('loan_id')->references('id')->on('loan_managements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_loan_deductions');
    }
};
