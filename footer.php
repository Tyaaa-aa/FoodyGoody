<footer>
    <nav class="nav footernav">
        <ul class="mainnav footerul">
            <li>
                <a href="index.php">
                    <img src="img/LOGO.png" alt="logo" class="logo" draggable="false">
                </a>
            </li>
        </ul>
        <ul class="mainnav footerul">
            <li><a href="index.php">Home</a></li>
            <li><a href="forums.php">Forums</a></li>
            <li class="userLog"><a href="#" class="login_btn btn">Login</a></li>
            <li class="userLog2"><a href="register.php" class="register_btn btn">Register</a></li>
        </ul>
        <!-- <div class="break"></div> -->
        <ul class="mainnav footerul">
            <!-- <input class="footerSearch" type="search" placeholder="Search the forums"> -->
            <form action="search.php" method="GET">
                <!-- <input class="forumSearch" type="search" name="query" placeholder="Search the forums"> -->
                <input class="footerSearch" type="search" name="query" placeholder="Search the forums">

                <button type="submit" class="search-btn"></button>
            </form>
        </ul>
    </nav>
    <h3>
        Copyright © 2020 FoodyGoody. <br> All rights reserved
        <br>
        <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a>
    </h3>
</footer>
<script type="text/javascript" src="js/script.js?v=6.0"></script>

<?php
if (isset($_SESSION["id"]) && $_SESSION["id"] == true) {

    $sFname = $_SESSION["user"];
    // echo "UR LOGGED IN, HELLO $sFname";
    echo "<script language='javascript'>
            $('.userLog').html('<a href=account.php>u/$sFname</a>');
            $('.userLog2').html(`<a onclick='signOut();' href=logout.php>Logout</a>`);
                console.log('Footer Loaded Successfully');
                $('.create-post-btn').css('display','flex');
                </script>";
}
?>