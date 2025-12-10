<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    public function viewManageApplicants()
    {
        $applicants = Applicant::all(); // fetch all applicants
        return view('Admin.manage-applicants', compact('applicants'));
    }
    public function viewApplicationForm($id)
    {
        $job = Job::findOrFail($id);
        return view('User.application-form', compact('job'));
    }

    public function submitApplicationForm(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'home_address' => 'required|string',
            'ethnicity' => 'nullable|string',
            'nationality' => 'nullable|string',
            'preferred_pronouns' => 'nullable|string',
            'position' => 'required|string',
            'program_name' => 'nullable|string',
            'languages_spoken' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:200048',
        ]);

        $resumePath = null;

        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $resumePath = 'storage/' . $path;
        }

        // Create applicant
        Applicant::create([
            'job_id' => $id,
            'user_id' => auth()->id(),
            'full_name' => $request->full_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'home_address' => $request->home_address,
            'ethnicity' => $request->ethnicity,
            'nationality' => $request->nationality,
            'preferred_pronouns' => $request->preferred_pronouns,
            'position' => $request->position,
            'program_name' => $request->program_name,
            'languages_spoken' => $request->languages_spoken,
            'resume_path' => $resumePath,
            'status' => 'pending',
        ]);

        // ---- CREATE NOTIFICATION HERE ----
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            Notification::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $admin->id,
                'type' => 'application_submitted',
                'status' => 'unread',
                'message' => auth()->user()->name . ' submitted an application.',
            ]);
        }

        return redirect()->back()->with('success', 'Application Submitted Successfully!');
    }
    public function approveApplicant($id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->status = 'approved';
        $applicant->save();

        Notification::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $applicant->user_id ?? null,
            'type' => 'application_status',
            'status' => 'unread',
            'message' => "Your application for the position {$applicant->position} has been approved."
        ]);

        return redirect()->back()->with('success', 'Applicant approved and notified.');
    }

    public function rejectApplicant($id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->status = 'rejected';
        $applicant->save();

        Notification::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $applicant->user_id ?? null,
            'type' => 'application_status',
            'status' => 'unread',
            'message' => "Your application for the position {$applicant->position} has been rejected."
        ]);

        return redirect()->back()->with('success', 'Applicant rejected and notified.');
    }


}
