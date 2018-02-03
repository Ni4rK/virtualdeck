$(document).ready(function() {

    $("#homepage").on("click", function() {
        window.location.href = "http://virtualdeck.local.com/auth/home.php";
    });

    $("#listing").on("click", function() {
        window.location.href = "http://virtualdeck.local.com/auth/games.php";
    });

    $("#logout").on("click", function() {
        window.location.href = "http://virtualdeck.local.com/auth/logout.php";
    });

    $("#home").find(".cart").on("mouseenter", function() {
        var images = $(this).find("image");
        var currentImage, imageRotated, coordsRotated = [];
        for (currentImage = 0; currentImage < images.length; currentImage++) {
            imageRotated = (currentImage + 1) % images.length;
            coordsRotated.push({
                x: $(images[imageRotated]).attr("x"),
                y: $(images[imageRotated]).attr("y")
            });
        }
        for (currentImage = 0; currentImage < images.length; currentImage++) {
            $(images[currentImage]).attr("x", coordsRotated[currentImage].x);
            $(images[currentImage]).attr("y", coordsRotated[currentImage].y);
        }
    });

    $("#all_games").on("click", function() {
        window.location.href = "http://virtualdeck.local.com/auth/games.php";
    });

    $("#my_games").on("click", function() {
        window.location.href = "http://virtualdeck.local.com/auth/games.php?filter=owned";
    });

    $("#profile").add("#left").on("click", function() {
        window.location.href = "http://virtualdeck.local.com/auth/profile.php";
    });

});
