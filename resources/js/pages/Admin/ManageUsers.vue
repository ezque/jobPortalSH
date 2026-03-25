<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/manage-user.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/header.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>
<!-- SIDEBAR -->
@include('Admin.Components.sidebar')

<!-- MAIN CONTENT -->
<main class="main-content">
    @include('Admin.Components.header')


    <div class="user-list">
        @forelse($allUsers as $user)
            <div class="user-card">
                <div class="user-info">
                    <img src="{{ $user->image ? asset($user->image) : asset('assets/images/DSCF7140.JPG') }}" alt="{{ $user->name }}"  class="user-avatar">
                    <div>
                        <strong class="user-name">{{ $user->name  }}</strong>
                        <p class="user-email">{{ $user->email }} • {{$user->contact_number }}</p>
                    </div>
                </div>
                <span class="status active">{{ $user->status }}</span>
                <p class="date">{{ $user->created_at->format('M-d-Y') }}</p>
                <div class="actions">
                    <form action="{{ route('updateUserStatus', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @if($user->status === 'active')
                            <button type="submit" class="block-btn">Block</button>
                        @else
                            <button type="submit" class="unblock-btn">Unblock</button>
                        @endif
                    </form>
                </div>


            </div>
        @empty
            <p class="text-muted">No jobs found.</p>
        @endforelse
    </div>
</main>
</body>

</html>
