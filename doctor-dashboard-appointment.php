<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();

    if (isset($_COOKIE['doctor_username'])) {
        $title = 'Doctor Appointments';
        include './includes/header.php';
        include './includes/doctor-dashboard-sidebar.php';
        include './db/db.php';
    } else {
        header("Location: ./user-login");
        exit();
    }
    ?>

    <style>
        .dashboard {
            margin-left: 240px;
            margin-top: 65px;
        }

        .heading {
            text-align: center;
            padding-top: 47px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .accordion {
            width: 800px;
            margin: 0 auto;
            margin-bottom: 100px;

        }

        .accordion-header button {
            box-shadow: none;
            border: none;
            font-size: 1.1rem;
        }

        .accordion-header button:focus,
        .accordion-header button:active {
            box-shadow: none;
            border: none;
        }

        .accordion-body {
            /* text-align: center; */
            min-height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navbar {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            z-index: 3;
        }

        .doctor-container {
            margin: 0px auto 50px;
            flex-direction: column;
            width: 600px;
        }

        .doctor {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            margin-top: 40px;
            border: 1px #DDDDDD solid;
            padding: 10px;
            height: 140px;
        }

        .doctor .doctor-image img {
            height: 120px;
            margin-right: 20px;
        }

        .doctor .doctor-details {
            width: 200px;
            margin-right: 20px;
        }

        .availability {
            margin-top: 20px;
        }

        .doctor .doctor-name {
            color: #0a8aca;
            font-weight: 700;
        }

        .doctor .doctor-gender {
            text-transform: uppercase;
        }

        .star {
            margin-bottom: 5px;
        }

        .doctor #start-appointment {
            margin-top: 10px;
            background-color: #0a8aca;
        }

        .doctor #start-appointment:hover,
        .doctor #start-appointment:active {
            background-color: #056ea2;
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <h1 class="heading">appointment details</h1>

        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item" id="past-container">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        <strong>PAST</strong>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="doctor-container">
                            <?php

                            $sql = "SELECT * FROM `appointment` WHERE `doctor` = '" . $_COOKIE['doctor_username'] . "' AND `appointment_date` < '" . date('Y-m-d') . "' OR `start_date_time` < '" . date('Y-m-d H:i:s') . "' ORDER BY `appointment_date` DESC, `start_date_time` DESC";

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) == 0) { ?>

                                <h5 style="color: #ed2020; text-align:center; margin-top:20px">No Appointments were scheduled in the past!</h5>

                                <?php

                            } else {

                                while ($row = mysqli_fetch_assoc($result)) {

                                    $sql1 = "SELECT * FROM `user-login` WHERE `username` = '" . $row['user'] . "'";
                                    $result1 = mysqli_query($conn, $sql1);
                                    $row1 = mysqli_fetch_assoc($result1);


                                    $sql2 = "SELECT * FROM `time-slots` WHERE `slot` = '" . $row['appointment_time'] . "'";
                                    $result2 = mysqli_query($conn, $sql2);
                                    $row2 = mysqli_fetch_assoc($result2);

                                ?>
                                    <div class="doctor" style="user-select:none;">
                                        <div class="doctor-image">
                                            <img src="./assests/images/doctor-avatar.png">
                                        </div>
                                        <div class="doctor-details">
                                            <span class="doctor-name"><?php echo $row1['name'] ?></span> </br>
                                            <span class="doctor-gender"><?php echo $row1['gender'] ?></span> </br>
                                            <span class="appointment-date"><strong>Date: </strong><?php echo date("d-m-Y", strtotime($row['appointment_date'])) ?></span></br>
                                            <span class="appointment-date"><strong>Time: </strong><?php echo $row2['time'] ?></span></br>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item" id="today-container">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        <strong>TODAY</strong>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="doctor-container">
                            <?php

                            $sql = "SELECT * FROM `appointment` WHERE `doctor` = '" . $_COOKIE['doctor_username'] . "' AND `appointment_date` = '" . date('Y-m-d') . "' AND `start_date_time` > '" . date('Y-m-d H:i:s') . "' ORDER BY `start_date_time`";

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) == 0) { ?>

                                <h5 style="color: #ed2020; text-align:center; margin-top:20px">No Appointments are scheduled today!</h5>

                                <?php

                            } else {

                                while ($row = mysqli_fetch_assoc($result)) {

                                    $sql1 = "SELECT * FROM `user-login` WHERE `username` = '" . $row['user'] . "'";
                                    $result1 = mysqli_query($conn, $sql1);
                                    $row1 = mysqli_fetch_assoc($result1);


                                    $sql2 = "SELECT * FROM `time-slots` WHERE `slot` = '" . $row['appointment_time'] . "'";
                                    $result2 = mysqli_query($conn, $sql2);
                                    $row2 = mysqli_fetch_assoc($result2);

                                ?>
                                    <div class="doctor" style="user-select:none;">
                                        <div class="doctor-image">
                                            <img src="./assests/images/doctor-avatar.png">
                                        </div>
                                        <div class="doctor-details">
                                            <span class="doctor-name"><?php echo $row1['name'] ?></span> </br>
                                            <span class="doctor-gender"><?php echo $row1['gender'] ?></span> </br>
                                            <span class="appointment-date"><strong>Date: </strong><?php echo date("d-m-Y", strtotime($row['appointment_date'])) ?></span></br>
                                            <span class="appointment-date"><strong>Time: </strong><?php echo $row2['time'] ?></span></br>
                                        </div>
                                        <div class="book">

                                            <button class="btn btn-primary" id="start-appointment" onclick="window.open('<?php echo $row['start_url'] ?>', '_blank'); " ;>START MEETING</button>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="upcoming-container">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                        <strong>UPCOMING</strong>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="doctor-container">
                            <?php

                            $sql = "SELECT * FROM `appointment` WHERE `doctor` = '" . $_COOKIE['doctor_username'] . "' AND `appointment_date` > '" . date('Y-m-d') . "' AND `start_date_time` > '" . date('Y-m-d H:i:s') . "' ORDER BY `start_date_time`";

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) == 0) { ?>

                                <h5 style="color: #ed2020; text-align:center; margin-top:20px">No Appointments are scheduled today!</h5>

                                <?php

                            } else {

                                while ($row = mysqli_fetch_assoc($result)) {

                                    $sql1 = "SELECT * FROM `user-login` WHERE `username` = '" . $row['user'] . "'";
                                    $result1 = mysqli_query($conn, $sql1);
                                    $row1 = mysqli_fetch_assoc($result1);


                                    $sql2 = "SELECT * FROM `time-slots` WHERE `slot` = '" . $row['appointment_time'] . "'";
                                    $result2 = mysqli_query($conn, $sql2);
                                    $row2 = mysqli_fetch_assoc($result2);

                                ?>
                                    <div class="doctor" style="user-select:none;">
                                        <div class="doctor-image">
                                            <img src="./assests/images/doctor-avatar.png">
                                        </div>
                                        <div class="doctor-details">
                                            <span class="doctor-name"><?php echo $row1['name'] ?></span> </br>
                                            <span class="doctor-gender"><?php echo $row1['gender'] ?></span> </br>
                                            <span class="appointment-date"><strong>Date: </strong><?php echo date("d-m-Y", strtotime($row['appointment_date'])) ?></span></br>
                                            <span class="appointment-date"><strong>Time: </strong><?php echo $row2['time'] ?></span></br>
                                        </div>
                                        <div class="book">
                                            <button class="btn btn-primary" id="join-appointment" disabled>JOIN MEETING</button>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>