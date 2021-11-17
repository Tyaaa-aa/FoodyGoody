<?php

session_start();
unset($_SESSION["id"]);
unset($_SESSION["user"]);
session_unset();
session_destroy();
echo "You Have Logged Out<br>";
header("Location: index.php");
?>
<a href="index.php">Click here if you are not automatically redirected</a>
<script>
    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function() {
            console.log('User signed out.');
        });
    }
</script>