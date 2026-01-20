<?php
session_start();
include 'connection.php'; // Make sure this connects to health_system

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username or email already exists!";
    } else {
        // Insert new admin
        $stmt = $conn->prepare("INSERT INTO admin (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $username, $email, $password); // storing plain password for now
        if ($stmt->execute()) {
            $success = "Registration successful! You can now <a href='admin_login.php'>login</a>.";
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration | Healthcare System</title>
    <style>
        body { font-family: Verdana; background: #f2f2f2; }
        .container { width: 400px; margin: 50px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        input[type="submit"] { background-color: #006666; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background-color: #00cccc; color: black; }
        .error { color: red; text-align: center; }
        .success { color: green; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <h2>Admin Registration</h2>

    <?php if ($error != ""): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php if ($success != ""): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <input type="submit" value="Register">
    </form>
</div>
</body>
</html>
