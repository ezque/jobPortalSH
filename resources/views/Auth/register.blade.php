<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register | Job Portal</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/Auth/register.css') }}">
</head>
<body>
<div class="register-container">
    <div class="form-box animate__animated animate__fadeInUp">

        <img src="{{ asset('assets/images/logo.png') }}" alt="Job Portal Logo" class="logo">

        <h2>Register</h2>

        <form id="registerForm" method="POST" action="{{ route('register') }}">
            @csrf

            <input name="name" type="text" placeholder="Full Name" required>
            <input name="contact_number" type="text" placeholder="Phone Number" required>
            <input name="email" type="email" placeholder="Email" required>

            <!-- Password -->
            <div class="password-field">
                <input name="password" type="password" placeholder="Password" id="password" required>
                <span class="toggle-password" data-target="password">👁️</span>
            </div>

            <!-- Confirm Password -->
            <div class="password-field">
                <input name="password_confirmation" type="password" placeholder="Confirm Password" id="confirm_password" required>
                <span class="toggle-password" data-target="confirm_password">👁️</span>
            </div>

            <button type="submit">Register</button>
        </form>

        <p class="login-text">
            Already have an account?
            <a href="{{ url('/login') }}">Login here</a>
        </p>
    </div>
</div>

<!-- SHOW / HIDE PASSWORD SCRIPT -->
<script>
    document.querySelectorAll(".toggle-password").forEach(toggle => {
        toggle.addEventListener("click", function () {
            let inputId = this.getAttribute("data-target");
            let input = document.getElementById(inputId);

            if (input.type === "password") {
                input.type = "text";
                this.textContent = "🙈";
            } else {
                input.type = "password";
                this.textContent = "👁️";
            }
        });
    });
</script>
</body>
</html>
