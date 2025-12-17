<!DOCTYPE html>
<html lang="en">
meta charset="UTF-8" />
<head>
    <
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Job Portal Admin Dashboard</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/sidebar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/header.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

    <body>
        <!-- Sidebar -->
        <div class="sidebar-container">
            @include('Admin.Components.sidebar')
        </div>



    <!-- Main Content -->
    <div class="main-content">

        @include('Admin.Components.header')

        <!-- Statistic Boxes -->
        <div class="stat-container">

            <div class="stat-box stat-jobs">
                <h4>Jobs Posted</h4>
                <p class="stat-number" id="jobsCount">0</p>
            </div>

            <div class="stat-box stat-applicants">
                <h4>Applicants</h4>
                <p class="stat-number" id="applicantsCount">0</p>
            </div>

            <div class="stat-box stat-users">
                <h4>Users</h4>
                <p class="stat-number" id="usersCount">0</p>
            </div>

            <div class="stat-box stat-notifications">
                <h4>Notifications</h4>
                <p class="stat-number" id="notificationsCount">0</p>
            </div>

        </div>

        <!-- Chart Section -->
        <div class="chart-box" style="background:#fff; border-radius:20px;">
            <h2>Job Portal Monthly Analytics</h2>
            <canvas id="jobChart"></canvas>
        </div>

    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let chartInstance = null;

        async function loadDashboardData() {
            try {
                const response = await fetch("/fetch-dashboard-data", {
                    headers: { "Accept": "application/json" }
                });

                if (!response.ok) {
                    console.error("API Error:", response.status);
                    return;
                }

                const data = await response.json();

                // Update Stat Boxes
                document.getElementById("jobsCount").textContent = data.jobsCount;
                document.getElementById("applicantsCount").textContent = data.applicantsCount;
                document.getElementById("usersCount").textContent = data.usersCount;
                document.getElementById("notificationsCount").textContent = data.notificationsCount;

                // Render Chart
                renderChart(data.jobsCount, data.applicantsCount, data.usersCount);

            } catch (error) {
                console.error("Error fetching dashboard data:", error);
            }
        }

        function renderChart(jobs, applicants, users) {
            const ctx = document.getElementById('jobChart').getContext('2d');

            if (chartInstance) {
                chartInstance.destroy(); // Avoid duplicate charts
            }

            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Current Stats'],
                    datasets: [
                        { label: 'Jobs Posted', data: [jobs], backgroundColor: '#0d47a1' },
                        { label: 'Applicants', data: [applicants], backgroundColor: '#ffcc00' },
                        { label: 'Users', data: [users], backgroundColor: '#1565c0' }
                    ]
                },
                options: { responsive: true }
            });
        }

        // Load data on page load
        loadDashboardData();
    </script>

    <!-- Profile Dropdown Logic -->


    </body>
</html>
