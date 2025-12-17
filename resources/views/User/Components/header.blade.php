<div class="top-logo">
    <div class="logo-container">
        <img src="{{ asset('assets/images/logo.png') }}" class="top-logo-img" alt="Logo">
        <span class="logo-text">JOB PORTAL</span>
    </div>

    <div class="right-header">
        <a href="{{ route('viewUserNotification') }}" class="notification">
            <span class="notif-icon">&#128276;</span>
            <span class="notif-count" id="notifCount" style="display:none;">0</span>
        </a>



        <div class="profile-dropdown" onclick="toggleDropdown()">
            <div class="profile">
                <img
                    src="{{ auth()->user()->profile_image
                        ? asset(auth()->user()->profile_image)
                        : asset('assets/images/logo.png') }}"
                    alt="Profile Image"
                >
                <span>
                    {{ auth()->user()->name }} <br>
                    <small>{{ auth()->user()->role ?? 'User' }}</small>
                </span>
                <i class="arrow">&#9662;</i>
            </div>
            <div class="dropdown-menu" id="profileMenu">
                <a href="{{ route('viewUserProfile') }}">View Profile</a>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                    @csrf
                    <button type="submit" style="
                        width: 100%;
                        text-align: left;
                        padding: 12px 18px;
                        border: none;
                        background: none;
                        cursor: pointer;
                        font-size: 15px;
                        color: #333;
                    ">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleDropdown() {
        document.getElementById('profileMenu').classList.toggle('show');
    }

    window.addEventListener("click", function(e) {
        if (!e.target.closest('.profile-dropdown')) {
            const menu = document.getElementById('profileMenu');
            if (menu.classList.contains('show')) {
                menu.classList.remove('show');
            }
        }
    });
    function loadUnreadNotifications() {
        fetch("{{ route('notificationCountUnread') }}")
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notifCount');
                if (data.count > 0) {
                    badge.innerText = data.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            });
    }

    // Load on page open
    loadUnreadNotifications();

    // Optional: refresh every 30 seconds
    setInterval(loadUnreadNotifications, 30000);
</script>

