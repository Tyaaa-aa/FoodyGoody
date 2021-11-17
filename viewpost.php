<?php include 'head.php'; ?>

<?php
$sUsername = "NAME UNSET";
$post_id = $_GET["post_id"];

if (!isset($_SESSION['id'])) {
    $session_id = "NULL";

} else {
    $session_id = $_SESSION['id'];
}
include "db_connect.php";
$stmt = $conn->prepare("SELECT p.*, u.sFname from tb_posts p inner join tb_users u on p.iUserid=u.id where post_id=$post_id");

$stmt->execute();
$stmt->bind_result($post_id, $sForumname, $sTitle, $fileDestination, $sPost, $iUserid, $tsLastUpdated, $likes, $sUsername);

while ($stmt->fetch()) {
    // echo $fileDestination;
    $time_ago = strtotime($tsLastUpdated);
}

?>
<head>
    <meta property="og:url" content="https://tya.design/nyp/dynWeb/foodygoody/viewpost.php?post_id=<?= $post_id ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?= $sTitle ?>" />
    <meta property="og:description" content="<?= $sPost ?>" />
    <meta property="og:image" content="https://tya.design/nyp/dynWeb/foodygoody/<?= $fileDestination ?>" />
</head>


<header id="viewpost-header">
    <?php include 'header.php'; ?>
</header>

<section id="viewpost">
    <div class="viewpost-container">
        <div class="viewpost-col1 viewpost-cols">
        <a href="<?= $fileDestination ?>" target="_blank">
            <img class="viewpost-img" src="<?= $fileDestination ?>" alt="<?= $fileDestination ?>">
        </a>
        </div>
        <div class="viewpost-col2 viewpost-cols">
            <h2><?= $sTitle ?></h2>
            <p>Posted by <a href="search.php?query=<?= $sUsername ?>&sortby=new">u/<?= $sUsername ?></a> in <a href="search.php?query=<?= $sForumname ?>&sortby=new"><?= $sForumname ?></a></p>
            <form action="likeSystem.php" method="post">
                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                <input type="hidden" name="user_id" value="<?= $session_id ?>">

                <button type="submit" name="like" class="like-btn">
                    <ion-icon name="heart-outline" class="post-likebtn post-btn"></ion-icon>
                </button>
                <p><?= $likes ?> likes</p>
            </form>
            <div class="viewpost-post-text">
                <p><?= $sPost ?></p>
            </div>
            <p class="timeago"><?php echo time_Ago($time_ago); ?></p>
            <?php

            $stmt->close();
            $conn->close();
            ?>
            <?php
            include "db_connect.php";
            $raw_results = mysqli_query($conn, "SELECT c.*, u.sFname from tb_comments c inner join tb_users u on c.user_id=u.id where post_id=$post_id");

            $stmt = $conn->prepare("SELECT c.*, u.sFname from tb_comments c inner join tb_users u on c.user_id=u.id where post_id=$post_id");

            
            $stmt->execute();
            $stmt->bind_result($comment_id, $user_id, $post_id, $sComment, $likes, $tsLastUpdated, $sFname);
            ?>
            <div class="comments-container">
                <div class="comments">
                    
                    <?php
                    if (mysqli_num_rows($raw_results) == 0){
                        echo "<h2>Be the first to comment!</h2>";
                        echo "<img src='img/gudetama.gif' draggable='false'  onContextMenu='return false;' style='width:100px;'>";
                    }
                    while ($stmt->fetch()) {
                        // $time_ago = strtotime($tsLastUpdated);
                        // $time = time_Ago($time_ago);
                        // echo time_Ago($time_ago);
                        echo '<div>';
                        // echo $time;
                        echo '<h4><a href="search.php?query=';
                        echo $sFname;
                        echo '&sortby=new">u/' . $sFname . '</a></h4>';
                        echo '<p>' . $sComment . '</p>';
                        echo '<p><span>' . $likes . ' Likes</span> ';
                        echo time_Ago(strtotime($tsLastUpdated));
                        echo ' </p>';
                        // echo $likes. " Likes" .'</p>';
                        echo '<form action="likeSystem_comments.php" method="post" class="comment-like-btn">';
                        echo '<input type="hidden" name="post_id" value="' . $comment_id . '">';
                        echo '<input type="hidden" name="user_id" value="' . $session_id . '">';
                        echo '<button type="submit" name="like" class="like-btn">';
                        echo '<ion-icon name="heart-outline" class="post-likebtn post-btn"></ion-icon>';
                        echo '</button>';
                        echo '</form>';
                        echo '
                        <hr>';
                        echo '</div>';
                    }
                    function time_Ago($time)
                    {
                        // Calculate difference between current 
                        // time and given timestamp in seconds 
                        $diff     = time() - $time;

                        // Time difference in seconds 
                        $sec     = $diff;

                        // Convert time difference in minutes 
                        $min     = round($diff / 60);

                        // Convert time difference in hours 
                        $hrs     = round($diff / 3600);

                        // Convert time difference in days 
                        $days     = round($diff / 86400);

                        // Convert time difference in weeks 
                        $weeks     = round($diff / 604800);

                        // Convert time difference in months 
                        $mnths     = round($diff / 2600640);

                        // Convert time difference in years 
                        $yrs     = round($diff / 31207680);

                        // Check for seconds 
                        if ($sec <= 60) {
                            echo "$sec seconds ago";
                        }

                        // Check for minutes 
                        else if ($min <= 60) {
                            if ($min == 1) {
                                echo "one minute ago";
                            } else {
                                echo "$min minutes ago";
                            }
                        }

                        // Check for hours 
                        else if ($hrs <= 24) {
                            if ($hrs == 1) {
                                echo "an hour ago";
                            } else {
                                echo "$hrs hours ago";
                            }
                        }

                        // Check for days 
                        else if ($days <= 7) {
                            if ($days == 1) {
                                echo "Yesterday";
                            } else {
                                echo "$days days ago";
                            }
                        }

                        // Check for weeks 
                        else if ($weeks <= 4.3) {
                            if ($weeks == 1) {
                                echo "a week ago";
                            } else {
                                echo "$weeks weeks ago";
                            }
                        }

                        // Check for months 
                        else if ($mnths <= 12) {
                            if ($mnths == 1) {
                                echo "a month ago";
                            } else {
                                echo "$mnths months ago";
                            }
                        }

                        // Check for years 
                        else {
                            if ($yrs == 1) {
                                echo "one year ago";
                            } else {
                                echo "$yrs years ago";
                            }
                        }
                    }
                    ?>
                </div>
                <div class="comment-box">
                    <form action="insertComment.php" method="POST">
                        <input type="text" class="comment-input" placeholder="Write a comment..." name="sComment">
                        <input type="hidden" name="post_id" value="<?= $_GET["post_id"] ?>">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['id'] ?>">
                        <input type="hidden" name="likes" value="0">
                        <button type="submit" class="comment-btn">
                            <ion-icon name="paper-plane-outline"></ion-icon>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
<style>
    body {
        /* background-image: url(<?= $fileDestination ?>); */
        background-color: #F8F8F8;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        /* background-position-y: -300px; */
        background-attachment: fixed;
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
        backdrop-filter: blur(10px);
    }

    footer {
        /* margin-top: 0px; */
        z-index: 1000;
        /* height: 230px; */
        /* \/\/\/ REMOVE LATER \/\/\/ */
        /* position: fixed;
        bottom: 0; */
    }

    @media screen and (max-width: 375px) {
        footer {
            /* height: 590px; */
        }
    }
</style>
<?php
if (!isset($_SESSION['id'])) {
    echo '<script>
    console.log("test");
    var html = `<h3>Login To Comment</h3> <p>Or <a href=register.php>create an account</a> first</p>`;
    console.log(html);
    $(".comment-box").html(html);
    // $(".comments").html("asd");
</script>';

}
?>