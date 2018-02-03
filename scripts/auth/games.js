var loadedVideos = {};

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

    $("#allgames").on("click", function() {
        window.location.href = "http://virtualdeck.local.com/auth/games.php";
    });

    $("#left").on("click", function () {
        window.location.href = "http://virtualdeck.local.com/auth/profile.php";
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
            url: "http://virtualdeck.local.com/auth/purchase.php",
            data: {game: game},
            method: "post",
            success: function(data) {
                if (data.success === true) {
                    if (data.stripped === false) {
                        $("#feedback").removeClass("hidden").addClass("success").val(data.message);
                        window.location.href = "http://virtualdeck.local.com/auth/games.php?filter=owned";
                    } else {
                        $("#games").css("display", "none");
                        $("body").append(data.stripe);
                    }
                } else {
                    $("#feedback").removeClass("hidden success").val(data.message);
                }
            },
            error: function() {
                $("#feedback").removeClass("hidden success").val("An error occured");
            }
        });
    });

    $(".download").on("click", function() {
        var game = $(this).parent().parent().data("for");
        $.ajax({
            url: "http://virtualdeck.local.com/auth/download.php",
            data: {game: game},
            method: "post",
            success: function(data) {
                if (data.success === true) {
                    window.open(data.link, '_blank');
                } else {
                    $("#feedback").removeClass("hidden success").val(data.message);
                }
            },
            error: function() {
                $("#feedback").removeClass("hidden success").val("An error occured");
            }
        });
    });

    $(".install").on("click", function() {
        var game = $(this).parent().parent().data("for");
        $("#hider").removeClass("hidden");
        $("#loader").removeClass("hidden");
        $("#feedback").addClass("hidden");
        $.ajax({
            url: "http://virtualdeck.local.com/auth/install.php",
            data: {game: game},
            method: "post",
            success: function(data) {
                $("#loader").addClass("hidden");
                if (data.success === true) {
                    portalDevice(data.link);
                } else {
                    $("#hider").addClass("hidden");
                    $("#feedback").removeClass("hidden success").val(data.message);
                }
            },
            error: function() {
                $("#loader").addClass("hidden");
                $("#hider").addClass("hidden");
                $("#feedback").removeClass("hidden success").val("Une erreur est survenue");
            }
        });
    });

});


function portalDevice(address)
{
    var frame = $("<iframe></iframe>")
        .css("zIndex", 1)
        .css("width", "100vw")
        .css("height", "100vh")
        .css("position", "fixed")
        .css("top", 0)
        .css("left", 0)
        .css("border", 0)
        .attr("src", address)
        .ready(function() {
            $("#loader").addClass("hidden");
            $("#microsoft").removeClass("hidden");
            console.log("done");
        })
    ;
    $("#games")
        .css("opacity", "0")
    ;
    $("header")
        .after(frame)
    ;
}
