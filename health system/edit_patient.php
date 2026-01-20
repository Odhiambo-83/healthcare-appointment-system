<?php
session_start();
include 'connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if patient id is passed
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid patient ID!");
}

$patient_id = intval($_GET['id']);

// Fetch patient details
$stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Patient not found!");
}

$patient = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname   = trim($_POST['full_name']);
    $email      = trim($_POST['email']);
    $phone      = trim($_POST['phone']);
    $password   = $_POST['password'];

    if (!empty($password)) {
        // Update with password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("
            UPDATE patients 
            SET full_name=?, email=?, phone=?, password=? 
            WHERE patient_id=?
        ");
        $stmt->bind_param("ssssi", $fullname, $email, $phone, $hashed_password, $patient_id);

    } else {
        // Update without changing password
        $stmt = $conn->prepare("
            UPDATE patients 
            SET full_name=?, email=?, phone=? 
            WHERE patient_id=?
        ");
        $stmt->bind_param("sssi", $fullname, $email, $phone, $patient_id);
    }

    if ($stmt->execute()) {
        header("Location: manage_patients.php?updated=1");
        exit();
    } else {
        echo "Error updating patient: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Patient</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; }
        .container {
            width: 50%; margin: 50px auto; background: #fff; padding: 20px;
            border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        input {
            width: 100%; padding: 12px; margin: 8px 0;
            border: 1px solid #ccc; border-radius: 4px;
        }
        button {
            background: #006666; color: #fff; padding: 12px; border: none;
            width: 100%; border-radius: 4px; cursor: pointer;
        }
        button:hover { background: #00cccc; color: black; }
        h2 { color: #006666; }
        a { text-decoration: none; color: #006666; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Patient Details</h2>

    <form action="" method="POST">

        <label>Full Name:</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($patient['full_name']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($patient['email']) ?>" required>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($patient['phone']) ?>" required>

        <label>New Password (leave blank to keep current):</label>
        <input type="password" name="password">

        <button type="submit">Update Patient</button>
    </form>

    <br>
    <a href="manage_patients.php">← Back to Manage Patients</a>
</div>

</body>
</html>
