<?php
$sEmail = $_POST["sEmail"];
$sPassword = $_POST["sPassword"];

include "db_connect.php";


$stmt = $conn->prepare("SELECT sPassword from tb_users where sEmail=?");
$stmt->bind_param("s", $sEmail);
$stmt->execute();

$stmt->store_result();
$row = $stmt->num_rows();
$stmt->bind_result($hashed_password);
$stmt->fetch();
$stmt->close();


echo $hashed_password . "<br>";

$userPassword = password_verify($sPassword, $hashed_password);
echo $userPassword . "<br>";
echo $sEmail . "<br>";
echo $sPassword . "<br>";

if ($userPassword) {
    $id = "NULL";
    include "db_connect.php";
    $stmt = $conn->prepare("SELECT id from tb_users where sEmail=?");
    $stmt->bind_param("s", $sEmail);
    $stmt->execute();

    $stmt->store_result();
    $row = $stmt->num_rows();
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();
    echo $id;
    if ($row == 0) {
        echo "<script type='text/javascript'>alert('Login Failed, Please Try Again or Register an Account First');
        
    </script>";
        echo '
    <script>
        setTimeout(() => {
            window.location = "register.php";    
        }, 10);
    </script>';
    } else {
        include "db_connect.php";
        $stmt = $conn->prepare("SELECT sFname, role from tb_users where id=$id");
        $stmt->bind_result($sFname, $role);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $conn->close();
        session_start();
        $_SESSION["id"] = $id;
        $_SESSION["role"] = $role;
        $_SESSION["user"] = $sFname;
        echo "Login Successful.<br> $id <br> $sFname";

        header("Location: forums.php");
    }
} else {
    echo "<script type='text/javascript'>alert('Login Failed, Please Try Again or Register an Account First');
        
    </script>";
    echo '
    <script>
        setTimeout(() => {
            window.location = "register.php";    
        }, 10);
    </script>';
}
?>
<a href="register.php">Click here if you are not redirected automatically within 3 seconds</a>