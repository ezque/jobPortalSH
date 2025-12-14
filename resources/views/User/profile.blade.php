<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>

    <link rel="stylesheet" href="{{ asset('assets/css/User/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/User/header.css') }}">
</head>
<body>
    @include('User.Components.header')
    <div class="profile-container">

        <!-- Back Button -->
        <a href="{{ route('viewUserDashboard') }}" class="backButton">
            ← Back to Dashboard
        </a>

        <h2>My Profile</h2>

        <!-- ================= DISPLAY MODE ================= -->
        <div id="displayMode">

            <div class="profile-image-wrapper">
                <img id="dProfileImage"
                     src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : asset('assets/images/default-profile.png') }}"
                     alt="Profile Image">
            </div>

            <div class="info-group">
                <label>Name</label>
                <span id="dName">{{ auth()->user()->name }}</span>
            </div>

            <div class="info-group">
                <label>Email</label>
                <span>{{ auth()->user()->email }}</span>
            </div>

            <div class="info-group">
                <label>Contact Number</label>
                <span id="dContact">{{ auth()->user()->contact_number }}</span>
            </div>

            <div class="info-group">
                <label>Age</label>
                <span id="dAge">{{ auth()->user()->age }}</span>
            </div>

            <div class="info-group">
                <label>Address</label>
                <span id="dAddress">{{ auth()->user()->address }}</span>
            </div>

            <div class="info-group">
                <label>About</label>
                <span id="dAbout">{{ auth()->user()->about }}</span>
            </div>

            <div class="button-row">
                <button class="btn btn-edit" onclick="enableEdit()">Edit Profile</button>
                <button class="btn btn-password" onclick="togglePassword()">Change Password</button>
            </div>
        </div>

        <!-- ================= EDIT MODE ================= -->
        <div id="editMode" style="display: none;">
            <form id="updateForm" enctype="multipart/form-data">
                @csrf

                <div class="profile-image-wrapper">
                    <img id="previewProfileImage"
                         src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : asset('assets/images/default-profile.png') }}">
                    <input type="file" name="profile_image" accept="image/*" onchange="previewImage(event)">
                </div>

                <div class="info-group">
                    <label>Name</label>
                    <input type="text" name="name" class="edit-input" value="{{ auth()->user()->name }}">
                </div>

                <div class="info-group">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" class="edit-input" value="{{ auth()->user()->contact_number }}">
                </div>

                <div class="info-group">
                    <label>Age</label>
                    <input type="number" name="age" class="edit-input" value="{{ auth()->user()->age }}">
                </div>

                <div class="info-group">
                    <label>Address</label>
                    <input type="text" name="address" class="edit-input" value="{{ auth()->user()->address }}">
                </div>

                <div class="info-group">
                    <label>About</label>
                    <textarea name="about" class="edit-input" rows="3">{{ auth()->user()->about }}</textarea>
                </div>

                <div class="button-row">
                    <button type="button" class="btn btn-save" onclick="saveProfile()">Save</button>
                    <button type="button" class="btn btn-cancel" onclick="cancelEdit()">Cancel</button>
                </div>
            </form>
        </div>

        <!-- ================= CHANGE PASSWORD ================= -->
        <div id="passwordMode" style="display:none;">
            <h3>Change Password</h3>

            <form id="passwordForm">
                @csrf

                <div class="info-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="edit-input">
                </div>

                <div class="info-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="edit-input">
                </div>

                <div class="info-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="edit-input">
                </div>

                <div class="button-row">
                    <button type="button" class="btn btn-save" onclick="changePassword()">Update Password</button>
                    <button type="button" class="btn btn-cancel" onclick="togglePassword()">Cancel</button>
                </div>
            </form>
        </div>

    </div>

    <script>
        function enableEdit() {
            displayMode.style.display = "none";
            editMode.style.display = "block";
            passwordMode.style.display = "none";
        }

        function cancelEdit() {
            editMode.style.display = "none";
            displayMode.style.display = "block";
        }

        function togglePassword() {
            displayMode.style.display = "none";
            editMode.style.display = "none";
            passwordMode.style.display =
                passwordMode.style.display === "block" ? "none" : "block";
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = () => previewProfileImage.src = reader.result;
            reader.readAsDataURL(event.target.files[0]);
        }

        function saveProfile() {
            let formData = new FormData(updateForm);

            fetch("{{ route('updateProfile') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) location.reload();
                });
        }

        function changePassword() {
            let formData = new FormData(passwordForm);

            fetch("{{ route('changePassword') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) throw data;
                    return data;
                })
                .then(data => {
                    alert(data.message);
                    if (data.success) location.reload();
                })
                .catch(err => {
                    alert(err.message || 'Something went wrong.');
                });
        }

    </script>

</body>
</html>
