<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = 'Forgot Password';
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

    .forgot-password {
        text-align: center;
    }

    .forgot-password h1 {
        margin-top: 50px;
        text-transform: uppercase;
        letter-spacing: 2px;
        word-spacing: 5px;
        font-weight: 700;
    }

    .forgot-password h5 {
        margin-top: 30px;
        text-transform: uppercase;
    }

    .email-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        width: 500px;
        margin: 50px auto 120px;
    }

    .email-container .input-group {
        margin-top: 0;
        box-shadow: none;
        padding: 10px;
    }

    .email-container input {
        font-size: 1.2rem;
    }

    .email-container input:focus {
        box-shadow: none;
    }

    .input-group-text {
        font-size: 1.2rem;
    }

    #email-msg {
        color: #ed2020;
    }

    #reset-password {
        margin: 30px auto 10px;
        width: 150px;
        font-weight: 700;
        background-color: #0a8aca;
        border: none;
        padding: 8px 0;
    }

    #reset-password:hover {
        background-color: #056ea2;
    }
</style>

<body>

    <div id="alert"></div>

    <div class="forgot-password">
        <h1>Forgot Password</h1>
        <h5>Enter user email to reset the password</h5>
    </div>

    <div class="email-container">

        <div class="input-group">
            <label class="input-group-text" for="email">Email ID</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter your Email" autocomplete="none">
        </div>
        <span id="email-msg"></span>

        <button type="button" class="btn btn-primary" id="reset-password">RESET&nbsp; PASSWORD</button>
        <span id="wait-msg"></span>

    </div>


    <script>
        // Retrieving the emails from the database
        let emails;

        $.ajax({
            url: './form-action/user-get-details',
            type: 'post',
            data: 'type=email',
            success: function(result) {
                emails = $.parseJSON(result);
                // console.log(emails);
            }
        })

        // Email Validation and Email OTP ajax

        $('#reset-password').click(() => {
            const re =
                /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


            if ($('#email').val().trim().length == 0) {
                $('#email-msg').html("Please enter the email address!");

            } else if (re.test($('#email').val().trim()) == false) {
                $('#email-msg').html("Invalid Email Address!");

            } else if ($.inArray($('#email').val(), emails) == -1) {
                $('#email-msg').html("Email is not Registered!");

            } else {
                $('#email-msg').html("");
                $('#wait-msg').html("Please Wait...");

                $.ajax({
                    url: './form-action/user-reset-password-action',
                    type: 'post',
                    data: {
                        email: $('#email').val(),
                    },
                    dataType: "text",
                    success: function(result) {
                        if ($.parseJSON(result) == 'success') {
                            $('#alert').html(`
                            <div class="alert-container" style="width: 390px;" id="email-alert-container">
                                <div class="alert alert-success alert-dismissible fade show">
                                   <strong>Reset link has been sent to your email</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);
                        } else {
                            $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="email-alert-container">
                                <div class="alert alert-danger alert-dismissible fade show">
                                   <strong>There was some error on our side!</strong> &nbsp;Please try again later
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);
                        }
                        $('#wait-msg').html("");
                    },
                    error: function(error) {
                        console.log(error);
                        $('#alert').html(`
                            <div class="alert-container" style="width: 460px;" id="email-alert-container">
                                <div class="alert alert-danger alert-dismissible fade show">
                                   <strong>There was some error on our side!</strong> &nbsp;Please try again later
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                                </div>
                            </div>`);
                        $('#wait-msg').html("");
                    }
                })
            }
        })

        $('#email').keyup(() => {
            $('#email-msg').html("");
        })
    </script>
</body>

</html>
<?php
include './includes/footer.php'
?>