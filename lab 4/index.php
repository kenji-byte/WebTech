<?php
session_start();

// Handle Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $cpassword = htmlspecialchars($_POST['cpassword']);
    $gender = htmlspecialchars($_POST['gender'] ?? '');
    $dob = htmlspecialchars($_POST['dob']);
    $country = htmlspecialchars($_POST['Country']);
    $opinion = htmlspecialchars($_POST['opinion']);
    $terms = isset($_POST['terms']) ? 'Agreed' : 'Not Agreed';
    $bgcolor = htmlspecialchars($_POST['bgcolor']);

    // Server-side validation
    $nameRegex = '/^[a-zA-Z.\-\s]+$/';
    $emailRegex = '/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|hotmail\.com)$/';
    if (empty($fname) || !preg_match($nameRegex, $fname)) {
        $errorMessage = "Full name is required and can only contain letters, dots, hyphens, and spaces.";
    } elseif (empty($email) || !preg_match($emailRegex, $email)) {
        $errorMessage = "A valid Gmail, Yahoo, or Hotmail address is required.";
    } elseif (empty($password) || strlen($password) < 8) {
        $errorMessage = "Password must be at least 8 characters long.";
    } elseif ($password !== $cpassword) {
        $errorMessage = "Passwords do not match.";
    } elseif (empty($dob)) {
        $errorMessage = "Date of birth is required.";
    } else {
        $dobDate = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($dobDate)->y;
        if ($age < 18) {
            $errorMessage = "You must be at least 18 years old.";
        }
    }
    if (empty($gender)) {
        $errorMessage = "Gender is required.";
    }
    if (empty($country)) {
        $errorMessage = "Country is required.";
    }
    if (!isset($_POST['terms'])) {
        $errorMessage = "You must agree to the terms and conditions.";
    }

    if (!isset($errorMessage)) {
        $_SESSION['user'] = [
            'fname' => $fname,
            'email' => $email,
            'password' => $password, // In production, hash the password
            'gender' => $gender,
            'dob' => $dob,
            'country' => $country,
            'opinion' => $opinion,
            'terms' => $terms,
            'bgcolor' => $bgcolor
        ];
        $successMessage = "Registration Successful. You can now login.";
    }
}

// Handle Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $loginEmail = htmlspecialchars($_POST['loginEmail']);
    $loginPassword = htmlspecialchars($_POST['loginPassword']);
    $emailRegex = '/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|hotmail\.com)$/';

    if (empty($loginEmail) || !preg_match($emailRegex, $loginEmail)) {
        $loginError = "A valid Gmail, Yahoo, or Hotmail address is required.";
    } elseif (empty($loginPassword)) {
        $loginError = "Password is required.";
    } elseif (isset($_SESSION['user']) &&
              $loginEmail === $_SESSION['user']['email'] &&
              $loginPassword === $_SESSION['user']['password']) {
        $_SESSION['logged_in'] = true;
        header("Location: process.php");
        exit();
    } else {
        $loginError = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>AIUB</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-top: 20px;
        }
        .logo {
            width: 200px;
            height: auto;
        }
        .Tahmid {
            display: flex;
            justify-content: center;
            align-items: stretch;
            margin-top: 20px;
        }
        .Hasan {
            background-color: white;
            width: 500px;
            padding: 20px;
            box-sizing: border-box;
            border: 5px solid black;
            border-radius: 0;
        }
        .column {
            display: flex;
            flex-direction: column;
            margin-left: 20px;
        }
        .side-box {
            background-color: white;
            height: 50%;
            width: 400px;
            border: 5px solid black;
            border-radius: 0;
            border-top: none;
            padding: 20px;
            box-sizing: border-box;
        }
        .side-box:first-child {
            border-top: 5px solid black;
        }
        input, select, textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 5px;
        }
        input[type="radio"] {
            width: auto;
            margin-right: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        table, th, td {
            border: 1px solid black;
        }
        th {
            background-color: #dce4df;
        }
        .message {
            color: green;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
        /* Added styling for checkbox and label */
        .terms-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .terms-container input[type="checkbox"] {
            width: auto;
            margin-right: 5px;
            margin-left: 0;
        }
        .terms-container label {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img class="logo" src="https://via.placeholder.com/200x100?text=Logo" alt="logo" />
        <h1>REGISTRATION PROCESS</h1>
    </div>
    <div class="Tahmid">
        <!-- Registration Form -->
        <div class="Hasan">
            <h2 style="background-color: rgb(220, 228, 223); text-align: center;">Registration Form</h2>
            <?php
            if (isset($successMessage)) echo "<div class='message'>$successMessage</div>";
            if (isset($errorMessage)) echo "<div class='error'>$errorMessage</div>";
            ?>
            <form method="post" action="">
                <input type="hidden" name="register" value="1" />
                <label for="fname">Full Name:</label><br>
                <input type="text" id="fname" name="fname" placeholder="Enter your full name" value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : ''; ?>"><br>
                <label for="email">Email:</label><br>
                <input type="text" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" placeholder="Enter your password"><br>
                <label for="cpassword">Confirm Password:</label><br>
                <input type="password" id="cpassword" name="cpassword" placeholder="Confirm your password"><br>
                <label for="gender">Gender:</label><br>
                <input type="radio" id="male" name="gender" value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'checked' : ''; ?>><label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'checked' : ''; ?>><label for="female">Female</label>
                <input type="radio" id="other" name="gender" value="other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'other') ? 'checked' : ''; ?>><label for="other">Other</label><br>
                <label for="dob">Date Of Birth:</label><br>
                <input type="date" id="dob" name="dob" value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>"><br>
                <label for="Country">Country:</label><br>
                <select id="Country" name="Country">
                    <option value="">--Select--</option>
                    <option value="Bangladesh" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'Bangladesh') ? 'selected' : ''; ?>>Bangladesh</option>
                    <option value="Pakistan" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'Pakistan') ? 'selected' : ''; ?>>Pakistan</option>
                    <option value="India" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'India') ? 'selected' : ''; ?>>India</option>
                    <option value="Malaysia" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'Malaysia') ? 'selected' : ''; ?>>Malaysia</option>
                    <option value="Singapore" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'Singapore') ? 'selected' : ''; ?>>Singapore</option>
                    <option value="Indonesia" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'Indonesia') ? 'selected' : ''; ?>>Indonesia</option>
                    <option value="Argentina" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'Argentina') ? 'selected' : ''; ?>>Argentina</option>
                    <option value="Germany" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'Germany') ? 'selected' : ''; ?>>Germany</option>
                    <option value="Saudi Arabia" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'Saudi Arabia') ? 'selected' : ''; ?>>Saudi Arabia</option>
                    <option value="France" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'France') ? 'selected' : ''; ?>>France</option>
                    <option value="South Africa" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'South Africa') ? 'selected' : ''; ?>>South Africa</option>
                    <option value="Colombia" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'Colombia') ? 'selected' : ''; ?>>Colombia</option>
                    <option value="Chile" <?php echo (isset($_POST['Country']) && $_POST['Country'] == 'Chile') ? 'selected' : ''; ?>>Chile</option>
                </select><br>
                <div class="terms-container">
                    <input type="checkbox" id="terms" name="terms" <?php echo isset($_POST['terms']) ? 'checked' : ''; ?>>
                    <label for="terms">I agree to the terms and conditions</label>
                </div>
                <label for="opinion">Opinion:</label><br>
                <textarea id="opinion" name="opinion" rows="4" cols="20" placeholder="Write your opinion..."><?php echo isset($_POST['opinion']) ? htmlspecialchars($_POST['opinion']) : ''; ?></textarea><br>
                <label for="bgcolor">Select Background Color:</label><br>
                <input type="color" id="bgcolor" name="bgcolor" value="<?php echo isset($_POST['bgcolor']) ? htmlspecialchars($_POST['bgcolor']) : '#ffffff'; ?>"><br>
                <input type="submit" value="Submit">
            </form>
        </div>

        <!-- Right Column -->
        <div class="column">
            <!-- Login Form -->
            <div class="side-box">
                <h2 style="text-align:center; background-color: rgb(220, 228, 223);">Login</h2>
                <?php if (isset($loginError)) echo "<div class='error'>$loginError</div>"; ?>
                <form method="post" action="">
                    <input type="hidden" name="login" value="1" />
                    <label for="loginEmail">Email:</label><br>
                    <input type="text" id="loginEmail" name="loginEmail" placeholder="Enter your email" value="<?php echo isset($_POST['loginEmail']) ? htmlspecialchars($_POST['loginEmail']) : ''; ?>"><br>
                    <label for="loginPassword">Password:</label><br>
                    <input type="password" id="loginPassword" name="loginPassword" placeholder="Enter your password"><br>
                    <input type="submit" value="Login">
                </form>
            </div>

            <!-- Table in Side Box -->
            <div class="side-box">
                <h2 style="text-align:center; background-color: rgb(220, 228, 223);">City Air Quality</h2>
                <table>
                    <thead>
                        <tr><th>City</th><th>AQI</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Dhaka</td><td>180</td></tr>
                        <tr><td>Delhi</td><td>250</td></tr>
                        <tr><td>Jakarta</td><td>120</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- JavaScript for real-time background color preview -->
    <script>
        document.getElementById('bgcolor').addEventListener('input', function() {
            document.querySelector('.Hasan').style.backgroundColor = this.value;
        });
    </script>
</body>
</html>