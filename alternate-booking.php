<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();

    if (isset($_COOKIE['user_username']) && isset($_GET['id'])) {
        $title = 'Alternate Booking';
        include './includes/header.php';
        include_once './db/db.php';
    } else {
        header("Location: ./user-login");
        exit();
    }
    ?>

    <style>
        .alert-container {
            position: absolute;
            left: 0;
            right: 0;
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

        .no-booking {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 800px;
            margin: 120px auto;
            /* margin-top:120px; 
            margin-bottom:150px; */
            /* background-color: #03861d; */
        }

        .no-booking h4 {
            text-align: center;
        }

        .no-booking span {
            text-transform: capitalize;
        }

        .alternate-booking {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 500px;
            margin: 50px auto 190px;
        }

        .alternate-booking h1 {
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
            width: 800px;
            margin-bottom: 65px;
        }

        .slot-buttons {
            width: 130px;
        }

        .specialist {
            text-align: center;
        }

        .specialist h1 {
            margin-top: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
            margin-bottom: -30px;
        }

        .doctor-container {
            margin: 80px auto 120px;
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
            border-radius: 50%;
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

        .doctor #book-appointment-same, .doctor #book-appointment-select {
            margin-top: 10px;
            background-color: #0a8aca;
        }

        .doctor #book-appointment-same:hover,
        .doctor #book-appointment-same:active,
        .doctor #book-appointment-select:hover,
        .doctor #book-appointment-select:active {
            background-color: #056ea2;
        }

        #modal-close:active,
        #modal-close:focus {
            box-shadow: none;
        }

        a,
        a:focus,
        a:active,
        a:visited {
            text-decoration: none;
            color: inherit;
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

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM `appointment` WHERE `id` = '$id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['cancelled'] != 1 || $row['alternative'] != 0 || $row['refund'] != 0) {

    ?>

        <script>
            window.location = "./user-login";
        </script>

    <?php } ?>


    <?php if (!isset($_GET['slot'])) { ?>

        <div class="alternate-booking">
            <h1>Choose alternative booking Type</h1>

            <span>Book appointment with another doctor on the same date and slot </span>
            <br />
            <button class="btn btn-primary slot-buttons" type="submit" name="refund" onclick="window.location.href = './alternate-booking.php?id=<?php echo $id ?>&slot=same'" ; <?php if (date('Y-m-d H:i:s') > $row['start_date_time']) echo "disabled"; ?>>
                SAME DATE
            </button>
            <?php if (date('Y-m-d H:i:s') > $row['start_date_time']) { ?>
                <span style="color:#ed2020">You can only book an appointment on another date now</span>
            <?php } ?>
            <br />
            OR
            <br />
            <br />
            <span>Book appointment with any doctor on another date and slot</span>
            <br />
            <button class="btn btn-primary slot-buttons" type="submit" name="refund" onclick="window.location.href = './alternate-booking.php?id=<?php echo $id ?>&slot=select'" ;>
                I WILL SELECT
            </button>
        </div>

        <?php } else if ($_GET['slot'] == 'same') {


        $sql = "SELECT * FROM `doctor-login` WHERE `username` = '" . $row['doctor'] . "';";
        $result = mysqli_query($conn, $sql);
        $doctor = mysqli_fetch_assoc($result);

        // echo $row['appointment_time'];

        $sql = "SELECT * FROM `time-slots` WHERE `slot` = '" . $row['appointment_time'] . "';";
        $result = mysqli_query($conn, $sql);
        $time_slot = mysqli_fetch_assoc($result);

        //echo $row['appointment_time'];

        $sql = "SELECT * FROM `doctor-availability` WHERE `" . $row['appointment_time'] . "` = 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 0) { ?>

            <div class="no-booking">
                <h5>We apologize, no doctors of specialization
                    <span>
                        <?php if ($doctor['specialization'] == 'other') echo $doctor['other-s'];
                        else echo $doctor['specialization'] ?></span> are available during the same slot!
                    <br />
                </h5>
                <h4>Please select another slot.</h4>
            </div>

        <?php
        } else { ?>
            <!-- // $doctor_availability = mysqli_fetch_assoc($result); -->

            <div class="doctor-container" id="doctor-container">

                <?php

                $c = 0;

                while ($doctor_availability = mysqli_fetch_assoc($result)) {

                    // echo $doctor_availability['username'];
                    // echo $doctor['specialization'];

                    if ($doctor['specialization'] == 'other') {

                        $sql1 = "SELECT * FROM `doctor-login` WHERE `username` = '" . $doctor_availability['username'] . "' AND `other-s` = '" . $doctor['other-s'] . "' AND `available` = 1 AND `username` <> '" . $row['doctor'] . "'";
                    } else {

                        $sql1 = "SELECT * FROM `doctor-login` WHERE `username` = '" . $doctor_availability['username'] . "' AND `specialization` = '" . $doctor['specialization'] . "' AND `available` = 1 AND `username` <> '" . $row['doctor'] . "'";
                    }


                    $result1 = mysqli_query($conn, $sql1);
                    $newdoctor = mysqli_fetch_assoc($result1);

                    // echo var_dump($newdoctor);

                    if (mysqli_num_rows($result1) != 0) {
                        $c++;

                ?>
                        <div class="doctor" style="user-select:none;">
                            <div class="doctor-image">
                                <img src="./assests/images/doctor-avatar-specialist.png?t=<?php echo time(); ?>">
                            </div>
                            <div class="doctor-details">
                                <span class="doctor-name"><?php echo $newdoctor['name'] ?></span> </br>
                                <span class="doctor-qualification"><?php echo $newdoctor['qualification'] ?></span> </br>
                                <span class="doctor-experience"><strong>Experience: </strong><?php echo $newdoctor['experience'] ?> years</span></br>
                                <?php if ($newdoctor['specialization'] == "other") { ?>
                                    <span class="doctor-specialization"><?php echo $newdoctor['other-s'] ?></span>
                                <?php } else { ?>
                                    <span class="doctor-specialization"><?php echo $newdoctor['specialization'] ?></span>
                                <?php } ?>
                            </div>
                            <div class="book <?php echo $newdoctor['username'] ?>">
                                <div class="star">
                                    <div class="stars-outer">
                                        <div class="stars-inner" style="width:<?php echo $newdoctor['ratings'] / 5 * 100 ?>%"></div>
                                    </div>
                                </div>
                                <?php

                                if ($newdoctor['available'] == 1) {
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
                                <button class="btn btn-primary" id="book-appointment-same" data-username="<?php echo $newdoctor['username'] ?>" <?php if ($newdoctor['available'] == 0) echo "disabled"; ?> data-id="<?php echo $_GET['id'] ?>">Book Appointment</button>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>

            <?php if ($c == 0) { ?>

                <div class="no-booking">
                    <h5>We apologize, no doctors of specialization
                        <span>
                            <?php if ($doctor['specialization'] == 'other') echo $doctor['other-s'];
                            else echo $doctor['specialization'] ?></span> are available during the same slot!
                        <br />
                    </h5>
                    <h4>Please select another slot.</h4>

                    <br />
                    <br />

                    <button class="btn btn-primary slot-buttons" type="submit" name="refund" onclick="window.location.href = './alternate-booking.php?id=<?php echo $id ?>&slot=select'" ;>
                        ANOTHER SLOT
                    </button>

                </div>
        <?php
            }
        }
        ?>


    <?php } else if ($_GET['slot'] == 'select') {


        $sql = "SELECT * FROM `doctor-login` WHERE `username` = '" . $row['doctor'] . "';";
        $result = mysqli_query($conn, $sql);
        $doctor = mysqli_fetch_assoc($result);

        //echo "<pre>";

        //echo (var_dump($doctor));
        //echo "</pre>";


        if ($doctor['specialization'] == 'other') {

            $sql1 = "SELECT * FROM `doctor-login` WHERE `other-s` = '" . $doctor['other-s'] . "' AND `available` = 1";
        } else {

            $sql1 = "SELECT * FROM `doctor-login` WHERE `specialization` = '" . $doctor['specialization'] . "' AND `available` = 1";
        }

        $result1 = mysqli_query($conn, $sql1);
    ?>

        <div class="specialist">
            <h1><?php

                if ($doctor['specialization'] == 'other') echo $doctor['other-s'];
                else echo $doctor['specialization'] ?></h1>
        </div>


        <div class="doctor-container" id="doctor-container">

            <?php

            while ($newdoctor = mysqli_fetch_assoc($result1)) { ?>

                <div class="doctor" style="user-select:none;">
                    <div class="doctor-image">
                        <img src="./assests/images/doctor-avatar-specialist.png?t=<?php echo time(); ?>">
                    </div>
                    <div class="doctor-details">
                        <span class="doctor-name"><?php echo $newdoctor['name'] ?></span> </br>
                        <span class="doctor-qualification"><?php echo $newdoctor['qualification'] ?></span> </br>
                        <span class="doctor-experience"><strong>Experience: </strong><?php echo $newdoctor['experience'] ?> years</span></br>
                        <?php if ($newdoctor['specialization'] == "other") { ?>
                            <span class="doctor-specialization"><?php echo $newdoctor['other-s'] ?></span>
                        <?php } else { ?>
                            <span class="doctor-specialization"><?php echo $newdoctor['specialization'] ?></span>
                        <?php } ?>
                    </div>
                    <div class="book <?php echo $newdoctor['username'] ?>">
                        <div class="star">
                            <div class="stars-outer">
                                <div class="stars-inner" style="width:<?php echo $newdoctor['ratings'] / 5 * 100 ?>%"></div>
                            </div>
                        </div>
                        <?php

                        if ($newdoctor['available'] == 1) {
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

                            <button class="btn btn-primary" id="book-appointment-select" data-username="<?php echo $newdoctor['username'] ?>" <?php if ($newdoctor['available'] == 0) echo "disabled"; ?> onclick="window.location.href = './book-appointment.php?id=<?php echo $id ?>&slot=select&doctor=<?php echo $newdoctor['username'] ?>'" ;>Book Appointment</button>

                    </div>
                </div>
            <?php } ?>
        </div>
    <?php
    } else { ?>

        <script>
            window.location = "./user-login";
        </script>

    <?php } ?>

    <!-- <div id="payment-form">
        <input type="hidden" id="id" name="id" value="<?php echo $_GET['id'] ?>">
        <button class="btn btn-primary" type="submit" name="refund" id="refund">
            INITIATE REFUND
        </button>
        <span id="wait-msg"></span>
    </div> -->

    <script>
        $('#refund').click(function() {

            let id = $('#id').val();

            $('#wait-msg').html('Please Wait...');

            $.ajax({
                url: "./form-action/update-refund-status",
                type: "post",
                data: {
                    id: id,
                    status: 1
                },
                success: function(result) {

                    window.location = "./user-dashboard-appointment?open=cancelled";

                },
            });
        });
    </script>

</body>

</html>
<?php
include './includes/footer.php'
?>