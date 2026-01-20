<?php
session_start();
include 'connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $specialization = trim($_POST['specialization']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($full_name && $email && $phone && $specialization && $password && $confirm_password) {
        if ($password !== $confirm_password) {
            $message = "Passwords do not match!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into database
            $stmt = $conn->prepare("INSERT INTO doctors (full_name, email, phone, specialization, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $full_name, $email, $phone, $specialization, $hashed_password);

            if ($stmt->execute()) {
                $message = "Doctor added successfully!";
            } else {
                $message = "Error: Could not add doctor. Email may already exist.";
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
    <title>Add Doctor | Healthcare System</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        h1 { text-align: center; color: #006666; }
        form { width: 40%; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        button { margin-top: 15px; padding: 10px 15px; background-color: #006666; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #00cccc; color: black; }
        .message { text-align: center; color: green; font-weight: bold; }
        .error { text-align: center; color: red; font-weight: bold; }
        .top-bar { width: 40%; margin: 10px auto; text-align: right; }
        a.button { text-decoration: none; padding: 8px 12px; background-color: #006666; color: white; border-radius: 4px; }
        a.button:hover { background-color: #00cccc; color: black; }
    </style>
</head>
<body>

<h1>Add New Doctor</h1>

<div class="top-bar">
    <a class="button" href="manage_Doctors.php">Back</a>
</div>

<?php if ($message): ?>
    <p class="<?= strpos($message, 'Error') !== false || strpos($message, 'Passwords') !== false ? 'error' : 'message' ?>"><?= $message ?></p>
<?php endif; ?>

<form method="POST" action="">
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

    <button type="submit">Add Doctor</button>
</form>

</body>
</html>
