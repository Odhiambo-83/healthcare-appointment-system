<?php
session_start();
include 'connection.php';

// Protect page: doctor must be logged in
if (!isset($_SESSION['doctor'])) {
    header("Location: doctors_login.php");
    exit();
}

$doctor_id = $_SESSION['doctor'];
$message = "";

// Fetch doctor details
$stmt = $conn->prepare("SELECT full_name, email, phone, specialization FROM doctors WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
$stmt->close();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $specialization = trim($_POST['specialization']);

    if ($full_name && $phone && $specialization) {
        $update_stmt = $conn->prepare("UPDATE doctors SET full_name = ?, phone = ?, specialization = ? WHERE doctor_id = ?");
        $update_stmt->bind_param("sssi", $full_name, $phone, $specialization, $doctor_id);

        if ($update_stmt->execute()) {
            $message = "Profile updated successfully!";
            // Refresh doctor data
            $doctor['full_name'] = $full_name;
            $doctor['phone'] = $phone;
            $doctor['specialization'] = $specialization;
            $_SESSION['doctor_name'] = $full_name; // update session name
        } else {
            $message = "Error updating profile: " . $update_stmt->error;
        }
        $update_stmt->close();
    } else {
        $message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile | Healthcare System</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef7f7; }
        h1 { text-align: center; color: #006666; }
        form { width: 40%; margin: 25px auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0px 0px 10px #ccc; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        button { margin-top: 20px; width: 100%; padding: 12px; background-color: #006666; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #00cccc; color: black; }
        .message { text-align: center; color: green; margin-bottom: 15px; }
        .top-bar { width: 40%; margin: 10px auto; text-align: right; }
        a.button { text-decoration: none; padding: 8px 12px; background-color: #006666; color: white; border-radius: 4px; }
        a.button:hover { background-color: #00cccc; color: black; }
        input[readonly] { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h1>My Profile</h1>

<div class="top-bar">
    <a class="button" href="doctor_dashboard.php">Back to Dashboard</a>
</div>

<form method="POST" action="">
    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <label>Full Name</label>
    <input type="text" name="full_name" value="<?= htmlspecialchars($doctor['full_name']) ?>" required>

    <label>Email (cannot be changed)</label>
    <input type="email" name="email" value="<?= htmlspecialchars($doctor['email']) ?>" readonly>

    <label>Phone</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($doctor['phone']) ?>" required>

    <label>Specialization</label>
    <input type="text" name="specialization" value="<?= htmlspecialchars($doctor['specialization']) ?>" required>

    <button type="submit">Update Profile</button>
</form>

</body>
</html>
