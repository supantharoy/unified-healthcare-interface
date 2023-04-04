<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();

    $title = 'Contact';
    include './includes/header.php';
    include './form-action/contact-action.php'
    ?>

    <style>
        .alert-container {
            position: absolute;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            width: 450px;
        }

        .alert-container button {
            border-left: 1px #a3cfbb solid;
            border-radius: 0;
        }

        .alert-container button:focus {
            box-shadow: none;
        }

        .contact-us h1 {
            text-align: center;
            margin-top: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            word-spacing: 5px;
            font-weight: 700;
        }

        .form-container {
            margin: 15px auto 40px;
            width: 400px;
        }

        .form-floating {
            margin-bottom: 15px;
        }

        textarea {
            resize: none;
        }

        textarea::-webkit-scrollbar {
            display: none;
        }

        .form-floating input,
        .form-floating textarea {
            border: none;
            border-bottom: 1px #64626484 solid;
            border-radius: 0;
        }

        .form-floating input:focus,
        .form-floating textarea:focus {
            box-shadow: none;
        }

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

        #send {
            color: #fff;
            background-color: #33cfb2;
            padding: 5px 10px;
            font-size: 1.2rem;
            margin: 20px 0 50px;
            transition: all 0.3s ease;
            font-weight: 700;
            width: 125px;
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

    <?php

    if (isset($alert)) {
    ?>
        <div class="alert-container">

            <?php

            if ($alert == 'success') {
            ?>
                <!-- Success Alert -->
                <div class="alert alert-success alert-dismissible fade show">
                    <strong>Thank you for contacting us!</strong> &nbsp;Please check your email.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                </div>

            <?php
            } else if ($alert == 'error') {
            ?>
                <!-- Error Alert -->
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>There was some error on our side!</strong> &nbsp;Please try again later.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="padding-right:0"></button>
                </div>
            <?php
            }
            ?>
        </div>
    <?php
    }
    ?>


    <div class="contact-us">
        <h1>Contact Us</h1>
    </div>

    <div class="form-container">
        <form action="" method="post" autocomplete="off" id="contact-form">
            <div class="form-floating">
                <input type="text" name="name" class="form-control input" id="floatingName" placeholder="Your name..." autocomplete="none" required>
                <label for="floatingInput" class="label">Name</label>
            </div>
            <div class="form-floating">
                <input type="email" name="email" class="form-control input" id="floatingEmail" placeholder="Your email..." autocomplete="none" required>
                <label for="floatingInput" class="label">Email</label>
            </div>
            <div class="form-floating">
                <input type="text" name="subject" class="form-control input" id="floatingSubject" placeholder="Subject..." autocomplete="none" required>
                <label for="floatingInput" class="label">Subject</label>
            </div>
            <div class="form-floating">
                <textarea name="comments" class="form-control input" placeholder="Leave a comment here" id="floatingTextarea" autocomplete="none" style="height: 60px" required></textarea>
                <label for="floatingTextarea" class="label">Comments</label>
            </div>
            <div class="input-group">
                <label class="input-group-text" for="captcha">
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
</body>

<script>
    // To prevent form resubmission on page reload
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    // Reload the Captcha function
    function reloadCaptcha() {
        var captchaImage = $("#captcha_image").attr("src");
        captchaImage = captchaImage.substring(0, captchaImage.lastIndexOf("?"));
        captchaImage = captchaImage + "?rand=" + Math.random() * 1000;
        $("#captcha_image").attr("src", captchaImage);
    }
    $("#reloadCaptcha").click(reloadCaptcha);


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


    // To increase height of textarea with content
    const textarea = document.querySelector("textarea");
    textarea.addEventListener('input', autoResize);

    function autoResize() {
        this.style.height = '60px';
        this.style.height = this.scrollHeight + 'px';
    }



    // Remove captcha-msg when keyup
    $('#captcha').keyup(() => {
        $('#captcha-msg').html('');
    })


    // Check Captcha Validity using ajax
    $('#contact-form').submit(event => {
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
                    $('#send').attr('disabled', true);
                }
            },
        });
    })


    // Disable submit button after form submit
    const name = document.querySelector('#floatingName');
    const email = document.querySelector('#floatingEmail');
    const subject = document.querySelector('#floatingSubject');
    const comments = document.querySelector('#floatingTextarea');


    function disable(e) {
        if (name.value && email.value && subject.value && comments.value) {
            setTimeout(function() {
                e.disabled = true;
            }, 0);
            return true;
        }
    }
</script>

</html>
<?php
include './includes/footer.php'
?>