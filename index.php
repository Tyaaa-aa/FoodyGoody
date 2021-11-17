<!DOCTYPE html>
<html>

<?php include 'head.php'; ?>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <section id="masthead">
        <!-- <div class="bgimage"></div> -->
        <div class="content">
            <div class="headerClear"></div>
            <div class="header">
                <h1>Welcome to FoodyGoody</h1>
                <h2>A community of food lovers for food lovers.
                    <br />
                    Find other food lovers today.
                </h2>
                <a href="forums.php" class="btn">Forums</a>
            </div>
            <div class="arrows">
                <ion-icon name="chevron-down-outline" class="arrow1"></ion-icon>
                <ion-icon name="chevron-down-outline" class="arrow2"></ion-icon>
            </div>
        </div>
    </section>
    <section id="topRated">
        <div class="content">
            <h1>Top rated restaurants nearby</h1>
            <h2>Best eateries decided by you foodys</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.7195749079974!2d103.73321371527994!3d1.344681961965306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da1018c6db78e5%3A0xe4eb2d5731a78433!2sEnaq!5e0!3m2!1sen!2ssg!4v1605793422167!5m2!1sen!2ssg" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

            <div class="pagination">
                <ul class="items">
                    <li class="item greyed">
                        <ion-icon name="chevron-back-outline" class="paginationArrow"></ion-icon>
                    </li>
                    <li class="item">1</li>
                    <li class="item active">2</li>
                    <li class="item">3</li>
                    <li class="item">4</li>
                    <li class="item">5</li>
                    <li class="item">6</li>
                    <li class="item greyed">
                        <ion-icon name="chevron-forward-outline" class="paginationArrow"></ion-icon>
                    </li>
                </ul>
            </div>
        </div>
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

</html>