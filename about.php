<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();

    $title = 'About';
    include './includes/header.php'
    ?>

    <style>
        body {
            color: #484748;
        }

        .team-name{
            text-align: center;
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
        }

        .team-name h1, .team-name h2{
            font-weight: 700;
        }

        .card-container {
            display: flex;
            justify-content: space-evenly;
            text-align: center;
            margin: 20px 50px 120px;
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
        }

        .card-content-h2 {
            margin-top: 20px;
            font-size: 1.3rem;
            text-transform: uppercase;
        }

        .card-content-h3 {
            margin-top: 10px;
            font-size: 0.8rem;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .social-media {
            margin-bottom: 10px;
        }

        .social-media a {
            margin: 10px;
        }

        .error {
            margin-top: 150px;
            text-align: center;
            margin-bottom: 200px;
        }
    </style>
</head>

<body>

    <?php

    $sql = "SELECT * FROM `admin`";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    ?>
        <div class="team-name">
            <h1>About the Developers</h1>
            <h3 style="margin-top:20px">Team Trix</h3>
        </div>
        <div class="card-container">

            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>

                <div class="card">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']) ?>" alt="" class="card-image">
                    <div class="card-content">
                        <h2 class="card-content-h2"><?php echo $row['name'] ?></h2>
                        <h3 class="card-content-h3"><?php echo $row['role'] ?></h3>

                        <div class="social-media">
                            <a class="btn btn-primary btn-floating" style="background-color: #55acee" href="<?php echo $row['twitter'] ?>" role="button">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="btn btn-primary btn-floating" style="background-color: #333333" href="<?php echo $row['github'] ?>" role="button">
                                <i class="fab fa-github"></i>
                            </a>
                            <a class="btn btn-primary btn-floating" style="background-color: #0082ca" href="<?php echo $row['linkedin'] ?>" role="button">
                                <i class="fab fa-linkedin-in"></i>
                            </a>

                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>

    <?php } else { ?>

        <div class="error">
            <h3>
                The developers are busy at this moment!
            </h3>
            <h4>
                Please visit later
            </h4>
        </div>
    <?php
    } ?>


</body>

</html>
<?php
include './includes/footer.php'
?>