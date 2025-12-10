<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal Admin Dashboard - Notifications</title>
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/notification.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/sidebar.css') }}">
    <!-- Optional icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body>

<!-- Sidebar -->
@include('Admin.Components.sidebar')

<!-- Main Content -->
<main class="main-content">

    @include('Admin.Components.header')

    <!-- Page Content -->
    <div class="content">

        <!-- Empty State -->
        @if($notifications->isEmpty())
            <div class="empty-state">
                <img src="{{ asset('assets/images/empty.png') }}" alt="No Notifications">
                <h3>No Notifications Yet</h3>
                <p>You're all caught up! We'll notify you when something new happens.</p>
            </div>
        @else

            <div class="notif-list">
                @foreach($notifications as $note)
                    <div class="notif-card-single {{ $note->is_read ? '' : 'notif-unread' }}">
                        <div class="notif-icon">
                            <i class="fa-solid fa-bell"></i>
                        </div>

                        <div class="notif-info">
                            <h3>{{ $note->title }}</h3>
                            <p class="notif-message">{{ $note->message }}</p>
                            <span class="notif-time">{{ $note->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="notif-actions">
                            <form action="{{ route('markAsRead', $note->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="mark-read">Mark as read</button>
                            </form>

                            <form action="{{ route('deleteNotification', $note->id) }}" method="POST" onsubmit="return confirm('Delete this notification?')">
                                @csrf
                                @method('DELETE')
                                <button class="delete">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        @endif

    </div>

</main>

<script>
    // Initialize Lucide icons
    lucide.replace();
</script>

</body>

</html>
