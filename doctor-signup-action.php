<?php

date_default_timezone_set("Asia/Kolkata");

if (isset($_POST['submit'])) {

    session_start();
    require_once './db/db.php';


    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);

    if (isset($_POST['other-s'])) {
        $other_s = mysqli_real_escape_string($conn, $_POST['other-s']);
    } else {
        $other_s = "";
    }

    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);


    $_SESSION['doctor_name_temp'] = $name;
    $_SESSION['doctor_username_temp'] = $username;
    $_SESSION['doctor_gender_temp'] = $gender;
    $_SESSION['doctor_qualification_temp'] = $qualification;
    $_SESSION['doctor_specialization_temp'] = $specialization;
    $_SESSION['doctor_experience_temp'] = $experience;
    $_SESSION['doctor_other_s_temp'] = $other_s;
    $_SESSION['doctor_password_temp'] = $password;

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php
        $title = 'Doctor Verification';
        include './includes/header.php';
        ?>
    </head>

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

        /* #email-alert-container,
    #mobile-alert-container {
        display: none;
    } */

        .doctor-verification {
            text-align: center;
        }

        .doctor-verification h1 {
            margin-top: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        .doctor-verification h5 {
            margin-top: 30px;
            text-transform: uppercase;
        }

        .container {
            display: flex;
            justify-content: space-evenly;
            margin-top: 50px;
            margin-bottom: 10px;
            text-align: center;
        }

        .container .input-group {
            margin-top: 0;
            box-shadow: none;
            padding: 10px;
        }

        .container input {
            font-size: 1.2rem;
        }

        .container input:focus {
            box-shadow: none;
        }

        #india-image {
            height: 25px;
            margin-right: 10px;
        }

        .input-group-text {
            font-size: 1.2rem;
        }

        .mobile-container,
        .email-container {
            display: flex;
            /* justify-content: space-evenly; */
            flex-direction: column;
            width: 410px;
        }

        #verify-email-otp,
        #verify-mobile-otp {
            font-weight: 700;
            background-color: #0a8aca;
            border: none;
        }

        #verify-email-otp:hover,
        #verify-mobile-otp:hover {
            background-color: #056ea2;
        }


        #email-counter-container,
        #mobile-counter-container,
        #email-msg,
        #mobile-msg {
            display: none;
        }


        #email-counter-container,
        #mobile-counter-container {
            margin-top: 5px;
        }

        #email-msg,
        #mobile-msg {
            color: #ed2020;
            display: none;
        }

        #email-otp-msg,
        #mobile-otp-msg {
            color: #ed2020;
        }

        #send-email-otp,
        #send-mobile-otp {
            margin-top: 10px;
            width: 110px;
            margin-left: auto;
            margin-right: auto;
            font-weight: 700;
            background-color: #0a8aca;
            border: none;
            padding: 8px 0;
            /* color: #fff; */
            /* background-color: #33cfb2; */
        }

        #send-email-otp:hover,
        #send-mobile-otp:hover {
            background-color: #056ea2;
            /* color: #33cfb2;
        background-color: #fff;
        box-shadow: 0 0 13px 2px #33cfb2; */
        }

        #verify-email-form {
            user-select: none;
        }

        #signup {
            color: #fff;
            background-color: #33cfb2;
            padding: 10px 10px;
            font-size: 1.2rem;
            margin: 70px auto 200px;
            transition: all 0.3s ease;
            font-weight: 700;
            width: 120px;
            border-radius: 30px;
            display: block;
        }

        #signup:hover {
            color: #33cfb2;
            background-color: #fff;
            box-shadow: 0 0 13px 2px #33cfb2;
        }
    </style>

    <body>

        <div id="alert">

        </div>

        <div class="doctor-verification">
            <h1>Doctor Verification</h1>
            <h5>Verify your email and mobile number to finish sign up process</h5>
        </div>

        <form action="./form-action/doctor-signup-finish" method="post" id="verify-email-form">
            <div class="container">

                <div class="email-container">
                    <div class="input-group">
                        <label class="input-group-text" for="email">Email ID</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your Email" autocomplete="none">
                    </div>
                    <span id="email-msg"></span>
                    <div style="display:none;" id="email-otp-container">
                        <div class="input-group">
                            <label class="input-group-text" for="email-otp">Email OTP</label>
                            <input type="text" class="form-control" name="email-otp" id="email-otp" placeholder="Enter the OTP" autocomplete="none" maxlength="6" onkeypress="return isNumberKey(event)">
                            <button type="button" class="btn btn-primary" name="verify-email-otp" id="verify-email-otp">VERIFY OTP</button>
                        </div>
                        <span id="email-otp-msg"></span>
                    </div>

                    <button type="button" class="btn btn-primary" name="send-email-otp" id="send-email-otp">SEND OTP</button>

                    <div id="email-counter-container">
                        You can resend OTP in <span id="email-counter"></span>
                    </div>
                </div>

                <div class="mobile-container">
                    <div class="input-group">
                        <label class="input-group-text" for="mobile"><img src="./assests/images/india.png" id="india-image" /> +91</label>
                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter your mobile number" autocomplete="none" maxlength="10" onkeypress="return isNumberKey(event)">
                    </div>
                    <span id="mobile-msg">Mobile number is already Registered!</span>

                    <div style="display:none;" id="mobile-otp-container">
                        <div class="input-group">
                            <label class="input-group-text" for="mobile-otp">Mobile OTP</label>
                            <input type="text" class="form-control" name="mobile-otp" id="mobile-otp" placeholder="Enter the OTP" autocomplete="none" maxlength="6" onkeypress="return isNumberKey(event)">
                            <button type="button" class="btn btn-primary" name="verify-mobile-otp" id="verify-mobile-otp">VERIFY OTP</button>
                        </div>
                        <span id="mobile-otp-msg"></span>
                    </div>

                    <button type="button" class="btn btn-primary" name="send-mobile-otp" id="send-mobile-otp">SEND OTP</button>

                    <div id="mobile-counter-container">
                        You can resend OTP in <span id="mobile-counter">00:05</span>
                    </div>

                </div>
            </div>

            <button type="submit" class="btn" name="signup" id="signup" disabled>SIGN UP</button>
        </form>


        <script>
            // To prevent form resubmission on page reload
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }

            // Retrieving the emails from the database
            let emails;

            $.ajax({
                url: './form-action/doctor-get-details',
                type: 'post',
                data: 'type=email',
                success: function(result) {
                    emails = $.parseJSON(result);
                    // console.log(emails);
                }
            })

            // Retrieving the mobiles from the database
            let mobiles;

            $.ajax({
                url: './form-action/doctor-get-details',
                type: 'post',
                data: 'type=mobile',
                success: function(result) {
                    mobiles = $.parseJSON(result);
                    // console.log(mobiles);
                }
            })

            // Disable Alphabets and special characters for number field
            function isNumberKey(evt) {
                var charCode = (evt.which) ? evt.which : event.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                return true;
            }


            // Email Validation and Email OTP ajax
            let emailSuccessStatus = 0;

            $('#send-email-otp').click(() => {
                const re =
                    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


                if ($('#email').val().trim().length == 0) {
                    $('#email-msg').html("Please enter the email address!");
                    emailSuccessStatus = 0;

                } else if (re.test($('#email').val().trim()) == false) {
                    $('#email-msg').html("Invalid Email Address!");
                    emailSuccessStatus = 0;

                } else if ($.inArray($('#email').val(), emails) != -1) {
                    $('#email-msg').html("Email is already Registered!");
                    emailSuccessStatus = 0;

                } else {
                    $('#email-msg').html("");
                    $('#send-email-otp').attr('disabled', 'disabled');
                    $('#email-counter-container').html("Please Wait...");
                    $('#email-counter-container').css('display', 'block');

                    email = $('#email').val();

                    $.ajax({
                        url: './includes/send-otp',
                        type: 'post',
                        data: {
                            type: 'doctor-email',
                            email: $('#email').val(),
                            subject: "OTP for Doctor Registration"
                        },
                        dataType: "text",
                        success: function(result) {
                            if ($.parseJSON(result) == 'success') {
                                $('#alert').html(`
                            <div class="alert-container" style="width: 390px;" id="email-alert-container">
                                <div class="alert alert-success alert-dismissible fade show">
                                   <strong>OTP sent to your email!</strong> &nbsp;(Valid for 15 minutes)
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);

                                $('#email-counter-container').html(`You can resend OTP in <span id="email-counter"></span>`);
                                $("#email-counter").html('02:00');
                                $('#email-otp-container').css('display', 'block');
                                startTimer(60 * 2 - 1, '#email-counter', '#send-email-otp', '#email-counter-container');
                                emailSuccessStatus = 1;
                            } else {
                                $('#email-counter-container').html("");
                                $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="email-alert-container">
                                <div class="alert alert-danger alert-dismissible fade show">
                                   <strong>There was some error on our side!</strong> &nbsp;Please try again later
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);
                                emailSuccessStatus = 0;
                            }

                        },
                        error: function(error) {
                            console.log(error);
                            $('#email-counter-container').html("");
                            $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="email-alert-container">
                                <div class="alert alert-danger alert-dismissible fade show">
                                   <strong>There was some error on our side!</strong> &nbsp;Please try again later
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);
                            emailSuccessStatus = 0;
                        }
                    })
                }

                if (emailSuccessStatus == 0) {
                    $('#email-otp-container').css('visiblity', 'hidden');
                    $('#email-msg').css('display', 'block');
                } else if (emailSuccessStatus == 1) {
                    $('#email-msg').css('display', 'none');
                }
            })

            $('#email').keyup(() => {
                $('#email-msg').css('display', 'none');
            })


            // Email OTP Verification
            let emailVerificationStatus = 0;

            $("#verify-email-otp").click(() => {
                const re = /^[0-9]{6}$/;


                if ($('#email-otp').val().trim().length < 6) {
                    $('#email-otp-msg').html("Please enter the 6-digit OTP!");
                    emailVerificationStatus = 0;

                } else if (re.test($('#email-otp').val().trim()) == false) {
                    $('#email-otp-msg').html("Invalid OTP!");
                    emailVerificationStatus = 0;
                } else {

                    $.ajax({
                        url: './includes/verify-otp',
                        type: 'post',
                        data: {
                            type: 'email-otp',
                            otp: $('#email-otp').val()
                        },
                        dataType: "text",
                        success: function(result) {
                            // console.log(result);
                            if ($.parseJSON(result) == 'success') {

                                $('#email-msg').html("Email Address Verified!");
                                $('#email-msg').css("color", "#03861d");
                                $('#email-msg').css("display", "block");

                                $('#email-otp-container').css("display", "none");
                                $('#email-counter-container').css("display", "none");
                                $('#send-email-otp').css("display", "none");

                                $('#email').val(email);
                                $('#email').attr("disabled", "disabled");
                                emailVerificationStatus = 1;
                                enableSubmit();
                            } else if ($.parseJSON(result) == 'invalid') {

                                $('#email-otp-msg').html("Invalid OTP!");
                                emailVerificationStatus = 0;

                            } else if ($.parseJSON(result) == 'expired') {

                                $('#email-otp-msg').html("OTP has expired!");
                                emailVerificationStatus = 0;
                            } else {
                                $('#email-counter-container').html("");
                                $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="email-alert-container">
                                <div class="alert alert-danger alert-dismissible fade show">
                                   <strong>There was some error on our side!</strong> &nbsp;Please try again later
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);

                                emailVerificationStatus = 0;
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            $('#email-counter-container').html("");
                            $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="email-alert-container">
                                <div class="alert alert-danger alert-dismissible fade show">
                                   <strong>There was some error on our side!</strong> &nbsp;Please try again later
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);

                            emailVerificationStatus = 0;
                        }
                    })
                }
            });

            $('#email-otp').keyup(() => {
                $('#email-otp-msg').html("");
            })


            // Mobile Validation and Mobile OTP ajax
            let mobileSuccessStatus = 0;

            $('#send-mobile-otp').click(() => {
                const re = /^[6-9]\d{9}$/;

                if ($('#mobile').val().trim().length < 10) {
                    $('#mobile-msg').html("Please enter the 10-digit mobile number!");
                    mobileSuccessStatus = 0;

                } else if (re.test($('#mobile').val().trim()) == false) {
                    $('#mobile-msg').html("Invalid Mobile Number!");
                    mobileSuccessStatus = 0;

                } else if ($.inArray($('#mobile').val(), mobiles) != -1) {
                    $('#mobile-msg').html("Mobile is already Registered!");
                    mobileSuccessStatus = 0;

                } else {
                    $('#mobile-msg').html("");
                    $('#send-mobile-otp').attr('disabled', 'disabled');
                    $('#mobile-counter-container').html("Please Wait...");
                    $('#mobile-counter-container').css('display', 'block');

                    mobile = $('#mobile').val();

                    $.ajax({
                        url: './includes/send-otp',
                        type: 'post',
                        data: {
                            type: 'doctor-mobile',
                            mobile: $('#mobile').val(),
                        },
                        dataType: "text",
                        success: function(result) {
                            if ($.parseJSON(result) == 'success') {
                                $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="mobile-alert-container">
                                <div class="alert alert-success alert-dismissible fade show">
                                    <strong>OTP sent to your mobile number!</strong> &nbsp;(Valid for 15 minutes)
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);

                                $('#mobile-counter-container').html(`You can resend OTP in <span id="mobile-counter"></span>`);
                                $("#mobile-counter").html('02:00');
                                $('#mobile-otp-container').css('display', 'block');
                                startTimer(60 * 2 - 1, '#mobile-counter', '#send-mobile-otp', '#mobile-counter-container');
                                mobileSuccessStatus = 1;
                            } else {
                                $('#mobile-counter-container').html("");
                                $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="mobile-alert-container">
                                <div class="alert alert-danger alert-dismissible fade show">
                                   <strong>There was some error on our side!</strong> &nbsp;Please try again later
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);
                                mobileSuccessStatus = 0;
                            }
                        },

                        error: function(error) {
                            console.log(error);
                            $('#mobile-counter-container').html("");
                            $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="mobile-alert-container">
                                <div class="alert alert-danger alert-dismissible fade show">
                                   <strong>There was some error on our side!</strong> &nbsp;Please try again later
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);
                            mobileSuccessStatus = 0;

                        }
                    })
                }

                if (mobileSuccessStatus == 0) {
                    $('#mobile-otp-container').css('visiblity', 'hidden');
                    $('#mobile-msg').css('display', 'block');
                } else if (mobileSuccessStatus == 1) {
                    $('#mobile-msg').css('display', 'none');
                    // $('#mobile-counter-container').css('display', 'block');
                }
            })

            $('#mobile').keyup(() => {
                $('#mobile-msg').css('display', 'none');
            })


            // Mobile OTP Verification
            let mobileVerificationStatus = 0;

            $("#verify-mobile-otp").click(() => {
                const re = /^[0-9]{6}$/;


                if ($('#mobile-otp').val().trim().length < 6) {
                    $('#mobile-otp-msg').html("Please enter the 6-digit OTP!");
                    mobileVerificationStatus = 0;

                } else if (re.test($('#mobile-otp').val().trim()) == false) {
                    $('#mobile-otp-msg').html("Invalid OTP!");
                    mobileVerificationStatus = 0;
                } else {
                    $.ajax({
                        url: './includes/verify-otp',
                        type: 'post',
                        data: {
                            type: 'mobile-otp',
                            otp: $('#mobile-otp').val()
                        },
                        dataType: "text",
                        success: function(result) {
                            if ($.parseJSON(result) == 'success') {

                                $('#mobile-msg').html("Mobile Number Verified!");
                                $('#mobile-msg').css("color", "#03861d");
                                $('#mobile-msg').css("display", "block");

                                $('#mobile-otp-container').css("display", "none");
                                $('#mobile-counter-container').css("display", "none");
                                $('#send-mobile-otp').css("display", "none");

                                $('#mobile').val(mobile);
                                $('#mobile').attr("disabled", "disabled");
                                mobileVerificationStatus = 1;
                                enableSubmit();

                            } else if ($.parseJSON(result) == 'invalid') {

                                $('#mobile-otp-msg').html("Invalid OTP!");
                                mobileVerificationStatus = 0;

                            } else if ($.parseJSON(result) == 'expired') {

                                $('#mobile-otp-msg').html("OTP has expired!");
                                mobileVerificationStatus = 0;
                            } else {
                                $('#mobile-counter-container').html("");
                                $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="mobile-alert-container">
                                <div class="alert alert-danger alert-dismissible fade show">
                                   <strong>There was some error on our side!</strong> &nbsp;Please try again later
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);

                                mobileVerificationStatus = 0;
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            $('#mobile-counter-container').html("");
                            $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="mobile-alert-container">
                                <div class="alert alert-danger alert-dismissible fade show">
                                   <strong>There was some error on our side!</strong> &nbsp;Please try again later
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);

                            mobileVerificationStatus = 0;
                        }
                    })
                }
            });

            $('#mobile-otp').keyup(() => {
                $('#mobile-otp-msg').html("");
            })


            // OTP Timer
            function startTimer(duration, element, remove, container) {
                var timer = duration,
                    minutes, seconds;

                var counter = setInterval(function() {
                    minutes = parseInt(timer / 60, 10)
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;
                    $(element).html(minutes + ":" + seconds);

                    if (--timer < 0) {
                        $(remove).removeAttr('disabled');
                        $(container).css('display', 'none');
                        clearInterval(counter);
                    }
                }, 1000);
            }

            // Enable Submit Button if email and mobile is verified
            function enableSubmit() {
                if (emailSuccessStatus == 1 & mobileSuccessStatus == 1 && emailVerificationStatus == 1 && mobileVerificationStatus == 1)
                    $('#signup').removeAttr("disabled");
            }
        </script>

    </body>
<?php

    include './includes/footer.php';
    exit();
} else {
    header("Location: ./doctor-signup");
    exit();
}
?>