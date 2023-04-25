<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();

    if (isset($_COOKIE['user_username'])) {
        $title = 'User Organ Donation Form';
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

        .dashboard {
            margin-left: 240px;
            margin-top: 60px;
        }

        .user-signup {
            text-align: center;
        }

        .user-signup h1 {
            margin-top: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
            padding-top: 35px;
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
            width: 125px;
        }

        #captcha-msg {
            display: block;
            text-align: center;
            color: #ed2020;
            margin-top: 10px;
        }

        #send {
            color: #fff;
            background-color: #33cfb2;
            padding: 5px 10px;
            font-size: 1.2rem;
            margin: 30px 0 100px;
            transition: all 0.3s ease;
            font-weight: 700;
            width: 120px;
            border-radius: 30px;
        }

        #send:hover {
            color: #33cfb2;
            background-color: #fff;
            box-shadow: 0 0 13px 2px #33cfb2;
        }
    </style>
</head>

<body>

    <div class="dashboard">

        <div class="user-signup">
            <h1>Organ Donor Form</h1>
        </div>

        <div class="form-container">
            <form method="post" id="organ-donor-form" action="./form-action/user-organ-donor-action">

                <div class="input-group">
                    <label class="input-group-text" for="floatingName">Name</label>
                    <input type="text" name="name" class="form-control" id="floatingName" placeholder="Your name..." autocomplete="nope" required>
                </div>

                <div class="input-group">
                    <label class="input-group-text" for="floatingEmail">Email</label>
                    <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Your email..." autocomplete="nope" required>
                </div>

                <div class="input-group">
                    <label class="input-group-text" for="floatingBlood">Blood Group</label>
                    <select id="floatingBlood" class="form-control" name="blood" required>
                        <option value="A+">A+</option>
                        <option value="B+">B+</option>
                        <option value="O+">O+</option>
                        <option value="AB+">AB+</option>
                        <option value="A-">A-</option>
                        <option value="B-">B-</option>
                        <option value="O-">O-</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>

                <div class="input-group">
                    <label class="input-group-text" for="floatingGender">Gender</label>
                    <select id="floatingGender" class="form-control" name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Shopping Bag">Shopping Bag</option>
                    </select>
                </div>

                <div class="input-group">
                    <label class="input-group-text" for="floatingOrgan">Organ</label>
                    <input type="text" name="organ" class="form-control" id="floatingOrgan" placeholder="Organ you are willing to donate..." autocomplete="nope" required>
                </div>

                <div class="input-group">
                    <label class="input-group-text" for="captcha" style="width:max-content">
                        <img src="./includes/get_captcha?rand=<?php echo rand(); ?>" id='captcha_image' alt="captcha" />
                    </label>
                    <input type="text" class="form-control" name="captcha" id="captcha" placeholder="Enter the Captcha" autocomplete="none" maxlength="10" required>

                    <a href="javascript:void(0)" class="input-group-text" id="reloadCaptcha">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </a>
                </div>
                <span id="captcha-msg"></span>

                <div class="text-center">
                    <button type="submit" class="btn" name="send" id="send">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>



    <script>
        // Reload the Captcha function
        function reloadCaptcha() {
            var captchaImage = $("#captcha_image").attr("src");
            captchaImage = captchaImage.substring(0, captchaImage.lastIndexOf("?"));
            captchaImage = captchaImage + "?rand=" + Math.random() * 1000;
            $("#captcha_image").attr("src", captchaImage);
        }
        $("#reloadCaptcha").click(reloadCaptcha);

        // Remove captcha-msg when keyup
        $('#captcha').keyup(() => {
            $('#captcha-msg').html('');
        })

        // Check Captcha Validity using ajax
        $('#organ-donor-form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "./form-action/verify-captcha",
                type: "post",
                data: "captcha=" + $('#captcha').val(),
                success: function(result) {

                    console.log($.parseJSON(result));

                    if ($.parseJSON(result) == 'invalid') {
                        $('#captcha-msg').html('Invalid Captcha!');
                        $('#captcha').val('');
                        reloadCaptcha();
                    } else if ($.parseJSON(result) == 'success') {
                        e.currentTarget.submit();
                    }
                },
            });
        })
    </script>
</body>

</html>