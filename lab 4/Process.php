<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Handle Logout
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>AIUB User Profile</title>
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
        .container {
            background-color: <?php echo htmlspecialchars($user['bgcolor']); ?>;
            width: 600px;
            padding: 20px;
            margin-top: 20px;
            border: 5px solid black;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #dce4df;
        }
        .logout-btn {
            background-color: #ff4d4d;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="header">
        <img class="logo" src="https://via.placeholder.com/200x100?text=Logo" alt="logo" />
        <h1>USER PROFILE</h1>
    </div>

    <div class="container">
        <h2 style="background-color: rgb(220, 228, 223); text-align: center;">Registered User Information</h2>
        <table>
            <tr><th>Field</th><th>Details</th></tr>
            <tr><td>Full Name</td><td><?php echo htmlspecialchars($user['fname']); ?></td></tr>
            <tr><td>Email</td><td><?php echo htmlspecialchars($user['email']); ?></td></tr>
            <tr><td>Gender</td><td><?php echo htmlspecialchars($user['gender'] ?: 'Not specified'); ?></td></tr>
            <tr><td>Date of Birth</td><td><?php echo htmlspecialchars($user['dob']); ?></td></tr>
            <tr><td>Country</td><td><?php echo htmlspecialchars($user['country']); ?></td></tr>
            <tr><td>Opinion</td><td><?php echo htmlspecialchars($user['opinion'] ?: 'No opinion provided'); ?></td></tr>
            <tr><td>Terms Agreement</td><td><?php echo htmlspecialchars($user['terms']); ?></td></tr>
            <tr><td>Background Color</td><td style="background-color: <?php echo htmlspecialchars($user['bgcolor']); ?>;"><?php echo htmlspecialchars($user['bgcolor']); ?></td></tr>
        </table>
        <form method="post" action="">
            <input type="hidden" name="logout" value="1" />
            <input type="submit" value="Logout" class="logout-btn">
        </form>
    </div>
</body>
</html>