<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Form</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 20px;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 400px;
        background: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 0px 10px 0px #aaa;
    }
    label {
        font-weight: bold;
    }
    input, select, textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .gender-group {
        display: flex;
        gap: 10px;
    }
    .checkbox-group {
        display: flex;
        align-items: center;
    }
    button {
        background-color: #28a745;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #218838;
    }
    .error {
        color: red;
        font-size: 14px;
    }
</style>
</head>
<body>
<div class="container">
<h2>Registration Form</h2>

<form id="registrationForm" action="#" method="post" onsubmit="return validateForm()">

    <label for="fullname">Full Name:</label>
    <input type="text" id="fullname" name="fullname" required>
    <div id="nameError" class="error"></div>

    <label for="email">User Email:</label>
    <input type="email" id="email" name="email" required>
    <div id="emailError" class="error"></div>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <div id="passwordError" class="error"></div>

    <label for="confirm-password">Confirm Password:</label>
    <input type="password" id="confirm-password" name="confirm-password" required>

    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" required>
    <div id="dobError" class="error"></div>

    <label for="country">Country:</label>
    <select id="country" name="country" required>
        <option value="">Select Country</option>
        <option value="Bangladesh">Bangladesh</option>
        <option value="Germany">Germany</option>
        <option value="USA">United States</option>
        <option value="UK">United Kingdom</option>
        <option value="Canada">Canada</option>
        <option value="India">India</option>
        <option value="Australia">Australia</option>
    </select>

    <label for="color">Favorite Color:</label>
    <select id="color" name="color" required>
        <option value="">Select Color</option>
        <option value="Red">Red</option>
        <option value="Blue">Blue</option>
        <option value="Green">Green</option>
        <option value="Yellow">Yellow</option>
        <option value="Purple">Purple</option>
        <option value="Black">Black</option>
        <option value="White">White</option>
    </select>

    <label>Gender:</label>
    <div class="gender-group">
        <input type="radio" id="male" name="gender" value="male" required>
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="female">
        <label for="female">Female</label>
    </div>

    <label for="comments">Comments:</label>
    <textarea id="comments" name="comments" rows="10" cols="20"></textarea>

    <div class="checkbox-group">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">I agree to the Terms and Conditions</label>
    </div>

    <button type="submit">Register</button>

</form>
</div>

<script>
function validateForm() {
    let valid = true;

    // Clear previous error messages
    document.getElementById('nameError').innerText = "";
    document.getElementById('emailError').innerText = "";
    document.getElementById('passwordError').innerText = "";
    document.getElementById('dobError').innerText = "";

    // Validate Full Name (only letters and spaces)
    const fullname = document.getElementById('fullname').value.trim();
    const nameRegex = /^[A-Za-z\s]+$/;
    if (!nameRegex.test(fullname)) {
        document.getElementById('nameError').innerText = "Please enter a valid name (letters only).";
        valid = false;
    }

    // Validate Email
    const email = document.getElementById('email').value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        document.getElementById('emailError').innerText = "Please enter a valid email address.";
        valid = false;
    }

    // Validate Password (min 8 characters, 1 special character)
    const password = document.getElementById('password').value;
    const passwordRegex = /^(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
    if (!passwordRegex.test(password)) {
        document.getElementById('passwordError').innerText = "Password must be at least 8 characters long and contain at least one special character.";
        valid = false;
    }

    // Validate Date of Birth (must be over 18 years old)
    const dob = document.getElementById('dob').value;
    if (dob) {
        const dobDate = new Date(dob);
        const today = new Date();
        let age = today.getFullYear() - dobDate.getFullYear();
        const m = today.getMonth() - dobDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
            age--;
        }
        if (age < 18) {
            document.getElementById('dobError').innerText = "You must be at least 18 years old.";
            valid = false;
        }
    } else {
        document.getElementById('dobError').innerText = "Please select your date of birth.";
        valid = false;
    }

    return valid;
}
</script>

</body>
</html>
