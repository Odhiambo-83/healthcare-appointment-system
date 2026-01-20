<?php
session_start();
include 'connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle deletion
if (isset($_GET['delete'])) {
    $doctor_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM doctors WHERE doctor_id = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_Doctors.php");
    exit();
}

// Fetch all doctors
$result = $conn->query("SELECT * FROM doctors ORDER BY doctor_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Doctors | Healthcare System</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        h1 { text-align: center; color: #006666; }
        table { width: 90%; margin: 20px auto; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #006666; color: white; }
        a.button { text-decoration: none; padding: 6px 12px; background-color: #006666; color: white; border-radius: 4px; }
        a.button:hover { background-color: #00cccc; color: black; }
        .top-bar { width: 90%; margin: 10px auto; text-align: right; }
    </style>
</head>
<body>

<h1>Manage Doctors</h1>

<div class="top-bar">
    <a class="button" href="add_Doctor.php">Add New Doctor</a>
    <a class="button" href="admin_dashboard.php">Back to Dashboard</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Specialization</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['doctor_id'] ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['specialization']) ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <a class="button" href="edit_Doctor.php?id=<?= $row['doctor_id'] ?>">Edit</a>
                <a class="button" href="manage_Doctors.php?delete=<?= $row['doctor_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="7">No doctors found.</td>
        </tr>
    <?php endif; ?>

</table>

</body>
</html>
