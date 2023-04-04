<!DOCTYPE html>
<html lang="en">

<head>

    <?php


    if (!isset($_COOKIE['user_username'])) {
        header("Location: ./user-login");
        exit();
    }

    session_start();

    $title = 'Book Appointment';
    include './includes/header.php'
    ?>

    <style>
        .appointment {
            text-align: center;
        }

        .appointment h1 {
            margin-top: 40px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        .time-slots-container {
            margin: 60px auto;
            width: 900px;
            height: 60vh;
        }

        .time-slots {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 25px;
            text-align: center;
        }

        .time-slot-button {
            width: 175px;
            padding: 10px 10px;
            background-color: #42BAA4;
            font-size: 1.1rem;
            border: none;
        }

        .time-slot-button:hover {
            background-color: #299883;
        }

        .time-slot-button:active {
            background-color: #299883 !important;
        }

        .modal-cross:active,
        .modal-cross:focus {
            box-shadow: none;
        }
    </style>

</head>


<body>

    <?php
    $sql = "SELECT * FROM `doctor-login` WHERE `username` = '" . $_GET['doctor'] . "'";
    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) == 0) {
    ?>
        <script>
            window.location = "./specialist";
        </script>
    <?php
    }

    $row = mysqli_fetch_assoc($result);

    if ($row['available'] == 0) {
    ?>

        <input type="hidden" id="specialization" name="specialization" value="<?php echo $row['specialization'] ?>">
        <script>
            window.location = "./specialist?field=" + $('#specialization').val();
        </script>

    <?php } ?>


    <?php

    if (isset($_GET['doctor']) && isset($_GET['date'])) {

        if (mysqli_num_rows($result) == 0) {
    ?>
            <script>
                window.location = "./specialist";
            </script>
        <?php
        } else { ?>

            <div class="appointment">
                <h1>Book Appointment</h1>
                <h4><strong>Dr. <?php echo $row['name'] ?></strong>
                    <span style="text-transform:capitalize;">
                        (<?php if ($row['specialization'] == 'other') {
                                echo $row['other-s'];
                            } else {
                                echo $row['specialization'];
                            } ?>)</span> is available during the below slots
                </h4>
            </div>

            <div class="time-slots-container">

                <?php

                $sql = "SELECT * FROM `doctor-availability` WHERE `username` = '" . $_GET['doctor'] . "'";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="time-slots" style="user-select:none;">

                        <?php for ($i = 2; $i < count($row); $i++) { ?>

                            <?php
                            $sql1 = "SELECT * FROM `time-slots` WHERE `slot` = '" . array_keys($row)[$i] . "'";
                            $result1 = mysqli_query($conn, $sql1);
                            $row1 = mysqli_fetch_assoc($result1);

                            if ($row[array_keys($row)[$i]] == 1) {

                                $start_time = explode(" - ", $row1['time']);
                                $start_time = date("H:i:s", strtotime($start_time[0]));
                                $currenttime = date('H:i:s');
                                $date = strtotime($_GET['date']);
                                $date = date('Y-m-d', $date);
                                $currentdate = date('Y-m-d');

                                if ($date != $currentdate || ($date == $currentdate && $start_time > $currenttime)) {
                            ?>

                                    <button class="btn btn-primary time-slot-button" data-slot="<?php echo array_keys($row)[$i] ?>"><?php echo $row1['time'] ?></button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modal-<?php echo array_keys($row)[$i] ?>" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="user-select:none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modal-<?php echo array_keys($row)[$i] ?>Label">Confirmation</h1>
                                                    <button type="button" class="btn-close modal-cross" data-bs-dismiss="modal" aria-label="Close" id="<?php echo array_keys($row)[$i] ?>-modal-close" shadow-none></button>
                                                </div>
                                                <div class="modal-body">

                                                    Your appointment will be scheduled between <?php echo $row1['time'] ?> on <?php echo $_GET['date'] ?>. After paying the appointment fees of &#x20B9; 1500, your appointment will be confirmed
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>

                                                    <form action="./book-appointment-payment" method="get">
                                                        <input type="hidden" id="doctor" name="doctor" value="<?php echo $_GET['doctor'] ?>">
                                                        <input type="hidden" id="user" name="user" value="<?php echo $_COOKIE['user_username'] ?>">
                                                        <input type="hidden" id="date" name="date" value="<?php echo $_GET['date'] ?>">
                                                        <input type="hidden" id="slot" name="slot" value="<?php echo array_keys($row)[$i] ?>">
                                                        <button class="btn btn-primary" type="submit">
                                                            PROCEED
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php
        }
    } else if (isset($_GET['doctor']) && !isset($_GET['date'])) { ?>

        <style>
            #appointment {
                margin-top: 50px;
            }

            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
            }

            .wrapper {
                width: 600px;
                padding: 0 0.5rem;
                margin-left: auto;
                margin-right: auto;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding-top: 4rem;
                margin-bottom: 300px;
            }

            .wrapper label {
                width: 300px;
                font-size: 0.75rem;
                font-weight: 400;
                display: block;
                margin-bottom: 0.5rem;
                /* color: #B0BEC5; */
                /* color: #607D8B; */
                border: 1px solid #ECEFF1;
                padding: 0.5rem 0.75rem;
                border-radius: 0.5rem;
            }

            .wrapper input {
                display: block;
                border: none;
                border-radius: 0.25rem;
                border: 1px solid transparent;
                line-height: 1.5rem;
                padding: 0;
                font-size: 1rem;
                /* color: #607D8B; */
                width: 100%;
                margin-top: 0.5rem;
            }

            .wrapper input:focus {
                outline: none;
            }

            .wrapper button {
                margin-top: 40px;
                border-radius: 30px;
                text-transform: uppercase;
                width: 150px;
            }

            .wrapper button:disabled {
                background-color: #7ae0cd;
            }

            #ui-datepicker-div {
                display: none;
                background-color: #fff;
                box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1);
                margin-top: 0.25rem;
                border-radius: 0.5rem;
                padding: 0.5rem;
            }

            .wrapper table {
                border-collapse: collapse;
                border-spacing: 0;
            }

            .ui-datepicker-calendar thead th {
                padding: 0.25rem 0;
                text-align: center;
                font-size: 0.75rem;
                font-weight: 400;
                color: #78909C;
            }

            .ui-datepicker-calendar tbody td {
                width: 2.5rem;
                text-align: center;
                padding: 0;
            }

            .ui-datepicker-calendar tbody td a {
                display: block;
                border-radius: 0.25rem;
                line-height: 2rem;
                transition: 0.3s all;
                color: #03861d;
                font-size: 0.875rem;
                text-decoration: none;
            }

            .ui-datepicker-calendar tbody td a:hover {
                background-color: #E0F2F1;
            }

            .ui-datepicker-calendar tbody td a.ui-state-active {
                background-color: #009688;
                color: white;
            }

            .ui-datepicker-header a.ui-corner-all {
                cursor: pointer;
                position: absolute;
                top: 0;
                width: 2rem;
                height: 2rem;
                margin: 0.5rem;
                border-radius: 0.25rem;
                transition: 0.3s all;
            }

            .ui-datepicker-header a.ui-corner-all:hover {
                background-color: #ECEFF1;
            }

            .ui-datepicker-header a.ui-datepicker-prev {
                left: 0;
                background: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMyIgaGVpZ2h0PSIxMyIgdmlld0JveD0iMCAwIDEzIDEzIj48cGF0aCBmaWxsPSIjNDI0NzcwIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik03LjI4OCA2LjI5NkwzLjIwMiAyLjIxYS43MS43MSAwIDAgMSAuMDA3LS45OTljLjI4LS4yOC43MjUtLjI4Ljk5OS0uMDA3TDguODAzIDUuOGEuNjk1LjY5NSAwIDAgMSAuMjAyLjQ5Ni42OTUuNjk1IDAgMCAxLS4yMDIuNDk3bC00LjU5NSA0LjU5NWEuNzA0LjcwNCAwIDAgMS0xLS4wMDcuNzEuNzEgMCAwIDEtLjAwNi0uOTk5bDQuMDg2LTQuMDg2eiIvPjwvc3ZnPg==");
                background-repeat: no-repeat;
                background-size: 0.5rem;
                background-position: 50%;
                transform: rotate(180deg);
            }

            .ui-datepicker-header a.ui-datepicker-next {
                right: 0;
                background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMyIgaGVpZ2h0PSIxMyIgdmlld0JveD0iMCAwIDEzIDEzIj48cGF0aCBmaWxsPSIjNDI0NzcwIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik03LjI4OCA2LjI5NkwzLjIwMiAyLjIxYS43MS43MSAwIDAgMSAuMDA3LS45OTljLjI4LS4yOC43MjUtLjI4Ljk5OS0uMDA3TDguODAzIDUuOGEuNjk1LjY5NSAwIDAgMSAuMjAyLjQ5Ni42OTUuNjk1IDAgMCAxLS4yMDIuNDk3bC00LjU5NSA0LjU5NWEuNzA0LjcwNCAwIDAgMS0xLS4wMDcuNzEuNzEgMCAwIDEtLjAwNi0uOTk5bDQuMDg2LTQuMDg2eiIvPjwvc3ZnPg==');
                background-repeat: no-repeat;
                background-size: 10px;
                background-position: 50%;
            }

            .ui-datepicker-header a>span {
                display: none;
            }

            .ui-datepicker-title {
                text-align: center;
                line-height: 2rem;
                margin-bottom: 0.25rem;
                font-size: 0.875rem;
                font-weight: 700;
                padding-bottom: 0.25rem;
            }

            .ui-datepicker-week-col {
                /* color: #78909C; */
                font-weight: 400;
                font-size: 0.75rem;
            }
        </style>

        <div class="appointment" id="appointment">
            <h1>Book Appointment</h1>
            <h4>Select your preferred date of appointment with <strong>Dr. <?php echo $row['name'] ?></strong>
                <span style="text-transform:capitalize;">
                    (<?php if ($row['specialization'] == 'other') {
                            echo $row['other-s'];
                        } else {
                            echo $row['specialization'];
                        } ?>)</span>
            </h4>
        </div>

        <div class="wrapper">
            <label for="datepicker">Pick a Date
                <input type="text" id="datepicker" autocomplete="off">
            </label>
            <button class="btn btn-primary time-slot-button" id="date-button" disabled><strong>PROCEED</strong></button>
        </div>


        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

        <script>
            $(function() {
                $("#datepicker").datepicker({
                    dateFormat: "dd-mm-yy",
                    duration: "fast",
                    minDate: 0
                });
            });
        </script>


    <?php } else { ?>
        <script>
            window.location = "./specialist";
        </script>
    <?php } ?>

    <script>
        $('.time-slot-button').click(function() {

            $('#modal-' + $(this).data("slot")).modal('show');

        });

        $('#datepicker').change(() => {
            $('#date-button').removeAttr('disabled');
        })

        $('#date-button').click(() => {
            window.location.href = window.location.href + '&date=' + $('#datepicker').val();
        })
    </script>

</body>

</html>
<?php
include './includes/footer.php'
?>