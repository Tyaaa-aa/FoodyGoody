<?php
	
$post_id = $_POST["post_id"];
$sForumname = $_POST["sForumname"];
$sTitle = $_POST["sTitle"];
$sPost = $_POST["sPost"];
$fileDestination = $_POST["fileDestination"];
//get the details of the uploaded file
$file = $_FILES['sImage'];
$fileName = $_FILES['sImage']['name'];
$fileTmpName = $_FILES['sImage']['tmp_name'];
$fileSize = $_FILES['sImage']['size'];
$fileError = $_FILES['sImage']['error'];
$fileType = $_FILES['sImage']['type'];

//define upload folder (relative to current path)
$uploadFolder = 'postIMG/';
$maxFileSizeinBytes = 5000000;

//extract file extension
$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));

//define allowed extension
$allowed = array('jpg', 'jpeg', 'png', 'gif');

/*echo "$fileName<br>$fileTmpName<br>$fileSize<br>$fileActualExt";*/

if (in_array($fileActualExt, $allowed)) {
	if ($fileError === 0) {
		if ($fileSize < $maxFileSizeinBytes) {
			$fileNameNew = uniqid('IMG_', 'false') . "." . $fileActualExt;
			$fileDestination = $uploadFolder . $fileNameNew;
			move_uploaded_file($fileTmpName, $fileDestination);
		} else {
			echo 'The file is too big';
			echo "<script type='text/javascript'>alert('The file is too big');</script>";
			echo '
			<script>
					window.location = "forums.php";    
			</script>';
		}
	} else {
		echo 'There was an error uploading this file';
		echo "<script type='text/javascript'>alert('There was an error uploading this file');</script>";
		echo '
		<script>
				window.location = "forums.php";    
		</script>';
	}

	session_start();
	$iUserid = $_SESSION["id"];
	
		include "db_connect.php"; 
		// $stmt = $conn->prepare("update tb_posts set sPost=?, set sForumname=?, set sTitle=?, set fileDestination=?, tsLastUpdated=current_timestamp where post_id=?"); 
		// $stmt = $conn->prepare("update tb_posts (sPost, sForumname, sTitle, fileDestination, post_id) values (?,?,?,?,?)"); 
		$sTitle = $sTitle . "<span> (edited)</span>";
		echo "Updating: $sPost, $sForumname, $sTitle, $fileDestination, $post_id <br> <br> $iUserid <br>";
		
		$stmt = $conn->prepare("UPDATE tb_posts SET sPost=?, sForumname=?, sTitle=?, sImage=? WHERE post_id=?");
	
		$stmt->bind_param("ssssi", $sPost, $sForumname, $sTitle, $fileDestination, $post_id);
		
		$stmt->execute(); 
		$stmt->close();
		$conn->close(); 
		echo '
		<script>
				window.location = "forums.php";
		</script>';
	
} else {
	echo 'You cannot upload file of this type';
	echo "<script type='text/javascript'>alert('You cannot upload file of this type');</script>";
	echo '
	<script>
		setTimeout(() => {
			window.location = "forums.php";    
		}, 0);
	</script>';
}


?>
<a href="forums.php">Click here if you are not automatically redirected to the forums page</a>
