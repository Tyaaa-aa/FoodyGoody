<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="44119854998-mgu9qum77qcmp5ouq6b82lnk62bsec4s.apps.googleusercontent.com">

<?php
$googleEmail = $_POST["googleEmail"];
$googleFname = $_POST["googleFname"];
$googleLname = $_POST["googleLname"];


echo $googleEmail . "<br>" . $googleFname . "<br>" . $googleLname . "<br>";

include "db_connect.php";
// $existingUser = mysqli_real_escape_string($conn, $existingUser);  // SECURITY!

$result = mysqli_query($conn, "SELECT 1 FROM tb_users WHERE sEmail='$googleEmail' LIMIT 1");
if (mysqli_fetch_row($result)) {
    // IF USER EXISTS LOGIN USER FIRST
    echo $googleEmail . " exists <br> <br> <br>";

    include "db_connect.php";
    $stmt = $conn->prepare("SELECT id, sFname, role from tb_users where sEmail=?");
    $stmt->bind_param("s", $googleEmail);
    $stmt->execute();

    $stmt->store_result();
    $row = $stmt->num_rows();
    $stmt->bind_result($id, $sFname, $role);
    $stmt->fetch();
    $stmt->close();

    echo $id . "<br>";
    echo $sFname . "<br>";
    session_start();
    $_SESSION["id"] = $id;
    $_SESSION["user"] = $sFname;
    $_SESSION["role"] = $role;
    echo "Login Successful.<br> $id <br> $sFname";

    header("Location: forums.php");
} else {
    // IF USER DOES NOT EXIST REGISTER THEM FIRST
    echo $googleEmail . " does not exist<br><br>";

    $sFname = $googleFname;
    $sLname = $googleLname;
    $sEmail = $googleEmail;
    // echo "Inserting $sFname, $sLname, $sEmail and $sPassword";

    include "db_connect.php";
    $stmt = $conn->prepare("insert into tb_users (sFname, sLname, sEmail) values (?,?,?)");
    $stmt->bind_param("sss", $sFname, $sLname, $sEmail);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    echo $googleEmail . " Inserted into database<br><br>";
    
    include "db_connect.php";
    $stmt = $conn->prepare("SELECT id, sFname, role from tb_users where sEmail=?");
    $stmt->bind_param("s", $googleEmail);
    $stmt->execute();

    $stmt->store_result();
    $row = $stmt->num_rows();
    $stmt->bind_result($id, $sFname, $role);
    $stmt->fetch();
    $stmt->close();

    echo $id . "<br>";
    echo $sFname . "<br>";
    session_start();
    $_SESSION["id"] = $id;
    $_SESSION["user"] = $sFname;
    $_SESSION["role"] = $role;
    echo "Login Successful.<br> $id <br> $sFname";

    header("Location: forums.php");
}

// $stmt = $conn->prepare("SELECT sPassword from tb_users where sEmail=?");
// $stmt->bind_param("s", $sEmail);
// $stmt->execute();

// $stmt->store_result();
// $row = $stmt->num_rows();
// $stmt->bind_result($hashed_password);
// $stmt->fetch();
// $stmt->close();
?>