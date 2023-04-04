<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();

    if (isset($_COOKIE['user_username'])) {
        $title = 'User Profile';
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
        }

        .dashboard h1,
        .dashboard h2 {
            text-align: center;
            /* margin-top: 40px; */
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        
    </style>
</head>

<body>
    <div class="dashboard">
        <h1>user profile</h1>

        <h2>Hello, <?php echo $_COOKIE['user_username'] ?>!
    </div>
</body>
</html>