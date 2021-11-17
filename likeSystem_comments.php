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
    $comment_id = "NULL";

    $user_id = $_POST["user_id"];
    $comment_id = $_POST["post_id"];
    echo $user_id . "<br>" . $comment_id;
    include "db_connect.php";
    mysqli_query($conn, "UPDATE tb_comments SET likes=likes+1 WHERE id=$comment_id");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>
<br>
<a href="forums.php">Click here if you are not automatically redirected to the forums page</a>