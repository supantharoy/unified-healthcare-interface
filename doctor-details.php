<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();

    $title = 'Doctor Details';
    include './includes/header.php';
    include './db/db.php';
    ?>

    <style>
        .dashboard h1,
        .dashboard h2 {
            text-align: center;
            margin-top: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        .ui-autocomplete {
            margin-top: 50px !important;
            margin-left: 1005px !important;
        }
    </style>
</head>

<body>

    <?php if (!isset($_GET['dn'])) { ?>

        <div class="dashboard">
            <h1>Doctor Details</h1>
        </div>

        

    <?php } ?>

</body>

</html>