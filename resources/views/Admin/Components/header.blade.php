<!-- Header -->
<div class="top-bar"
     style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h1>Welcome to the Admin Dashboard</h1>

    <!-- Profile Dropdown -->
    <div class="profile-dropdown">
        <div class="edge-profile-box profile-toggle">
            <img src="{{ asset('assets/images/494356517_720172503782781_666955056287399904_n.jpg') }}"
                 alt="Admin Profile" />
            <div class="profile-info" style="margin-left:10px; text-align:right;">
                <h4>Admin</h4>
                <p>Administrator</p>
            </div>
        </div>

        <!-- Dropdown -->
        <div class="dropdown-menu">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>
</div>
