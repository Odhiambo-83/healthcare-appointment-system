<?php
session_start();
include 'connection.php';

// Protect page: doctor must be logged in
if (!isset($_SESSION['doctor'])) {
    header("Location: doctors_login.php");
    exit();
}

$doctor_name = $_SESSION['doctor_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard | Healthcare System</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #e6f7f7; 
            margin: 0;
            padding: 0;
        }
        .header {
            background: #006666; 
            padding: 15px; 
            color: white; 
            text-align: center;
            font-size: 26px;
        }
        .container {
            width: 80%;
            margin: 40px auto;
            text-align: center;
        }
        .welcome {
            font-size: 22px;
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            margin: 10px;
            background: #006666;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 18px;
        }
        .button:hover {
            background: #00cccc;
            color: black;
        }
    </style>
</head>
<body>

<div class="header">
    Doctor Dashboard
</div>

<div class="container">

    <p class="welcome">Welcome, <strong><?= htmlspecialchars($doctor_name) ?></strong>!</p>

    <!-- Dashboard Menu Options -->
    <a class="button" href="doctor_profile.php">My Profile</a>
    <a class="button" href="view_patients.php">Patient List</a>
    <a class="button" href="view_appointments.php">Appointments</a>
    <a class="button" href="doctor_logout.php">Logout</a>

</div>

</body>
</html>
