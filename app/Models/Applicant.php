<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'job_id',
        'user_id',
        'full_name',
        'date_of_birth',
        'gender',
        'email',
        'phone_number',
        'home_address',
        'ethnicity',
        'nationality',
        'preferred_pronouns',
        'position',
        'program_name',
        'languages_spoken',
        'resume_path',
        'status',
    ];
}
