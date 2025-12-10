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

                <!-- Jobs will load here via API -->
                <div class="jobs-grid" id="jobsContainer"></div>
            </section>
        </main>

        <!-- JOB POPUP -->
        <div id="jobPopup" class="popup-overlay">
            <div class="popup-box">
                <button id="closePopup" class="close-btn" onclick="closeJobPopup()">X</button>

                <div class="popup-content">
                    <div class="filter-section">
                        <p><strong>Job type</strong></p>
                        <p id="filterJobType"></p>

                        <br>
                        <p><strong>Salary</strong></p>
                        <p>Min <b id="filterSalaryMin"></b> &nbsp;&nbsp; Max <b id="filterSalaryMax"></b></p>

                        <br>
                        <p><strong>Work Schedule</strong></p>
                        <p id="filterSchedule"></p>
                    </div>

                    <div class="job-details">
                        <img id="popupImage" src="" alt="Job Image" class="popup-img">
                        <h3 id="popupTitle">Job Title</h3>
                        <p id="popupCompany">Company: </p>
                        <p id="popupDate">Date Posted: </p>
                        <p id="popupType">Job Type: </p>
                        <p id="popupSalary">Salary: </p>
                        <p id="popupSchedule">Schedule: </p>
                        <p id="popupLocation">Location: </p>
                        <p id="popupVacancies">Vacancies: </p>

                        <h4>Job Description</h4>
                        <p id="popupDescription">Job Description goes here.</p>

                        <button id="applyBtn" class="apply-btn">APPLICATION FORM</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            /* ============================================
               LOAD JOBS FROM API
               ============================================ */
            function loadJobs(search = "") {
                fetch(`/fetch-user-jobs?search=` + encodeURIComponent(search))
                    .then(response => response.json())
                    .then(data => {
                        const jobsContainer = document.getElementById("jobsContainer");
                        jobsContainer.innerHTML = ""; // clear old jobs

                        if (data.jobs.length === 0) {
                            jobsContainer.innerHTML = "<p>No Job Available</p>";
                            return;
                        }

                        data.jobs.forEach(job => {
                            jobsContainer.innerHTML += `
                                <div class="job-card">
                                    <img src="${job.image ? job.image : '/assets/images/default-job.png'}" alt="image" />
                                    <h4>${job.job_name}</h4>

                                    <button onclick="openJobPopup(
                                        '${job.id}',
                                        '${job.job_name}',
                                        '${job.image ? job.image : 'assets/images/default-job.png'}',
                                        '${new Date(job.created_at).toLocaleDateString()}',
                                        \`${job.job_description.replace(/`/g, "\\`")}\`,
                                        '${job.company_name}',
                                        '${job.job_type}',
                                        '${job.salary_minimum}',
                                        '${job.salary_maximum}',
                                        '${job.schedule_day}',
                                        '${job.schedule_time}',
                                        '${job.location}',
                                        '${job.number_of_vacancies}'
                                    )">View Job</button>
                                </div>
                            `;
                        });
                    });
            }

            // Load jobs when page opens
            document.addEventListener("DOMContentLoaded", () => loadJobs());

            /* SEARCH BAR (API-BASED) */
            document.querySelector(".search-bar").addEventListener("submit", function(e) {
                e.preventDefault();
                const searchValue = this.querySelector("input[name='search']").value;
                loadJobs(searchValue);
            });

            /* ============================================
               POPUP HANDLERS
               ============================================ */
            function openJobPopup(id, title, image, datePosted, description, company, type, salary_minimum, salary_maximum, scheduleDay, scheduleTime, location, vacancies) {

                document.getElementById("popupTitle").innerText = title;
                document.getElementById("popupCompany").innerText = 'Company: ' + company;
                document.getElementById("popupDate").innerText = 'Date Posted: ' + datePosted;
                document.getElementById("popupType").innerText = 'Job Type: ' + type;
                document.getElementById("popupSalary").innerText = 'Salary: ' + salary_minimum + ' - ' + salary_maximum;
                document.getElementById("popupSchedule").innerText = 'Schedule: ' + scheduleDay + ', ' + scheduleTime;
                document.getElementById("popupLocation").innerText = 'Location: ' + location;
                document.getElementById("popupVacancies").innerText = 'Vacancies: ' + vacancies;

                document.getElementById("filterJobType").innerText = type;
                document.getElementById("filterSalaryMin").innerText = salary_minimum;
                document.getElementById("filterSalaryMax").innerText = salary_maximum;
                document.getElementById("filterSchedule").innerText = scheduleDay + ", " + scheduleTime;

                if (image === 'assets/images/default-job.png') {
                    document.getElementById("popupImage").src = "{{ asset('assets/images/default-job.png') }}";
                } else {
                    document.getElementById("popupImage").src = "{{ url('/') }}" + image;

                }

                document.getElementById("popupDescription").innerText = description;

                document.getElementById("applyBtn").setAttribute("onclick", "openApplicationForm(" + id + ")");
                document.getElementById("jobPopup").style.display = "flex";
            }

            function closeJobPopup() {
                document.getElementById("jobPopup").style.display = "none";
            }

            function openApplicationForm(jobId) {
                window.location.href = `/application-form/${jobId}`;
            }
        </script>

    </body>

</html>
