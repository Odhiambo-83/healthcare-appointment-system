<?php
// doctor_login.php
session_start();

// Database configuration
$host = "localhost";
$dbname = "health_system";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM doctors WHERE email = ?");
    $stmt->execute([$email]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($doctor && password_verify($password, $doctor['password'])) {
        $_SESSION['doctor_id'] = $doctor['doctor_id'];
        $_SESSION['doctor_name'] = $doctor['full_name'];
        header("Location: doctor_dashboard.php");
        exit;
    } else {
        $message = "Invalid email or password!";
    }
}

// Pre-fill email if passed in URL
$prefill_email = isset($_GET['email']) ? $_GET['email'] : "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Login</title>
    <style>
        body { font-family: Verdana, sans-serif; background: #f2f2f2; }
        .container {
            width: 400px; margin: 50px auto; padding: 20px; background: white;
            border-radius: 10px; box-shadow: 0 10px 20px rgba(0,0,0,0.19);
        }
        h2 { text-align: center; color: teal; }
        input[type=email], input[type=password] {
            width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;
        }
        input[type=submit] {
            background-color: teal; color: white; border: none; padding: 12px; width: 100%;
            font-size: 16px; border-radius: 5px; cursor: pointer;
        }
        input[type=submit]:hover { background-color: #006666; }
        .message { text-align: center; color: red; font-weight: bold; }
        .register-link {
            text-align: center; margin-top: 15px; font-size: 14px;
        }
        .register-link a {
            color: teal; text-decoration: none; font-weight: bold;
        }
        .register-link a:hover { color: #006666; }
    </style>
</head>
<body>

<div class="container">
    <h2>Doctor Login</h2>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <form method="post" action="">
        <input type="email" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($prefill_email); ?>">
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>

    <!-- Registration link -->
    <div class="register-link">
        <p>Don't have an account? <a href="doctor_register.php">Register here</a></p>
    </div>
</div>

</body>
</html>
