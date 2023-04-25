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
        z-index: 4;
    }

    .sidebar .icon {
        margin-right: 10px;
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
        padding-top: 40px;
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
        text-align: center;
        font-weight: 700;
        /* font-size: 1.1rem; */
        margin-bottom: 20px;
    }

    .menu:hover {
        background-color: white;
        color: #0e4066;
        /* color:#3aa592; */
    }
</style>

<body>

    <div class="sidebar">

        <div id="image">
            <img src="./assests/images/user-avatar.png?t=<?php echo time(); ?>">
            <div class="doctor-name"><?php echo $_COOKIE['user_username'] ?></div>
            <!-- <div class="doctor-specialization">Specialization</div> -->
        </div>
        <hr />
        <div class="menu" onclick="window.location.href = './user-dashboard'" ;>
            <span class="icon"><i class="fa-solid fa-table"></i></span>&nbsp;Dashboard
        </div>
        <hr />
        <div class="menu" onclick="window.location.href = './user-dashboard-profile'" ;>
            <span class="icon"><i class="fa-solid fa-circle-user"></i></span>&nbsp;Profile
        </div>
        <hr />
        <div class="menu" onclick="window.location.href = './user-dashboard-appointment'" ;>
            <span class="icon"><i class="fas fa-calendar-alt"></i></span>&nbsp;Appointments
        </div>
        <hr />
        <div class="menu">
            <span class="icon"><i class="fa-solid fa-circle-user"></i></span>&nbsp;Payment History
        </div>
        <hr />
        <div class="menu" onclick="window.location.href = './user-dashboard-organ-donation'" ;>
            <span class="icon"><i class="fa-solid fa-hand-holding-heart"></i></span>Organ Donation
        </div>
        <hr />
        <div class="menu" onclick="window.location.href = './user-dashboard-blood-donation'" ;>
            <span class="icon"><i class="fa-solid fa-droplet"></i></span>&nbsp;&nbsp;Blood Donation
        </div>
        <hr />
        <div style="margin-top:70px">
            <hr />
            <div class="menu" onclick="window.location.href = './logout?click=true'" ;><span class="icon"><i class="fas fa-sign-out-alt"></i></span>Log Out</div>
            <hr />
        </div>
    </div>

</body>