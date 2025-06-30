<?php
session_start();

$loginErrors = $_SESSION['login_errors'] ?? [];
$oldEmail = $_SESSION['old_email'] ?? '';

unset($_SESSION['login_errors'], $_SESSION['old_email']);
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration & Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* All your existing styles remain unchanged */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f7f7f7;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo-container img {
            width: 120px;
            height: auto;
        }

        .form-heading {
            font-size: 2rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .container {
            width: 90%;
            max-width: 960px;
            display: flex;
            border: 1px solid #e0e0e0;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .left {
            border-right: 1px solid #e0e0e0;
        }

        .form-section h2,
        .form-section h3 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="date"],
        .form-group select,
        .form-group input[type="color"],
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            font-size: 1rem;
            color: #2d3748;
            outline: none;
            transition: border-color 0.2s ease-in-out;
        }

        .form-group input:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 0.2rem rgba(66, 153, 225, 0.25);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .radio-group,
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-top: 0.25rem;
        }

        .radio-group label,
        .checkbox-group label {
            margin-left: 0.5rem;
            font-weight: normal;
            color: #4a5568;
        }

        .error-message {
            color: #e53e3e;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        button {
            padding: 0.75rem 1.5rem;
            background-color: #48bb78;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color 0.2s ease-in-out;
            width: 100%;
            display: block;
            margin-top: 1rem;
        }

        button:hover {
            background-color: #38a169;
        }

        .login-button {
            background-color: #4299e1;
        }

        .login-button:hover {
            background-color: #3182ce;
        }

        .side-box {
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }

        .side-box table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .side-box th,
        .side-box td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .side-box th {
            background-color: #f4f4f4;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left, .right {
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
            }

            .right:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>
<body>

<div class="logo-container">
    <img src="download.png" alt="Logo" style="width: 100px; height: auto;">
</div>
<h2 class="form-heading">Registration & Login</h2>

<div class="container">
    <div class="form-section left">
        <h2>Register</h2>
        <form id="registrationForm" action="process.php" method="POST">
          <div class="form-group">
                    <label for="fullname">Full Name:</label>
                    <input type="text" id="fullname" name="fullname" />
                    <div id="fullname-error" class="error-message"></div>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" />
                    <div id="email-error" class="error-message"></div>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" />
                    <div id="password-error" class="error-message"></div>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" />
                    <div id="confirm-password-error" class="error-message"></div>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" />
                    <div id="dob-error" class="error-message"></div>
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <select id="country" name="country">
                        <option value="">Select Country</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="India">India</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Nepal">Nepal</option>
                        <option value="USA">USA</option>
                        <option value="Australia">Australia</option>
                    </select>
                    <div id="country-error" class="error-message"></div>
                </div>
                <div class="form-group">
                    <label>Gender:</label>
                    <div class="radio-group">
                        <input type="radio" id="male" name="gender" value="male" />
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="female" />
                        <label for="female">Female</label>
                    </div>
                    <div id="gender-error" class="error-message"></div>
                </div>
                <div class="form-group">
                    <label for="color">Favorite Color:</label>
                    <input type="color" id="color" name="color" value="#000000" />
                </div>
                <div class="form-group">
                    <label for="opinion">Your Opinion:</label>
                    <textarea id="opinion" name="opinion" rows="4"></textarea>
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="terms" name="terms" />
                    <label for="terms">I agree to the terms and conditions</label>
                    <div id="terms-error" class="error-message"></div>
                </div>
            <button type="submit">Register</button>
        </form>
    </div>

    <div class="form-section right">
        <h3>Log In</h3>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="loginEmail">Email:</label>
                <input type="email" id="loginEmail" name="email" value="<?= htmlspecialchars($oldEmail) ?>" />
                <div id="loginEmailError" class="error-message"><?= $loginErrors['email'] ?? '' ?></div>
            </div>
            <div class="form-group">
                <label for="loginPassword">Password:</label>
                <input type="password" id="loginPassword" name="password" />
                <div id="loginPasswordError" class="error-message"><?= $loginErrors['password'] ?? '' ?></div>
            </div>
            <button type="submit" class="login-button">Log In</button>
        </form>

        <div class="side-box">
            <h2 style="text-align:center; background-color: rgb(220, 228, 223);">City Air Quality</h2>
            <table>
                <thead>
                    <tr><th>City</th><th>AQI</th></tr>
                </thead>
                <tbody>
                    <tr><td>Dhaka</td><td>180</td></tr>
                    <tr><td>Delhi</td><td>250</td></tr>
                    <tr><td>Jakarta</td><td>125</td></tr>
                    <tr><td>Cairo</td><td>120</td></tr>
                    <tr><td>Bangkok</td><td>140</td></tr>
                    <tr><td>Tokyo</td><td>45</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const registrationForm = document.getElementById("registrationForm");
    const loginForm = document.getElementById("loginForm");
    const registrationErrorMessages = document.querySelectorAll("#registrationForm .error-message");
    const loginErrorMessages = document.querySelectorAll("#loginForm .error-message");
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function clearErrors(errors) {
        errors.forEach(el => el.textContent = "");
    }

    function validateRegistrationForm(event) {
        clearErrors(registrationErrorMessages);
        let hasErrors = false;

        const fullname = document.getElementById("fullname").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm-password").value;
        const dob = document.getElementById("dob").value;
        const country = document.getElementById("country").value;
        const gender = document.querySelector('input[name="gender"]:checked');
        const terms = document.getElementById("terms").checked;

        if (!fullname) {
            document.getElementById("fullname-error").textContent = "Please enter your full name";
            hasErrors = true;
        }

        if (!email) {
            document.getElementById("email-error").textContent = "Please enter your email address";
            hasErrors = true;
        } else if (!emailRegex.test(email)) {
            document.getElementById("email-error").textContent = "Please enter a valid email address";
            hasErrors = true;
        }

        if (!password) {
            document.getElementById("password-error").textContent = "Please enter a password";
            hasErrors = true;
        } else if (password.length < 6) {
            document.getElementById("password-error").textContent = "Password must be at least 6 characters long";
            hasErrors = true;
        }

        if (!confirmPassword) {
            document.getElementById("confirm-password-error").textContent = "Please confirm your password";
            hasErrors = true;
        } else if (confirmPassword !== password) {
            document.getElementById("confirm-password-error").textContent = "Passwords do not match";
            hasErrors = true;
        }

        if (!dob) {
            document.getElementById("dob-error").textContent = "Please enter your date of birth";
            hasErrors = true;
        } else {
            const dobDate = new Date(dob);
            const today = new Date();
            const minAgeDate = new Date();
            minAgeDate.setFullYear(today.getFullYear() - 18);

            if (dobDate > today) {
                document.getElementById("dob-error").textContent = "Date of birth cannot be in the future";
                hasErrors = true;
            } else if (dobDate > minAgeDate) {
                document.getElementById("dob-error").textContent = "You must be at least 18 years old";
                hasErrors = true;
            }
        }

        if (!country) {
            document.getElementById("country-error").textContent = "Please select your country";
            hasErrors = true;
        }

        if (!gender) {
            document.getElementById("gender-error").textContent = "Please select your gender";
            hasErrors = true;
        }

        if (!terms) {
            document.getElementById("terms-error").textContent = "You must agree to the terms and conditions";
            hasErrors = true;
        }

        if (hasErrors) {
            event.preventDefault();
        }
    }

    function validateLoginForm(event) {
        clearErrors(loginErrorMessages);
        let hasErrors = false;

        const loginEmail = document.getElementById("loginEmail").value.trim();
        const loginPassword = document.getElementById("loginPassword").value;

        if (!loginEmail) {
            document.getElementById("loginEmailError").textContent = "Please enter your email address";
            hasErrors = true;
        } else if (!emailRegex.test(loginEmail)) {
            document.getElementById("loginEmailError").textContent = "Please enter a valid email address";
            hasErrors = true;
        }

        if (!loginPassword) {
            document.getElementById("loginPasswordError").textContent = "Please enter your password";
            hasErrors = true;
        }

        if (hasErrors) {
            event.preventDefault();
        }
    }

    registrationForm.addEventListener("submit", validateRegistrationForm);
    loginForm.addEventListener("submit", validateLoginForm);
});
</script>
</body>
</html>
