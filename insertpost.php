<?php
session_start();
$iUserid = $_SESSION["id"];
$sForumname = $_POST["sForumname"];
$sTitle = $_POST["sTitle"];
$sPost = $_POST["sPost"];

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
				setTimeout(() => {
					window.location = "forums.php";    
				}, 0);
			</script>';
		}
	} else {
		echo 'There was an error uploading this file';
		echo "<script type='text/javascript'>alert('There was an error uploading this file');</script>";
		echo '
		<script>
			setTimeout(() => {
				window.location = "forums.php";    
			}, 0);
		</script>';
	}

	// echo "Inserting ,$sForumname, $sTitle, $fileDestination, $sPost, $iUserid <br>";

	include "db_connect.php";
	$stmt = $conn->prepare("insert into tb_posts (sForumname, sTitle, sImage,sPost, iUserid) values (?,?,?,?,?)");
	$stmt->bind_param("sssss", $sForumname, $sTitle, $fileDestination, $sPost, $iUserid);
	$stmt->execute();
	$stmt->close();
	$conn->close();
	echo '
	<script>
		setTimeout(() => {
			window.location = "forums.php";    
		}, 0);
	</script>';
	// echo "Insert post success! <br>";
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



// header("Location: forums.php");




?>
<a href="forums.php">Click here if you are not automatically redirected to the forums page</a>