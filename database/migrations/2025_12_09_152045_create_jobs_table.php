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
        Schema::create('user_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_name');
            $table->text('job_description');
            $table->string('company_name');
            $table->string('job_type');
            $table->decimal('salary_minimum', 12, 2)->nullable();
            $table->decimal('salary_maximum', 12, 2)->nullable();
            $table->string('schedule_day');
            $table->string('schedule_time');
            $table->string('location');
            $table->string('number_of_vacancies');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
