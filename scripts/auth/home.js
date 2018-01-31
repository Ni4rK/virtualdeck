var timers = {};

$(document).ready(function() {

    $("#logout").on("click", function() {
        window.location.href = "/2018/virtualdeck/auth/logout.php";
    });

    $("#home").find(".cart").on("mouseenter", function() {
        var id = $(this).attr("id");
        var images = $(this).find("image");
        if (timers[id] === undefined || timers[id] === null) {
            cart(images);
            timers[id] = window.setInterval(cart.bind(null, images), 500);
        }
    }).on("mouseleave", function() {
        var id = $(this).attr("id");
        if (timers[id] !== undefined && timers[id] !== null) {
            window.clearInterval(timers[id]);
            timers[id] = null;
        }
    });

    $("#all_games").on("click", function() {
        window.location.href = "/2018/virtualdeck/auth/games.php";
    });

    $("#my_games").on("click", function() {
        window.location.href = "/2018/virtualdeck/auth/games.php?filter=owned";
    });

    $("#profile").add("#left").on("click", function() {
        window.location.href = "/2018/virtualdeck/auth/profile.php";
    });

});

function cart(images)
{
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
}
