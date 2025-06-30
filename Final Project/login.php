<?php
session_start();

$host = "localhost";
$db = "aqi";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

$errors = [];

if (empty($email)) {
    $errors['email'] = "Please enter your email address";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Please enter a valid email address";
}

if (empty($password)) {
    $errors['password'] = "Please enter your password";
}

if (empty($errors)) {
    $stmt = $conn->prepare("SELECT password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $errors['email'] = "Email is incorrect";
    } else {
        $stmt->bind_result($dbPassword);
        $stmt->fetch();

        if ($password === $dbPassword) {
            $_SESSION['user'] = $email;
            header("Location: request.php");
            exit();
        } else {
            $errors['password'] = "Password is incorrect";
        }
    }

    $stmt->close();
}

$_SESSION['login_errors'] = $errors;
$_SESSION['old_email'] = $email;
header("Location: index.php");
exit;

?>
<!DOCTYPE html>
<html>
<head>
    <script>
        window.onload = function () {
            <?php if (isset($errors['email'])): ?>
                document.getElementById("loginEmailError").textContent = "<?= $errors['email'] ?>";
            <?php endif; ?>
            <?php if (isset($errors['password'])): ?>
                document.getElementById("loginPasswordError").textContent = "<?= $errors['password'] ?>";
            <?php endif; ?>
        };
    </script>
</head>
<body>
    <script>
        // Redirect back to index.php to show the errors
        window.location.href = "index.php";
    </script>
</body>
</html>
