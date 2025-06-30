<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Back page logic
$backPage = isset($_GET['from']) ? $_GET['from'] : 'request.php';

// Database connection
$host = "localhost";
$db = "aqi";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$email = $_SESSION['user'];

// Retrieve user info
$stmt = $conn->prepare("SELECT full_name, email, password, Date_of_Birth, country, gender, Favourite_color FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo "<h2 style='text-align:center; color:red;'>User not found.</h2>";
    exit();
}

$stmt->bind_result($full_name, $email, $password, $dob, $country, $gender, $favorite_color);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Additional back button style */
        .back-btn-inline {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #6c757d;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
        }

        .back-btn-inline:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Profile</h2>
        <table>
            <tr><th>Full Name</th><td><?= htmlspecialchars($full_name) ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($email) ?></td></tr>
            <tr><th>Password</th><td><?= htmlspecialchars($password) ?></td></tr>
            <tr><th>Date of Birth</th><td><?= htmlspecialchars($dob) ?></td></tr>
            <tr><th>Country</th><td><?= htmlspecialchars($country) ?></td></tr>
            <tr><th>Gender</th><td><?= htmlspecialchars($gender) ?></td></tr>
            <tr><th>Favorite Color</th><td style="color: <?= htmlspecialchars($favorite_color) ?>; font-weight: bold;"><?= htmlspecialchars($favorite_color) ?></td></tr>
        </table>

        <!-- New back button using query parameter -->
        <div style="text-align:center; margin-top:20px;">
            <a href="<?= htmlspecialchars($backPage) ?>" class="back-btn-inline">🔙 Back</a>
        </div>
    </div>
</body>
</html>
