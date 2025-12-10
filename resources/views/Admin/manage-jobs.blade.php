<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Job Portal | Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/Admin/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/dashboard.css') }}">
</head>

<body>

@include('Admin.Components.sidebar')

<div class="main-content">
    @include('Admin.Components.header')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>MANAGE JOBS</h5>

        <div>
            <input type="text" id="searchInput" class="form-control d-inline-block me-2"
                   placeholder="Search Job" style="width: 180px;">
            <button class="btn btn-outline-secondary" onclick="fetchJobs()">Search</button>
            <a href="{{ route('viewPostJobs') }}" class="btn btn-primary me-2">Post Job</a>
        </div>
    </div>

    <!-- JOB CARDS -->
    <div class="row g-4" id="jobsContainer">
        <p class="text-muted">Loading jobs...</p>
    </div>
</div>

<!-- ========================================= -->
<!--             EDIT JOB MODAL                -->
<!-- ========================================= -->
<div class="modal fade" id="editJobModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="editJobForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- This will be updated dynamically --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <input type="hidden" id="edit_job_id">

                    <div class="col-md-6">
                        <label class="form-label">Job Name</label>
                        <input type="text" id="edit_job_name" name="job_name" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Company Name</label>
                        <input type="text" id="edit_company_name" name="company_name" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Job Description</label>
                        <textarea id="edit_job_description" name="job_description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Job Type</label>
                        <select id="edit_job_type" name="job_type" class="form-control">
                            <option value="Full-Time">Full-Time</option>
                            <option value="Part-Time">Part-Time</option>
                            <option value="Contract">Contract</option>
                            <option value="Temporary">Temporary</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Salary Min</label>
                        <input type="number" id="edit_salary_minimum" name="salary_minimum" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Salary Max</label>
                        <input type="number" id="edit_salary_maximum" name="salary_maximum" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Schedule Day</label>
                        <input type="text" id="edit_schedule_day" name="schedule_day" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Schedule Time</label>
                        <input type="text" id="edit_schedule_time" name="schedule_time" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select id="edit_status" name="status" class="form-control">
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <input type="text" id="edit_location" name="location" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Vacancies</label>
                        <input type="number" id="edit_number_of_vacancies" name="number_of_vacancies" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Image</label>
                        <input type="file" id="edit_image" name="image" class="form-control">
                        <img id="edit_image_preview" src="" class="img-fluid mt-2 border" style="max-height:120px;">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Update Job</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        fetchJobs();
    });

    function fetchJobs() {
        const search = document.getElementById("searchInput").value;

        fetch(`/fetch-admin-job?search=${search}`)
            .then(res => res.json())
            .then(data => {
                const jobs = data.jobs;
                const container = document.getElementById("jobsContainer");
                container.innerHTML = "";

                if (!jobs || jobs.length === 0) {
                    container.innerHTML = `<p class="text-muted">No jobs found.</p>`;
                    return;
                }

                jobs.forEach(job => {
                    const jobCard = `
                        <div class="col-md-4">
                            <div class="card card-job">
                                <img src="${job.image ? `${job.image}` : '/assets/images/default-job.png'}" class="card-img-top">
                                <div class="card-body">
                                    <h6>${job.job_name}</h6>
                                    <p>Workers Needed: ${job.number_of_vacancies}</p>
                                </div>
                                <div class="p-3">
                                    <button onclick="openEditModal(${job.id})" class="btn btn-primary w-100 mb-2">Edit</button>
                                    <button onclick="deleteJob(${job.id})" class="btn btn-danger w-100">Delete</button>
                                </div>
                            </div>
                        </div>
                    `;
                    container.innerHTML += jobCard;
                });
            })
            .catch(err => console.error(err));
    }

    function openEditModal(id) {
        fetch(`/admin/jobs/get/${id}`)
            .then(res => {
                if (!res.ok) throw new Error('Job not found');
                return res.json();
            })
            .then(job => {
                document.getElementById("edit_job_id").value = job.id;
                document.getElementById("edit_job_name").value = job.job_name;
                document.getElementById("edit_company_name").value = job.company_name;
                document.getElementById("edit_job_description").value = job.job_description;
                document.getElementById("edit_job_type").value = job.job_type;
                document.getElementById("edit_salary_minimum").value = job.salary_minimum;
                document.getElementById("edit_salary_maximum").value = job.salary_maximum;
                document.getElementById("edit_schedule_day").value = job.schedule_day;
                document.getElementById("edit_schedule_time").value = job.schedule_time;
                document.getElementById("edit_status").value = job.status;
                document.getElementById("edit_location").value = job.location;
                document.getElementById("edit_number_of_vacancies").value = job.number_of_vacancies;

                document.getElementById("edit_image_preview").src = job.image ? `${job.image}` : "/assets/images/default-job.png";

                const form = document.getElementById("editJobForm");
                form.action = `/admin/jobs/update/${job.id}`;

                new bootstrap.Modal(document.getElementById("editJobModal")).show();
            })
            .catch(err => alert(err.message));
    }

    function deleteJob(id) {
        if (!confirm("Delete this job?")) return;

        fetch(`/delete-job/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        })
            .then(res => res.json())
            .then(() => fetchJobs())
            .catch(err => alert("Failed to delete job."));
    }

</script>

</body>
</html>
