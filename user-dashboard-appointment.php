<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();

    if (isset($_COOKIE['user_username'])) {
        $title = 'User Appointments';
        include './includes/header.php';
        include './includes/user-dashboard-sidebar.php';
        include './db/db.php';
    } else {
        header("Location: ./user-login");
        exit();
    }
    ?>

    <style>
        .navbar {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            z-index: 4;
        }

        .alert-container {
            position: absolute;
            left: 240px;
            right: 0;
            top: 65px;
            margin-left: auto;
            margin-right: auto;
            user-select: none;
        }

        .alert-container button {
            border-left: 1px #a3cfbb solid;
            border-radius: 0;
        }

        .alert-container button:focus {
            box-shadow: none;
        }

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

        .doctor .doctor-specialization {
            text-transform: uppercase;
        }

        .star {
            margin-bottom: 5px;
        }

        .doctor #join-appointment {
            margin-top: 10px;
            background-color: #0a8aca;
        }

        .doctor #join-appointment:hover,
        .doctor #join-appointment:active {
            background-color: #056ea2;
        }

        .stars-outer {
            display: inline-block;
            position: relative;
            font-family: FontAwesome;
        }

        .stars-outer::before {
            content: "\f006 \f006 \f006 \f006 \f006";
        }

        .stars-inner {
            position: absolute;
            top: 0;
            left: 0;
            white-space: nowrap;
            overflow: hidden;
            width: 0;
            font-family: FontAwesome;
        }

        .stars-inner::before {
            content: "\f005 \f005 \f005 \f005 \f005";
            color: #f8ce0b;
        }
    </style>
</head>

<body>

    <?php

    if (isset($_GET['success'])) {
        if ($_GET['success'] == 'check-email') { ?>

            <div class="alert-container" style="width: 460px;" id="mobile-alert-container">
                <div class="alert alert-success alert-dismissible fade show">
                    <strong>Appointment Confirmed!</strong> &nbsp;Please check your email
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <div class="dashboard">
        <h1 class="heading">appointment details</h1>

        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item" id="past-container">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        <strong>PAST</strong>
                    </button>
                </h2>
                <?php $c = 0; ?>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="doctor-container">
                            <?php

                            $sql = "SELECT * FROM `appointment` WHERE `user` = '" . $_COOKIE['user_username'] . "' AND `appointment_date` < '" . date('Y-m-d') . "' OR `start_date_time` < '" . date('Y-m-d H:i:s') . "' ORDER BY `appointment_date` DESC, `start_date_time` DESC";

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) == 0) { ?>

                                <h5 style="color: #ed2020; text-align:center; margin-top:20px">No Appointments were scheduled in the past!</h5>

                                <?php

                            } else {

                                while ($row = mysqli_fetch_assoc($result)) {

                                    $sql1 = "SELECT * FROM `doctor-login` WHERE `username` = '" . $row['doctor'] . "'";
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
                                            <span class="doctor-qualification"><?php echo $row1['qualification'] ?></span> </br>
                                            <span class="appointment-date"><strong>Date: </strong><?php echo date("d-m-Y", strtotime($row['appointment_date'])) ?></span></br>
                                            <span class="appointment-date"><strong>Time: </strong><?php echo $row2['time'] ?></span></br>
                                        </div>
                                        <input type="hidden" value="<?php echo $row1['username'] . "-" . $c; ?>" class="username">
                                        <div class="book <?php echo $row1['username'] . "-" . $c; ?>">
                                            <?php $c++; ?>
                                            <div class="star">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                            </div>
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

                            $sql = "SELECT * FROM `appointment` WHERE `user` = '" . $_COOKIE['user_username'] . "' AND `appointment_date` = '" . date('Y-m-d') . "' AND `start_date_time` > '" . date('Y-m-d H:i:s') . "' ORDER BY `start_date_time`";

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) == 0) { ?>

                                <h5 style="color: #ed2020; text-align:center; margin-top:20px">No Appointments are scheduled today!</h5>

                                <?php

                            } else {

                                while ($row = mysqli_fetch_assoc($result)) {

                                    $sql1 = "SELECT * FROM `doctor-login` WHERE `username` = '" . $row['doctor'] . "'";
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
                                            <span class="doctor-qualification"><?php echo $row1['qualification'] ?></span> </br>
                                            <span class="appointment-date"><strong>Date: </strong><?php echo date("d-m-Y", strtotime($row['appointment_date'])) ?></span></br>
                                            <span class="appointment-date"><strong>Time: </strong><?php echo $row2['time'] ?></span></br>
                                        </div>
                                        <input type="hidden" value="<?php echo $row1['username'] . "-" . $c; ?>" class="username">
                                        <div class="book <?php echo $row1['username'] . "-" . $c; ?>">
                                            <div class="star">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                            </div>
                                            <?php

                                            $c++;

                                            if ($row1['available'] == 1) {
                                            ?>
                                                <span class="availability" style="color: #03861d;"><i class="fa-solid fa-circle-check"></i>&nbsp; Available</span>
                                            <?php
                                            } else {
                                            ?>
                                                <span class="availability" style="color: #ed2020;"><i class="fa-solid fa-circle-xmark"></i>&nbsp; Unavailable</span>
                                            <?php
                                            }
                                            ?>
                                            </br>
                                            <button class="btn btn-primary" id="join-appointment" <?php if ($row1['available'] == 0)  echo "disabled";  ?> onclick="window.open('<?php echo $row['join_url'] ?>', '_blank'); " ;>JOIN MEETING</button>
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

                            $sql = "SELECT * FROM `appointment` WHERE `user` = '" . $_COOKIE['user_username'] . "' AND `appointment_date` > '" . date('Y-m-d') . "' AND `start_date_time` > '" . date('Y-m-d H:i:s') . "' ORDER BY `start_date_time`";

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) == 0) { ?>

                                <h5 style="color: #ed2020; text-align:center; margin-top:20px">No Appointments are scheduled today!</h5>

                                <?php

                            } else {

                                while ($row = mysqli_fetch_assoc($result)) {

                                    $sql1 = "SELECT * FROM `doctor-login` WHERE `username` = '" . $row['doctor'] . "'";
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
                                            <span class="doctor-qualification"><?php echo $row1['qualification'] ?></span> </br>
                                            <span class="appointment-date"><strong>Date: </strong><?php echo date("d-m-Y", strtotime($row['appointment_date'])) ?></span></br>
                                            <span class="appointment-date"><strong>Time: </strong><?php echo $row2['time'] ?></span></br>
                                        </div>
                                        <input type="hidden" value="<?php echo $row1['username'] . "-" . $c; ?>" class="username">
                                        <div class="book <?php echo $row1['username'] . "-" . $c; ?>">
                                            <div class="star">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                            </div>
                                            <?php

                                            $c++;

                                            if ($row1['available'] == 1) {
                                            ?>
                                                <span class="availability" style="color: #03861d;"><i class="fa-solid fa-circle-check"></i>&nbsp; Available</span>
                                            <?php
                                            } else {
                                            ?>
                                                <span class="availability" style="color: #ed2020;"><i class="fa-solid fa-circle-xmark"></i>&nbsp; Unavailable</span>
                                            <?php
                                            }
                                            ?>
                                            </br>
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

    <script>
        username_inputs = document.getElementsByClassName("username");

        let usernames = [];

        for (let i = 0; i < username_inputs.length; i++) {
            usernames.push(username_inputs[i].value);
        }

        console.log(usernames)

        var values = [];
        for (i = 0; i < usernames.length; i++) {
            var precision = 100; // 2 decimals
            var randomnum = Math.floor(Math.random() * (5 * precision - 1 * precision) + 1 * precision) / (1 * precision);

            values.push(randomnum);
        }


        // var values = [2.54, 2.83, 2.35, 2.72, 4.88, 4.56, 4.49, 2.32, 4.47, 4.24, 2.66, 2.76, 3.51, 3.51, 3.09, 2.17, 2.57, 2.74];
        var ratings = {};
        usernames.forEach((key, i) => ratings[key] = values[i]);

        console.log(ratings)

        const starTotal = 5;

        for (const rating in ratings) {
            console.log(ratings[rating], rating);
            const starPercentage = `${(ratings[rating] / starTotal) * 100}%`;
            document.querySelector(`.${rating} .star .stars-inner`).style.width = starPercentage;
        }
    </script>
</body>

</html>