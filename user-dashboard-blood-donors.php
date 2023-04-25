<!DOCTYPE html>
<html lang="en">

<head>

    <?php

    session_start();

    if (isset($_COOKIE['user_username'])) {
        $title = 'User Blood Donors';
        include './includes/header.php';
        include './includes/user-dashboard-sidebar.php';
        include './db/db.php';
    } else {
        header("Location: ./user-login");
        exit();
    }
    ?>

    <style>
        .navbar {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            z-index: 4;
        }

        .alert-container {
            position: absolute;
            left: 240px;
            right: 0;
            /* top: 65px; */
            margin-left: auto;
            margin-right: auto;
            user-select: none;
            padding-top: 10px;
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
            margin-top: 60px;
        }

        .specialist {
            text-align: center;
        }

        .specialist h1 {
            margin-top: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
            padding-top: 60px;
        }

        .doctor-container {
            margin: 50px auto 120px;
            flex-direction: column;
            width: 550px;
        }

        .doctor {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            margin-top: 40px;
            border: 1px #DDDDDD solid;
            padding: 10px;
            height: 160px;
        }

        .doctor .doctor-image img {
            height: 130px;
            margin-right: 20px;
            border-radius: 50%;
        }

        .doctor .doctor-details {
            width: 200px;
            line-height: 25px;
        }

        .availability {
            margin-top: 20px;
        }

        .doctor .doctor-name {
            color: #0a8aca;
            font-weight: 700;
        }

        /* #modal-close:active,
        #modal-close:focus {
            box-shadow: none;
        } */

        .contact-button {
            width: 100px;
            text-transform: uppercase;
            font-weight: 700;
            padding: 5px 10px;
            background-color: #42BAA4;
            font-size: 1.1rem;
            border: none;
        }

        .contact-button:hover {
            background-color: #299883;
        }

        .contact-button:active {
            background-color: #299883 !important;
        }

        .contact-button:disabled {
            background-color: #54d5be;
        }

        .modal-cross:active,
        .modal-cross:focus {
            box-shadow: none;
        }

        .form-container {
            margin: 40px auto 0px;
            width: 500px;
            user-select: none;
        }

        .input-group {
            margin-top: 30px;
        }

        .input-group input,
        .input-group select {
            font-size: 1.2rem;
        }

        .input-group input:focus,
        .input-group select:focus {
            box-shadow: none;
        }

        .input-group-text {
            font-size: 1.2rem;
        }

        .input-group label:first-child {
            width: 90px;
        }

        #send {
            color: #fff;
            margin-top: 30px;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 1px;
        }
    </style>

</head>


<body>

    <?php

    if (isset($_SESSION['blood_donor_contact']) && $_SESSION['blood_donor_contact'] == 'success') { ?>

        <div class="alert-container" style="width: 360px;">
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Email sent!</strong> They will get back to you soon
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
            </div>
        </div>

    <?php
    } else if (isset($_SESSION['blood_recipient']) && $_SESSION['blood_recipient'] == 'success') { ?>

        <div class="alert-container" style="width: 470px;">
            <div class="alert alert-success alert-dismissible fade show">
                <strong>There was some error on our side!</strong> &nbsp;Please try again later
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
            </div>
        </div>

    <?php }

    unset($_SESSION['blood_donor_contact']);
    unset($_SESSION['blood_recipient']);
    ?>

    <div class="dashboard">
        <div class="specialist">
            <h1>blood donors</h1>
        </div>

        <div class="doctor-container" id="doctor-container">
            <?php

            $sql = "SELECT * FROM `blood-donors` ORDER BY `datetime` DESC";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="doctor" style="user-select:none;">
                    <div class="doctor-image">
                        <img src="./assests/images/user-avatar.png?t=<?php echo time(); ?>">
                    </div>
                    <div class="doctor-details">
                        <span class="doctor-name"><?php echo $row['name'] ?></span> </br>
                        <span class="doctor-qualification"><strong>Blood Group: </strong><?php echo $row['blood'] ?></span> </br>
                        <span class="doctor-experience"><strong>Gender: </strong><?php echo $row['gender'] ?></span></br>
                        <span class="doctor-experience"><strong>Posted on: </strong><?php echo date("d-m-Y", strtotime($row['posted_on'])) ?></span></br>
                    </div>
                    <div class="book <?php echo $row['id'] ?>">

                        <button class="btn btn-primary contact-button" data-id="<?php echo $row['id'] ?>">Contact</button>

                        <!-- Modal -->
                        <div class="modal fade" id="modal-<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="user-select:none;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="modal-<?php echo $row['id'] ?>Label">Contact <?php echo $row['name'] ?> for <?php echo $row['blood'] ?> blood donation </h1>
                                        <button type="button" class="btn-close modal-cross" data-bs-dismiss="modal" aria-label="Close" id="<?php echo $row['id'] ?>-modal-close" shadow-none></button>
                                    </div>
                                    <div class="modal-body">

                                        For the privacy of donors, we will send an email on your behalf and the donor will get back to you.

                                        <form method="post" id="blood-donor-contact" action="./form-action/user-blood-donor-contact-action">

                                            <input type="hidden" id="donor_id" name="donor_id" value="<?php echo $row['id'] ?>">

                                            <div class="input-group">
                                                <label class="input-group-text" for="floatingName">Name</label>
                                                <input type="text" name="name" class="form-control" id="floatingName" placeholder="Your name..." autocomplete="nope" required>
                                            </div>

                                            <div class="input-group">
                                                <label class="input-group-text" for="floatingEmail">Email</label>
                                                <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Your email..." autocomplete="nope" required>
                                            </div>

                                            <div class="input-group">
                                                <label class="input-group-text" for="floatingSubject">Subject</label>
                                                <input type="text" name="subject" class="form-control" id="floatingSubject" placeholder="Email subject..." autocomplete="nope" required>
                                            </div>

                                            <div class="input-group">
                                                <label class="input-group-text" for="floatingMessage">Message</label>
                                                <input type="text" name="message" class="form-control" id="floatingMessage" placeholder="Email message..." autocomplete="nope" required>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary" name="send" id="send">SEND</button>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>


    <script>
        $('.contact-button').click(function() {
            $('#modal-' + $(this).data("id")).modal('show');
        });
    </script>

</body>

</html>