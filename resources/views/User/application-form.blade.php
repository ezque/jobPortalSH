<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form | Job Portal</title>
    <link rel="stylesheet" href="{{ asset('assets/css/User/application.css') }}">
</head>
<body>

<div class="page-container">

    <header>
        <img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="image">
    </header>

    <h2 class="form-title">Application Form for {{ $job->job_name }}</h2>

    <form class="form-box" action="{{ route('submitApplicationForm', $job->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="date" name="date_of_birth" required>
        </div>

        <div class="row">
            <select name="gender" required>
                <option value="" disabled selected>Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="phone_number" placeholder="Phone Number" required>
        </div>

        <textarea name="home_address" placeholder="Home Address" required></textarea>

        <div class="row">
            <input type="text" name="ethnicity" placeholder="Ethnicity">
            <input type="text" name="nationality" placeholder="Nationality">
            <input type="text" name="preferred_pronouns" placeholder="Preferred Pronouns">
        </div>

        <div class="row">
            <input type="text" name="position" placeholder="Position Applying For" value="{{ $job->job_name }}" readonly>
            <input type="text" name="program_name" placeholder="Program Name">
            <input type="text" name="languages_spoken" placeholder="Languages Spoken">
        </div>

        <input
            type="file"
            name="resume"
            class="file-input"
            accept=".pdf,.doc,.docx"
        >


        <div class="btn-area">
            <button type="button" class="cancel-btn" onclick="history.back()">Cancel</button>
            <button type="submit" class="apply-btn">Apply Job</button>
        </div>

    </form>

</div>

@if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif

</body>

</html>
