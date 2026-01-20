<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['patient'])) {
    header("Location: patient_login.php");
    exit();
}

// Get patient_id
$email = $_SESSION['patient'];
$stmt = $conn->prepare("SELECT patient_id, full_name FROM patients WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
$patient = $res->fetch_assoc();
$patient_id = $patient['patient_id'];
$patient_name = $patient['full_name'];
$stmt->close();

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = intval($_POST['doctor_id']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = trim($_POST['message']);
    $appointment_date = $date . ' ' . $time;
    $status = 'Pending';

    if (!$doctor_id || !$date || !$time) {
        $error = "Fill all required fields";
    } else {
        $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, status, message) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iisss", $patient_id, $doctor_id, $appointment_date, $status, $message);
        if ($stmt->execute()) {
            $success = "Appointment booked successfully. Waiting for approval.";
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment | Healthcare System</title>
    <style>
        body {
            font-family: 'Verdana', sans-serif;
            background: #e8f6f6;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #006666;
            color: white;
            padding: 20px;
            text-align: center;
            margin: 0 0 30px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .container {
            max-width: 600px;
            margin: 0 auto 50px auto;
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }
        select, input[type="date"], input[type="time"], textarea {
            width: 100%;
            padding: 12px 15px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s, box-shadow 0.3s;
        }
        select:focus, input:focus, textarea:focus {
            border-color: #006666;
            box-shadow: 0 0 5px rgba(0,102,102,0.3);
            outline: none;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 14px;
            width: 100%;
            background-color: #006666;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #00cccc;
            color: black;
        }
        .success, .error {
            text-align: center;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-weight: bold;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<h1>Book an Appointment</h1>
<div class="container">
    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Select Doctor</label>
        <select name="doctor_id" required>
            <option value="">-- Choose Doctor --</option>
            <?php
            $res = $conn->query("SELECT doctor_id, full_name, specialization FROM doctors");
            while($d = $res->fetch_assoc()) {
                echo "<option value='{$d['doctor_id']}'>{$d['full_name']} ({$d['specialization']})</option>";
            }
            ?>
        </select>

        <label>Date</label>
        <input type="date" name="date" required>

        <label>Time</label>
        <input type="time" name="time" required>

        <label>Message (optional)</label>
        <textarea name="message"></textarea>

        <input type="submit" value="Book Appointment">
    </form>
</div>

</body>
</html>
