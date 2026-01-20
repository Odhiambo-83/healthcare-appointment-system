<?php
session_start();
include 'connection.php';

// Redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$error = "";
$success = "";

// Fetch current admin details
$admin_username = $_SESSION['admin'];
$stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
$stmt->bind_param("s", $admin_username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash password if changed
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update admin details
        $stmt = $conn->prepare("UPDATE admin SET username=?, email=?, password=? WHERE admin_id=?");
        $stmt->bind_param("sssi", $username, $email, $hashed_password, $admin['admin_id']);

        if ($stmt->execute()) {
            $success = "Profile updated successfully!";
            $_SESSION['admin'] = $username; // update session
        } else {
            $error = "Failed to update profile. Try again.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile | Healthcare System</title>
    <style>
        body { 
            margin: 0; 
            font-family: Verdana, sans-serif; 
            background: #e8f6f6; 
        }

        h1 {
            background-color: #006666;
            color: white;
            margin: -10px -10px 0 -10px;
            padding: 20px;
            font-size: 45px;
            text-align: center;
        }

        ul {
            list-style: none;
            background-color: #006666;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        li { float: left; }
        li a {
            display: block;
            color: white;
            padding: 15px 25px;
            text-decoration: none;
            font-size: 18px;
        }
        li a:hover { background: #00cccc; color: #003333; }

        .container {
            width: 450px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0,0,0,0.25);
        }

        h2 { text-align: center; color: #004f4f; margin-bottom: 20px; }

        label { font-weight: bold; color: #004f4f; }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            border: 1px solid #aaa;
            border-radius: 6px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #006666;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover { background-color: #00cccc; color: #003333; }

        .message { text-align: center; font-size: 16px; margin-bottom: 10px; }
        .error { color: red; }
        .success { color: green; }

        .footer {
            background-color: #006666;
            padding: 20px;
            text-align: center;
            color: #D6FEFF;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <h1>HEALTHCARE APPOINTMENT SYSTEM</h1>

    <ul>
        <li><a href="admin_dashboard.php">DASHBOARD</a></li>
        <li><a href="manage_patients.php">PATIENTS</a></li>
        <li><a href="manage_appointments.php">APPOINTMENTS</a></li>
        <li><a href="admin_profile.php">PROFILE</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
    </ul>

    <div class="container">
        <h2>Admin Profile</h2>

        <?php if ($error != ""): ?>
            <p class="message error"><?= $error ?></p>
        <?php endif; ?>
        <?php if ($success != ""): ?>
            <p class="message success"><?= $success ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($admin['username']) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>

            <label>New Password</label>
            <input type="password" name="password" placeholder="Enter new password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm new password" required>

            <input type="submit" value="Update Profile">
        </form>
    </div>

    <div class="footer">Developer: KJ Software Solutions</div>

</body>
</html>
