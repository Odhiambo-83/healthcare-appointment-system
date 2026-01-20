<!DOCTYPE html>
<html>
<head>
    <title>HealthCare Image Gallery</title>
    <style>
        body { margin: 0; background: #f2f2f2; font-family: Verdana, sans-serif; }

        /* Header */
        h1 {
            background-color: rgba(0,102,102,0.95);
            color: white;
            margin: -10px -10px 0 -10px;
            padding: 15px;
            font-size: 55px;
            text-align: center;
            font-family: "Times New Roman";
        }

        /* Navigation */
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

        /* Gallery Title */
        .r_room {
            color: #FFF;
            padding: 10px;
            font-size: 35px;
            text-align: center;
            text-shadow: 2px 2px black;
            background-color: rgba(0,102,102,0.95);
            width: 500px;
            margin: auto;
            border-radius: 40px;
        }

        /* Image Boxes */
        .basic_box {
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 20px 100px;
            padding: 30px;
            background: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.19);
        }

        .row { display: flex; flex-wrap: wrap; }
        .column {
            flex: 33.33%;
            padding: 5px;
            text-align: center;
        }

        img {
            width: 100%;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        img:hover {
            transform: scale(1.05);
        }

        /* Footer */
        .footer {
            background-color: rgba(0,102,102,0.95);
            padding: 20px;
        }
        .foot-text { color: #D6FEFF; text-align: left; }
    </style>
</head>
<body>

    <h1>HEALTH<span style="color:#e6b800;">CARE</span> IMAGE GALLERY</h1>

    <!-- Navigation -->
    <ul>
        <li><a href="index.php">HOME</a></li>
        <li><a href="admin_login.php">ADMIN LOGIN</a></li>
        <li><a href="patient_login.php">PATIENT LOGIN</a></li>
        <li><a href="doctors.php">DOCTORS</a></li>
        <li style="float:right;"><a href="#contact">CONTACT</a></li>
    </ul>

    <h2 class="r_room">OUR FACILITIES</h2>

    <!-- FIRST ROW -->
    <div class="row">
        <div class="column">
            <img src="images/1.png" alt="Facility 1">
        </div>
        <div class="column">
            <img src="images/2.png" alt="Facility 2">
        </div>
        <div class="column">
            <img src="images/3.png" alt="Facility 3">
        </div>
    </div>

    <!-- SECOND ROW -->
    <div class="row">
        <div class="column">
            <img src="images/4.png" alt="Doctors Team">
        </div>
        <div class="column">
            <img src="images/5.png" alt="Lab Technologist">
        </div>
        <div class="column">
            <img src="images/6.png" alt="Medical Technology">
        </div>
    </div>

    <!-- SERVICES -->
    <h2 class="r_room">OUR SERVICES</h2>
    <div class="basic_box">
        <div class="row">
            <div class="column">
                <img src="images/2.jpg" alt="General Consultation">
                <h3>General Consultation</h3>
            </div>
            <div class="column">
                <img src="images/3.jpg" alt="Full Body Checkup">
                <h3>Full Body Checkup</h3>
            </div>
            <div class="column">
                <img src="images/5.jpg" alt="Laboratory Services">
                <h3>Laboratory Services</h3>
            </div>
        </div>
    </div>

    <!-- ROOMS -->
    <h2 class="r_room">OUR ROOMS</h2>
    <div class="basic_box">
        <div class="row">
            <div class="column">
                <img src="images/1.jpg" alt="Room 1">
            </div>
            <div class="column">
                <img src="images/2.jpg" alt="Room 2">
            </div>
            <div class="column">
                <img src="images/3.jpg" alt="Room 3">
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div id="contact" class="footer">
        <hr>
        <h2 class="foot-text">Contact Us!</h2>
        <h3 class="foot-text">Developer: KJ Software Solutions</h3>
    </div>

</body>
</html>
