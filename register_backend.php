<?php
$sFname = $_POST['sFname'];
$sLname = $_POST['sLname'];
$sEmail = $_POST['sEmail'];
$sPassword = $_POST['sPassword'];
$hashed_password = password_hash($sPassword, PASSWORD_DEFAULT);
// echo "Inserting $sFname, $sLname, $sEmail and $sPassword";

include "db_connect.php";
$stmt = $conn->prepare("insert into tb_users (sFname, sLname, sEmail,sPassword) values (?,?,?,?)");
$stmt->bind_param("ssss", $sFname, $sLname, $sEmail, $hashed_password);
$stmt->execute();
$stmt->close();
$conn->close();
// header("Location: index.php");

// echo "Registration success:";

?>
<a href="forums.php">Click here if you are not automatically redirected to the forums page</a>

<form action="login_backend.php" method="post" name="login-form">
        <input type="hidden" class="form-fields" id="email" value="<?= $sEmail ?>" name="sEmail" required>
        <input type="hidden" class="form-fields" id="showPassword" value="<?= $sPassword ?>" name="sPassword" required>

        <button type="submit" class="popup-login-btn btn">Login</button>
</form>
<script>
        // window.location = "index.php";
        window.onload = function() {
                document.forms['login-form'].submit();
        }
</script>