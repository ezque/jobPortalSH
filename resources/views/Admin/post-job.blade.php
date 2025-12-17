<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal Admin Dashboard - Post Jobs</title>

    <!-- Sidebar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/post-job.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/header.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

</head>

<body>
    @include('Admin.Components.sidebar')
<!-- Main Content -->
<main class="main-content">

    @include('Admin.Components.header')

    <!-- Post Job Form -->
    <div class="content">
        <div class="form-card">
            <h2>Post Job</h2>

            <form class="job-form" method="POST" action="{{ route('postJobs') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-section">Job Details</div>
                <div class="form-row">
                    <input type="text" name="job_name" class="form-input" placeholder="Job Title" required>
                    <input type="text" name="company_name" class="form-input" placeholder="Company Name" required>
                </div>

                <div class="form-row">
                    <input type="text" name="location" class="form-input" placeholder="Location" required>
                    <input type="text" name="job_type" class="form-input" placeholder="Employment Type" required>
                </div>

                <div class="form-row">
                    <input type="number" name="salary_min" class="form-input" placeholder="Salary Min" required>
                    <input type="number" name="salary_max" class="form-input" placeholder="Salary Max" required>
                </div>

                <div class="form-row">
                    <input type="text" name="schedule_day" class="form-input" placeholder="Schedule Day" required>
                    <input type="text" name="schedule_time" class="form-input" placeholder="Schedule Time" required>
                </div>
                <div class="form-row">
                    <input type="number" name="number_of_vacancies" class="form-input" placeholder="Number of Vacancies" required>
                </div>

                <div class="form-row">
                    <textarea name="job_description" class="form-input" placeholder="Job Description" required></textarea>
                    <input type="file" name="job_image" class="form-input">
                </div>

                <div class="form-actions">
                    <button type="submit">Post Job</button>
                </div>

            </form>
        </div>
    </div>

</main>

<script>
    lucide.replace();
</script>
<script src="https://unpkg.com/lucide@latest"></script>
</body>

</html>
