// Password info button
$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

// Retrieving the usernames from the database
let usernames;

$.ajax({
  url: "./form-action/get-details.php",
  type: "post",
  data: "type=username",
  success: function (result) {
    usernames = $.parseJSON(result);
  },
});

// To add color to labels when the corresponding input field is focussed
const label = Array.from(document.getElementsByClassName("label"));
const input = Array.from(document.getElementsByClassName("form-control"));

input.forEach((element, index) => {
  element.addEventListener("focus", () => {
    label[index - 1].style.color = "#0fabd2";
  });
  element.addEventListener("focusout", () => {
    label[index - 1].style.color = "inherit";
  });
});

// To toggle eye icon and eye-slash icon
$(".toggle-password1").click(function () {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $("#floatingPassword");
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
$(".toggle-password2").click(function () {
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
const tips = document.querySelector(".tips");

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

// To check password equality
const passwordMsg = document.querySelector("#password-msg");
const progressBar = document.querySelector("#progress-bar-container");

let passwordSuccessStatus = 0;

function checkPasswordValidity() {
  pwd1 = password.value;
  pwd2 = password2.value;

  tips.style.display = "block";

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
const name = document.querySelector("#floatingName");

function disable(e) {
  setTimeout(function () {
    e.disabled = true;
  }, 0);
  return true;
}

$("#user-signup-form input").keyup(function () {
  var empty = false;
  $("#user-signup-form input").each(function () {
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
