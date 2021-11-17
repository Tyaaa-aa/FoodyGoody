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
            echo '
            <script>
                    window.location = "index.php";    
            </script>';
        }
        if ($_SESSION['role'] == 10) {
            $adminMsg = "Hello Admin";
            $admin = true;
        } else {
            $adminMsg = "Your Account:";
            $admin = false;
        }




        $user_id = $_SESSION["id"];
        include "db_connect.php";
        $raw_results = mysqli_query($conn, "SELECT * from tb_users where id=$user_id");

        $sEmail = "NULL";
        $sFname = "NULL";
        $sLname = "NULL";
        $sPassword = "NULL";
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
        <!-- <div class="" -->
        <div class="account-container">
            <div class="account-col1 account-cols">
                <form action="editaccount.php" method="POST">
                    <h1><?= $adminMsg ?></h1>
                    <h3>Email</h3>
                    <input type="email" class="account-text" id="sEmail" name="sEmail" value="<?= $sEmail ?>" readonly>
                    <br>
                    <br>
                    <h3>First Name</h3>
                    <input type="text" class="account-text" id="sFname" name="sFname" value="<?= $sFname ?>" readonly>
                    <br>
                    <br>
                    <h3>Last Name</h3>
                    <input type="text" class="account-text" id="sLname" name="sLname" value="<?= $sLname ?>" readonly>
                    <br>
                    <br>
                    <!-- <h3>Password</h3>
                    <input type="password" class="account-text" id="showPassword" name="sPassword" value="<?= $sPassword ?>" readonly autocomplete="off"> -->
                    <!-- <input type="checkbox" onclick="showpassword()" id="showPWcb" name="showPWcb">
                    <label for="showPWcb">Show Password</label> -->
                    <br>
                    <input class="btn edit-btn" type="submit" value="Edit Account">
                </form>
            </div>
            <div class="account-col2 account-cols">
                <?php
                if ($_SESSION['role'] == 10) {
                    //if user is admin show admin panel
                    include "db_connect.php";
                    $raw_results = mysqli_query($conn, "SELECT * from tb_users order by id DESC");

                    $sEmail = "NULL";
                    $sFname = "NULL";
                    $sLname = "NULL";
                    $sPassword = "NULL";


                ?>
                    <div class="admin-panel">
                        <h1>All users:</h1>
                        <?php
                        while ($results = mysqli_fetch_array($raw_results)) {

                            $sEmail = $results['sEmail'];
                            $userid = $results['id'];
                            $sFname = $results['sFname'];

                            echo '<div>';
                            echo '<p><a href=search.php?query=' . $sFname . '>' . $sFname . '</a></p>';
                            echo '<form action="deleteuseradmin.php" method="POST">';
                            echo '<input type="hidden" name="userid" value="' . $userid . '">';
                            echo '<input type="submit" class="admindeleteuser" value="Delete"onclick="return confirm(';
                            echo "'Are you sure?')";
                            echo '">';
                            echo '</form>';
                            echo '</div>';
                        }
                        ?>
                    </div>



                    <style>
                    </style>

                <?php
                } else {
                    // if user is not admin show their latest post
                    echo ' <h2>Your Latest Post</h2>
                    <div class="featured-post">';
                    $raw_result = mysqli_query($conn, "SELECT p.*, u.sFname from tb_posts p inner join tb_users u on p.iUserid=u.id WHERE iUserid=$user_id ORDER BY post_id DESC LIMIT 1");

                    while ($results = mysqli_fetch_array($raw_result)) {
                        echo '<div class="featured-post-title">';
                        echo '<img src="';
                        echo $results['sImage'];
                        echo '" alt="';
                        echo $results['sFname'];
                        echo '">';
                        echo '<h3>';
                        echo $results['sTitle'];
                        echo '</h3>';
                        echo '</div>';
                        echo '<div class="featured-post-btns">';
                        echo '<span>';
                        // $rand = rand(1, 9);
                        // echo $rand;
                        echo $results['likes'] . " likes";
                        echo '</span>';
                        echo '<form action="likeSystem.php" method="post">';
                        echo '<input type="hidden" name="post_id" value="' . $results['post_id'] . '">';
                        echo '<input type="hidden" name="user_id" value="' . $_SESSION["id"] . '">';
                        echo '<button type="submit" name="like" class="like-btn">';
                        echo '<ion-icon name="heart-outline" class="post-likebtn post-btn"></ion-icon>';
                        echo '</button>';
                        echo '</form>';
                        echo '<ion-icon name="share-social" class="featured-post-sharebtn post-btn" onclick="copyClipboard()"></ion-icon>';
                        echo '</div>';
                        echo '<p>' . $results['sPost'] . '</p>';
                        echo '<p class="post-author">Posted by <a href="search.php?query=' . $results['sFname'] . '&sortby=new">u/';
                        echo $results['sFname'];
                        echo '</a> in <a href="search.php?query=' . $results['sForumname'] . '&sortby=new">';
                        echo $results['sForumname'];
                        echo '</a> <br>';
                        // echo "$tsLastUpdated";
                        $time_ago = strtotime($results['tsLastUpdated']);
                        echo time_Ago($time_ago);
                        echo '</p>';
                    }
                }
                ?>
            </div>
        </div>
        </div>
    </section>
    <section id="account-posts">
        <?php
        $query = $_SESSION["user"];
        // gets value sent over search form

        $min_length = 1;
        // you can set minimum length of the query if you want

        if (strlen($query) >= $min_length) { // if query length is more or equal minimum length then

            $query = htmlspecialchars($query);
            // changes characters used in html to their equivalents, for example: < to &gt;

            $raw_results = mysqli_query($conn, "SELECT p.*, u.sFname from tb_posts p inner join tb_users u on p.iUserid=u.id WHERE (`sTitle` LIKE '%" . $query . "%') OR (`sPost` LIKE '%" . $query . "%') OR (`sForumname` LIKE '%" . $query . "%') OR (`sFname` LIKE '%" . $query . "%') ORDER BY post_id DESC");

            if (mysqli_num_rows($raw_results) > 0) { // if one or more rows are returned do following
                echo "<h1>All posts made by you, $query </h1>";

                while ($results = mysqli_fetch_array($raw_results)) {
                    // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
                    echo '<div class="post-container">';
                    echo '<div class="post-content">';
                    echo '<img class="post-img" src="' . $results['sImage'] . '" alt="' . $results['sFname'] . '">';
                    echo '<div>';
                    echo '<h2 class="post-title">' . $results['sTitle'] . '</h2>';
                    // echo '<p class="post-text">' . $results['sPost'] . '</p>';
                    echo '<p class="post-text">' . $results['sPost'] . '<br><br><br><br><ion-icon name="chatbubble-ellipses-outline" class="reply-btn" onclick="location.href=' . "'" . 'viewpost.php?post_id=' . $results['post_id'] . "'" . ';" ></ion-icon>' . '</p>';
                    echo '<p class="post-author">Posted by <a href="search.php?query=' . $results['sFname'] . '&sortby=new">u/' . $results['sFname'] . '</a> in <a href="search.php?query=' . $results['sForumname'] . '&sortby=new">' . $results['sForumname'] . '</a> ';
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
                    // echo $rand;
                    // echo "$post_id likes";
                    echo $results['likes'];
                    echo "likes";
                    echo '</span>';
                    echo '<form action="likeSystem.php" method="post">';
                    echo '<input type="hidden" name="post_id" value="' . $results['post_id'] . '">';
                    echo '<input type="hidden" name="user_id" value="' . $_SESSION["id"] . '">';
                    echo '<button type="submit" name="like" class="like-btn">';
                    echo '<ion-icon name="heart-outline" class="post-likebtn post-btn"></ion-icon>';
                    echo '</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '<ion-icon name="share-social" class="post-sharebtn post-btn" onclick="copyClipboard()"></ion-icon>';
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
                        
                        // echo '<span><a href="deletepost.php?post_id=';
                        // // echo "$post_id";
                        // echo $results['post_id'];
                        // echo '">Delete Post</a></span>';
                        
                        echo '<span><a href="deletepost.php?post_id=' . $results['post_id'] . '"';
                        echo 'onclick="return confirm(';
                        echo "'Are you sure you want to delete?')";
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
            // echo "<h1>Minimum length for search is " . $min_length . ": ''$query''" . "</h1>";
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
    <script>
        function copyClipboard() {
            copyToClipboard(window.location.href);
            console.log(window.location.href);
        }

        function copyToClipboard(e) {
            var tempItem = document.createElement('input');

            tempItem.setAttribute('type', 'text');
            tempItem.setAttribute('display', 'none');

            let content = e;
            if (e instanceof HTMLElement) {
                content = e.innerHTML;
            }

            tempItem.setAttribute('value', content);
            document.body.appendChild(tempItem);

            tempItem.select();
            document.execCommand('Copy');

            tempItem.parentElement.removeChild(tempItem);
        }

        function report() {
            alert("Post Reported!")
            // console.log("Reported post made by user: "+ "<?php echo $sFname; ?>" );

        }
    </script>
</body>

</html>