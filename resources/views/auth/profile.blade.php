<!DOCTYPE html>
<html>
<head>
    <title>User Profile - Bookstore</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 20px;
            color: #333;
        }

        .profile-container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .navbar .brand a {
            color: #2980b9;
            font-weight: 600;
            text-decoration: none;
            font-size: 20px;
        }

        .navbar .nav-buttons a {
            text-decoration: none;
            color: #fff;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            margin-left: 10px;
            transition: background 0.3s ease;
        }

        .navbar .nav-buttons a.dashboard {
            background-color: #3498db;
        }

        .navbar .nav-buttons a.dashboard:hover {
            background-color: #2980b9;
        }

        .navbar .nav-buttons a.logout {
            background-color: #e74c3c;
        }

        .navbar .nav-buttons a.logout:hover {
            background-color: #c0392b;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #34495e;
            font-size: 28px;
        }

        .profile-picture-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 15px;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #3498db;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-picture:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(52,152,219,0.6);
        }

        .upload-btn-wrapper {
            text-align: center;
            margin-top: 10px;
        }

        .upload-btn-wrapper input[type=file] {
            display: none;
        }

        .upload-btn-wrapper button {
            background-color: #2980b9;
            color: #fff;
            padding: 8px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .upload-btn-wrapper button:hover {
            background-color: #3498db;
        }

        form {
            margin-top: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            transition: border 0.3s ease;
        }

        .form-group input:focus {
            border-color: #3498db;
            outline: none;
        }

        button.submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        button.submit-btn:hover {
            background-color: #2ecc71;
        }

        .success-message {
            text-align: center;
            color: #27ae60;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .activity {
            margin-top: 35px;
        }

        .activity h3 {
            margin-bottom: 15px;
            font-size: 20px;
            color: #34495e;
        }

        .activity ul {
            list-style: none;
            padding: 0;
        }

        .activity ul li {
            background: #ecf0f1;
            padding: 12px 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="profile-container">

    <!-- Navigation bar inside the card -->
    <div class="navbar">
        <div class="brand"><a href="{{ url('/books') }}">📚 Bookstore</a></div>
        <div class="nav-buttons">
            @if(Route::has('dashboard'))
                <a href="{{ route('dashboard') }}" class="dashboard"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
            @endif
            <a href="{{ route('logout') }}" class="logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <h2>My Profile</h2>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <div class="profile-picture-wrapper">
        <img id="profilePreview"
             src="{{ $user->profile_image ? asset('images/profiles/' . $user->profile_image) : asset('images/avatar.png') }}"
             alt="Profile Picture" class="profile-picture">
    </div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="upload-btn-wrapper">
            <input type="file" name="profile_image" accept="image/*" onchange="previewImage(event)">
            <button type="button" onclick="this.previousElementSibling.click()">Change Profile Picture</button>
        </div>

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="password">New Password (leave blank to keep current)</label>
            <input type="password" id="password" name="password" placeholder="********">
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <input type="text" id="role" value="{{ $user->is_seller ? 'Seller' : 'Buyer' }}" disabled>
        </div>

        <button type="submit" class="submit-btn">Save Changes</button>
    </form>

    <div class="activity">
        <h3>Recent Activity</h3>
        <ul>
            <li>Books purchased: 5</li>
            <li>Books listed for sale: 3</li>
            <li>Last login: {{ now()->format('d M Y, H:i') }}</li>
        </ul>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('profilePreview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

</body>
</html>
