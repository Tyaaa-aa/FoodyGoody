<?php
session_start();

include "db_connect.php";


if (!isset($_SESSION['id'])) {
	header("Location: index.php");
}
$user_id = $_SESSION["id"];
$postUser_ID = "NULL";
$post_id = $_GET["post_id"];


include "db_connect.php";
$raw_results = mysqli_query($conn, "SELECT * from tb_posts where post_id=$post_id");

while ($results = mysqli_fetch_array($raw_results)) {
	$postUser_ID = $results['iUserid'];
}

$sessionID = $_SESSION['id'];

echo $sessionID . "<br>";
echo $user_id . "<br>";
echo $postUser_ID . "<br>";
if (!isset($_SESSION['id']) or $sessionID != $postUser_ID) {
	$post_id = "NULL";
	echo "YOU AREN'T ALLOWED TO DELETE OTHER USERS POSTS! >:( <br>";
	header("Location: forums.php");
}
else{
	echo "Trying to delete post of id $post_id";
	
	$stmt = $conn->prepare("delete from tb_posts where post_id=?");
	$stmt->bind_param("i", $_GET["post_id"]);
	$stmt->execute();
	$stmt->close();
	$conn->close();
	header("Location: forums.php");

}
if(isset($_SESSION['id']) && $_SESSION['role']==10){
    echo "Trying to delete post of id $post_id as admin";
    
    $stmt = $conn->prepare("delete from tb_posts where post_id=?");
    $stmt->bind_param("i", $_GET["post_id"]);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: forums.php");
}
?>
<br>
<a href="forums.php">Click here if you are not automatically redirected to the forums page</a>