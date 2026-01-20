<?php
session_start();
include 'connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Validate ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid doctor ID.";
    exit();
}

$doctor_id = intval($_GET['id']);

// FETCH DOCTOR DETAILS
$stmt = $conn->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Doctor not found!";
    exit();
}

$doctor = $result->fetch_assoc();
$stmt->close();

// UPDATE DETAILS
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name     = $_POST['full_name'];
    $email         = $_POST['email'];
    $phone         = $_POST['phone'];
    $specialization = $_POST['specialization'];

    $stmt = $conn->prepare("UPDATE doctors SET full_name=?, email=?, phone=?, specialization=? WHERE doctor_id=?");
    $stmt->bind_param("ssssi", $full_name, $email, $phone, $specialization, $doctor_id);

    if ($stmt->execute()) {
        header("Location: manage_Doctors.php?updated=1");
        exit();
    } else {
        echo "Error updating doctor!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Doctor</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; }
        .container {
            width: 50%; margin: 50px auto; background: #fff; padding: 20px;
            border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        input, select {
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
    <h2>Edit Doctor Details</h2>

    <form action="" method="POST">

        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($doctor['full_name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($doctor['email']) ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($doctor['phone']) ?>" required>

        <label>Specialization</label>
        <input type="text" name="specialization" value="<?= htmlspecialchars($doctor['specialization']) ?>" required>

        <button type="submit">Update Doctor</button>
    </form>

    <br>
    <a href="manage_Doctors.php">← Back to Manage Doctors</a>
</div>

</body>
</html>
