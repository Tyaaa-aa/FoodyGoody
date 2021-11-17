<?php
session_start();
include "db_connect.php";
?>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="44119854998-mgu9qum77qcmp5ouq6b82lnk62bsec4s.apps.googleusercontent.com">
<nav class="nav">
    <ul class="mainnav">
        <li>
            <a href="forums.php">
                <img src="img/LOGO.png" alt="logo" class="logo" draggable="false">
            </a>
        </li>
    </ul>
    <ul class="mainnav">
        <li><a href="index.php">Home</a></li>
        <li><a href="forums.php">Forums</a></li>
        <li class="userLog">
            <a href="#" class="login_btn btn"> Login</a>
            <div class="login-popup">
                <h2>Login</h2>
                <h4 class="login-popup-close">X</h4>
                <form action="login_backend.php" method="post">
                    <input type="email" class="form-fields" id="email" placeholder="Email" name="sEmail" required>
                    <input type="password" class="form-fields" id="showPassword" placeholder="Password" name="sPassword" required>
                    <br>
                    <br>
                    <input type="checkbox" onclick="showpassword()" id="showPWcb" name="showPWcb">
                    <label for="showPWcb">Show Password</label>
                    <br>
                    <div class="g-signin2" data-onsuccess="onSignIn">Google</div>
                    <button type="submit" class="popup-login-btn btn">Login</button>
                </form>

            </div>
        </li>
        <li class="userLog2"><a href="register.php" class="register_btn btn">Register</a></li>
    </ul>
    <a href="#" class="mobileMenu">
        <ion-icon name="menu-outline"></ion-icon>
    </a>

    <div class="mobileMenu-card">
        <ul class="mainnav">
            <li><a href="index.php">Home</a></li>
            <li><a href="forums.php">Forums</a></li>
            <li class="userLog">
                <a href="#" class="login_btn btn">Login</a>

            </li>
            <li class="userLog2"><a href="register.php" class="register_btn btn">Register</a></li>
        </ul>
    </div>
    <div class="login-popup login-popup-mobile">
        <h2>Login</h2>
        <h4 class="login-popup-close">X</h4>
        <form action="login_backend.php" method="post">
            <input type="email" class="form-fields" id="email-mobile" placeholder="Email" name="sEmail" required>
            <input type="password" class="form-fields" id="password-mobile" placeholder="Password" name="sPassword" required>
            <br>
            <br>
            <input type="checkbox" onclick="showpassword2()" id="showPWcb2" name="showPWcb">
            <label for="showPWcb2">Show Password</label>
            <br>
            <div class="g-signin2" data-onsuccess="onSignIn">Google</div>
            <button type="submit" class="popup-login-btn btn">Login</button>
        </form>
    </div>

</nav>

<?php
if (isset($_SESSION["id"]) && $_SESSION["id"] == true) {

    $sFname = $_SESSION["user"];
    // echo "UR LOGGED IN, HELLO $sFname";
    echo "<script language='javascript'>
            $('.userLog').html('<a href=account.php>u/$sFname</a>');
                $('.userLog2').html(`<a onclick='signOut();' href=logout.php>Logout</a>`);
                console.log('Header Loaded Successfully');
                $('.create-post-btn').css('display','flex');
                </script>";
}
?>
<form action="login_backend_google.php" method="post" name="login_backend_google" id="login_backend_google">
    <input type="hidden" value="" name="googleEmail" required id="googleEmail">
    <input type="hidden" value="" name="googleFname" required id="googleFname">
    <input type="hidden" value="" name="googleLname" required id="googleLname">
</form>
<script>
    function onSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();
        console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
        console.log('Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        // console.log('Family Name: ' + profile.getFamilyName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

        var googleEmail = profile.getEmail();
        var googleFname = profile.getGivenName();
        var googleLname = profile.getName();

        $("#googleEmail").val(googleEmail);
        $("#googleFname").val(googleFname);
        $("#googleLname").val(googleLname);
        <?php
        if (!isset($_SESSION["id"])) {

            echo '$("form#login_backend_google").submit();';
        }
        ?>

        
    }

    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function() {
            console.log('User signed out.');
        });
    }
</script>