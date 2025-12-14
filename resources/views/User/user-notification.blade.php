<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Job Portal Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/User/notification.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/User/header.css') }}">
</head>
<body>
@include('User.Components.header')
<div class="page-frame">



    <div class="dashboard">

        <main class="main-content">
            <a href="{{ route('viewUserDashboard') }}" class="backButton">
                ← Back to Dashboard
            </a>

            <h3>Welcome back!!</h3>
            <p class="subtitle">Here’s what’s happening with your job today.</p>

            @forelse($notifications as $notification)
                <div class="notification-card" >
                    <div class="notification-text">
                        <strong>DOLE</strong> — {{ $notification->message }}
                    </div>

                </div>
            @empty
                <p>No Notification</p>
            @endforelse

        </main>
    </div>
</div>

<script src="js/notification.js"></script>
</body>
</html>
