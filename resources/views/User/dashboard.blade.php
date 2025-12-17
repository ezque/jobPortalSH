<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Job Portal Dashboard</title>

    <link rel="stylesheet" href="{{ asset('assets/css/User/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/User/header.css') }}">
</head>
<body>

@include('User.Components.header')

<!-- MAIN CONTENT -->
<main>
    <section class="jobs-section">
        <div class="jobs-header">
            <h3>Available Jobs</h3>

            <!-- Search Bar -->
            <form class="search-bar">
                <input type="text" name="search" placeholder="Search Job">
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Jobs Container -->
        <div class="jobs-grid" id="jobsContainer"></div>
    </section>
</main>

<!-- JOB POPUP -->
<div id="jobPopup" class="popup-overlay">
    <div class="popup-box">
        <button class="close-btn" onclick="closeJobPopup()">X</button>

        <div class="popup-content">
            <div class="filter-section">
                <p><strong>Job Type</strong></p>
                <p id="filterJobType"></p>

                <br>
                <p><strong>Salary</strong></p>
                <p>Min <b id="filterSalaryMin"></b> — Max <b id="filterSalaryMax"></b></p>

                <br>
                <p><strong>Work Schedule</strong></p>
                <p id="filterSchedule"></p>
            </div>

            <div class="job-details">
                <img id="popupImage" class="popup-img" alt="Job Image">

                <h3 id="popupTitle"></h3>
                <p id="popupCompany"></p>
                <p id="popupDate"></p>
                <p id="popupType"></p>
                <p id="popupSalary"></p>
                <p id="popupSchedule"></p>
                <p id="popupLocation"></p>
                <p id="popupVacancies"></p>

                <h4>Job Description</h4>
                <p id="popupDescription"></p>

                <button id="applyBtn" class="apply-btn">APPLICATION FORM</button>
            </div>
        </div>
    </div>
</div>

<script>
    /* =========================================
       LOAD JOBS FROM API
    ========================================= */
    function loadJobs(search = "") {
        fetch(`/fetch-user-jobs?search=` + encodeURIComponent(search))
            .then(res => res.json())
            .then(data => {
                const container = document.getElementById("jobsContainer");
                container.innerHTML = "";

                if (data.jobs.length === 0) {
                    container.innerHTML = "<p>No Job Available</p>";
                    return;
                }

                data.jobs.forEach(job => {
                    container.innerHTML += `
                    <div class="job-card">
                        <img src="${job.image ? job.image : '/assets/images/default-job.png'}">
                        <h4>${job.job_name}</h4>

                        <button class="view-job-btn"
                            data-job='${JSON.stringify(job).replace(/'/g, "&apos;")}'>
                            View Job
                        </button>
                    </div>
                `;
                });
            });
    }

    document.addEventListener("DOMContentLoaded", () => loadJobs());

    /* SEARCH */
    document.querySelector(".search-bar").addEventListener("submit", function(e) {
        e.preventDefault();
        loadJobs(this.search.value);
    });

    /* =========================================
       VIEW JOB BUTTON HANDLER
    ========================================= */
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("view-job-btn")) {
            const job = JSON.parse(e.target.dataset.job);
            openJobPopup(job);
        }
    });

    /* =========================================
       POPUP FUNCTIONS
    ========================================= */
    function openJobPopup(job) {

        document.getElementById("popupTitle").innerText = job.job_name;
        document.getElementById("popupCompany").innerText = "Company: " + job.company_name;
        document.getElementById("popupDate").innerText =
            "Date Posted: " + new Date(job.created_at).toLocaleDateString();
        document.getElementById("popupType").innerText = "Job Type: " + job.job_type;
        document.getElementById("popupSalary").innerText =
            "Salary: " + job.salary_minimum + " - " + job.salary_maximum;
        document.getElementById("popupSchedule").innerText =
            "Schedule: " + job.schedule_day + ", " + job.schedule_time;
        document.getElementById("popupLocation").innerText =
            "Location: " + job.location;
        document.getElementById("popupVacancies").innerText =
            "Vacancies: " + job.number_of_vacancies;

        document.getElementById("filterJobType").innerText = job.job_type;
        document.getElementById("filterSalaryMin").innerText = job.salary_minimum;
        document.getElementById("filterSalaryMax").innerText = job.salary_maximum;
        document.getElementById("filterSchedule").innerText =
            job.schedule_day + ", " + job.schedule_time;

        document.getElementById("popupImage").src = job.image
            ? "{{ url('/') }}" + job.image
            : "{{ asset('assets/images/default-job.png') }}";

        document.getElementById("popupDescription").innerText = job.job_description;

        document.getElementById("applyBtn").onclick = () => {
            window.location.href = `/application-form/${job.id}`;
        };

        document.getElementById("jobPopup").style.display = "flex";
    }

    function closeJobPopup() {
        document.getElementById("jobPopup").style.display = "none";
    }
</script>
@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif
@if(session('error'))
    <script>alert("{{ session('error') }}");</script>
@endif
</body>
</html>
