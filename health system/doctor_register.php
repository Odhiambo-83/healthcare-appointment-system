<?php
session_start();
include 'connection.php';

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $specialization = trim($_POST['specialization']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($full_name && $email && $phone && $specialization && $password && $confirm_password) {

        if ($password !== $confirm_password) {
            $message = "Passwords do not match.";
        } else {

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert doctor
            $stmt = $conn->prepare("INSERT INTO doctors (full_name, email, phone, specialization, password) VALUES (?, ?, ?, ?, ?)");

            // Check if prepare failed
            if (!$stmt) {
                die("Database error: " . $conn->error);
            }

            $stmt->bind_param("sssss", $full_name, $email, $phone, $specialization, $hashed_password);

            if ($stmt->execute()) {
                $message = "Registration successful! You can now log in.";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }

    } else {
        $message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Registration | Healthcare System</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef7f7; }
        h1 { text-align: center; color: #006666; }
        form { width: 40%; margin: 25px auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0px 0px 10px #ccc; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        button { margin-top: 20px; width: 100%; padding: 12px; background-color: #006666; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #00cccc; color: black; }
        .message { text-align: center; color: red; margin-bottom: 15px; }
        .top-bar { text-align: center; margin-top: 20px; }
        a.button { text-decoration: none; padding: 8px 12px; background-color: #006666; color: white; border-radius: 4px; }
        a.button:hover { background-color: #00cccc; color: black; }
    </style>
</head>
<body>

<h1>Doctor Registration</h1>

<div class="top-bar">
    <a class="button" href="doctors_login.php">Back to Login</a>
</div>

<form method="POST">
    <?php if ($message): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>

    <label>Full Name</label>
    <input type="text" name="full_name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Phone</label>
    <input type="text" name="phone" required>

    <label>Specialization</label>
    <input type="text" name="specialization" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required>

    <button type="submit">Register</button>
</form>

</body>
</html>
