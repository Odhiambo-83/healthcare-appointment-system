<?php
session_start();
include 'connection.php';

// Protect page: doctor must be logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctors_login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch approved appointments for this doctor
$stmt = $conn->prepare("
    SELECT a.appointment_id, a.appointment_date, a.status,
           p.full_name AS patient_name, p.email AS patient_email, p.phone AS patient_phone
    FROM appointments a
    JOIN patients p ON a.patient_id = p.patient_id
    WHERE a.doctor_id = ? AND a.status = 'approved'
    ORDER BY a.appointment_date DESC
");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments | Healthcare System</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        h1 { text-align: center; color: #006666; }
        table { width: 95%; margin: 20px auto; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #006666; color: white; }
        .status { font-weight: bold; }
        .status.pending { color: orange; }
        .status.approved { color: green; }
        .status.cancelled { color: red; }
        .top-bar { width: 95%; margin: 10px auto; text-align: right; }
        a.button { text-decoration: none; padding: 6px 12px; background-color: #006666; color: white; border-radius: 4px; }
        a.button:hover { background-color: #00cccc; color: black; }
    </style>
</head>
<body>

<h1>My Appointments</h1>

<div class="top-bar">
    <a class="button" href="doctor_dashboard.php">Back to Dashboard</a>
</div>

<table>
    <tr>
        <th>Appointment ID</th>
        <th>Patient Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Date & Time</th>
        <th>Status</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['appointment_id'] ?></td>
            <td><?= htmlspecialchars($row['patient_name']) ?></td>
            <td><?= htmlspecialchars($row['patient_email']) ?></td>
            <td><?= htmlspecialchars($row['patient_phone']) ?></td>
            <td><?= htmlspecialchars($row['appointment_date']) ?></td>
            <td class="status <?= strtolower($row['status']) ?>"><?= ucfirst($row['status']) ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No approved appointments found.</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>
