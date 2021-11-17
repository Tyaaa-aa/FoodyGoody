<?php

session_start();


include "db_connect.php";

if (isset($_SESSION['id'])) {

	$userID = $_SESSION["id"];
	echo $userID;
	$sql = mysqli_query($conn, "DELETE FROM tb_users WHERE id='$userID'");
	$sql2 = mysqli_query($conn, "DELETE FROM tb_posts WHERE iUserid='$userID'");
	$sql3 = mysqli_query($conn, "DELETE FROM tb_comments WHERE user_id='$userID'");

	if ($sql) {
		echo "Deleted";
		echo '<script>
		function signOut() {
			var auth2 = gapi.auth2.getAuthInstance();
			auth2.signOut().then(function() {
				console.log("User signed out.");
			});
		}
	</script>';
		unset($_SESSION["id"]);
		unset($_SESSION["user"]);
		session_unset();
		session_destroy();
		header("Location: logout.php");
	} else {
		echo "<script type='text/javascript'>alert('Failed to delete account');</script>";
		echo '
		<script>
				window.location = "forums.php";    
		</script>';
	}
}
?>
<br>
<a href="forums.php">Click here if you are not automatically redirected to the forums page</a>