<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();

    if (isset($_COOKIE['doctor_username'])) {
        header("Location: ./doctor-dashboard");
        exit();
    } else {

        $title = 'Doctor Login';
        include './includes/header.php';
        include_once './db/db.php';
    }

    if (isset($_COOKIE['user_username']) || isset($_COOKIE['user_email'])) {
    ?>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="user-select:none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">User Session Detected</h1>
                    </div>
                    <div class="modal-body">
                        We have detected an active User Account Session. If you wish to log in as an doctor, please log out of user account first.
                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-secondary" onclick="window.location.href = './logout?doctor=login'" ;>
                            LOG OUT
                        </button>

                        <button class="btn btn-primary" onclick="window.location.href = './user-dashboard'" ;>
                            CONTINUE AS USER
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trigger modal on Page Reload -->
        <script type="text/javascript">
            $(window).on('load', function() {
                $('#staticBackdrop').modal('show');
            });
        </script>

    <?php
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

        .doctor-login h1 {
            text-align: center;
            margin-top: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        .form-container {
            margin: 30px auto 0px;
            width: 400px;
            user-select: none;
        }

        .form-floating {
            margin-bottom: 20px;
        }

        .form-floating input {
            border: none;
            border-bottom: 1px #64626484 solid;
            border-radius: 0;
        }

        .form-floating input:focus {
            box-shadow: none;
        }

        .form-check {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .form-check,
        .form-check-label,
        .form-check-input {
            cursor: pointer;
        }

        #remember-checkbox {
            border: 1px black solid;
        }

        #remember-checkbox:focus {
            box-shadow: 0 0 0 0;
        }

        /* #forgot-password-container {
            position: absolute;
            left: 285px;
            right: 0;
            top: 353px;
            margin-left: auto;
            margin-right: auto;
            width: max-content;
        }

        #forgotPassword {
            background: none !important;
            border: none;
            padding: 0 !important;
            color: #0d6efd;
            cursor: pointer;

        } */

        .input-group {
            margin-top: 30px;
        }

        .input-group input {
            font-size: 1.2rem;
        }

        .input-group input:focus {
            box-shadow: none;
        }

        #captcha-msg {
            display: block;
            text-align: center;
            color: #ed2020;
            margin-top: 10px;
        }

        #login {
            color: #fff;
            background-color: #33cfb2;
            padding: 5px 10px;
            font-size: 1.2rem;
            margin: 20px 0 20px;
            transition: all 0.3s ease;
            font-weight: 700;
            width: 120px;
            border-radius: 30px;
        }

        #login:hover {
            color: #33cfb2;
            background-color: #fff;
            box-shadow: 0 0 13px 2px #33cfb2;
        }

        .sign-up {
            text-align: center;
            margin-bottom: 150px;
        }

        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
        }

        .toggle-password {
            display: none;
        }
    </style>
</head>

<body>

    <?php
    if (isset($_SESSION['credentials'])) {
        if ($_SESSION['credentials'] == 'wrong') { ?>

            <div class="alert-container" style="width: 300px;">
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Credentials do not match!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                </div>
            </div>
        <?php
        } else if ($_SESSION['credentials'] == 'not_found') { ?>

            <div class="alert-container" style="width: 250px;">
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Username not found!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                </div>
            </div>
        <?php
        } else if ($_SESSION['credentials'] == 'not_registered') { ?>

            <div class="alert-container" style="width: 250px;">
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Email not found!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                </div>
            </div>
        <?php }
    } else if (isset($_SESSION['password_change'])) {
        if ($_SESSION['password_change'] == 'success') {
        ?>
            <div class="alert-container" style="width: 300px;">
                <div class="alert alert-success alert-dismissible fade show">
                    <strong>Password changed successfully!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                </div>
            </div>
        <?php
        } else if ($_SESSION['password_change'] == 'failure') {
        ?>
            <div class="alert-container" style="width: 370px;">
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Failed to change password!</strong> Please try again
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                </div>
            </div>
    <?php
        }
    }
    unset($_SESSION['credentials']);
    unset($_SESSION['password_change']);
    ?>

    <div class="doctor-login">
        <h1>Doctor Login</h1>
    </div>

    <div class="form-container">
        <form action="./form-action/doctor-login-action" method="post" autocomplete="off" id="doctor-login-form">

            <div class="form-floating">
                <input type="text" name="username" class="form-control input" id="floatingUsername" placeholder="Your username..." required>
                <label for="floatingInput" class="label">Email/Username</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control input" id="floatingPassword" placeholder="Your password..." required>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                <label for="floatingInput" class="label">Password</label>
            </div>

            <div class="form-check form-switch">
                <div>
                    <input class="form-check-input" name="save" value="yes" type="checkbox" id="remember-checkbox">
                    <label class="form-check-label" for="remember-checkbox">Remember Me</label>
                </div>
                <div class="text-center" id="forgot-password-container">
                    <a href="./doctor-forgot-password" id="forgotPassword"> Forgot Password? </a>
                </div>
            </div>


            <div class="input-group">
                <label class="input-group-text" for="captcha">
                    <img src="./includes/get_captcha?rand=<?php echo rand(); ?>" id='captcha_image' alt="captcha" />
                </label>
                <input type="text" class="form-control" name="captcha" id="captcha" placeholder="Enter the Captcha" autocomplete="none" maxlength="6" required>

                <a href="javascript:void(0)" class="input-group-text" id="reloadCaptcha">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </a>
            </div>
            <span id="captcha-msg"></span>

            <div class="text-center">
                <button type="submit" class="btn" name="login" id="login">LOG IN</button>
            </div>

        </form>
    </div>

    <div class="sign-up">
        Don't have an account? <a href="./doctor-signup">Sign Up</a>
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


        // To toggle eye icon and eye-slash icon
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $('#floatingPassword');
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        // To show or hide password
        const password = document.querySelector('#floatingPassword');

        password.addEventListener('keyup', () => {
            if (password.value.length == 0)
                $(".toggle-password").hide();
            else
                $(".toggle-password").show();
        })
        password.addEventListener('change', () => {
            if (password.value.length == 0)
                $(".toggle-password").hide();
            else
                $(".toggle-password").show();
        })


        // To add color to labels when the corresponding input field is focussed
        const label = Array.from(document.getElementsByClassName('label'));
        const input = Array.from(document.getElementsByClassName('input'));

        input.forEach((element, index) => {
            element.addEventListener('focus', () => {
                label[index].style.color = "#0fabd2";
            })
            element.addEventListener('focusout', () => {
                label[index].style.color = "inherit";
            })
        })

        // Remove captcha-msg when keyup
        $('#captcha').keyup(() => {
            $('#captcha-msg').html('');
        })


        // Check Captcha Validity using ajax
        $('#doctor-login-form').submit(event => {
            event.preventDefault();

            $.ajax({
                url: "./form-action/verify-captcha",
                type: "post",
                data: "captcha=" + $('#captcha').val(),
                success: function(result) {

                    if ($.parseJSON(result) == 'invalid') {
                        $('#captcha-msg').html('Invalid Captcha!');
                        $('#captcha').val('');
                        reloadCaptcha();

                    } else if ($.parseJSON(result) == 'success') {
                        event.currentTarget.submit();
                    }
                },
            });
        })
    </script>

</body>

</html>
<?php
include './includes/footer.php'
?>