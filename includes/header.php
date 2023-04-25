<!DOCTYPE html>
<html lang="en">

<?php
include './db/db.php';
date_default_timezone_set("Asia/Kolkata");
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish:wght@200;300;400;500;600;700;800;900&display=swa">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gentium+Book+Plus:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <!-- <script src="https://kit.fontawesome.com/93f53a7c5e.js" crossorigin="anonymous"></script> -->
    <link href="./assests/font-awesome/css/fontawesome.css" rel="stylesheet">
    <link href="./assests/font-awesome/css/all.css" rel="stylesheet">
    <link href="./assests/font-awesome/css/solid.css" rel="stylesheet">

    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
    </link>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

    <link rel="icon" type="image/png" href="./assests/images/logo.png?t=<?php echo time(); ?>">

    <style>
        :root {
            --grey: #646264;
        }

        html {
            scroll-behavior: smooth;
            /* user-select: none; */
        }

        * {
            margin: 0;
            padding: 0;
            font-family: 'Gentium Book Plus', serif;
        }

        a,
        a:focus,
        a:active,
        a:target {
            text-decoration: none;
        }

        html::-webkit-scrollbar {
            width: 12px;
        }

        html::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 100px;
        }

        html::-webkit-scrollbar-thumb {
            background-color: #c1c1c1;
            border-radius: 100px;
        }

        html::-webkit-scrollbar-thumb:hover {
            background-color: #a8a8a8;
        }

        #logo {
            font-size: 1.6rem;
            font-weight: 700;
            margin-right: 20px;
            color: var(--grey);
            letter-spacing: 3px;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            width: 100px;
        }

        #logo img {
            height: 30px;
            width: 30px;
        }

        .font-weight-500 {
            font-weight: 500;
        }

        #nav-ul li {
            text-align: center;
            margin-right: 10px;
            text-transform: uppercase;
        }

        #nav-ul li a {
            width: fit-content;
            transition: all 0.3s ease;
            margin-right: 5px;
            padding: 0.5rem 0.5rem 3px 0.5rem;
            color: var(--grey);
        }

        #nav-ul li a:hover {
            border-bottom: 3px var(--grey) solid;
        }

        .nav-item .nav-link {
            margin-top: -2px;
            font-size: 1.23rem;
            font-weight: 400;
        }

        .active {
            border-bottom: 3px var(--grey) solid;
        }

        .not-active {
            border-bottom: 3px solid transparent;
        }

        .navbar-toggler-icon {
            color: #fff;
        }

        #search-input {
            border: #959495 1px solid;
            border-right: transparent;
            border-radius: 0;
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            width: 180px;
        }

        #search-input:focus {
            box-shadow: 0 0 3px 1px #64626484;
            clip-path: inset(-15px 0px -15px -15px);
        }

        #search {
            border-radius: 0;
            color: var(--grey);
            border: #959495 1px solid;
            font-weight: 900;
            margin-right: 10px;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            z-index: 5;
        }

        #search:hover {
            background-color: #3aa592;
            color: #fff;
        }

        .dropdown {
            margin: 2.5px 15px 0 10px;
            cursor: pointer;
            border-radius: 50px;
        }

        .dropdown i {
            font-size: 2rem;
            color: #3aa592;
        }

        .dropdown-pull-right {
            float: right !important;
            right: 0;
            left: auto;
        }

        #dropdown-menu {
            right: 0;
            left: auto;
            text-transform: uppercase;
        }

        #dropdown-menu a {
            color: #d2d2d2;
        }

        #dropdown-menu button {
            color: #d2d2d2;
            text-transform: uppercase;
        }

        @media screen and (max-width: 990px) {
            #nav-ul li a {
                margin: 5px 10px;
            }
        }

        select {
            cursor: pointer;
        }

        .ui-autocomplete {
            margin-top: 50px !important;
            margin-left: 992px !important;
            cursor: pointer;
        }
    </style>

</head>

<body>


    <nav id="navbar" class="navbar navbar-expand-lg" data-bs-theme="dark" style="background-color: #fff;">
        <div class="container-fluid">
            <a class="navbar-brand" href="./" id="logo">
                <img src="./assests/images/logo.png?t=<?php echo time(); ?>" alt="Logo" width="30" height="24">
                UHI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 font-weight-500" id="nav-ul">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($title == 'Unified Healthcare Interface')
                                                echo "active";
                                            else
                                                echo "not-active"
                                            ?>" href="./" title="Home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (substr($title, 0, 4) === "User")
                                                echo "active";
                                            else
                                                echo "not-active"
                                            ?>" href="./user-login" title="User Account">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (substr($title, 0, 6) === "Doctor" && $title != "Doctor Details")
                                                echo "active";
                                            else
                                                echo "not-active"
                                            ?>" href="./doctor-login" title="Doctor Account">Doctor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($title == 'Specialist')
                                                echo "active";
                                            else
                                                echo "not-active"
                                            ?>" href="./specialist">Specialist</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($title == 'About')
                                                echo "active";
                                            else
                                                echo "not-active"
                                            ?>" href="./about">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php if ($title == 'Contact')
                                                echo "active";
                                            else
                                                echo "not-active"
                                            ?>" href="./contact">Contact</a>
                    </li>
                </ul>

                <!-- <form class="d-flex"> -->
                <input class="form-control" type="search" placeholder="Search Doctors..." aria-label="Search" id="search-input">
                <button class="btn font-weight-500" type="submit" id="search" title="Search" style="text-transform: uppercase;"><i class="fa-solid fa-magnifying-glass"></i></button>

                <!-- <div class="ui-widget">
                    <label for="tags">Tags: </label>
                    <input id="tags">
                </div> -->
                <!-- </form> -->


                <div class="dropdown dropdown-pull-right">
                    <i class="fa-solid fa-circle-user" data-bs-toggle="dropdown" aria-expanded="false"></i>
                    <ul class="dropdown-menu" id="dropdown-menu">

                        <?php
                        if (isset($_COOKIE['user_username']) || isset($_COOKIE['user_email']) || isset($_COOKIE['doctor_username']) || isset($_COOKIE['doctor_email'])) { ?>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <form action="./logout?click=true" method="post">
                                    <button class="dropdown-item" type="submit">Log Out</button>
                                </form>
                            </li>
                        <?php
                        } else { ?>
                            <li><a class="dropdown-item" href="./user-login">User Login</a></li>
                            <li><a class="dropdown-item" href="./doctor-login">Doctor Login</a></li>
                        <?php }
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <script>
        const searchInput = document.querySelector('#search-input');
        const search = document.querySelector('#search');

        searchInput.addEventListener('focus', () => {
            search.style.boxShadow = "0 0 4px 1px #64626484";
            search.style.clipPath = "inset(-15px -15px -15px 0px)"
        })

        searchInput.addEventListener('focusout', () => {
            search.style.boxShadow = "0 0 0px 0px #64626484";
        })

        $(function() {

            let usernames;

            $.ajax({
                url: "./form-action/doctor-get-details",
                type: "post",
                async: false,
                data: "type=username",
                success: function(result) {
                    usernames = $.parseJSON(result);
                },
            });

            let names;

            $.ajax({
                url: "./form-action/doctor-get-details",
                type: "post",
                async: false,
                data: "type=name",
                success: function(result) {
                    names = $.parseJSON(result);
                },
            });

            console.log(typeof(usernames));
            console.log(typeof(names));

            usernames_array = Object.values(usernames);
            names_array = Object.values(names);

            console.log(typeof(usernames_array));
            console.log(typeof(names_array));


            var doctor_details = [];
            
            for (i=0; i<usernames.length;i++){
                var singleObj = {};
                singleObj['value'] = names_array[i];
                singleObj['link'] = 'http://localhost/UHI/doctor-details?dn=' + usernames_array[i];
                doctor_details.push(singleObj);
            }
            // names_array.forEach(function(entry) {
            //     var singleObj = {}
            //     singleObj['value'] = entry;
            //     singleObj['link'] = 'http://localhost/UHI/doctor-details?';
            //     listOfObjects.push(singleObj);
            // });

            // console.log(doctor_details);

            // var availableTags = [{
            //         value: "ActionScript",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "AppleScript",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "Asp",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "BASIC",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "C",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "C++",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "Clojure",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "COBOL",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "ColdFusion",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "Erlang",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "Fortran",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "Groovy",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "Haskell",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "Java",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "JavaScript",
            //         link: 'https://google.com'
            //     },
            //     {
            //         value: "Lisp",
            //         link: 'https://google.com'
            //     },

            // ];

            console.log((doctor_details));

            $("#search-input").autocomplete({
                source: doctor_details,
                select: function(event, ui) {
                    console.log(ui.item.link);
                    window.location = ui.item.link;
                }
            });
        });
    </script>
</body>

</html>