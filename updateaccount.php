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
            header("Location: index.php");
        }
        $user_id = $_SESSION["id"];

        $sEmail = $_POST['sEmail'];
        $sFname = $_POST['sFname'];
        $sLname = $_POST['sLname'];
        $sPassword = $_POST['sPassword'];
        $hashed_password = password_hash($sPassword, PASSWORD_DEFAULT);

        include "db_connect.php";

        $stmt = $conn->prepare("UPDATE tb_users SET sFname=?, sLname=?, sEmail=?, sPassword=? WHERE id=$user_id");

        $stmt->bind_param("ssss", $sFname, $sLname, $sEmail, $hashed_password);

        $stmt->execute();
        $stmt->close();
        $conn->close();

        // header("Location: logout.php");
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
    <form action="login_backend.php" method="post" name="login-form">
        <input type="email" class="form-fields" id="email" value="<?= $sEmail ?>" name="sEmail" required>
        <input type="password" class="form-fields" id="showPassword" value="<?= $sPassword ?>" name="sPassword" required>

        <button type="submit" class="popup-login-btn btn">Login</button>
    </form>
    <script>
        // window.location = "index.php";
        window.onload = function() {
            document.forms['login-form'].submit();
        }
    </script>
</body>

</html>