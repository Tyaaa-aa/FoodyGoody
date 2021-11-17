<?php
include "db_connect.php";
session_start();
//check if logged in
if (!isset($_SESSION['id'])) {
    echo 'Please log in or make an account first';
    echo "<script type='text/javascript'>alert('Please log in or make an account first');</script>";
    echo '
			<script>
				setTimeout(() => {
					window.location = "forums.php";    
				}, 0);
			</script>';
} else {

    $user_id = "NULL";
    $post_id = "NULL";

    $user_id = $_POST["user_id"];
    $post_id = $_POST["post_id"];
    echo $user_id . "<br>" . $post_id;

    // $stmt = $conn->prepare("INSERT into tb_likes (user_id, post_id) values (?,?)");
    // $stmt->bind_param("ii", $user_id, $post_id);
    // $stmt->execute();
    // $stmt->close();
    // $conn->close();

    // include "db_connect.php";
    // $stmt = $conn->prepare("SELECT * from tb_posts where post_id=$post_id");

    // $stmt->execute();
    // $stmt->bind_result($post_id, $sForumname, $sTitle, $fileDestination, $sPost, $iUserid, $tsLastUpdated, $likes);
    // $stmt->close();
    // $conn->close();

    include "db_connect.php";
    mysqli_query($conn, "UPDATE tb_posts SET likes=likes+1 WHERE post_id=$post_id");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
// include "db_connect.php";
// $stmt = $conn->prepare("UPDATE tb_posts (likes) values (?)");
// $stmt->bind_param("i", $updateLike);
// $stmt->execute();
// $stmt->close();
// $conn->close();
// $stmt = mysqli_query($conn, "SELECT * from tb_users where id=$user_id");
?>
<br>
<a href="forums.php">Click here if you are not automatically redirected to the forums page</a>