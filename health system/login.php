<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "health_system";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// If login form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch doctor record
    $sql = "SELECT * FROM doctors WHERE username='$username' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $doctor = $result->fetch_assoc();

        // If password matches (use password_verify if hashed)
        if ($password == $doctor['password']) {

            // Save login session
            $_SESSION['doctor_id'] = $doctor['id'];
            $_SESSION['doctor_username'] = $doctor['username'];

            // Redirect to doctor dashboard
            header("Location: doctor_dashboard.php");
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Doctor not found!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Login</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: white;
            padding: 25px;
            width: 350px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.3);
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
        }
        button {
            width: 100%;
            padding: 12px;
            background: teal;
            border: none;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #005f5f;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Doctor Login</h2>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
