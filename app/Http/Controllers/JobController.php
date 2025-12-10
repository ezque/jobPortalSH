<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function viewManageJobs()
    {
        return view('Admin.manage-jobs');
    }
    public function viewPostJobs()
    {
        return view('Admin.post-job');
    }
    public function fetchAdminJobs(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $query = Job::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('job_name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $jobs = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'jobs' => $jobs
        ]);
    }
    public function addJob(Request $request)
    {
        $validated = $request->validate([
            'job_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string|max:100',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'schedule_day' => 'required|string|max:50',
            'schedule_time' => 'required|string|max:50',
            'job_description' => 'required|string',
            'number_of_vacancies' => 'required|integer|min:1',
            'job_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:200048',
        ]);

        $imagePath = null;
        if ($request->hasFile('job_image')) {
            $path = $request->file('job_image')->store('jobs', 'public');
            $imagePath = '/storage/' . $path;
        }

        $job = new Job();
        $job->job_name = $validated['job_name'];
        $job->job_description = $validated['job_description'];
        $job->location = $validated['location'];
        $job->company_name = $validated['company_name'];
        $job->job_type = $validated['job_type'];
        $job->salary_minimum = $validated['salary_min'] ?? null;
        $job->salary_maximum = $validated['salary_max'] ?? null;
        $job->schedule_day = $validated['schedule_day'];
        $job->schedule_time = $validated['schedule_time'];
        $job->number_of_vacancies = $validated['number_of_vacancies']; // <-- new
        $job->status = 'active';
        $job->image = $imagePath;
        $job->save();

        return redirect()->route('viewManageJobs')->with('success', 'Job posted successfully!');
    }
    public function getJob($id)
    {
        $job = Job::find($id);
        if (!$job) return response()->json(['error' => 'Job not found'], 404);
        return response()->json($job);
    }

    public function editJob(Request $request, $id)
    {
        // Find the job by ID
        $job = Job::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'job_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary_minimum' => 'nullable|numeric|min:0',
            'salary_maximum' => 'nullable|numeric|min:0',
            'job_description' => 'required|string',
            // If you allow image upload
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update job fields
        $job->job_name = $validated['job_name'];
        $job->company_name = $validated['company_name'];
        $job->location = $validated['location'];
        $job->salary_minimum = $validated['salary_minimum'];
        $job->salary_maximum = $validated['salary_maximum'];
        $job->job_description = $validated['job_description'];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('jobs', 'public');
            $job->image = 'storage/' . $imagePath;
        }

        $job->save();

        return redirect()->back()->with('success', 'Job updated successfully!');
    }

    public function deleteJob(Request $request, $id)
    {
        // Find the job by ID
        $job = Job::find($id);

        if (!$job) {
            return redirect()->back()->with('error', 'Job not found.');
        }

        // Optionally delete the job image from storage
        if ($job->image && file_exists(public_path($job->image))) {
            unlink(public_path($job->image));
        }

        // Delete the job
        $job->delete();

        return redirect()->back()->with('success', 'Job deleted successfully.');
    }

}
