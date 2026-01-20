<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_username = $_SESSION['admin'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | Healthcare System</title>

    <style>
        body {
            margin: 0;
            font-family: Verdana, sans-serif;
            background-color: #f4f6f8;
        }

        /* Header */
        header {
            background-color: #006666;
            color: white;
            padding: 20px;
            text-align: center;
        }

        /* Navigation */
        ul.nav {
            list-style: none;
            margin: 0;
            padding: 0;
            background-color: #004d4d;
            overflow: hidden;
        }

        ul.nav li {
            float: left;
        }

        ul.nav li a {
            display: block;
            padding: 14px 22px;
            color: white;
            text-decoration: none;
            font-size: 15px;
        }

        ul.nav li a:hover {
            background-color: white;
            color: #006666;
        }

        /* Main Container */
        .container {
            width: 90%;
            margin: 30px auto;
        }

        /* Welcome Section */
        .welcome-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .welcome-box h2 {
            color: #006666;
            margin-top: 0;
        }

        /* Dashboard Cards */
        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            min-width: 250px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card h3 {
            margin: 0;
            color: #006666;
            font-size: 22px;
        }

        .card p {
            font-size: 16px;
            color: #555;
        }

        .card a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: white;
            background: #006666;
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 14px;
        }

        .card a:hover {
            background: #009999;
        }

        /* Logout */
        .logout {
            text-align: right;
            margin-bottom: 15px;
        }

        .logout a {
            text-decoration: none;
            color: #006666;
            font-weight: bold;
        }

        .logout a:hover {
            color: #009999;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 15px;
            background: #004d4d;
            color: white;
            margin-top: 40px;
        }
    </style>
</head>

<body>

<header>
    <h1>Healthcare System – Admin Dashboard</h1>
</header>

<ul class="nav">
    <li><a href="admin_dashboard.php">Dashboard</a></li>
    <li><a href="manage_patients.php">Manage Patients</a></li>
    <li><a href="manage_doctors.php">Manage Doctors</a></li>
    <li><a href="manage_appointments.php">Manage Appointments</a></li>
    <li><a href="admin_profile.php">Profile</a></li>
</ul>

<div class="container">

    <div class="logout">
        <a href="admin_logout.php">Logout</a>
    </div>

    <div class="welcome-box">
        <h2>Welcome, <?php echo htmlspecialchars($admin_username); ?> 👋</h2>
        <p>
            This is your administrator control panel. From here, you can manage
            doctors, patients, appointments, and system records securely.
        </p>
    </div>

    <div class="cards">

        <div class="card">
            <h3>Patients</h3>
            <p>View, add, update, and manage registered patients.</p>
            <a href="manage_patients.php">Manage Patients</a>
        </div>

        <div class="card">
            <h3>Doctors</h3>
            <p>Manage doctor profiles, availability, and records.</p>
            <a href="manage_doctors.php">Manage Doctors</a>
        </div>

        <div class="card">
            <h3>Appointments</h3>
            <p>View and manage all patient appointments.</p>
            <a href="manage_appointments.php">Manage Appointments</a>
        </div>

    </div>

</div>

<footer>
    &copy; <?php echo date("Y"); ?> Healthcare Appointment System | Admin Panel
</footer>

</body>
</html>
