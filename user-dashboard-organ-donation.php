<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();

    if (isset($_COOKIE['user_username'])) {
        $title = 'User Organ Donation';
        include './includes/header.php';
        include './includes/user-dashboard-sidebar.php';
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
            margin-top: 50px;
            text-align: center;
        }

        .dashboard h1 {
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        .dashboard h3 {
            margin-top: 40px;
        }

        .dashboard h4 {
            margin-top: 40px;
        }

        .dashboard h5 {
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <?php

    if (isset($_SESSION['organ_donor']) && $_SESSION['organ_donor'] == "success") { ?>

        <div class="alert-container" style="width: 470px;">
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Thank you, your details are live!</strong> &nbsp;Please check your email
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
            </div>
        </div>

    <?php
    } else if (isset($_SESSION['organ_recipient']) && $_SESSION['organ_recipient'] == 'success') { ?>

        <div class="alert-container" style="width: 470px;">
            <div class="alert alert-success alert-dismissible fade show">
                <strong>There was some error on our side!</strong> &nbsp;Please try again later
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
            </div>
        </div>

    <?php }

    unset($_SESSION['organ_donor']);
    unset($_SESSION['organ_recipient']);
    ?>

    <div class="dashboard">
        <h1>Organ Donation</h1>

        <h3>Choose one</h3>
        <h5>Need an organ transplant? <a href="./user-dashboard-organ-donors">Contact an organ donor</a></h5>
        <h4>OR</h4>
        <h5>Willing to donate an organ? <a href="./user-dashboard-organ-donor-form">Become an organ donor</a></h5>
    </div>
</body>

</html>