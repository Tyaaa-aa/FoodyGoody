<!DOCTYPE html>
<html>

<?php include 'head.php'; ?>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <section id="forum-masthead">
        <!-- <div class="bgimage"></div> -->
        <div class="headerClear"></div>
        <div class="content">
            <div class="header">
                <h1>FoodyGoody Forums</h1>
            </div>
        </div>
    </section>
    <?php
    $query = $_GET['query'];
    if (isset($_GET['sortby'])) {
        $checksort = $_GET['sortby'];
        $sortyby = "likes";

        $tabsactivetrending = "";
        $tabsactivehot = "";
        $tabsactivenew = "";

        if ($checksort == "trending") {
            $sortyby = "RAND()";
            $tabsactivetrending = "active";
        }
        if ($checksort == "hot") {
            $sortyby = "likes";
            $tabsactivehot = "active";
        }
        if ($checksort == "new") {
            $sortyby = "tsLastUpdated";
            $tabsactivenew = "active";
        }
        
    } else {
        $sortyby = "tsLastUpdated";
        $tabsactivenew = "active";
    }
    ?>
    <section id="forum">
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab <?= $tabsactivetrending ?>" onclick="window.location='search.php?query=<?= $query ?>&sortby=trending'">
                    <ion-icon name="trending-up-outline" class="icon searchtabicon"></ion-icon>
                    <span>Trending</span>
                </li>
                <li class="tab <?= $tabsactivehot ?>" onclick="window.location='search.php?query=<?= $query ?>&sortby=hot'">
                    <ion-icon name="flame-outline" class="icon searchtabicon"></ion-icon>
                    <span>Hot</span>
                </li>
                <li class="tab <?= $tabsactivenew ?>" onclick="window.location='search.php?query=<?= $query ?>&sortby=new'">
                    <ion-icon name="ribbon-outline" class="icon searchtabicon"></ion-icon>
                    <span>New</span>
                </li>
            </ul>
            <form action="search.php" method="GET">
                <input class="forumSearch" type="search" name="query" placeholder="Search the forums">
                <button type="submit" class="search-btn">
                    <img src="img/search.png" />
                </button>
            </form>
        </div>
        <div class="content">
            <div class="posts">
                <?php
                if (!isset($_SESSION['id'])) {
                    $session_id = "NULL";
                    $userRole = "NULL";
                } else {
                    $session_id = $_SESSION['id'];
                    $userRole = $_SESSION["role"];
                }
                $query = $_GET['query'];
                // gets value sent over search form

                $min_length = 3;
                // you can set minimum length of the query if you want

                if (strlen($query) >= $min_length) { // if query length is more or equal minimum length then

                    $query = htmlspecialchars($query);
                    // changes characters used in html to their equivalents, for example: < to &gt;

                    $raw_results = mysqli_query($conn, "SELECT p.*, u.sFname from tb_posts p inner join tb_users u on p.iUserid=u.id WHERE (`sTitle` LIKE '%" . $query . "%') OR (`sPost` LIKE '%" . $query . "%') OR (`sForumname` LIKE '%" . $query . "%') OR (`sFname` LIKE '%" . $query . "%') ORDER BY $sortyby DESC");

                    // * means that it selects all fields, you can also write: `id`, `title`, `text`
                    // articles is the name of our table

                    // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
                    // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
                    // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'

                    if (mysqli_num_rows($raw_results) > 0) { // if one or more rows are returned do following
                        echo "<h1>Showing results for ''$query'' </h1>";

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
                            // echo $results['sPost'];
                            echo '<p class="post-text">' . $results['sPost'] . '<br><br><br><br><ion-icon name="chatbubble-ellipses-outline" class="reply-btn" onclick="location.href=' . "'" . 'viewpost.php?post_id=' . $results['post_id'] . "'" . ';" ></ion-icon>' . '</p>';
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
                            echo $results['likes'] . " likes";
                            echo '</span>';
                            echo '<ion-icon name="heart-outline" class="post-likebtn post-btn"></ion-icon>';
                            echo '</div>';
                            echo '<ion-icon name="share-social" class="post-sharebtn post-btn"></ion-icon>';
                            echo '<ion-icon name="ellipsis-horizontal" class="post-morebtn post-morebtn1 post-btn"></ion-icon>';
                            echo '</div>';
                            //check if it is logged in and post is created by current user
                            if ((isset($_SESSION["id"]) && ($_SESSION["id"] == $results['iUserid']))||$userRole==10) {
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
                        echo "<h1>No results found for ''$query'' </h1>";
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




            </div>
            <div class="sidebar">
                <div class="featured-container">
                    <h1>Featured Topics</h1>
                    <hr>
                    <div class="featured-forums">
                        <img src="img/boyswhocancook.jpg" alt="BoysWhoCanCook">
                        <div class="content">
                            <h3>f/BWCC</h3>
                            <div class="stats">
                                <div class="stat1">
                                    <h4>28k</h4>
                                    <span>Users</span>
                                </div>
                                <div class="stat2">
                                    <h4>12k</h4>
                                    <span>Posts</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    include "db_connect.php";

                    $stmt = $conn->prepare("SELECT * from tb_forums ORDER BY RAND() LIMIT 2");
                    $stmt->execute();
                    $stmt->bind_result($sForumname, $sForumimage, $sForumusers, $sForumposts);

                    while ($stmt->fetch()) {

                        echo '<div class="featured-forums">';
                        echo '<img src="';
                        echo "$sForumimage";
                        echo '" alt="';
                        echo "$sForumimage";
                        echo '">';
                        echo '<div class="content">';
                        echo '<h3>';
                        echo "$sForumname";
                        echo '</h3>';
                        echo '<div class="stats">';
                        echo '<div class="stat1">';
                        echo '<h4>';
                        echo "$sForumusers";
                        echo 'k</h4>';
                        echo '<span>Users</span>';
                        echo '</div>';
                        echo '<div class="stat2">';
                        echo '<h4>';
                        echo "$sForumposts";
                        echo 'k</h4>';
                        echo '<span>Posts</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    $stmt->close();
                    $conn->close();
                    ?>
                </div>

                <div class="top-rated">
                    <h1>Featured Topics</h1>
                    <hr>
                    <h2>Forum</h2>
                    <?php
                    include "db_connect.php";
                    $stmt = $conn->prepare("SELECT * from tb_forums ORDER BY RAND() LIMIT 1");
                    $stmt->execute();
                    $stmt->bind_result($sForumname, $sForumimage, $sForumusers, $sForumposts);
                            while ($stmt->fetch()) {
                            echo '<a href="search.php?query='. $sForumname .'&sortby=new" class="featured-forums">';
                            echo '<img src="';
                            echo "$sForumimage";
                            echo '" alt="';
                            echo "$sForumimage";
                            echo '">';
                            echo '<div class="content">';
                            echo '<h3>';
                            echo "$sForumname";
                            echo '</h3>';
                            echo '<div class="stats">';
                            echo '<div class="stat1">';
                            echo '<h4>';
                            echo "$sForumusers";
                            echo 'k</h4>';;
                            echo '<span>Users</span>';
                            echo '</div>';
                            echo '<div class="stat2">';
                            echo '<h4>';
                            echo "$sForumposts";
                            echo 'k</h4>';
                            echo '<span>Posts</span>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        $stmt->close();
                        $conn->close();
                        ?>
                    </a>

                    <h2>Post</h2>

                    <div class="featured-post">
                        <?php
                        include "db_connect.php";

                        $stmt = $conn->prepare("SELECT p.*, u.sFname from tb_posts p inner join tb_users u on p.iUserid=u.id ORDER BY RAND() LIMIT 1");
                        $stmt->execute();
                        $stmt->bind_result($post_id, $sForumname, $sTitle, $fileDestination, $sPost, $iUserid, $tsLastUpdated, $likes, $sFname);

                        while ($stmt->fetch()) {
                            echo '<div class="featured-post-title">';
                            echo '<img src="';
                            echo "$fileDestination";
                            echo '" alt="';
                            echo "$fileDestination";
                            echo '">';
                            echo '<h3>';
                            echo "$sTitle";
                            echo '</h3>';
                            echo '</div>';
                            echo '<div class="featured-post-btns">';
                            echo '<span>';
                            echo "$likes likes";
                            echo '</span>';
                            echo '<form action="likeSystem.php" method="post">';
                            echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
                            echo '<input type="hidden" name="user_id" value="' . $session_id . '">';
                            echo '<button type="submit" name="like" class="like-btn">';
                            echo '<ion-icon name="heart-outline" class="post-likebtn post-btn"></ion-icon>';
                            echo '</button>';
                            echo '</form>';
                            echo '<ion-icon name="share-social" class="featured-post-sharebtn post-btn"></ion-icon>';
                            echo '</div>';
                            echo '<p class="post-author">Posted by <a href="search.php?query=' . $sFname . '&sortby=new">u/';
                            echo "$sFname";
                            echo '</a> in <a href="search.php?query=' . $sForumname . '&sortby=new">';
                            echo "$sForumname";
                            echo '</a> on ';
                            // echo "$tsLastUpdated";
                            $time_ago = strtotime($tsLastUpdated);
                            echo time_Ago($time_ago);
                            echo '</p>';
                        }
                        $stmt->close();
                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- <div class="pagination">
        <ul class="items">

            <li class="item <?php if ($pageno == 1) {
                                echo 'active';
                            } ?>">
                <a href="?page=1">First</a>
            </li>

            <li class="item greyed <?php if ($pageno <= 1) {
                                        echo 'disabled';
                                    } ?>">

                <a href="<?php if ($pageno <= 1) {
                                echo '#';
                            } else {
                                echo "?page=" . ($pageno - 1);
                            } ?>">
                    <ion-icon name="chevron-back-outline" class="paginationArrow"></ion-icon>
                </a>
            </li>

            <li class="item greyed <?php if ($pageno >= $total_pages) {
                                        echo 'disabled';
                                    } ?>">

                <a href="<?php if ($pageno >= $total_pages) {
                                echo '#';
                            } else {
                                echo "?page=" . ($pageno + 1);
                            } ?>">
                    <ion-icon name="chevron-forward-outline" class="paginationArrow"></ion-icon>
                </a>
            </li>
            <li class="item <?php if ($pageno == $total_pages) {
                                echo 'active';
                            } ?>">
                <a href="?page=<?php echo $total_pages; ?>">Last(<?php echo $total_pages; ?>)</a>
            </li>
        </ul>


    </div> -->

    <div class="create-post-container">
        <form action="insertpost.php" method="post" enctype="multipart/form-data">
            <div class="create-post-content">
                <h2 class="create-post-close">X</h2>
                <h1>Create a new post</h1>
                <div class="create-post-fields">
                    <div class="create-post-field1">
                        <!-- <div onclick="myFunction()" class="dropbtn create-fields">Choose your forum</div> -->
                        <input type="text" onclick="myFunction()" class="dropbtn create-fields" name="sForumname" placeholder="Choose your forum" required autocomplete="off" onkeypress="return false;" readonly>
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
                        <input type="text" class="create-fields create-field-title" placeholder="Title" name="sTitle" required autocomplete="off">
                    </div>
                    <div class="create-post-field2">
                        <div class="upload-image-btn">
                            <input type="file" class="upload-img" id="upload-img" name="sImage" required>
                            <ion-icon class="upload-prompt" name="cloud-upload"></ion-icon>
                            <label class="upload-prompt" id="upload-label" for="upload-img">Upload an image</label>
                        </div>
                    </div>
                </div>
                <textarea class="create-post-textarea" placeholder="Start your discussion..." name="sPost" required autocomplete="off"></textarea>
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





    <div class="create-post-btn">
        <ion-icon name="add-outline"></ion-icon>
    </div>

    <?php include 'footer.php'; ?>

    <script type="text/javascript" src="js/script.js?v=1.5"></script>
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

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var filepath = e.target.result
                    // $('#blah').attr('src', e.target.result);
                    $(".upload-image-btn").css("background", "url(" + filepath + ")")
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
                $(".upload-prompt").css("display", "none")
            }
        }

        $("#upload-img").change(function() {
            readURL(this);
        });
    </script>
</body>

</html>