<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - Bookstore</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .signup-card {
            background-color: white;
            max-width: 400px;
            width: 100%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .form-group {
            position: relative;
            margin-bottom: 15px;
        }
        .form-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #3498db;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 10px 10px 35px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box; /* FIX */
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px #3498db;
            outline: none;
        }
        .checkbox-group {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .checkbox-group input[type="checkbox"] {
            margin-right: 10px;
            width: auto;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #2980b9;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
        .login-link a {
            color: #3498db;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="signup-card">
        <h2>Sign Up</h2>
        <form method="POST" action="{{ route('signup.store') }}">
            @csrf
            <div class="form-group">
                <i class="fa fa-user"></i>
                <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" name="is_seller" id="is_seller" {{ old('is_seller') ? 'checked' : '' }}>
                <label for="is_seller">Register as Seller</label>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="/login">Login here</a>
        </div>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
