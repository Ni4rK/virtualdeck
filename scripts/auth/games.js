var loadedVideos = {};

$(document).ready(function() {

    $("#home").on("click", function() {
        window.location.href = "/2018/virtualdeck/auth/home.php";
    });

    $("#logout").on("click", function() {
        window.location.href = "/2018/virtualdeck/auth/logout.php";
    });

    $("#allgames").on("click", function() {
        window.location.href = "/2018/virtualdeck/auth/games.php";
    });

    $("#left").on("click", function () {
        window.location.href = "/2018/virtualdeck/auth/profile.php";
    });

    $(".left, .middle").on("click", function() {
        var name = $(this).parent().data("for");
        var div = $("#" + name);
        var src = div.data("src");
        var video = div.find("video")[0];
        if (loadedVideos[name] === undefined) {
            div.find("source").attr("src", src);
            video.load();
            loadedVideos[name] = false;
        }
        if (loadedVideos[name]) {
            video.pause();
        } else {
            video.play();
        }
        div.slideToggle();
        loadedVideos[name] = !loadedVideos[name];
    });

    $("#feedback").on("click", function () {
        $(this).addClass("hidden");
    });

    $(".buy").on("click", function() {
        var game = $(this).parent().parent().data("for");
        console.log(game);
        $.ajax({
            url: "/2018/virtualdeck/auth/purchase.php",
            data: {game: game},
            method: "post",
            success: function(data) {
                if (data.success === true) {
                    $("#feedback").removeClass("hidden").addClass("success").text(data.message);
                    window.location.href = "/2018/virtualdeck/auth/games.php?filter=owned";
                } else {
                    $("#feedback").removeClass("hidden success").text(data.message);
                }
            },
            error: function() {
                $("#feedback").removeClass("hidden success").text("Une erreur est survenue");
            }
        });
    });

    $(".download").on("click", function() {
        var game = $(this).parent().parent().data("for");
        $.ajax({
            url: "/2018/virtualdeck/auth/download.php",
            data: {game: game},
            method: "post",
            success: function(data) {
                if (data.success === true) {
                    window.open(data.link, '_blank');
                } else {
                    $("#feedback").removeClass("hidden success").text(data.message);
                }
            },
            error: function() {
                $("#feedback").removeClass("hidden success").text("Une erreur est survenue");
            }
        });
    });

    $(".install").on("click", function() {
        var game = $(this).parent().parent().data("for");
        $.ajax({
            url: "/2018/virtualdeck/auth/install.php",
            data: {game: game},
            method: "post",
            success: function(data) {
                if (data.success === true) {
                    window.open(data.link, '_blank');
                } else {
                    $("#feedback").removeClass("hidden success").text(data.message);
                }
            },
            error: function() {
                $("#feedback").removeClass("hidden success").text("Une erreur est survenue");
            }
        });
    });

});
