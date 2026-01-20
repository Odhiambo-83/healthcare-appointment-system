<!DOCTYPE html>
<html>
<head>
    <title>HealthCare Appointment System</title>

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

        li a:hover {
            background: white;
            color: #006666;
        }

        /* --- SLIDESHOW FIXED (NO CROPPING) --- */
        .slideshow-container {
            width: 100%;
            max-width: 1300px;
            margin: auto;
            position: relative;
            border-bottom: 4px solid #006666;
        }

        .mySlides { display: none; }

        .slideshow-container img {
            width: 100% !important;
            height: auto !important;           /* NO CROPPING */
            object-fit: contain !important;    /* FULL IMAGE ALWAYS VISIBLE */
            background: #000;                  /* padding for tall images */
        }

        .text {
            color: #fff;
            font-size: 30px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-shadow: 4px 4px black;
            text-align: center;
        }

        .dot {
            height: 15px;
            width: 15px;
            background-color: white;
            border-radius: 50%;
            display: inline-block;
            margin: 0 2px;
            transition: background-color 0.6s ease;
        }

        .active { background-color: #717171; }

        .fade { animation: fade 1.5s; }
        @keyframes fade { from { opacity: .4; } to { opacity: 1; } }

        /* CTA */
        .reserve_room {
            background-color: rgba(0,102,102,0.95);
            color: #fff;
            padding: 12px;
            font-size: 32px;
            width: 520px;
            margin: auto;
            text-align: center;
            border-radius: 50px;
            text-shadow: 2px 2px black;
            display: block;
            text-decoration: none;
        }

        .reserve_room:hover {
            background: #33cccc;
            color: #000;
        }

        /* Welcome Text */
        .welcome1 { text-align: center; font-size: 26px; font-family: "Courier New"; }
        .welcome2 { text-align: center; font-size: 23px; font-family: "Snell Roundhand"; color: teal; }

        /* Services */
        .r_room {
            background-color: rgba(0,102,102,0.95);
            color: #FFF;
            padding: 10px;
            font-size: 35px;
            text-align: center;
            text-shadow: 2px 2px black;
            border-radius: 40px;
            width: 500px;
            margin: auto;
        }

        .basic_box {
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 20px 220px;
            padding: 40px;
            background: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.19);
        }

        .row { display: flex; }
        .column {
            flex: 33.33%;
            padding: 12px;
            text-align: center;
        }

        /* SERVICE IMAGES — FIXED, FULLY VISIBLE */
        .column img {
            width: 100% !important;
            height: auto !important;         /* NO CROPPING */
            object-fit: contain !important;  /* FULL IMAGE */
            background: #000;
            border-radius: 8px;
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

    <h1>HEALTH<span style="color:#e6b800;">CARE</span> APPOINTMENT SYSTEM</h1>

    <ul>
        <li><a href="index.php">HOME</a></li>
        <li><a href="admin_login.php">ADMIN LOGIN</a></li>
        <li><a href="patient_login.php">PATIENT LOGIN</a></li>
        <li><a href="#services">OUR SERVICES</a></li>
        <li><a href="doctors.php">DOCTORS</a></li>
        <li style="float:right;"><a href="#contact">CONTACT</a></li>
    </ul>

    <!-- SLIDESHOW -->
    <div class="slideshow-container">
        <div class="mySlides fade">
            <img src="Images/1.png">
            <div class="text">Quality Healthcare You Can Trust</div>
        </div>

        <div class="mySlides fade">
            <img src="Images/2.png">
            <div class="text">Expert Doctors at Your Service</div>
        </div>

        <div class="mySlides fade">
            <img src="Images/6.png">
            <div class="text">Book Appointments Anytime</div>
        </div>
    </div>

    <br>
    <div style="text-align:center;">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>

    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");

            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            slideIndex++;
            if (slideIndex > slides.length) slideIndex = 1;

            for (let i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active");
            }

            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].classList.add("active");

            setTimeout(showSlides, 4500);
        }
    </script>

    <br><br>

    <a class="reserve_room" href="patient_login.php">BOOK AN APPOINTMENT</a>

    <h2 class="welcome1">Providing reliable medical care for you and your family.</h2>
    <h2 class="welcome2">We ensure comfort, convenience, and expert treatment.</h2>

    <h2 class="r_room" id="services">OUR SERVICES</h2>

    <div class="basic_box">
        <div class="row">
            <div class="column">
                <img src="Images/4.png" alt="Medical Team">
                <h3>Our Medical Team</h3>
            </div>

            <div class="column">
                <img src="Images/5.png" alt="Laboratory Services">
                <h3>Laboratory Services</h3>
            </div>

            <div class="column">
                <img src="Images/6.png" alt="Online Appointment System">
                <h3>Online Appointment System</h3>
            </div>
        </div>
    </div>

    <div id="contact" class="footer">
        <hr>
        <h2 class="foot-text">Contact Us!</h2>
        <h3 class="foot-text">Developer: KJ Software Solutions</h3>
    </div>

</body>
</html>
