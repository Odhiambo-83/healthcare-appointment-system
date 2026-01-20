<?php
// doctors.php

// Database configuration
$host = "localhost";
$dbname = "health_system"; // your database name
$username = "root";        // MySQL username
$password = "";            // MySQL password

// Create connection using PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch doctors from 'doctors' table
try {
    $stmt = $pdo->prepare("SELECT doctor_id, full_name, specialization, email, phone FROM doctors");
    $stmt->execute();
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctors - HealthCare Appointment System</title>
    <style>
        body { margin: 0; background: #f2f2f2; font-family: Verdana, sans-serif; }

        h1 {
            background-color: rgba(0,102,102,0.95);
            color: white;
            margin: -10px -10px 0 -10px;
            padding: 15px;
            font-size: 55px;
            text-align: center;
            font-family: "Times New Roman";
        }

        ul {
            list-style: none;
            background-color: rgba(0,102,102,0.95);
            margin: 0;
            padding: 0;
            overflow: hidden;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        li { float: left; }

        li a {
            display: block;
            color: white;
            padding: 14px 25px;
            text-decoration: none;
            text-align: center;
            font-size: 18px;
        }

        li a:hover { background: white; color: #006666; }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 40px auto;
            background: #fff;
            box-shadow: 0 10px 20px rgba(0,0,0,0.19);
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: rgba(0,102,102,0.95);
            color: white;
            font-size: 20px;
        }

        tr:hover { background-color: #f1f1f1; }

        .login-btn {
            background-color: teal;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .login-btn:hover { background-color: #006666; }

        .footer {
            background-color: rgba(0,102,102,0.95);
            padding: 20px;
            color: #D6FEFF;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<h1>HEALTH<span style="color:#e6b800;">CARE</span> DOCTORS</h1>

<ul>
    <li><a href="index.php">HOME</a></li>
    <li><a href="admin_login.php">ADMIN LOGIN</a></li>
    <li><a href="patient_login.php">PATIENT LOGIN</a></li>
    <li><a href="#services">OUR SERVICES</a></li>
    <li><a href="doctors.php">DOCTORS</a></li>
    <li style="float:right;"><a href="#contact">CONTACT</a></li>
</ul>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Specialization</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Login</th>
    </tr>
    <?php foreach ($doctors as $doctor): ?>
    <tr>
        <td><?php echo htmlspecialchars($doctor['doctor_id']); ?></td>
        <td><?php echo htmlspecialchars($doctor['full_name']); ?></td>
        <td><?php echo htmlspecialchars($doctor['specialization']); ?></td>
        <td><?php echo htmlspecialchars($doctor['email']); ?></td>
        <td><?php echo htmlspecialchars($doctor['phone']); ?></td>
        <td>
            <a class="login-btn" href="doctor_login.php?email=<?php echo urlencode($doctor['email']); ?>">Login</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<div id="contact" class="footer">
    <h2>Contact Us!</h2>
    <h3>Developer: KJ Software Solutions</h3>
</div>

</body>
</html>
