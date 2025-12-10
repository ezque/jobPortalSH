<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Job Portal</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/Auth/login.css') }}">
</head>

<body>
<div class="login-container">
    <div class="login-box animate__animated animate__fadeInUp">

        <img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="img">

        <h2>Login</h2>

        @if(session('success'))
            <p class="success-message">{{ session('success') }}</p>
        @endif

        <!-- GENERAL LOGIN ERROR -->
        @if($errors->has('login_error'))
            <p class="error-message">{{ $errors->first('login_error') }}</p>
        @endif

        <!-- LOGIN FORM -->
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
            @error('email')
            <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="password-field">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-password" data-target="password">👁️</span>
            </div>
            @error('password')
            <p class="error-message">{{ $message }}</p>
            @enderror


            <button type="submit">Login</button>
        </form>

        <p class="register-text">
            Don’t have an Account? <a href="{{ route('register') }}">Register here</a>
        </p>
    </div>
</div>

<!-- SHOW / HIDE PASSWORD SCRIPT -->
<script>
    document.querySelectorAll(".toggle-password").forEach(toggle => {
        toggle.addEventListener("click", function () {
            let target = this.getAttribute("data-target");
            let input = document.getElementById(target);
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
