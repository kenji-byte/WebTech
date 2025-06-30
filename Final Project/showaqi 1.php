<?php
session_start(); // Start the session at the beginning

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle error message from GET parameter
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'no_selection') {
        echo "<h2 style='text-align:center; color:red; margin-top:50px;'>❌ You must select at least 1 city.</h2>";
    } elseif ($_GET['error'] == 'too_many') {
        echo "<h2 style='text-align:center; color:red; margin-top:50px;'>❌ You cannot select more than 10 cities.</h2>";
    }
    echo "<div style='text-align:center; margin-top:20px;'>
            <a href='request.php' style='text-decoration:none; color:#007bff; font-weight:bold;'>Go back and select again</a>
          </div>";
    exit;
}

// Initialize
$selectedCities = [];
$error = '';

// Handle POST request and store in session
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['countries']) || count($_POST['countries']) < 1) {
        $error = 'You must select at least 1 city.';
    } elseif (count($_POST['countries']) > 10) {
        $error = 'You cannot select more than 10 cities.';
    } else {
        $selectedCities = $_POST['countries'];
        $_SESSION['selected_city'] = $selectedCities; // ✅ Store in session
    }
} else {
    // Not a POST request – retrieve from session
    $selectedCities = isset($_SESSION['selected_city']) ? $_SESSION['selected_city'] : [];
}

// Error handling
if (empty($selectedCities)) {
    echo "<h2 style='text-align:center; color:red; margin-top:50px;'>❌ No city data found. Please select again.</h2>";
    echo "<div style='text-align:center; margin-top:20px;'>
            <a href='request.php' style='text-decoration:none; color:#007bff; font-weight:bold;'>Go back and select again</a>
          </div>";
    exit;
}

// DB credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aqi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Escape each city name for SQL IN clause
$escapedCities = array_map([$conn, 'real_escape_string'], $selectedCities);
$cityList = "'" . implode("','", $escapedCities) . "'";

$sql = "SELECT city, country, aqi FROM info WHERE city IN ($cityList)";
$result = $conn->query($sql);

// Get favorite color from cookie
$backgroundColor = isset($_COOKIE['favorite_color']) ? htmlspecialchars($_COOKIE['favorite_color']) : '#f9f9f9';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Air Quality Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: <?= $backgroundColor ?>;
            position: relative;
        }
        .container {
            max-width: 500px;
            margin: auto;
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .user-btn {
            position: absolute;
            top: 20px;
            right: 130px;
            background-color: #17a2b8;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }
        .user-btn:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>
    <a href="user.php?from=showaqi.php" class="user-btn">User</a>
    <a href="index.php" class="logout-btn">Logout</a>

    <div class="container">
        <h2>Selected Cities and Their AQI</h2>
        <table>
            <tr><th>City</th><th>Country</th><th>Air Quality Index (AQI)</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['city']) ?></td>
                    <td><?= htmlspecialchars($row['country']) ?></td>
                    <td><?= htmlspecialchars($row['aqi']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <div style="text-align: center; margin-top: 20px;">
            <a href="request.php" style="
                display: inline-block;
                margin-top: 20px;
                text-decoration: none;
                background-color: #28a745;
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
                font-weight: bold;
            ">Select Again</a>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
