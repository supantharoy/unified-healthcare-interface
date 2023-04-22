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
            z-index: 1;
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

        .doctor .doctor-image {
            width: 120px;
            text-align: center;
        }

        .doctor .doctor-image img {
            height: 120px;
        }

        .doctor .doctor-details {
            width: 200px;
            margin-right: 20px;
            margin-left: 20px;
        }

        .doctor .book {
            text-align: center;
            width: 150px;
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

        .doctor .join-appointment {
            margin-top: 10px;
            background-color: #0a8aca;
        }

        .doctor .join-appointment:hover,
        .doctor .join-appointment:active {
            background-color: #056ea2;
        }

        .doctor .refund-button {
            margin-top: 10px;
            width: 120px;
        }

        .star {
            text-align: center;
            margin-bottom: 5px;
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

        .ratingValue {
            position: relative;
            display: block;
            text-align: center;
            font-size: 1rem;
            font-weight: 400;
        }

        .range {
            width: 100px;
            height: 10px;
            -webkit-appearance: none;
            background: #d8d8d8;
            outline: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: inset 0 0 5px #d8d8d8;
        }

        .range::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #0D6EFD;
            cursor: pointer;
            border: 1px solid #333;
            box-shadow: -407px 0 0 400px #0D6EFD;
        }

        .send-feedback {
            font-size: 0.8rem;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <?php

    if (isset($_SESSION['success']) && $_SESSION['success'] == 'check-email') { ?>

        <div class="alert-container" style="width: 420px;">
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Appointment Confirmed!</strong> &nbsp;Please check your email
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
            </div>
        </div>

    <?php
    } else if (isset($_SESSION['refund']) && $_SESSION['refund'] == 'initiated') { ?>

        <div class="alert-container" style="width: 360px;">
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Refund Initiated!</strong> &nbsp;Please check your email
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
            </div>
        </div>

    <?php }

    unset($_SESSION['success']);
    unset($_SESSION['refund']);
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
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="doctor-container">
                            <?php

                            $sql = "SELECT * FROM `appointment` WHERE `user` = '" . $_COOKIE['user_username'] . "' AND `cancelled` = 0 AND  `appointment_date` < '" . date('Y-m-d') . "' OR `start_date_time` < '" . date('Y-m-d H:i:s') . "' ORDER BY `appointment_date` DESC, `start_date_time` DESC";

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
                                            <span class="doctor-name"><?php echo $row1['name'] ?></span>
                                            <?php if ($row1['specialization'] == "other") { ?>
                                                <span class="doctor-specialization">(<?php echo $row1['other-s'] ?>)</span>
                                            <?php } else { ?>
                                                <span class="doctor-specialization">(<?php echo $row1['specialization'] ?>)</span>
                                            <?php } ?>
                                            </br>
                                            <span class="appointment-id"><strong>Appointment ID: </strong><?php echo $row['id'] ?></span>
                                            </br>
                                            <span class="appointment-date"><strong>Date: </strong><?php echo date("d-m-Y", strtotime($row['appointment_date'])) ?></span></br>
                                            <span class="appointment-date"><strong>Time: </strong><?php echo $row2['time'] ?></span></br>
                                        </div>
                                        <div class="book">
                                            <div class="star" id="<?php echo $row['id'] ?>">

                                                <?php if ($row['rating'] == 0) { ?>

                                                    <div>
                                                        <span id="<?php echo $row['id'] ?>-ratingValue" class="ratingValue">1 / 5</span>
                                                        <input class="range" type="range" value="1" id="<?php echo $row['id'] ?>-slider" min="1" max="5" onChange="rangeSlide(this.value, '<?php echo $row['id'] ?>-ratingValue')" onmousemove="rangeSlide(this.value, '<?php echo $row['id'] ?>-ratingValue')"></input>
                                                    </div>
                                                    <button class="btn btn-primary send-feedback" data-id="<?php echo $row['id'] ?>">SEND FEEDBACK</button>

                                                <?php } else { ?>

                                                    <div class="stars-outer">
                                                        <div class="stars-inner" style="width:<?php echo $row['rating'] / 5 * 100 ?>%"></div>
                                                    </div>
                                                <?php } ?>
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

                            $sql = "SELECT * FROM `appointment` WHERE `user` = '" . $_COOKIE['user_username'] . "' AND `cancelled` = 0 AND `appointment_date` = '" . date('Y-m-d') . "' ORDER BY `start_date_time`";

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
                                            <span class="doctor-name"><?php echo $row1['name'] ?></span>
                                            <?php if ($row1['specialization'] == "other") { ?>
                                                <span class="doctor-specialization">(<?php echo $row1['other-s'] ?>)</span>
                                            <?php } else { ?>
                                                <span class="doctor-specialization">(<?php echo $row1['specialization'] ?>)</span>
                                            <?php } ?>
                                            </br>
                                            <span class="appointment-id"><strong>Appointment ID: </strong><?php echo $row['id'] ?></span>
                                            </br>
                                            <span class="appointment-date"><strong>Date: </strong><?php echo date("d-m-Y", strtotime($row['appointment_date'])) ?></span></br>
                                            <span class="appointment-date"><strong>Time: </strong><?php echo $row2['time'] ?></span></br>
                                        </div>
                                        <div class="book">
                                            <div class="star">
                                                <div class="stars-outer">
                                                    <div class="stars-inner" style="width:<?php echo $row1['ratings'] / 5 * 100 ?>%"></div>
                                                </div>
                                            </div>
                                            <?php

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
                                            <button class="btn btn-primary join-appointment" <?php if ($row1['available'] == 0 ||  $row['start_date_time'] < date('Y-m-d H:i:s')) echo "disabled";  ?> onclick="window.open('<?php echo $row['join_url'] ?>', '_blank'); " ;>JOIN MEETING</button>
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

                            $sql = "SELECT * FROM `appointment` WHERE `user` = '" . $_COOKIE['user_username'] . "' AND `cancelled` = 0 AND `appointment_date` > '" . date('Y-m-d') . "' AND `start_date_time` > '" . date('Y-m-d H:i:s') . "' ORDER BY `start_date_time`";

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) == 0) { ?>

                                <h5 style="color: #ed2020; text-align:center; margin-top:20px">No Appointments are scheduled further!</h5>

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
                                            <span class="doctor-name"><?php echo $row1['name'] ?></span>
                                            <?php if ($row1['specialization'] == "other") { ?>
                                                <span class="doctor-specialization">(<?php echo $row1['other-s'] ?>)</span>
                                            <?php } else { ?>
                                                <span class="doctor-specialization">(<?php echo $row1['specialization'] ?>)</span>
                                            <?php } ?>
                                            </br>
                                            <span class="appointment-id"><strong>Appointment ID: </strong><?php echo $row['id'] ?></span>
                                            </br>
                                            <span class="appointment-date"><strong>Date: </strong><?php echo date("d-m-Y", strtotime($row['appointment_date'])) ?></span></br>
                                            <span class="appointment-date"><strong>Time: </strong><?php echo $row2['time'] ?></span></br>
                                        </div>
                                        <div class="book">
                                            <div class="star">
                                                <div class="stars-outer">
                                                    <div class="stars-inner" style="width:<?php echo $row1['ratings'] / 5 * 100 ?>%"></div>
                                                </div>
                                            </div>
                                            <?php

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
                                            <button class="btn btn-primary join-appointment" disabled>JOIN MEETING</button>
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
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                        <strong style="color:#ed2020">CANCELLED</strong>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse <?php if (isset($_GET['open']) && ($_GET['open'] == 'cancelled')) echo "show" ?>">
                    <div class="accordion-body">
                        <div class="doctor-container">
                            <?php

                            $sql = "SELECT * FROM `appointment` WHERE `user` = '" . $_COOKIE['user_username'] . "' AND `cancelled` = 1 ORDER BY `start_date_time` DESC";

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) == 0) { ?>

                                <h5 style="color: #ed2020; text-align:center; margin-top:20px">No Appointments have been cancelled yet!</h5>

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
                                        <div class="doctor-details" style="margin-right:0">
                                            <span class="doctor-name"><?php echo $row1['name'] ?></span>
                                            <?php if ($row1['specialization'] == "other") { ?>
                                                <span class="doctor-specialization">(<?php echo $row1['other-s'] ?>)</span>
                                            <?php } else { ?>
                                                <span class="doctor-specialization">(<?php echo $row1['specialization'] ?>)</span>
                                            <?php } ?>
                                            </br>
                                            <span class="appointment-id"><strong>Appointment ID: </strong><?php echo $row['id'] ?></span>
                                            </br>
                                            <span class="appointment-date"><strong>Date: </strong><?php echo date("d-m-Y", strtotime($row['appointment_date'])) ?></span></br>
                                            <span class="appointment-date"><strong>Time: </strong><?php echo $row2['time'] ?></span></br>
                                        </div>
                                        <div class="book" style="width:160px">

                                            <?php if ($row['refund'] == 0 and $row['alternative'] == 0) { ?>

                                                <button class="btn btn-primary alternative-button" onclick="window.location.href = './alternate-booking.php?id=<?php echo $row['id'] ?>'" ;>ALTERNATIVE</button>

                                                <button class="btn btn-success refund-button" onclick="window.location.href = './user-refund.php?id=<?php echo $row['id'] ?>'" ;>REFUND</button>

                                            <?php } else if ($row['refund'] == 1 and $row['alternative'] == 0) { ?>

                                                <strong style="color:#03861d">Refund initiated</strong><br />We will notify you once it is processed.

                                            <?php } else if ($row['refund'] == 2 and $row['alternative'] == 0) { ?>

                                                <strong style="color:#03861d">Refund Processed</strong>

                                            <?php } else if ($row['refund'] == 0 and $row['alternative'] != 0) { ?>

                                                <span>Alternate Booking with <strong style="color:#03861d"> Appointment ID = <?php echo $row['alternative'] ?> </strong> has been confirmed!</span>

                                            <?php } ?>
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
        // Ratings input
        function rangeSlide(value, rating_id) {
            document.getElementById(rating_id).innerHTML = value + " / 5";
        }

        $('.send-feedback').click(function() {

            // console.log($(this).data("id"));
            // console.log($("#" + $(this).data("id") + "-slider").val())

            let id = $(this).data("id");
            let rating = $("#" + $(this).data("id") + "-slider").val();

            $.ajax({
                url: "./form-action/send-appointment-rating",
                type: "post",
                data: {
                    id: id,
                    rating: rating
                },
                success: function(result) {
                    // console.log($.parseJSON(result));

                    rating_percentage = rating / 5 * 100;

                    $("#" + id).html(`<div class="stars-outer"> <div class="stars-inner" style="width:${rating_percentage}%"> </div> </div>`);

                    // $("#panelsStayOpen-collapseOne").load(location.href + " #panelsStayOpen-collapseOne>*", "");

                    $("#panelsStayOpen-collapseTwo").load(location.href + " #panelsStayOpen-collapseTwo>*", "");

                    $("#panelsStayOpen-collapseThree").load(location.href + " #panelsStayOpen-collapseThree>*", "");

                },
            });
        });

        $('.time-slot-button').click(function() {

            $('#modal-' + $(this).data("slot")).modal('show');

        });

        // appointment_id_inputs = document.getElementsByClassName("username");

        // let usernames = [];

        // for (let i = 0; i < appointment_id_inputs.length; i++) {
        //     appointment_ids.push(appointment_id_inputs[i].value);
        // }

        // // console.log(usernames)

        // var values = [];
        // for (i = 0; i < appointment_ids.length; i++) {
        //     var precision = 100; // 2 decimals
        //     var randomnum = Math.floor(Math.random() * (5 * precision - 1 * precision) + 1 * precision) / (1 * precision);

        //     values.push(randomnum);
        // }


        // // var values = [2.54, 2.83, 2.35, 2.72, 4.88, 4.56, 4.49, 2.32, 4.47, 4.24, 2.66, 2.76, 3.51, 3.51, 3.09, 2.17, 2.57, 2.74];
        // var ratings = {};
        // usernames.forEach((key, i) => ratings[key] = values[i]);

        // // console.log(ratings)

        // const starTotal = 5;

        // for (const rating in ratings) {
        //     // console.log(ratings[rating], rating);
        //     const starPercentage = `${(ratings[rating] / starTotal) * 100}%`;
        //     // document.querySelector(`.${rating} .star .stars-inner`).style.width = starPercentage;
        // }
    </script>
</body>

</html>