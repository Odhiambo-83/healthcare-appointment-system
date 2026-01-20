<?php
session_start();
include 'connection.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare statement
        $stmt = $conn->prepare("INSERT INTO patients (full_name, email, phone, password, created_at) VALUES (?, ?, ?, ?, NOW())");
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        $stmt->bind_param("ssss", $full_name, $email, $phone, $hashed_password);

        if ($stmt->execute()) {
            $success = "Registration Successful! You can now log in.";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Registration | Healthcare System</title>

    <style>
        body { margin: 0; background: #f2f2f2; font-family: Verdana, sans-serif; }

        /* Header */
        h1 {
            background-color: rgba(0,102,102,0.95);
            color: white;
            margin: -10px -10px 0 -10px;
            padding: 15px;
            font-size: 55px;
            text-align: center;
            font-family: "Times New Roman";
        }

        /* Navigation */
        ul {
            list-style: none;
            background-color: rgba(0,102,102,0.95);
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        li { float: left; }

        li a {
            display: block;
            color: white;
            padding: 14px 25px;
            text-decoration: none;
            font-size: 18px;
        }

        li a:hover { background: white; color: #006666; }

        /* Register Box */
        .register-container {
            width: 500px;
            margin: 70px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .register-container h2 {
            text-align: center;
            color: #006666;
        }

        input[type="text"], input[type="email"], input[type="number"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #006666;
            color: white;
            padding: 12px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #00cccc;
            color: black;
        }

        .error {
            color: red;
            text-align: center;
            font-size: 16px;
        }

        .success {
            color: green;
            text-align: center;
            font-size: 16px;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            text-decoration: none;
            color: #006666;
            font-weight: bold;
            font-size: 18px;
        }

        .login-link a:hover {
            color: #00cccc;
        }

        .footer {
            background-color: rgba(0,102,102,0.95);
            padding: 20px;
            text-align: center;
            margin-top: 50px;
            color: #D6FEFF;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <h1>HEALTHCARE APPOINTMENT SYSTEM</h1>

    <!-- Navigation -->
    <ul>
        <li><a href="index.php">HOME</a></li>
        <li><a href="admin_login.php">ADMIN LOGIN</a></li>
        <li><a href="patient_login.php">PATIENT LOGIN</a></li>
    </ul>

    <!-- Registration Form -->
    <div class="register-container">
        <h2>Patient Registration</h2>

        <?php if ($error != ""): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <?php if ($success != ""): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Full Name:</label>
            <input type="text" name="fullname" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Phone Number:</label>
            <input type="number" name="phone" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Confirm Password:</label>
            <input type="password" name="confirm" required>

            <input type="submit" value="Register">
        </form>

        <div class="login-link">
            <p>Already have an account?</p>
            <a href="patient_login.php">Login here</a>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Developer: KJ Software Solutions
    </div>

</body>
</html>
