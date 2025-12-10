<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\Applicant;
use App\Models\Notification;

class AdminController extends Controller
{
    public function viewAdminDashboard()
    {
        return view('Admin.dashboard');
    }
    public function fetchDashboardData()
    {
        $userId = auth()->id();

        return response()->json([
            'jobsCount' => Job::count(),
            'applicantsCount' => Applicant::count(),
            'usersCount' => User::where('role', 'user')->count(),
            'notificationsCount' => Notification::where('receiver_id', $userId)->count(),
        ]);
    }

}
