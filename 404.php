<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $title = 'Page Not Found';
        include './includes/header.php';
    ?>

    <style>
        #error-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 70px;
            margin-bottom: 100px;
        }

        #error {
            text-align: center;
        }

        #error h1,
        #error h3 {
            margin: 10px;
            cursor: default;
        }

        #error h1 {
            font-size: 8em;
            border-bottom: 1px dashed black;
        }

        #error a,
        #error a:active,
        #error a:focus,
        #error a:hover {
            text-decoration: none;
        }

        #error a {
            font-weight: 700;
            background-color: #0a8aca;
            border: none;
            padding: 8px 10px;
            text-transform: uppercase;
            margin-top: 30px;
            font-size: 1.1rem;
        }

        #error a:hover {
            background-color: #056ea2;
        }
    </style>
</head>

<body>
    <div id="error-container">
        <div id="error">
            <h1>
                <span id="digit1">4</span>
                <span id="digit2">0</span>
                <span id="digit3">4</span>
            </h1>
            <h3>PAGE NOT FOUND</h3>
            <a href="./" class="btn btn-primary">Return To Home</a>
        </div>
    </div>

</body>

</html>
<?php
include './includes/footer.php'
?>