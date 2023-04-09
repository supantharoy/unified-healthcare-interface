<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();

    if (isset($_COOKIE['user_username']) && isset($_GET['id'])) {
        $title = 'Appointment Refund';
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

        .payment-gateway h1 {
            text-align: center;
            margin-top: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        #payment-form {
            width: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 100px auto 200px;
        }

        #wait-msg{
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <?php

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM `appointment` WHERE `id` = '$id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['cancelled'] != 1 || $row['alternative'] != 0 || $row['refund'] != 0) { ?>

        <script>
            window.location = "./user-login";
        </script>

    <?php } ?>

    <div class="payment-gateway">
        <h1>Payment Gateway</h1>
    </div>

    <div id="payment-form">
        <input type="hidden" id="id" name="id" value="<?php echo $_GET['id'] ?>">
        <button class="btn btn-primary" type="submit" name="refund" id="refund">
            INITIATE REFUND
        </button>
        <span id="wait-msg"></span>
    </div>

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