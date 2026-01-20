<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Approve or reject appointment
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE appointments SET status='approved' WHERE appointment_id=$id");
}
if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    $conn->query("UPDATE appointments SET status='rejected' WHERE appointment_id=$id");
}

$appointments = $conn->query("
    SELECT a.appointment_id, a.appointment_date, a.status, 
           p.full_name AS patient_name, d.full_name AS doctor_name
    FROM appointments a
    JOIN patients p ON a.patient_id = p.patient_id
    JOIN doctors d ON a.doctor_id = d.doctor_id
    ORDER BY a.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments</title>
    <style>
        body { font-family: Verdana; background:#f2f2f2; margin:0; }
        h1 { text-align:center; color:#006666; }
        table { width:90%; margin:20px auto; border-collapse:collapse; background:white; }
        th, td { border:1px solid #ccc; padding:10px; text-align:center; }
        th { background:#006666; color:white; }
        a.button { text-decoration:none; padding:5px 10px; background:#006666; color:white; border-radius:5px; }
        a.button:hover { background:#00cccc; color:black; }
    </style>
</head>
<body>
<h1>Manage Appointments</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Patient</th>
        <th>Doctor</th>
        <th>Date & Time</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $appointments->fetch_assoc()): ?>
        <tr>
            <td><?= $row['appointment_id'] ?></td>
            <td><?= htmlspecialchars($row['patient_name']) ?></td>
            <td><?= htmlspecialchars($row['doctor_name']) ?></td>
            <td><?= $row['appointment_date'] ?></td>
            <td><?= ucfirst($row['status']) ?></td>
            <td>
                <?php if($row['status'] == 'pending'): ?>
                    <a class="button" href="?approve=<?= $row['appointment_id'] ?>">Approve</a>
                    <a class="button" href="?reject=<?= $row['appointment_id'] ?>">Reject</a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
