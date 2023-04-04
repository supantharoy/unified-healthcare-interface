<?php

if (isset($_GET['secret'])) {

    date_default_timezone_set("Asia/Kolkata");
    require_once './db/db.php';

    $secret = $_GET['secret'];
    $email = base64_decode($secret);

    $sql = "SELECT * FROM `doctor-login` WHERE `email` = '$email'";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);

    if ($row['password_change_request'] == 1) {

?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <?php
            session_start();

            $title = 'Reset Password';
            include './includes/header.php';

            ?>

            <style>
                .reset-password {
                    text-align: center;
                }

                .reset-password h1 {
                    margin-top: 50px;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                    word-spacing: 5px;
                    font-weight: 700;
                }

                .reset-password h5 {
                    margin-top: 20px;
                    text-transform: uppercase;
                }

                .reset-password-container {
                    margin: 40px auto 0px;
                    width: 600px;
                    user-select: none;
                }

                .reset-password-container .input-group {
                    margin-top: 0;
                    box-shadow: none;
                    padding: 10px;
                }

                .reset-password-container input {
                    font-size: 1.1rem;
                    border-top-right-radius: 0.375rem !important;
                    border-bottom-right-radius: 0.375rem !important;
                }

                .reset-password-container input:focus {
                    box-shadow: none;
                }

                #india-image {
                    height: 25px;
                    margin-right: 10px;
                }

                .input-group-text {
                    font-size: 1.1rem;
                }

                #tip {
                    position: absolute;
                    right: -1.5%;
                    top: 40%;
                    font-size: 11px;
                    visibility: hidden;
                    color: #0a8aca;
                    z-index: 5;
                }

                #password-msg {
                    margin-bottom: 5px;
                    text-align: center;
                }

                #progress-bar-container {
                    margin: 0 15px;
                    visibility: hidden;
                }


                #submit {
                    color: #fff;
                    background-color: #33cfb2;
                    padding: 10px 15px;
                    font-size: 1.2rem;
                    margin: 30px 0 120px;
                    transition: all 0.3s ease;
                    font-weight: 700;
                    width: 190px;
                    border-radius: 30px;
                    text-transform: uppercase;
                }

                #submit:hover {
                    color: #33cfb2;
                    background-color: #fff;
                    box-shadow: 0 0 13px 2px #33cfb2;
                }

                .field-icon {
                    position: absolute;
                    right: 15px;
                    top: 22px;
                    z-index: 6;
                }

                .toggle-password1,
                .toggle-password2 {
                    display: none;
                }
            </style>
        </head>

        <body>

            <div class="reset-password">
                <h1>Doctor Reset Password</h1>
                <h5>Enter your new password</h5>
            </div>

            <div class="reset-password-container">
                <form action="./form-action/doctor-password-update" method="post" id="password-update-form">
                    <input type="hidden" name="secret" id="secret" value="<?php echo $secret ?>">
                    <div class="input-group">
                        <label class="input-group-text" for="floatingPassword">Enter Password</label>
                        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Your password..." autocomplete="nope" onkeyup="checkPasswordValidity()" onchange="checkPasswordValidity()" required>
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password1"></span>
                        <i id="tip" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Use combination of uppercase letters, lowercase letters, numbers and special characters"></i>
                    </div>

                    <div class="input-group">
                        <label class="input-group-text" for="floatingPassword2">Repeat Password</label>
                        <input type="password" name="password2" class="form-control" id="floatingPassword2" placeholder="Your password..." autocomplete="nope" onkeyup="checkPasswordValidity()" onchange="checkPasswordValidity()" required>
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                    </div>
                    <div id="password-msg"></div>
                    <div id="progress-bar-container" class="progress" role="progressbar" aria-label="Example 1px high" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 6px">
                        <div id="progress-bar" class="progress-bar"></div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn" name="submit" id="submit" onclick="disable(this)" disabled="disabled">reset password</button>
                    </div>
                </form>
            </div>


            <script>
                // Password info button
                $(document).ready(function() {
                    $('[data-toggle="tooltip"]').tooltip();
                });


                // To toggle eye icon and eye-slash icon
                $(".toggle-password1").click(function() {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var input = $("#floatingPassword");
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
                $(".toggle-password2").click(function() {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var input = $("#floatingPassword2");
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });

                // To show or hide password
                const password = document.querySelector("#floatingPassword");
                const password2 = document.querySelector("#floatingPassword2");

                $("#floatingPassword").focus(() => {
                    $("#tip").css("visibility", "visible");
                });
                $("#floatingPassword").focusout(() => {
                    $("#tip").css("visibility", "hidden");
                });

                password.addEventListener("keyup", () => {
                    if (password.value.length == 0) $(".toggle-password1").hide();
                    else $(".toggle-password1").show();
                });
                password.addEventListener("change", () => {
                    if (password.value.length == 0) $(".toggle-password1").hide();
                    else $(".toggle-password1").show();
                });
                password2.addEventListener("keyup", () => {
                    if (password2.value.length == 0) $(".toggle-password2").hide();
                    else $(".toggle-password2").show();
                });
                password2.addEventListener("change", () => {
                    if (password2.value.length == 0) $(".toggle-password2").hide();
                    else $(".toggle-password2").show();
                });

                // To check password equality and password strength
                const passwordMsg = document.querySelector("#password-msg");
                const progressBar = document.querySelector("#progress-bar-container");

                let passwordSuccessStatus = 0;

                function checkPasswordValidity() {
                    pwd1 = password.value;
                    pwd2 = password2.value;


                    if (pwd1 && pwd2) {
                        if (!(pwd1 == pwd2)) {
                            passwordSuccessStatus = 0;
                            passwordMsg.style.color = "#ed2020";
                            passwordMsg.innerHTML = "Passwords do not match!";
                            progressBar.style.visibility = "hidden";
                        } else if (pwd1.length < 6) {
                            passwordSuccessStatus = 0;
                            passwordMsg.style.color = "#ed2020";
                            passwordMsg.innerHTML = "Password must of atleast 6 characters!";
                            progressBar.style.visibility = "hidden";
                        } else {
                            let passwordStrength = 0;

                            if (pwd1.match(/[a-z]/)) passwordStrength += 1;
                            if (pwd1.match(/[A-Z]/)) passwordStrength += 1;
                            if (pwd1.match(/\d/)) passwordStrength += 1;
                            if (pwd1.match(/[^a-zA-Z\d]/)) passwordStrength += 1;
                            if (pwd1.length > 12) passwordStrength += 1;

                            passwordMsg.style.color = "#212529";

                            if (passwordStrength == 1) {
                                passwordMsg.innerHTML = "Password Strength: Very Weak";
                                progressBar.firstElementChild.style.backgroundColor = "#ed2020";
                                progressBar.firstElementChild.style.width = "20%";
                            } else if (passwordStrength == 2) {
                                passwordMsg.innerHTML = "Password Strength: Weak";
                                progressBar.firstElementChild.style.backgroundColor = "#e16f05";
                                progressBar.firstElementChild.style.width = "40%";
                            } else if (passwordStrength == 3) {
                                passwordMsg.innerHTML = "Password Strength: Medium";
                                progressBar.firstElementChild.style.backgroundColor = "#f2e606";
                                progressBar.firstElementChild.style.width = "60%";
                            } else if (passwordStrength == 4) {
                                passwordMsg.innerHTML = "Password Strength: Strong";
                                progressBar.firstElementChild.style.backgroundColor = "#87bc00";
                                progressBar.firstElementChild.style.width = "80%";
                            } else {
                                passwordMsg.innerHTML = "Password Strength: Very Strong";
                                progressBar.firstElementChild.style.backgroundColor = "#03861d";
                                progressBar.firstElementChild.style.width = "100%";
                            }

                            progressBar.style.visibility = "visible";
                            passwordSuccessStatus = 1;
                        }
                    } else {
                        passwordSuccessStatus = 0;
                        passwordMsg.innerHTML = "";
                        progressBar.style.visibility = "hidden";
                    }
                }

                // Disable submit button after form submit
                function disable(e) {
                    setTimeout(function() {
                        e.disabled = true;
                    }, 0);
                    return true;
                }

                $("#password-update-form input").keyup(function() {
                    var empty = false;
                    $("#password-update-form input").each(function() {
                        if ($(this).val() == "") {
                            empty = true;
                        }
                    });

                    if (passwordSuccessStatus == 0) empty = true;
                    else empty = false;

                    if (empty) {
                        $("#submit").attr("disabled", "disabled");
                    } else {
                        $("#submit").removeAttr("disabled");
                    }
                });
            </script>

        </body>

        </html>
        <?php
        include './includes/footer.php'
        ?>


<?php
    } else {
        header("Location: ./doctor-login");
        exit();
    }
} else {
    header("Location: ./doctor-login");
    exit();
}
?>