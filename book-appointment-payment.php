<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();

    $title = 'Appointment Payment';
    include './includes/header.php';
    include_once './db/db.php';
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

        .payment-gateway h1 {
            text-align: center;
            margin-top: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        #payment-form{
            display: flex;
            justify-content: center;
            margin: 100px auto 200px;
        }
    </style>
</head>

<body>


    <div class="payment-gateway">
        <h1>Payment Gateway</h1>
    </div>

    <div id="payment-form">
        <form action="./form-action/book-appointment-action" method="post">
            <input type="hidden" id="doctor" name="doctor" value="<?php echo $_GET['doctor'] ?>">
            <input type="hidden" id="user" name="user" value="<?php echo $_GET['user'] ?>">
            <input type="hidden" id="date" name="date" value="<?php echo $_GET['date'] ?>">
            <input type="hidden" id="slot" name="slot" value="<?php echo $_GET['slot'] ?>">
            <button class="btn btn-primary" type="submit" name="done">
                PAYMENT DONE
            </button>
        </form>
    </div>




</body>

</html>
<?php
include './includes/footer.php'
?>