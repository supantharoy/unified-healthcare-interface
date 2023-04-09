<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    session_start();

    $title = 'Specialist';
    include './includes/header.php'
    ?>

    <style>
        .specialist {
            text-align: center;
        }

        .specialist h1 {
            margin-top: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        .doctor-container {
            margin: 50px auto 120px;
            flex-direction: column;
            width: 600px;
        }

        .doctor {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            margin-top: 40px;
            border: 1px #DDDDDD solid;
            padding: 10px;
            height: 140px;
        }

        .doctor .doctor-image img {
            height: 120px;
            margin-right: 20px;
            border-radius: 50%;
        }

        .doctor .doctor-details {
            width: 200px;
            margin-right: 20px;
        }

        .availability {
            margin-top: 20px;
        }

        .doctor .doctor-name {
            color: #0a8aca;
            font-weight: 700;
        }

        .doctor .doctor-specialization {
            text-transform: uppercase;
        }

        .star {
            margin-bottom: 5px;
        }

        .doctor #book-appointment {
            margin-top: 10px;
            background-color: #0a8aca;
        }

        .doctor #book-appointment:hover,
        .doctor #book-appointment:active {
            background-color: #056ea2;
        }

        #modal-close:active,
        #modal-close:focus {
            box-shadow: none;
        }

        .card-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 40px 40px;
            text-align: center;
            margin: 40px 120px 120px;
        }

        .card {
            width: 300px;
            transition: all 0.1s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0px 5px 5px #64626484;
        }

        .card,
        .card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-content {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .card-image {
            width: 300px;
            height: 200px;
            object-fit: cover;
        }

        .card-content-h2 {
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 1.3rem;
            text-transform: uppercase;
        }

        .card-content-h3 {
            margin-top: 10px;
            font-size: 0.8rem;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        a,
        a:focus,
        a:active,
        a:visited {
            text-decoration: none;
            color: inherit;
        }

        .stars-outer {
            display: inline-block;
            position: relative;
            font-family: FontAwesome;
        }

        .stars-outer::before {
            content: "\f006 \f006 \f006 \f006 \f006";
        }

        .stars-inner {
            position: absolute;
            top: 0;
            left: 0;
            white-space: nowrap;
            overflow: hidden;
            width: 0;
            font-family: FontAwesome;
        }

        .stars-inner::before {
            content: "\f005 \f005 \f005 \f005 \f005";
            color: #f8ce0b;
        }
    </style>

</head>


<body>

    <?php

    if (isset($_GET['field'])) {

        $sql = "SELECT * FROM `doctor-login` WHERE `specialization` = '" . $_GET['field'] . "' ORDER BY `id` DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 0) {
    ?>
            <script>
                window.location = "./specialist";
            </script>
        <?php
        } else {
            $row = mysqli_fetch_assoc($result);
        ?>
            <div class="specialist">
                <h1><?php echo $row['specialization'] ?></h1>
            </div>

            <div class="doctor-container" id="doctor-container">
                <?php

                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="doctor" style="user-select:none;">
                        <div class="doctor-image">
                            <img src="./assests/images/doctor-avatar-specialist.png?t=<?php echo time(); ?>">
                        </div>
                        <div class="doctor-details">
                            <span class="doctor-name"><?php echo $row['name'] ?></span> </br>
                            <span class="doctor-qualification"><?php echo $row['qualification'] ?></span> </br>
                            <span class="doctor-experience"><strong>Experience: </strong><?php echo $row['experience'] ?> years</span></br>
                            <?php if ($row['specialization'] == "other") { ?>
                                <span class="doctor-specialization"><?php echo $row['other-s'] ?></span>
                            <?php } else { ?>
                                <span class="doctor-specialization"><?php echo $row['specialization'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="book <?php echo $row['username'] ?>">
                            <div class="star">
                                <div class="stars-outer">
                                    <div class="stars-inner" style="width:<?php echo $row['ratings'] / 5 * 100 ?>%"></div>
                                </div>
                            </div>
                            <?php

                            if ($row['available'] == 1) {
                            ?>
                                <span class="availability" style="color: #03861d;"><i class="fa-solid fa-circle-check"></i>&nbsp; Available</span>
                            <?php
                            } else {
                            ?>
                                <span class="availability" style="color: #ed2020;"><i class="fa-solid fa-circle-xmark"></i>&nbsp; Unavailable</span>
                            <?php
                            }

                            ?>
                            </br>
                            <button class="btn btn-primary" id="book-appointment" data-username="<?php echo $row['username'] ?>" <?php if ($row['available'] == 0) echo "disabled"; ?>>Book Appointment</button>



                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="user-select:none;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Log In Required</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modal-close" shadow-none></button>
                                        </div>
                                        <div class="modal-body">
                                            To Book an Appointment, you need to be logged in as an user!
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>

                                            <button class="btn btn-primary" onclick="window.location.href = './user-login'" ;>
                                                LOGIN
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                <?php } ?>
            </div>
        <?php
        }
    } else { ?>

        <div class="specialist">
            <h1>specialist</h1>
        </div>

        <?php

        $sql = "SELECT * FROM `specialization`";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
        ?>
            <div class="card-container">

                <?php
                while ($row = mysqli_fetch_assoc($result)) {

                    $sql1 = "SELECT * FROM `doctor-login` WHERE `specialization` = '" . $row['link'] . "'";
                    $result1 = mysqli_query($conn, $sql1);

                    if (mysqli_num_rows($result1) > 0) {
                ?>
                        <div class="card">
                            <a href="./specialist?field=<?php echo $row['link'] ?>">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']) ?>" alt="" class="card-image">
                                <div class="card-content">
                                    <h2 class="card-content-h2"><?php echo $row['field'] ?></h2>
                                </div>
                            </a>
                        </div>
                <?php }
                } ?>

            </div>

    <?php
        }
    }
    ?>

    <script>
        // Retrieving the usernames from the database
        // let usernames;

        // var urlParams = window.location.href.split("=")[1];

        // if (urlParams) {

        //     $.ajax({
        //         url: "./form-action/doctor-get-details",
        //         type: "post",
        //         data: {
        //             type: "field",
        //             field: urlParams
        //         },
        //         success: function(result) {
        //             usernames = $.parseJSON(result);
        //             // console.log(usernames.length);

        //             var values = [];
        //             for (i = 0; i < usernames.length; i++) {
        //                 var precision = 100; // 2 decimals
        //                 var randomnum = Math.floor(Math.random() * (5 * precision - 1 * precision) + 1 * precision) / (1 * precision);

        //                 values.push(randomnum);
        //             }


        //             // var values = [2.54, 2.83, 2.35, 2.72, 4.88, 4.56, 4.49, 2.32, 4.47, 4.24, 2.66, 2.76, 3.51, 3.51, 3.09, 2.17, 2.57, 2.74];
        //             var ratings = {};
        //             usernames.forEach((key, i) => ratings[key] = values[i]);

        //             console.log(ratings)

        //             const starTotal = 5;

        //             for (const rating in ratings) {
        //                 console.log(ratings[rating], rating);
        //                 const starPercentage = `${(ratings[rating] / starTotal) * 100}%`;
        //                 document.querySelector(`.${rating} .star .stars-inner`).style.width = starPercentage;
        //             }
        //         },
        //     });
        // }


        $('.book #book-appointment').click(function() {
            <?php
            if (!isset($_COOKIE['user_username'])) {
            ?>
                $('#staticBackdrop').modal('show');
            <?php
            } else { ?>
                window.location.href = './book-appointment?doctor=' + $(this).data("username");
            <?php } ?>
        });
    </script>

</body>

</html>
<?php
include './includes/footer.php'
?>