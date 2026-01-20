<?php
session_start();
include 'connection.php';

// If doctor is already logged in
if (isset($_SESSION['doctor'])) {
    header("Location: doctor_dashboard.php");
    exit();
}

$error = "";

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate
    if ($email && $password) {
        // Fetch doctor by email
        $stmt = $conn->prepare("SELECT doctor_id, full_name, email, password FROM doctors WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $doctor = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $doctor['password'])) {
                $_SESSION['doctor'] = $doctor['doctor_id']; // Save doctor session
                $_SESSION['doctor_name'] = $doctor['full_name'];
                header("Location: doctor_dashboard.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Doctor not found.";
        }

        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Login | Healthcare System</title>
    <style>
        body { font-family: Arial, sans-serif; background: #e6f2f2; }
        h1 { text-align: center; color: #006666; }
        form { width: 35%; margin: 40px auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0px 0px 10px #ccc; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 10px; margin-top: 5px; border-radius: 4px; border: 1px solid #ccc; }
        button { margin-top: 20px; width: 100%; padding: 12px; background-color: #006666; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #00cccc; color: black; }
        .error { color: red; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

<h1>Doctor Login</h1>

<form method="POST" action="">
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
    <div class="register">
            <p>Don't have an account?</p>
            <a href="doctor_register.php">Register here</a>
        </div>
</form>


</body>
</html>
