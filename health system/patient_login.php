<?php
session_start();
include 'connection.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare statement
    $stmt = $conn->prepare("SELECT * FROM patients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['patient'] = $row['email'];
            header("Location: patient_dashboard.php");
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "Invalid email or password!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Login | Healthcare System</title>
    <style>
        body { margin: 0; background: #e8f6f6; font-family: Verdana, sans-serif; }

        /* Header */
        h1 {
            background-color: #006666;
            color: white;
            margin: -10px -10px 0 -10px;
            padding: 20px;
            font-size: 50px;
            text-align: center;
            letter-spacing: 1px;
            font-family: "Times New Roman";
        }

        /* Navigation */
        ul { list-style: none; background-color: #006666; margin: 0; padding: 0; overflow: hidden; }
        li { float: left; }
        li a {
            display: block;
            color: white;
            padding: 15px 28px;
            text-decoration: none;
            font-size: 18px;
            transition: 0.3s;
        }
        li a:hover { background: #00cccc; color: #004444; }

        /* Login Box */
        .login-container {
            width: 420px;
            margin: 90px auto;
            padding: 35px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.25);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .login-container h2 { text-align: center; color: #004f4f; margin-bottom: 10px; }
        label { font-weight: bold; color: #004f4f; }

        input[type="email"], input[type="password"] {
            width: 100%; padding: 12px; margin: 12px 0;
            border: 1px solid #aaa; border-radius: 6px; transition: 0.3s;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #00cccc;
            box-shadow: 0 0 5px rgba(0,204,204,0.5);
            outline: none;
        }
        input[type="submit"] {
            width: 100%; background-color: #006666; color: white;
            padding: 12px; font-size: 18px; border: none; border-radius: 6px;
            margin-top: 10px; cursor: pointer; transition: 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #00cccc; color: #003333; transform: translateY(-2px);
        }

        .error { color: red; text-align: center; font-size: 16px; margin-bottom: 10px; }

        /* Register section */
        .register { text-align: center; margin-top: 22px; padding-top: 15px; border-top: 1px solid #ccc; }
        .register a { text-decoration: none; color: #006666; font-weight: bold; font-size: 18px; transition: 0.3s; }
        .register a:hover { color: #00cccc; }

        .footer { background-color: #006666; padding: 22px; text-align: center; margin-top: 60px; color: #D6FEFF; font-size: 18px; letter-spacing: 1px; }
    </style>
</head>

<body>

    <h1>HEALTHCARE APPOINTMENT SYSTEM</h1>

    <ul>
        <li><a href="index.php">HOME</a></li>
        <li><a href="admin_login.php">ADMIN LOGIN</a></li>
        <li><a href="patient_login.php">PATIENT LOGIN</a></li>
    </ul>

    <div class="login-container">
        <h2>Patient Login</h2>

        <?php if ($error != ""): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Login">
        </form>

        <div class="register">
            <p>Don't have an account?</p>
            <a href="patient_register.php">Register here</a>
        </div>
    </div>

    <div class="footer">Developer: KJ Software Solutions</div>

</body>
</html>
