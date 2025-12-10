<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Applicants | Job Portal</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Admin/dashboard.css') }}">
</head>
<body>
@include('Admin.Components.sidebar')

<div class="main-content p-4">
    @include('Admin.Components.header')
    <h2 class="mb-4">Manage Applicants</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="applicantsTable">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($applicants as $applicant)
                <tr>
                    <td>{{ $applicant->id }}</td>
                    <td>{{ $applicant->full_name }}</td>
                    <td>{{ $applicant->email }}</td>
                    <td>
                        @if($applicant->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($applicant->status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-secondary">Pending</span>
                        @endif
                    </td>
                    <td>
                        <!-- View Button -->
                        <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#viewApplicantModal"
                                onclick='populateApplicantModal(@json($applicant))'>View</button>

                        @if($applicant->status === 'pending')
                            <!-- Approve Form -->
                            <form action="{{ route('approveApplicant', $applicant->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success me-1">Approve</button>
                            </form>

                            <!-- Reject Form -->
                            <form action="{{ route('rejectApplicant', $applicant->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No applicants found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- VIEW APPLICANT MODAL -->
<div class="modal fade" id="viewApplicantModal" tabindex="-1" aria-labelledby="viewApplicantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Applicant Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th>ID</th><td id="modalApplicantID"></td></tr>
                    <tr><th>Full Name</th><td id="modalApplicantName"></td></tr>
                    <tr><th>Email</th><td id="modalApplicantEmail"></td></tr>
                    <tr><th>Phone Number</th><td id="modalApplicantPhone"></td></tr>
                    <tr><th>Gender</th><td id="modalApplicantGender"></td></tr>
                    <tr><th>Date of Birth</th><td id="modalApplicantDOB"></td></tr>
                    <tr><th>Home Address</th><td id="modalApplicantAddress"></td></tr>
                    <tr><th>Position</th><td id="modalApplicantPosition"></td></tr>
                    <tr><th>Status</th><td id="modalApplicantStatus"></td></tr>
                    <tr><th>Resume</th><td><a id="modalApplicantResume" href="#" target="_blank">View Resume</a></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function populateApplicantModal(applicant) {
        document.getElementById('modalApplicantID').innerText = applicant.id;
        document.getElementById('modalApplicantName').innerText = applicant.full_name;
        document.getElementById('modalApplicantEmail').innerText = applicant.email;
        document.getElementById('modalApplicantPhone').innerText = applicant.phone_number;
        document.getElementById('modalApplicantGender').innerText = applicant.gender;
        document.getElementById('modalApplicantDOB').innerText = applicant.date_of_birth;
        document.getElementById('modalApplicantAddress').innerText = applicant.home_address;
        document.getElementById('modalApplicantPosition').innerText = applicant.position;
        document.getElementById('modalApplicantStatus').innerHTML = getStatusBadge(applicant.status);

        if(applicant.resume_path) {
            document.getElementById('modalApplicantResume').href = "{{ url('/') }}/" + applicant.resume_path;
            document.getElementById('modalApplicantResume').style.display = 'inline';
        } else {
            document.getElementById('modalApplicantResume').style.display = 'none';
        }
    }

    function getStatusBadge(status) {
        switch(status) {
            case 'approved': return '<span class="badge bg-success">Approved</span>';
            case 'rejected': return '<span class="badge bg-danger">Rejected</span>';
            default: return '<span class="badge bg-secondary">Pending</span>';
        }
    }
</script>

</body>
</html>
