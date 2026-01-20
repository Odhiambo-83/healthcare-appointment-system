<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['doctor'])) {
    header("Location: doctors_login.php");
    exit();
}

$doctor_id = $_SESSION['doctor'];

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

<table>
    <tr>
        <th>ID</th>
        <th>Patient Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Date & Time</th>
        <th>Status</th>
    </tr>
    <?php if($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['appointment_id'] ?></td>
            <td><?= htmlspecialchars($row['patient_name']) ?></td>
            <td><?= htmlspecialchars($row['patient_email']) ?></td>
            <td><?= htmlspecialchars($row['patient_phone']) ?></td>
            <td><?= $row['appointment_date'] ?></td>
            <td><?= ucfirst($row['status']) ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="6">No approved appointments found.</td></tr>
    <?php endif; ?>
</table>
