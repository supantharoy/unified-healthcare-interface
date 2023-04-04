<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();

    if (isset($_COOKIE['doctor_username'])) {
        $title = 'Doctor Availability';
        include './includes/header.php';
        include './includes/doctor-dashboard-sidebar.php';
        include './db/db.php';
    } else {
        header("Location: ./user-login");
        exit();
    }
    ?>

    <style>
        .alert-container {
            position: absolute;
            left: 240px;
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

        .availability {
            margin-top: 50px;
            margin-left: 240px;
        }

        .availability h1,
        .availability h2 {
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        .time-slots-container {
            margin: 50px auto 20px;
            width: 900px;
            height: 60vh;
        }

        .time-slots {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 25px;
            text-align: center;
            font-size: 1.1rem;
        }

        .form-check-input,
        .form-check-label {
            cursor: pointer;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0;
        }
        
    </style>
</head>

<body>

    <div id="alert"></div>

    <div class="availability">
        <h1>Specify your Availability</h1>

        <input type="hidden" id="username" name="username" value="<?php echo $_COOKIE['doctor_username'] ?>">

        <div class="time-slots-container">
            <?php

            $sql = "SELECT * FROM `doctor-availability` WHERE `username` = '" . $_COOKIE['doctor_username'] . "'";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="time-slots" style="user-select:none;">


                    <?php for ($i = 2; $i < count($row); $i++) { ?>

                        <?php
                        $sql1 = "SELECT * FROM `time-slots` WHERE `slot` = '" . array_keys($row)[$i] . "'";
                        $result1 = mysqli_query($conn, $sql1);
                        $row1 = mysqli_fetch_assoc($result1)
                        ?>

                        <div class="form-check form-switch">
                            <div style="margin-left:40px">

                                <input class="form-check-input" name="<?php echo array_keys($row)[$i] ?>" value="1" type="checkbox" id="<?php echo array_keys($row)[$i] ?>" <?php if ($row[array_keys($row)[$i]] == 1) { ?> checked <?php } ?>>


                                <label class="form-check-label" for="<?php echo array_keys($row)[$i] ?>" style="margin-left:-40px"><?php echo $row1['time'] ?></label>

                            </div>
                        </div>
                    <?php } ?>
                </div>

            <?php } ?>
        </div>
    </div>

    <script>
        $('.form-check-input').click(() => {

            var checked = [];
            var unchecked = [];

            $('input:checkbox:checked').each(function() {
                checked.push($(this).attr('name'));
            });

            $('input:checkbox:not(:checked)').each(function() {
                unchecked.push($(this).attr('name'));
            });

            console.log(checked);
            console.log(unchecked);

            $.ajax({
                url: './form-action/doctor-slots-update',
                type: 'post',
                data: {
                    username: $('#username').val(),
                    checked: JSON.stringify(checked),
                    unchecked: JSON.stringify(unchecked),
                },
                dataType: "text",
                success: function(result) {
                    if ($.parseJSON(result) != 'success') {
                        $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="email-alert-container">
                                <div class="alert alert-danger alert-dismissible fade show">
                                   <strong>There was some error on our side!</strong> &nbsp;Please try again later
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);
                    }

                    console.log($.parseJSON(result));
                }
            })
        });
    </script>

</body>

</html>