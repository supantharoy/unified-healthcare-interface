<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();

    if (isset($_COOKIE['user_username'])) {
        $title = 'Organ Donation';
        include './includes/header.php';
        include './includes/user-dashboard-sidebar.php';
        include './db/db.php';
    } else {
        header("Location: ./user-login");
        exit();
    }
    ?>

    <style>
        .dashboard {
            margin-left: 240px;
            margin-top: 30px;
            text-align: center;
        }

        .dashboard h1 {
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        .dashboard h3{
            margin-top: 40px;
        }

        .dashboard h4{
            margin-top: 40px;
        }

        .dashboard h5{
            margin-top: 40px;
        }

    </style>
</head>

<body>
    <div class="dashboard">
        <h1>Organ Donation</h1>

        <h3>Choose one</h3>
        <h5>Need an organ transplant? <a href="">Contact an organ donor</a></h5>
        <h4>OR</h4>
        <h5>Willing to donate an organ? <a href="./organ-donor-form">Become an organ donor</a></h5>
    </div>
</body>
</html>