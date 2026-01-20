<?php
session_start();
include 'connection.php';

// Redirect if not logged in
if (!isset($_SESSION['patient'])) {
    header("Location: patient_login.php");
    exit();
}

// Fetch patient info
$email = $_SESSION['patient'];
$stmt = $conn->prepare("SELECT * FROM patients WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$patient = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch all doctors for display inside dashboard
$doctors = $conn->query("SELECT * FROM doctors ORDER BY full_name ASC");

// Fetch appointments
$stmt2 = $conn->prepare("SELECT * FROM appointment WHERE email = ? ORDER BY created_at DESC");
$stmt2->bind_param("s", $email);
$stmt2->execute();
$appointments = $stmt2->get_result();
$stmt2->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard | Healthcare System</title>
    <style>
        body { margin: 0; font-family: Verdana, sans-serif; background: #e8f6f6; }
        h1 { background-color: #006666; color: white; margin: 0; padding: 20px; text-align: center; }

        /* MENU */
        ul { list-style: none; background-color: #006666; margin: 0; padding: 0; overflow: hidden; }
        li { float: left; }
        li a { display: block; color: white; padding: 15px 25px; text-decoration: none; font-size: 18px; }
        li a:hover { background: #00cccc; color: #003333; }

        .container { width: 90%; margin: 30px auto; padding: 25px; background: white;
            border-radius: 10px; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; border-bottom: 1px solid #ccc; text-align: center; }
        th { background-color: #006666; color: white; }

        .btn { padding: 8px 12px; border-radius: 5px; text-decoration: none; color: white; }
        .btn-book { background-color: #006666; }
        .btn-logout { background-color: red; }

        .footer { background-color: #006666; padding: 20px; text-align: center;
            color: #D6FEFF; margin-top: 40px; }
    </style>
</head>
<body>

    <h1>Patient Dashboard</h1>

    <ul>
        <li><a href="#home">Dashboard</a></li>
        <li><a href="book_appointment.php">Book Appointment</a></li>
        <li><a href="#doctors">Doctors</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <div class="container" id="home">
        <h2>Welcome, <?= htmlspecialchars($patient['full_name']) ?>!</h2>
        <p><strong>Email:</strong> <?= htmlspecialchars($patient['email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($patient['phone']) ?></p>

        <h3>Your Appointments</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>

            <?php if ($appointments->num_rows > 0): ?>
                <?php while ($row = $appointments->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['appointment_id'] ?></td>
                    <td><?= htmlspecialchars($row['doctor']) ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['time']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No appointments found.</td></tr>
            <?php endif; ?>
        </table>

        <br>
        <a href="book_appointment.php" class="btn btn-book">Book New Appointment</a>
        <a href="logout.php" class="btn btn-logout">Logout</a>
    </div>

    <div class="container" id="doctors">
        <h2>Available Doctors</h2>

        <table>
            <tr>
                <th>Name</th>
                <th>Specialization</th>
               
                <th>Phone</th>
                <th>Email</th>
                <th>Action</th>
            </tr>

         <?php if ($doctors->num_rows > 0): ?>
    <?php while ($doc = $doctors->fetch_assoc()): ?>

        <?php
        // Safe handling for missing or null experience field
        $experience = "";
        if (isset($doc['experience']) && $doc['experience'] !== "") {
            $experience = $doc['experience'] . " years";
        } else {
            // Fall back to qualification field if available
            if (isset($doc['qualification'])) {
                $experience = $doc['qualification'];
            } else {
                $experience = "Not specified";
            }
        }
        ?>

        <tr>
            <td><?= htmlspecialchars($doc['full_name']) ?></td>
            <td><?= htmlspecialchars($doc['specialization']) ?></td>
            <td><?= htmlspecialchars($doc['phone']) ?></td>
            <td><?= htmlspecialchars($doc['email']) ?></td>
            <td>
                <a class="btn btn-book" href="book_appointment.php?doctor=<?= urlencode($doc['full_name']) ?>">
                    Book
                </a>
            </td>
        </tr>

    <?php endwhile; ?>
<?php else: ?>
    <tr><td colspan="6">No doctors available.</td></tr>
<?php endif; ?>

        </table>
    </div>

    <div class="footer">
        Developer: KJ Software Solutions
    </div>

</body>
</html>

<?php $conn->close(); ?>
