<?php

session_start();
$userID = $_POST['userid'];

include "db_connect.php";

if ((isset($_SESSION['id'])) && $_SESSION['role']==10) {
	if($userID == $_SESSION['id']){		
		echo "<script type='text/javascript'>alert('Failed to delete account.');</script>";
		echo '
		<script>
				window.location = "account.php";    
		</script>';
	}else{
		echo $userID;
		$sql = mysqli_query($conn, "DELETE FROM tb_users WHERE id='$userID'");
		$sql2 = mysqli_query($conn, "DELETE FROM tb_posts WHERE iUserid='$userID'");
		$sql3 = mysqli_query($conn, "DELETE FROM tb_comments WHERE user_id='$userID'");
	
		if ($sql) {
			echo "Deleted";
			// header("Location: logout.php");
			echo '
			<script>
					window.location = "account.php";    
			</script>';
		} else {
			echo "<script type='text/javascript'>alert('Failed to delete account');</script>";
			echo '
			<script>
					window.location = "account.php";    
			</script>';
		}
	}
}
?>
<br>
<a href="forums.php">Click here if you are not automatically redirected to the forums page</a>