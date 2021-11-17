<!DOCTYPE html>
<html>

<?php include 'head.php'; ?>

<body>
    <header id="register-header">
        <?php include 'header.php'; ?>
    </header>

    <section id="account">
        <?php
        //check if logged in
        if (!isset($_SESSION['id'])) {
            header("Location: forums.php");
        }
        $user_id = $_SESSION["id"];
        // echo $user_id;
        include "db_connect.php";
        $raw_results = mysqli_query($conn, "SELECT * from tb_users where id=$user_id");

        while ($results = mysqli_fetch_array($raw_results)) {
            // echo $results['sFname'];
            $sEmail = "s";
            $sEmail = $results['sEmail'];
            $sFname = $results['sFname'];
            $sLname = $results['sLname'];
            $sPassword = $results['sPassword'];
        }
        // $stmt = mysqli_query($conn, "SELECT * from tb_users where id=$user_id");

        ?>
        <div class="account-container">
            <form action="updateaccount.php" method="POST">
                <h1>Edit Account:</h1>
                <h3>Email</h3>
                <input type="email" class="account-text" id="sEmail" name="sEmail" value="<?= $sEmail ?>" required>
                <br>
                <br>
                <h3>First Name</h3>
                <input type="text" class="account-text" id="sFname" name="sFname" value="<?= $sFname ?>" required>
                <br>
                <br>
                <h3>Last Name</h3>
                <input type="text" class="account-text" id="sLname" name="sLname" value="<?= $sLname ?>" required>
                <br>
                <br>
                <h3>Password</h3>
                <input type="text" class="account-text" id="showPassword" name="sPassword" placeholder="Enter Password" required minlength="8">
                <br>
                <br>
                <input type="checkbox" id="edit-terms" required>
                <label id="edit-terms-label" for="edit-terms">I agree to the <a href="#">Terms</a> & <a href="#">Privacy Policy</a></label>
                <br>
                <input class="btn edit-btn" type="submit" value="Update Account">
            </form>
            <form action="deleteuser.php" method="POST">
                <input type="hidden" value="<?= $user_id ?>" name="user_id">
                <input type="button" value="Delete Account" class="btn delete-btn" id="delete-acc-prompt" />
                <div>
                    <input type="button" value="No" class="btn delete-btn delete-btn-no hide-btns" />
                    <input type="submit" value="PERMANENTLY DELETE" class="btn delete-btn hide-btns" id="delete-acc-submit" onclick="signOut();" />
                    <h3 class="delete-msg hide-btns">Deleting your account will permanently delete your account and all posts and comments. This action cannot be undone.</h3>
                </div>
            </form>
        </div>

        <script>
            function signOut() {
                var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function() {
                    console.log("User signed out.");
                });
            }
            $("#edit-terms").css("display", "none");
            $('#edit-terms-label').html('Passwords must be at least 8 characters!').css('color', 'red');
            $("#delete-acc-prompt").click(function() {
                $(".delete-btn, .delete-msg").removeClass("hide-btns");
                $("#delete-acc-prompt").addClass("hide-btns");
            });
            $(".delete-btn-no").click(function() {
                $(".delete-btn, .delete-msg").addClass("hide-btns");
                $("#delete-acc-prompt").removeClass("hide-btns");
            });

            $('#showPassword').on('keyup', function() {
                if ($('#showPassword').val().length >= 8) {
                    $("#edit-terms").css("display", "inline-block");
                    $('#edit-terms-label').html(`I agree to the <a href="#">Terms</a> & <a href="#">Privacy Policy</a>`).css('color', 'black');
                } else {
                    $("#edit-terms").css("display", "none");
                    $('#edit-terms-label').html('Passwords must be at least 8 characters!').css('color', 'red');
                }
            });
        </script>

    </section>
    <section id="account-posts">
        <?php
        $query = $sFname;
        // gets value sent over search form

        $min_length = 1;
        // you can set minimum length of the query if you want

        if (strlen($query) >= $min_length) { // if query length is more or equal minimum length then

            $query = htmlspecialchars($query);
            // changes characters used in html to their equivalents, for example: < to &gt;

            $raw_results = mysqli_query($conn, "SELECT p.*, u.sFname from tb_posts p inner join tb_users u on p.iUserid=u.id WHERE (`sTitle` LIKE '%" . $query . "%') OR (`sPost` LIKE '%" . $query . "%') OR (`sForumname` LIKE '%" . $query . "%') OR (`sFname` LIKE '%" . $query . "%') ORDER BY post_id DESC");

            // * means that it selects all fields, you can also write: `id`, `title`, `text`
            // articles is the name of our table

            // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
            // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
            // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'

            if (mysqli_num_rows($raw_results) > 0) { // if one or more rows are returned do following
                echo "<h1>All posts made by ''$query'' </h1>";

                while ($results = mysqli_fetch_array($raw_results)) {
                    // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
                    echo '<div class="post-container">';
                    echo '<div class="post-content">';
                    echo '<img class="post-img" src="';
                    // echo "$fileDestination";
                    echo $results['sImage'];
                    echo '" alt="salmon">';
                    echo '<div>';
                    echo '<h2 class="post-title">';
                    // echo "$sTitle";
                    echo $results['sTitle'];
                    echo '</h2>';
                    echo '<p class="post-text">';
                    echo $results['sPost'];
                    echo '</p>';
                    echo '<p class="post-author">Posted by <a href="search.php?query=' . $results['sFname'] . '">u/';
                    // echo "$sFname";
                    echo $results['sFname'];
                    echo '</a> in <a href="search.php?query=' . $results['sForumname'] . '">';
                    // echo "$sForumname";
                    echo $results['sForumname'];
                    echo '</a> ';
                    echo "<br>";
                    $time_ago = strtotime($results['tsLastUpdated']);
                    echo time_Ago($time_ago);
                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '';
                    echo '<div class="post-btns">';
                    echo '<div class="post-likes">';
                    echo '<span>';
                    echo rand(1, 9);
                    // echo "$post_id likes";
                    echo $results['post_id'];
                    echo "likes";
                    echo '</span>';
                    echo '<ion-icon name="heart-outline" class="post-likebtn post-btn"></ion-icon>';
                    echo '</div>';
                    echo '<ion-icon name="share-social" class="post-sharebtn post-btn"></ion-icon>';
                    echo '<ion-icon name="ellipsis-horizontal" class="post-morebtn post-morebtn1 post-btn"></ion-icon>';
                    echo '</div>';
                    //check if it is logged in and post is created by current user
                    if (isset($_SESSION["id"]) && ($_SESSION["id"] == $results['iUserid'])) {
                        echo '<div class="post-popup">';
                        echo '<div class="options option1">';
                        echo '<ion-icon name="create-outline"></ion-icon>';
                        echo '<span><a href="editpost.php?post_id=';
                        // echo "$post_id";
                        echo $results['post_id'];
                        echo '">Edit Post</a></span>';
                        echo '</div>';
                        echo '<div class="options option2">';
                        echo '<ion-icon name="trash-outline"></ion-icon>';
                        echo '<span><a href="deletepost.php?post_id=';
                        // echo "$post_id";
                        echo $results['post_id'];
                        echo '">Delete Post</a></span>';
                        echo '</div>';
                        echo '<div class="options option3" onclick="copyClipboard()">';
                        echo '<ion-icon name="copy-outline"></ion-icon>';
                        echo '<span>Copy Link</span>';
                        echo '</div>';
                        echo '<div class="options option4" onclick="report()">';
                        echo '<ion-icon name="alert-circle-outline"></ion-icon>';
                        echo '<span>Report Post</span>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="post-popup post-popup-unlogged">';
                        echo '<div class="options option3" onclick="copyClipboard()">';
                        echo '<ion-icon name="copy-outline"></ion-icon>';
                        echo '<span>Copy Link</span>';
                        echo '</div>';
                        echo '<div class="options option4" onclick="report()">';
                        echo '<ion-icon name="alert-circle-outline"></ion-icon>';
                        echo '<span>Report Post</span>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                    // posts results gotten from database(title and text) you can also show id ($results['id'])
                }
            } else { // if there is no matching rows do following
                // echo "<h1>No results found for ''$query'' </h1>";
            }
        } else { // if query length is less than minimum
            echo "<h1>Minimum length for search is " . $min_length . ": ''$query''" . "</h1>";
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
    </section>
    <section id="featured">
        <div class="content">
            <h1>Featured Topics</h1>
            <div class="topicContainer">
                <div class="topics topic1">
                    <div class="topicFilter"></div>
                    <h2>f/FoodSos</h2>
                </div>
                <div class="topics topic2">
                    <div class="topicFilter"></div>
                    <h2>f/HowTo101</h2>
                </div>
                <div class="topics topic3">
                    <div class="topicFilter"></div>
                    <h2>f/FoodyCritic</h2>
                </div>
                <div class="topics topic4">
                    <div class="topicFilter"></div>
                    <h2>f/RecipeHub</h2>
                </div>
                <div class="topics topic5">
                    <div class="topicFilter"></div>
                    <h2>f/FoodQnA</h2>
                </div>
                <div class="topics topic6">
                    <div class="topicFilter"></div>
                    <h2>f/FoodMemes</h2>
                </div>
                <div class="topics topic7">
                    <div class="topicFilter"></div>
                    <h2>f/FurryFoodys</h2>
                </div>
                <div class="topics topic8">
                    <div class="topicFilter"></div>
                    <h2>f/BoysWhoCanCook</h2>
                </div>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
</body>
<style>
    .account-container {
        flex-direction: column;
    }
</style>

</html>