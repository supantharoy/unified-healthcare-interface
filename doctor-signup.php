<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();

    if (isset($_COOKIE['doctor_username'])) {
        header("Location: ./doctor-dashboard");
        exit();
    } else {

        $title = 'Doctor Sign Up';
        include './includes/header.php';
        require_once './db/db.php';
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

                        <button class="btn btn-secondary" onclick="window.location.href = './logout?doctor=signup'" ;>
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
        .doctor-signup {
            text-align: center;
        }

        .doctor-signup h1 {
            margin-top: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        .form-container {
            margin: 40px auto 0px;
            width: 600px;
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
            width: 140px
        }

        #username-msg,
        #password-msg {
            margin-top: 10px;
            margin-left: 5px;
        }

        #tip {
            position: absolute;
            right: -6%;
            top: 30%;
            font-size: 16px;
            visibility: hidden;
            color: #0a8aca;
        }

        #password-msg {
            margin-bottom: 5px;
        }

        #progress-bar-container {
            margin: 0 15px;
            visibility: hidden;
        }

        #submit {
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

        #submit:hover {
            color: #33cfb2;
            background-color: #fff;
            box-shadow: 0 0 13px 2px #33cfb2;
        }

        .sign-in {
            text-align: center;
            margin-bottom: 120px;
        }
    </style>
</head>

<body>

    <div class="doctor-signup">
        <h1>Doctor Sign Up</h1>
    </div>

    <div class="form-container">
        <form action="./doctor-signup-action" method="post" id="doctor-signup-form">
            <div class="input-group">
                <label class="input-group-text" for="floatingName">Name</label>
                <input type="text" name="name" class="form-control" id="floatingName" placeholder="Your name..." autocomplete="nope" required>
            </div>

            <div class="input-group">
                <label class="input-group-text" for="floatingUsername">Username</label>
                <input type="text" name="username" class="form-control" id="floatingUsername" placeholder="Your username..." autocomplete="nope" required>
            </div>
            <div id="username-msg"></div>

            <div class="input-group">
                <label class="input-group-text" for="floatingGender">Gender</label>

                <select id="floatingGender" class="form-control" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Shopping Bag">Shopping Bag</option>
                </select>
            </div>
           
            <div class="input-group">
                <label class="input-group-text" for="floatingQualification">Qualification</label>
                <input type="text" name="qualification" class="form-control" id="floatingQualification" placeholder="MBBS, MS, ..." autocomplete="nope" required>
            </div>

            <?php
            $sql = "SELECT * FROM `specialization`";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
            ?>
                <div class="input-group">
                    <label class="input-group-text" for="floatingSpecialization">Specialization</label>

                    <select id="floatingSpecialization" class="form-control" name="specialization" required>

                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['link'] ?>"><?php echo $row['field'] ?></option>
                        <?php } ?>
                        <!-- <option value="other" id="other-s">Other</option> -->
                    </select>
                </div>

            <?php } ?>

            <div id="otherSpecializationGroup"></div>

            <div class="input-group">
                <label class="input-group-text" for="floatingExperience">Experience</label>
                <input type="text" name="experience" class="form-control" id="floatingExperience" placeholder="Years of Experience" autocomplete="nope" required>
            </div>

            <div class="input-group">
                <label class="input-group-text" for="floatingPassword">Password</label>
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Your password..." autocomplete="nope" onkeyup="checkPasswordValidity()" onchange="checkPasswordValidity()" required>
                <label class="input-group-text">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password1"></span>
                </label>
                <i id="tip" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Atleast 6 characters with combination of uppercase letters, lowercase letters, numbers and special characters"></i>
            </div>


            <div class="input-group">
                <label class="input-group-text" for="floatingPassword2">Repeat</label>
                <input type="password" name="password2" class="form-control" id="floatingPassword2" placeholder="Repeat password..." autocomplete="nope" onkeyup="checkPasswordValidity()" onchange="checkPasswordValidity()" required>
                <label class="input-group-text">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                </label>
            </div>

            <div id="password-msg"></div>
            <div id="progress-bar-container" class="progress" role="progressbar" aria-label="Example 1px high" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 6px">
                <div id="progress-bar" class="progress-bar"></div>
            </div>

    </div>
    <div class="text-center">
        <button type="submit" class="btn" name="submit" id="submit" disabled="disabled">SUBMIT</button>
    </div>
    </form>
    </div>

    <div class="sign-in">
        Already have an account? <a href="./doctor-login">Sign in</a>
    </div>


    <script>
        // Password info button
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Retrieving the usernames from the database
        let usernames;

        $.ajax({
            url: "./form-action/doctor-get-details",
            type: "post",
            data: "type=username",
            success: function(result) {
                usernames = $.parseJSON(result);
            },
        });

        // Display Textbox, when Other is selected as an option in Qualification
        // $('#floatingQualification').change(() => {

        //     if($('#floatingQualification').val() == 'other-q'){
        //         $('#otherQualificationGroup').html(`<label class="input-group-text" for="floatingQualificationOther">Please Specify</label>
        //         <input type="text" name="qualification" class="form-control" id="floatingQualificationOther" placeholder="Your Qualification..." autocomplete="nope" required>`);
                
        //         $('#otherQualificationGroup').addClass('input-group');

        //         $('#floatingQualification').removeAttr('name');
        //     } else {
        //         $('#otherQualificationGroup').html(``);
        //         $('#otherQualificationGroup').removeClass('input-group');
        //         $('#floatingQualification').attr('name', 'qualification');
        //     }
        // });

        // Display Textbox, when Other is selected as an option in Specialization
        $('#floatingSpecialization').change(() => {

            if($('#floatingSpecialization').val() == 'other'){
                $('#otherSpecializationGroup').html(`<label class="input-group-text" for="floatingSpecializationOther">Please Specify</label>
                <input type="text" name="other-s" class="form-control" id="floatingSpecializationOther" placeholder="Your Specialization..." autocomplete="nope" required>`);
                
                $('#otherSpecializationGroup').addClass('input-group');
                // $('#floatingSpecialization').removeAttr('name');
            } else {
                $('#otherSpecializationGroup').html(``);
                $('#otherSpecializationGroup').removeClass('input-group');
                // $('#floatingSpecialization').attr('name', 'specialization');
            }
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

        // To check password equality
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

        // To check if username is valid or not
        const pattern = /^(?=.{3,16}$)(?![_0-9])(?!.*[_]{2})[a-zA-Z0-9_]+(?<![_])$/;
        const username = document.querySelector("#floatingUsername");
        const usernameMsg = document.querySelector("#username-msg");

        let usernameSuccessStatus = 0;

        username.addEventListener("keyup", () => {
            if (username.value.trim()) {
                var matchStatus = pattern.test(username.value.trim());

                if (matchStatus) {
                    for (let i = 0; i < usernames.length; i++) {
                        if (usernames[i] == username.value.trim()) {
                            usernameSuccessStatus = 0;
                            break;
                        } else {
                            usernameSuccessStatus = 1;
                        }
                    }

                    if (usernames.length == 0) {
                        usernameSuccessStatus = 1;
                    }

                    if (usernameSuccessStatus == 0) {
                        usernameMsg.style.color = "#ed2020";
                        // usernameMsg.style.marginBottom = "inherit"
                        usernameMsg.innerHTML = "Username is taken! Try another one";
                    } else {
                        usernameMsg.style.color = "#03861d";
                        // usernameMsg.style.marginBottom = "inherit"
                        usernameMsg.innerHTML = "Username is available!";
                    }
                } else {
                    // usernameMsg.style.marginBottom = "-60px";
                    usernameMsg.style.color = "#ed2020";
                    usernameMsg.innerHTML =
                        "Username can contain a-z, A-Z, 0-9 and _ (underscore)<br/>Username must not start with 0-9 or _ (underscore)<br/>Username must not end with _ (underscore)<br/>Username must be between 3 to 16 characters";
                    usernameSuccessStatus = 0;
                }
            } else {
                usernameMsg.innerHTML = "";
                // usernameMsg.style.marginBottom = "inherit"
                usernameSuccessStatus = 0;
            }
        });

        // Disable submit button after form submit
        // function disable(e) {
        //     setTimeout(function() {
        //         e.disabled = true;
        //     }, 0);
        //     return true;
        // }

        $("#doctor-signup-form input").keyup(function() {
            var empty = false;
            $("#doctor-signup-form input").each(function() {
                if ($(this).val() == "") {
                    empty = true;
                }
            });

            if (usernameSuccessStatus == 0 || passwordSuccessStatus == 0) empty = true;
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