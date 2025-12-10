<div class="sidebar">
    <div class="logo-section">
        <img src="{{ asset('assets/images/Department_of_Labor_and_Employment_(DOLE).svg') }}" alt="Logo"
             class="dashboard-logo" />
        <div class="portal-title">JOB PORTAL</div>
        <h4>ADMIN DASHBOARD</h4>
    </div>

    <!-- Navigation Links -->
    <a href="{{ route('viewAdminDashboard') }}" class="nav-link {{ Request::is('admin-dashboard*') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('viewManageJobs') }}" class="nav-link {{ Request::is('view-manage-job*') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i>
        <span>Manage Jobs</span>
    </a>

    <a href="{{ route('viewManageApplicants') }}" class="nav-link {{ Request::is('view-manage-applicant*') ? 'active' : '' }}">
        <i class="fas fa-users"></i>
        <span>Manage Applicants</span>
    </a>

    <a href="{{ route('viewManageUsers') }}" class="nav-link {{ Request::is('manage-user*') ? 'active' : '' }}">
        <i class="fas fa-user-cog"></i>
        <span>Manage Users</span>
    </a>

    <a href="{{ route('viewAdminNotification') }}" class="nav-link {{ Request::is('view-admin-notification*') ? 'active' : '' }}">
        <i class="fas fa-bell"></i>
        <span>Notification</span>
    </a>
</div>

<script>
    // Profile dropdown toggle
    document.addEventListener("click", function(e) {
        const dropdown = document.querySelector(".profile-dropdown");
        if (dropdown && dropdown.contains(e.target)) {
            dropdown.classList.toggle("active");
        } else if (dropdown) {
            dropdown.classList.remove("active");
        }
    });
</script>
