<?php 
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "aqi";

// Initialize variables with POST data or empty strings
$fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$confirm_password = isset($_POST['confirm-password']) ? trim($_POST['confirm-password']) : '';
$dob = isset($_POST['dob']) ? trim($_POST['dob']) : '';
$country = isset($_POST['country']) ? trim($_POST['country']) : '';
$gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
$color = isset($_POST['color']) ? trim($_POST['color']) : '';
$opinion = isset($_POST['opinion']) ? trim($_POST['opinion']) : '';
$terms = isset($_POST['terms']) ? "Agreed" : "Not Agreed";

$message = '';

if (isset($_POST['confirm'])) {
    // Basic validation
    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } elseif ($terms !== "Agreed") {
        $message = "You must agree to the terms!";
    } elseif (empty($fullname) || empty($email) || empty($password)) {
        $message = "Please fill in all required fields!";
    } else {
        // Connect to database
        $conn = new mysqli($servername, $username, $password_db, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Sanitize input for SQL injection
        $fullname_db = $conn->real_escape_string($fullname);
        $email_db = $conn->real_escape_string($email);
        $password_db_escaped = $conn->real_escape_string($password);
        $dob_db = $conn->real_escape_string($dob);
        $country_db = $conn->real_escape_string($country);
        $gender_db = $conn->real_escape_string($gender);
        $color_db = $conn->real_escape_string($color);

        // Insert query
        $sql = "INSERT INTO user (Full_Name, Email, Password, Date_of_Birth, Country, Gender,Favourite_color) VALUES 
                ('$fullname_db', '$email_db', '$password_db_escaped', '$dob_db', '$country_db', '$gender_db','$color_db')";

        if ($conn->query($sql) === TRUE) {
            // ✅ Set favorite color in a cookie (expires in 1 day)
            setcookie("favorite_color", $color, time() + (86400), "/");
            $message = "New record created successfully. Cookie set for favorite color.";
        } else {
            $message = "SQL Error: " . $conn->error;
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Registration Details</title>
    <style>
        body {
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;  
            align-items: center;      
        }
        .container {
            text-align: center;
            width: 480px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            margin: 0 auto 20px auto;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
            font-size: 1.1em;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        h2 {
            text-align: center;
            color: #000000;
            margin-bottom: 20px;
            font-weight: normal;
        }
        .color-box {
            display: inline-block;
            width: 20px;
            height: 20px;
            vertical-align: middle;
            margin-right: 8px;
            border: 1px solid #ccc;
        }
        .btn {
            padding: 10px 20px;
            margin: 5px 10px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-confirm {
            background-color: #28a745;
            color: white;
        }
        .btn-back {
            background-color: #dc3545;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .message {
            margin-bottom: 20px;
            font-weight: bold;
            color: <?= strpos($message, 'Error') !== false || strpos($message, 'Passwords') !== false ? 'red' : 'green'; ?>;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registration Details</h2>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <table>
        <tr><th>Field</th><th>Value</th></tr>
        <tr><td>Full Name</td><td><?= htmlspecialchars($fullname) ?></td></tr>
        <tr><td>Email</td><td><?= htmlspecialchars($email) ?></td></tr>
        <tr><td>Password</td><td><?= htmlspecialchars($password) ?></td></tr>
        <tr><td>Confirm Password</td><td><?= htmlspecialchars($confirm_password) ?></td></tr>
        <tr><td>Date of Birth</td><td><?= htmlspecialchars($dob) ?></td></tr>
        <tr><td>Country</td><td><?= htmlspecialchars($country) ?></td></tr>
        <tr><td>Gender</td><td><?= htmlspecialchars($gender) ?></td></tr>
        <tr><td>Favorite Color</td><td><span class="color-box" style="background-color:<?= htmlspecialchars($color) ?>;"></span> <?= htmlspecialchars($color) ?></td></tr>
        <tr><td>Your Opinion</td><td><?= nl2br(htmlspecialchars($opinion)) ?></td></tr>
        <tr><td>Terms Agreed</td><td><?= htmlspecialchars($terms) ?></td></tr>
    </table>

    <form action="process.php" method="post" style="display:inline-block; margin-right:10px;">
        <!-- Pass all data as hidden inputs -->
        <input type="hidden" name="fullname" value="<?= htmlspecialchars($fullname) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
        <input type="hidden" name="confirm-password" value="<?= htmlspecialchars($confirm_password) ?>">
        <input type="hidden" name="dob" value="<?= htmlspecialchars($dob) ?>">
        <input type="hidden" name="country" value="<?= htmlspecialchars($country) ?>">
        <input type="hidden" name="gender" value="<?= htmlspecialchars($gender) ?>">
        <input type="hidden" name="color" value="<?= htmlspecialchars($color) ?>">
        <input type="hidden" name="opinion" value="<?= htmlspecialchars($opinion) ?>">
        <input type="hidden" name="terms" value="<?= ($terms === "Agreed") ? "on" : "" ?>">
        <button type="submit" name="confirm" class="btn btn-confirm">Confirm</button>
    </form>

    <form action="index.php" method="post" style="display:inline-block;">
        <!-- Pass all data back to index.php for editing -->
        <input type="hidden" name="fullname" value="<?= htmlspecialchars($fullname) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
        <input type="hidden" name="confirm-password" value="<?= htmlspecialchars($confirm_password) ?>">
        <input type="hidden" name="dob" value="<?= htmlspecialchars($dob) ?>">
        <input type="hidden" name="country" value="<?= htmlspecialchars($country) ?>">
        <input type="hidden" name="gender" value="<?= htmlspecialchars($gender) ?>">
        <input type="hidden" name="color" value="<?= htmlspecialchars($color) ?>">
        <input type="hidden" name="opinion" value="<?= htmlspecialchars($opinion) ?>">
        <input type="hidden" name="terms" value="<?= ($terms === "Agreed") ? "on" : "" ?>">
        <button type="submit" class="btn btn-back">Back</button>
    </form>
</div>

</body>
</html>
