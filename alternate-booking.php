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

        .alternate-booking {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 500px;
            margin: 50px auto;
        }

        .alternate-booking h1 {
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
            width: 800px;
            margin-bottom: 30px;
        }

        .slot-buttons{
            width: 150px;
        }

        /* #payment-form {
            width: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 100px auto 200px;
        }

        #wait-msg {
            margin-top: 10px;
        } */
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

    <div class="alternate-booking">
        <h1>Choose alternative booking Type</h1>

        <span>Book another appointment during the same slot with another doctor of the same specialization
        </span>

        <br />
        <button class="btn btn-primary slot-buttons" type="submit" name="refund">
            SAME SLOT
        </button>
        <br />
        OR
        <br />
        <br />
        <span>Book another appointment with any doctor of the same specialization during any slot</span>
        <br/>
        <button class="btn btn-primary slot-buttons" type="submit" name="refund">
            I WILL SELECT
        </button>
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