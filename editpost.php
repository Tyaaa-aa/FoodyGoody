<?php include 'head.php'; ?>

<header>
	<?php include 'header.php'; ?>
</header>
<?php
$post_id = $_GET["post_id"];
include "db_connect.php";
$stmt = $conn->prepare("select * from tb_posts where post_id=?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$stmt->bind_result($post_id, $sForumname, $sTitle, $fileDestination, $sPost, $iUserid, $likes, $tsLastUpdated);
$stmt->fetch();

$sTitle = str_replace("<span> (edited)</span>","",$sTitle);
$sessionID = $_SESSION["id"];

// check if logged in and if logged in user is same as selected post author
if (!isset($_SESSION['id']) or $sessionID != $iUserid) {
	// header("Location: forums.php");
}

?>
<div class="filter"></div>
<div class="create-post-container edit-container">
	<form action="updatepost.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="post_id" value=<?= $post_id ?>>
		<input type="hidden" name="fileDestination" value=<?= $fileDestination ?>>
		<div class="create-post-content">
			<h2 class="create-post-close create-post-close-edit">X</h2>
			<h1>Edit post</h1>
			<div class="create-post-fields">
				<div class="create-post-field1">
					<!-- <div onclick="myFunction()" class="dropbtn create-fields">Choose your forum</div> -->
					<input type="text" onclick="myFunction()" class="dropbtn create-fields" name="sForumname" value=<?= $sForumname ?> required autocomplete="off" onkeypress="return false;" readonly>
					<div id="myDropdown" class="dropdown-content">
						<a href="#" class="dropdown-option" title="">-- Select an option --</a>
						<a href="#" class="dropdown-option" title="f/FoodSOS">f/FoodSOS</a>
						<a href="#" class="dropdown-option" title="f/HowTo101">f/HowTo101</a>
						<a href="#" class="dropdown-option" title="f/FoodyCritic">f/FoodyCritic</a>
						<a href="#" class="dropdown-option" title="f/RecipeHub">f/RecipeHub</a>
						<a href="#" class="dropdown-option" title="f/FoodQnA">f/FoodQnA</a>
						<a href="#" class="dropdown-option" title="f/FoodMemes">f/FoodMemes</a>
						<a href="#" class="dropdown-option" title="f/FurryFoodys">f/FurryFoodys</a>
					</div>
					<input type="text" class="create-fields create-field-title" value="<?= $sTitle ?>" name="sTitle" required autocomplete="off">
				</div>
				<div class="create-post-field2">
					<div class="upload-image-btn">
						<input type="file" class="upload-img" id="upload-img" name="sImage" required>
						<ion-icon class="upload-prompt" name="cloud-upload"></ion-icon>
						<label class="upload-prompt" id="upload-label" for="upload-img">Upload an image</label>
					</div>
				</div>
			</div>
			<textarea class="create-post-textarea" placeholder="Start your discussion..." name="sPost" required autocomplete="off"><?= $sPost ?></textarea>
			<div class="create-post-bottombtns">
				<div class="create-post-tags-btn">
					+ Tags
				</div>
				<input type="submit" class="create-post-submit" value="Submit">
			</div>
		</div>
	</form>
	<div class="success-post">
		<h2 class="create-post-close">X</h2>
		<ion-icon name="checkmark-circle-outline" class="check-icon"></ion-icon>
		<h1>Your post has been uploaded successfully</h1>
		<p>Redirecting automatically in <span class="success-countdown">5</span> seconds</p>
	</div>
</div>

<script>
	$(".upload-prompt").css("display", "none")

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				var filepath = e.target.result
				// $('#blah').attr('src', e.target.result);
				$(".upload-image-btn").css("background", "url(" + filepath + ")");
				$("body").css("background-image", "url(" + filepath + ")");
			}

			reader.readAsDataURL(input.files[0]); // convert to base64 string
			$(".upload-prompt").css("display", "none")
		}
	}

	$("#upload-img").change(function() {
		readURL(this);
	});

	$(".create-post-close-edit").click(function() {
		window.location.replace("forums.php");
	});
</script>

<style>
	body {
		background-image: url(<?= $fileDestination ?>);
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
		/* background-position-y: -300px; */
		background-attachment: fixed;
	}

	header {
		backdrop-filter: blur(10px) brightness(0.3);
		/* overflow: hidden; */
	}

	.create-post-container {
		display: flex;
		justify-content: space-around;
		top: 45%;
	}

	.upload-image-btn {
		background: url(<?= $fileDestination ?> );
	}

	.filter {
		/* border: 1px solid red; */
		height: 100%;
		width: 100%;
		backdrop-filter: blur(10px) brightness(0.6);
	}

	footer {
		margin-top: 0px;
		z-index: 1000;
		height: 230px;
	}

	@media screen and (max-width: 375px) {
		footer {
			height: 590px;
		}
	}
</style>
<?php
$stmt->close();
$conn->close();
?> <?php include 'footer.php'; ?>