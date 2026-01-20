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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Basic validation
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM patients WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already exists!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert patient
            $stmt = $conn->prepare("INSERT INTO patients (full_name, email, phone, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $full_name, $email, $phone, $hashed_password);

            if ($stmt->execute()) {
                $success = "Patient added successfully!";
            } else {
                $error = "Failed to add patient. Try again.";
            }
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Patient | Admin Panel</title>
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
            letter-spacing: 1px;
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
        <li><a href="add_patient.php">ADD PATIENT</a></li>
        <li><a href="manage_appointments.php">APPOINTMENTS</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
    </ul>

    <div class="container">
        <h2>Add New Patient</h2>

        <?php if ($error != ""): ?>
            <p class="message error"><?= $error ?></p>
        <?php endif; ?>
        <?php if ($success != ""): ?>
            <p class="message success"><?= $success ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="full_name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Phone</label>
            <input type="text" name="phone">

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <input type="submit" value="Add Patient">
        </form>
    </div>

    <div class="footer">Developer: KJ Software Solutions</div>

</body>
</html>
