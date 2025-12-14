<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Job;
class UserController extends Controller
{
    public function viewUserDashboard()
    {
        if (!auth()->check()) {
            return redirect()->route('viewLogin')->withErrors([
                'auth' => 'You must be logged in to access the dashboard.'
            ]);
        }

        return view('User.dashboard');
    }
    public function viewUserProfile()
    {
        if (!auth()->check()) {
            return redirect()->route('viewLogin')->withErrors([
                'auth' => 'You must be logged in to access the dashboard.'
            ]);
        }

        return view('User.profile');
    }
    public function adminManageUsers()
    {
        if (!auth()->check()) {
            return redirect()->route('viewLogin')->withErrors([
                'auth' => 'You must be logged in to access the dashboard.'
            ]);
        }
        $allUsers = User::where('role', 'user')->get();
        return view('Admin.manage-user', compact('allUsers'));
    }

    public function fetchJobs(Request $request)
    {
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
    public function updateUserStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Toggle status
        $user->status = $user->status === 'active' ? 'blocked' : 'active';
        $user->save();

        return redirect()->back()->with('success', "User status updated successfully.");
    }
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $data = $request->only(['name', 'contact_number', 'age', 'address', 'about']);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/profile_images'), $imageName);
            $data['profile_image'] = 'uploads/profile_images/'.$imageName;
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'profile_image' => isset($data['profile_image']) ? asset($data['profile_image']) : null
        ]);
    }
    public function getUserInfo()
    {
        $user = auth()->user();
        return response()->json([
            'user' => $user
        ]);
    }

}
