<?php
session_start();
include 'connection.php';

// Protect page: doctor must be logged in
if (!isset($_SESSION['doctor'])) {
    header("Location: doctors_login.php");
    exit();
}

$doctor_name = $_SESSION['doctor_name'];

// Fetch all patients
$result = $conn->query("SELECT * FROM patients ORDER BY patient_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient List | Healthcare System</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        h1 { text-align: center; color: #006666; }
        table { width: 90%; margin: 20px auto; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #006666; color: white; }
        .top-bar { width: 90%; margin: 10px auto; text-align: right; }
        a.button { text-decoration: none; padding: 6px 12px; background-color: #006666; color: white; border-radius: 4px; }
        a.button:hover { background-color: #00cccc; color: black; }
    </style>
</head>
<body>

<h1>Patient List</h1>

<div class="top-bar">
    <a class="button" href="doctor_dashboard.php">Back to Dashboard</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Created At</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['patient_id'] ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No patients found.</td>
        </tr>
    <?php endif; ?>

</table>

</body>
</html>
