<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();

    $title = 'Unified Healthcare Interface';
    include './includes/header.php'
    ?>

    <style>
        :root {
            --grey: #646264;
        }

        #hero-section {
            height: 100vh;
        }

        #center {
            background: url("./assests/images/center.jpg?t=<?php echo time(); ?>") no-repeat;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            height: 100vh;
            position: relative;
            text-align: center;
            color: white;
        }

        #center:before {
            content: "";
            background-color: #000;
            opacity: 0.7;
            width: 100%;
            height: 100%;
            z-index: 1;
            position: absolute;
            top: 0;
            left: 0;
        }

        .title h1,
        .title h2 {
            text-align: center;
            color: #fff;
            z-index: 2;
            text-transform: uppercase;
            text-align: center;
        }

        .title h1 {
            position: absolute;
            left: 16.5%;
            /* position: absolute;
            left: 0;
            right: 0; */
            top: 37%;
            margin-left: auto;
            margin-right: auto;
            font-size: 2.75rem;
        }

        .title h2 {
            position: absolute;
            left: 0;
            right: 0;
            top: 47%;
            margin-left: auto;
            margin-right: auto;
            font-size: 1.5rem;
        }

        .hero-button {
            cursor: pointer;
            text-align: center;
        }

        .hero-button a {
            position: absolute;
            left: 0;
            right: 0;
            top: 57%;
            margin-left: auto;
            margin-right: auto;
            width: max-content;
            font-size: 1.5rem;
            text-transform: uppercase;
            font-weight: 700;
            z-index: 2;
            padding: 6px 16px;
            border-radius: 40px;
            word-spacing: 3px;
            transition: all 0.3s ease;
            border: #404040 1px solid;
            background-color: #3aa592;
            color: #fff;
        }

        .hero-button a:hover {
            background-color: #fff;
            color: #3aa592;
            box-shadow: 0 0 10px 1px #3aa592;
        }

        #arrow {
            background-color: var(--grey);
            color: #fff;
            width: 50px;
            height: 50px;
            padding: 7px 16px;
            font-size: 1.5rem;
            border-radius: 50%;
            position: fixed;
            bottom: 6%;
            right: 3%;
            z-index: 5;
            cursor: pointer;
            transition: all 0.2s ease;
            display: none;
            font-family: inherit;
        }

        #arrow:hover {
            box-shadow: 0 0 30px 10px #64626484;
            color: #3b3b3b;
            background-color: #fff;
        }

        span.auto-type {
            color: #0fabd2;
        }

        .counter-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 100px;
            margin-top: 50px;
        }

        .counter-item {
            text-align: center;
            margin: 30px 50px;
        }

        #counter-section {
            color: #3b3a3b;
            text-transform: uppercase;
            padding-top: 120px;
            height: 100vh;
        }

        #counter-section h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-top: 10px;
            letter-spacing: 2px;
            word-spacing: 10px;
            font-weight: 700;
        }

        .counter-item h2 {
            font-size: 1.8rem;
            font-weight: 700;
        }

        #counter-section h3 {
            text-align: center;
            margin-top: 20px;
            font-weight: 400;
        }
    </style>
</head>


<body class="scrollbar">

    <section id="hero-section">
        <div id="center">
        </div>
        <div class="title">
            <h1>Welcome to <span class="auto-type"></span></h1>
            <h2>India's biggest portal in healthcare facility</h2>
        </div>

        <div class="hero-button">
            <a href="#counter-section">Get Started</a>
        </div>
    </section>

    <div id="arrow">
        <i class="fa-solid fa-arrow-up"></i>
    </div>


    <section id="counter-section">
        <div class="container">
            <h1 class="section-heading">We've connected</h1>
        </div>
        <div class="counter-container">
            <div class="counter-item">
                <i class="fas fa-user fa-3x" style="color:#0fabd2"></i>
                <h1 class="counter" data-target="7000">0</h1>
                <h2>Patients</h2>
            </div>
            <div class="counter-item">
                <i class="fas fa-user-doctor fa-3x" style="color:#3aa592"></i>
                <h1 class="counter" data-target="600">0</h1>
                <h2>Doctors</h2>
            </div>
            <div class="counter-item">
                <i class="fa-solid fa-hospital fa-3x" style="color:#ed2020"></i>
                <h1 class="counter" data-target="200">0</h1>
                <h2>Hospitals</h2>
            </div>
        </div>
        <div class="container">
            <h3 class="section-footer">and counting . . .</h3>
        </div>
    </section>




</body>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script src="./js/index.js"></script>

</html>


<?php
include './includes/footer.php'
?>