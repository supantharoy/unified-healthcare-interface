<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();

    if (isset($_COOKIE['doctor_username'])) {
        $title = 'Doctor Dashboard';
        include './includes/header.php';
        include './includes/doctor-dashboard-sidebar.php';
        include './db/db.php';
    } else {
        header("Location: ./doctor-login");
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
        
        .dashboard {
            margin-left: 240px;
            margin-top: 40px;
            user-select: none;
        }

        .dashboard h1,
        .dashboard h2 {
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        .available-container {
            display: flex;
            justify-content: right;
            margin: 20px 50px;
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

    <div class="dashboard">
        <h1>dashboard</h1>

        <input type="hidden" id="username" name="username" value="<?php echo $_COOKIE['doctor_username'] ?>">

        <div class="available-container">
            <div class="form-check form-switch" id="available-check">

                <?php

                $sql = "SELECT * FROM `doctor-login` WHERE `username` = '" . $_COOKIE['doctor_username'] . "'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result)

                ?>

                <label class="form-check-label" for="available">Available to take appointments?</label>
                <input class="form-check-input" name="available" value="1" type="checkbox" id="available" <?php if ($row['available'] == 1) { ?> checked <?php } ?>>
            </div>
        </div>

    </div>

    <script>
        $('#available-check>.form-check-input').click(() => {

            let available = 0;

            if ($('#available').is(':checked')) {
                available = 1;
            }

            $.ajax({
                url: "./form-action/doctor-availability-update",
                type: "post",
                data: {
                    username: $('#username').val(),
                    available: available
                },
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
                },
            });
        })
    </script>

</body>

</html>