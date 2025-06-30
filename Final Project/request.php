<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['countries'])) {
    $_SESSION['selected_city'] = $_POST['countries'];
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Cities</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 650px;
            margin: 60px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        form {
            margin-top: 20px;
        }

        .checkbox-group {
            columns: 2;
            -webkit-columns: 2;
            -moz-columns: 2;
            padding: 15px;
        }

        .checkbox-group label {
            display: block;
            margin-bottom: 12px;
            font-size: 15px;
            color: #333;
        }

        .submit-container {
            text-align: center;
            margin-top: 25px;
        }

        .submit-container input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-container input[type="submit"]:hover {
            background-color: #0069d9;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            background-color: #dc3545;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
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
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .user-btn:hover {
            background-color: #138496;
        }
    </style>

    <script>
    function validateSelection() {
        const selected = document.querySelectorAll('input[name="countries[]"]:checked');
        if (selected.length === 0) {
            // Redirect with error param
            window.location.href = "showaqi.php?error=no_selection";
            return false; // prevent form submit after redirect
        }
        if (selected.length > 10) {
            // Redirect with error param
            window.location.href = "showaqi.php?error=too_many";
            return false; // prevent form submit after redirect
        }
        return true; // submit form normally
    }
    </script>
</head>
<body>

<!-- User and Logout Buttons -->
<a href="user.php?from=request.php" class="user-btn">User</a>
<a href="index.php" class="logout-btn">Logout</a>

<div class="container">
    <h2>Select Cities (Min: 1, Max: 10)</h2>
    <form method="post" action="showaqi.php" onsubmit="return validateSelection()">
        <div class="checkbox-group">
            <?php
            $conn = new mysqli("localhost", "root", "", "aqi");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT DISTINCT city FROM info ORDER BY city ASC";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                $city = htmlspecialchars($row['city']);
                echo "<label><input type='checkbox' name='countries[]' value='$city'> $city</label>";
            }

            $conn->close();
            ?>
        </div>

        <div class="submit-container">
            <input type="submit" value="Submit">
        </div>
    </form>
</div>

</body>
</html>
