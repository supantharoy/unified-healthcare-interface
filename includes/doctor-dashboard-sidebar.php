<style>
    .sidebar {
        background-color: #0e4066;
        /* background-color: #3aa592; */
        color: #fff;
        width: 240px;
        height: 100%;
        padding: 0;
        /* font-size: 1.1rem; */
        text-transform: uppercase;
        font-weight: 400;
        position: fixed;
        left: 0;
    }

    .icon i {
        /* margin-right: 10px; */
        width: 30px;
    }

    /* a, a:active, a:visited, a:hover{
        text-decoration: none;
        color: inherit;
    } */

    .menu {
        padding: 10px 25px;
        cursor: pointer;
    }

    #image {
        padding-top: 25px;
        text-align: center;
        margin-bottom: 20px;
    }

    #image img {
        display: block;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto;
    }

    hr {
        margin: 0px;
    }

    div.menu:first-child {
        background-color: #fff;
        color: #0e4066;
    }

    #image .doctor-name {
        margin-top: 15px;
        font-weight: 700;
    }

    #image .doctor-specialization {
        font-size: 0.8rem;
    }

    .menu:hover {
        background-color: white;
        color: #0e4066;
        /* color:#3aa592; */
    }
    
</style>

<body>

    <?php

    $sql = "SELECT * FROM `doctor-login` WHERE `username` = '" . $_COOKIE['doctor_username'] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result)

    ?>

    <div class="sidebar">

        <div id="image">
            <img src="https://img.freepik.com/free-icon/user_318-159711.jpg">
            <div class="doctor-name">Dr. <?php echo $row['name'] ?></div>
            <div class="doctor-specialization">
                <?php
                if ($row['specialization'] == 'other') {
                    echo $row['other-s'];
                } else {
                    echo $row['specialization'];
                }
                ?>
            </div>
        </div>
        <hr />
        <div class="menu" onclick="window.location.href = './doctor-dashboard'" ;>
            <span class="icon"><i class="fa-solid fa-table"></i></span>Dashboard
        </div>
        <hr />
        <div class="menu" onclick="window.location.href = './doctor-dashboard-profile'" ;>
            <span class="icon"><i class="fa-solid fa-circle-user"></i></span>Profile
        </div>
        <hr />
        <div class="menu" onclick="window.location.href = './doctor-dashboard-availability'" ;>
            <span class="icon"><i class="fa-solid fa-business-time"></i></span>Availability
        </div>
        <hr />
        <div class="menu" onclick="window.location.href = './doctor-dashboard-appointment'" ;>
            <span class="icon"><i class="fas fa-calendar-alt"></i></span>Appointments
        </div>
        <hr />
        <div class="menu"><span class="icon"><i class="fa-solid fa-circle-user"></i></span>Payment History</div>
        <hr />
        <div class="menu"><span class="icon"><i class="fa-solid fa-hand-holding-heart"></i></span>Organ Donation</div>
        <hr />
        <div style="margin-top:60px">
            <hr />
            <div class="menu" onclick="window.location.href = './logout?click=true'" ;><span class="icon"><i class="fas fa-sign-out-alt"></i></span>Log Out</div>
            <hr />
        </div>
    </div>

</body>