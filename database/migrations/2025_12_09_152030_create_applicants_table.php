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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('full_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();

            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('home_address')->nullable();

            $table->string('ethnicity')->nullable();
            $table->string('nationality')->nullable();
            $table->string('preferred_pronouns')->nullable();

            $table->string('position')->nullable();
            $table->string('program_name')->nullable();
            $table->string('languages_spoken')->nullable();

            $table->string('resume_path')->nullable();

            $table->enum('status', ['approved', 'declined', 'pending'])->default('pending');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
