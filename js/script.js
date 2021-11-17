$(function () {
    $(window).scroll(function () {
        var yPos = window.pageYOffset;
        // console.log(yPos);
    });

    $(".mobileMenu").click(function () {
        $(".mobileMenu-card").css("display", "block");
        setTimeout(() => {
            $(".mobileMenu-card").addClass("mobileMenu-ani");
        }, 10);

    });




    $(".topic1").click(function () {
        window.location.href = "search.php?query=f/FoodSos";
    });
    $(".topic2").click(function () {
        window.location.href = "search.php?query=f/HowTo101";
    });
    $(".topic3").click(function () {
        window.location.href = "search.php?query=f/FoodyCritic";
    });
    $(".topic4").click(function () {
        window.location.href = "search.php?query=f/RecipeHub";
    });
    $(".topic5").click(function () {
        window.location.href = "search.php?query=f/FoodQnA";
    });
    $(".topic6").click(function () {
        window.location.href = "search.php?query=f/FoodMemes";
    });
    $(".topic7").click(function () {
        window.location.href = "search.php?query=f/FurryFoodys";
    });
    $(".topic8").click(function () {
        window.location.href = "forums.php";
    });


    $(".arrows").click(function () {
        scrollToAbout()
    });

    function scrollToAbout() {
        // window.scrollTo(0, 950);
        // window.scrollTo("#topRated");
        console.log("test");
        $("#topRated")[0].scrollIntoView()
    }

    $(".login_btn").click(function () {
        console.log("Login")
    });

    $(".login_btn, .register-login-prompt").click(function () {
        $(".login-popup").css("display", "block");
    });

    $(".login-popup-close").click(function () {
        $(".login-popup").css("display", "none");
    });


    // ========== FORUMS SCRIPT ==========


    // ======= POST POP UP FUNCTIONALITY CODE ========
    $(window).click(function () {
        //Hide the menus if visible    
        $(".post-popup").css("display", "none");
        $(".post-container, .sidebar").css("z-index", "1");

        if ($(".mobileMenu-card").hasClass("mobileMenu-ani")) {
            setTimeout(() => {
                $(".mobileMenu-card").css("display", "none");
            }, 1100);
            console.log("test")
        }

        $(".mobileMenu-card").removeClass("mobileMenu-ani");


        $(".post-text").css({
            "opacity": "0",
            "height": "0px"
        });


        $(".post-img").css({
            "height": "60px",
            "width": "60px"
        });

        $(".post-content").css({
            "flex-direction": "row"
        });

        
    });

    $('.post-morebtn').click(function () {
        var element = $(this).parent().parent();
        // console.log(test);
        // $(".post-popup").css("display", "none");

        setTimeout(function () {
            element.css("z-index", "100");
            element.find(".post-popup").css("display", "flex");
            // $(".sidebar").css("z-index", "-99999");
        }, 1);

    });

    // Like button functionality code

    // $(".post-likebtn, .featured-post-likebtn").click(function () {
    //     var element = $(this);

    //     if (element.attr("name") == "heart-outline") {
    //         element.attr("name", "heart");
    //         console.log("Liked");
    //     } else if (element.attr("name") == "heart") {
    //         element.attr("name", "heart-outline");
    //         console.log("Unliked");
    //     }
    // });

    $(".post-likebtn, .featured-post-likebtn").on("click", likebtn);

    function likebtn(){
        var element = $(this);

        if (element.attr("name") == "heart-outline") {
            element.attr("name", "heart");
            console.log("Liked");
        } else if (element.attr("name") == "heart") {
            element.attr("name", "heart-outline");
            console.log("Unliked");
        }
    }

    $('.dropdown-option').click(function () {
        var element = $(this).attr("title");
        console.log($(this).index());
        // console.log(test);
        $(".dropbtn").val(element)
    });

    // $(".create-post-submit").click(function(){
    //     $(".create-post-content").css("display", "none");
    //     $(".success-post").css("display", "block");
    //     successCountdown();
    //     // alert("test");
    // });

    // function successCountdown(){
    //     var t = 5;
    //     var timer = setInterval(() => {
    //         t--;
    //         $(".success-countdown").text(t);

    //         if(t < 1){
    //             clearInterval(timer);
    //             location.reload(true);
    //         }
    //     }, 1000);
    // }







    $(".post-container").on("click", showPost);

    function showPost() {
        setTimeout(() => {
            // $(this).find(".post-text").css("opacity","1", "height","auto");
            var element = $(this);
            element.find(".post-text").css({
                "opacity": "1",
                "height": "auto"
            });

            function myFunction(x) {
                if (x.matches) { // If media query matches
                    element.find(".post-img").css({
                        "height": "150px",
                        "width": "100%"
                    });

                    element.find(".post-content").css({
                        "flex-direction": "column"
                    });

                } else {
                    element.find(".post-img").css({
                        "height": "150px",
                        "width": "150px"
                    });
                }
            }
    
            var x = window.matchMedia("(max-width: 375px)")
            myFunction(x) // Call listener function at run time
            x.addListener(myFunction) // Attach listener function on state changes
        }, 10);

        

    }


    $(".create-post-btn").click(function () {
        $(".create-post-container").css("display", "block");
        $(".create-post-btn").css("display", "none");
    });

    $(".create-post-close").click(function () {
        $(".create-post-btn").css("display", "block");
        $(".create-post-container").css("display", "none");
    });


    function scrollToAbout() {
        // window.scrollTo(0, 950);
        // window.scrollTo("#topRated");
        console.log("test");
        $("#topRated")[0].scrollIntoView()
    }

});

function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}



function showpassword() {
    var x = document.getElementById("showPassword");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function showpassword2() {
    var x = document.getElementById("password-mobile");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}


// SORT BY SECTION SELECTORS 
$(".tab").click(function(){
    $(this).find("form.myForm").submit();
});