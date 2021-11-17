<!DOCTYPE html>
<html>

<?php include 'head.php'; ?>

<body>
    <header id="register-header">
        <?php include 'header.php'; ?>
    </header>

    <section id="register">
        <div class="content">
            <h1>Register a new account</h1>
            <div class="register-container">
                <div class="register-column1">
                    <img src="img/register bg.png" class="register-img" draggable="false">
                </div>

                <div class="register-column2">
                    <form action="register_backend.php" method="post" class="register-form">
                        <div>
                            <input type="text" class="form-fields form-field-half" id="fname" placeholder="First Name" name="sFname" required>
                            <input type="text" class="form-fields form-field-half" id="lname" placeholder="Last Name" name="sLname" required>
                        </div>

                        <input type="email" class="form-fields" id="email-register" placeholder="Email" name="sEmail" required autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">

                        <input type="password" class="form-fields" id="password-register" placeholder="Password" name="pw" required minlength="8">

                        <input type="password" class="form-fields" id="cnfm-password-register" placeholder="Confirm Password" name="sPassword" required minlength="8">
                        <span id="message"></span>
                        <div class="register-chkbox">
                            <input type="checkbox" class="agree-chkbox" id="agreement" name="agreement" value="agreement" required minlength="8">

                            <label id="edit-terms-label" for="agreement"> I agree to the <a href="#">Terms</a> & <a href="#">Privacy Policy</a></label>
                        </div>

                        <button type="submit" class="register-btn btn">Register</button>
                        <div class="g-signin2" data-onsuccess="onSignIn">Google</div>
                        <a href="#" class="register-login-prompt">Login Instead</a>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <script>
        $("#agreement, #edit-terms-label").css("display", "none");
        $('#password-register, #cnfm-password-register').on('keyup', function() {
            if ($('#password-register').val().length >= 8) {
                if ($('#password-register').val() == $('#cnfm-password-register').val()) {
                    $('#message').html('Passwords Match').css('color', 'green');
                    $("#agreement, #edit-terms-label").css("display", "inline-block");
                    $("#agreement, #edit-terms-label").css("pointer-events", "auto");
                } else {
                    $("#agreement, #edit-terms-label").css("display", "none");
                    $("#agreement, #edit-terms-label").css("pointer-events", "none");
                    $('#message').html('Passwords do not match!').css('color', 'red');
                }
            } else {
                $("#agreement, #edit-terms-label").css("display", "none");
                $("#agreement, #edit-terms-label").css("pointer-events", "none");
                $('#message').html('Passwords must be at least 8 characters!').css('color', 'red');
            }
        });
    </script>
</body>

</html>
<?php
if (isset($_SESSION["id"]) && $_SESSION["id"] == true) {

    echo '<script>window.location = "index.php";
        </script>';
}
?>