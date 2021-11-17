<?php
session_start();
$iUserid = $_SESSION["id"];
$sComment = $_POST["sComment"];
$post_id = $_POST["post_id"];
$user_id = $_POST["user_id"];
$likes = $_POST["likes"];

if (isset($_SESSION["id"]) && ($_SESSION["id"] == $iUserid)) {
	include "db_connect.php";
	$stmt = $conn->prepare("INSERT into tb_comments (user_id, post_id, sComment, likes) values (?,?,?,?)");
	$stmt->bind_param("ssss", $user_id, $post_id, $sComment, $likes);
	$stmt->execute();
	$stmt->close();
	$conn->close();
	
    header('Location: ' . $_SERVER['HTTP_REFERER']);


	echo $sComment ."<br>". $post_id ."<br>". $user_id ."<br>". $likes;
} else {
	echo '
	<script>
		alert("You need to login or register an account first!");
		setTimeout(() => {
			window.location = "forums.php";    
		}, 0);
	</script>';
}



// header("Location: forums.php");




?>
<a href="forums.php">Click here if you are not automatically redirected to the forums page</a>