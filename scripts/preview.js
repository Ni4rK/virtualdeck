var toggle = false;
var cursor = 0;
var videos = $(".video");

$(document).ready(function() {

    videos.get(0).play();

    videos.each(function() {
        $(this).on('ended', function() {
            videos.get(cursor).currentTime = 0;
            $(videos.get(cursor)).addClass('hidden');
            cursor = (cursor + 1) % videos.length;
            $(videos.get(cursor)).removeClass('hidden');
            videos.get(cursor).play();
        });
    });

    $("#backward").on("click", function() {
        videos.get(cursor).currentTime = 0;
        $(videos.get(cursor)).addClass('hidden');
        cursor = (cursor - 1) % videos.length;
        $(videos.get(cursor)).removeClass('hidden');
        videos.get(cursor).play();
    });

    $("#play").on("click", function() {
        videos.get(cursor).play();
    });

    $("#pause").on("click", function() {
        videos.get(cursor).pause();
    });

    $("#forward").on("click", function() {
        videos.get(cursor).currentTime = 0;
        $(videos.get(cursor)).addClass('hidden');
        cursor = (cursor + 1) % videos.length;
        $(videos.get(cursor)).removeClass('hidden');
        videos.get(cursor).play();
    });

    $("#connect").on("click", function() {
        var form = $("#login_form");
        if (form.hasClass("hidden")) {
            form.toggleClass("hidden");
            $(".text").toggleClass("hidden");
            $(this).text("Inscription").css("backgroundColor", "#338436");
        } else {
            window.scrollTo(0, document.body.scrollHeight);
        }
    });

    $("#sign").on("click", function() {
        $("#error").removeClass("hidden").text(
            "Not implemented yet"
        );
        window.scrollTo(0,0);
    });

    $("#toggle").on("click", function () {
        window.scrollTo(0, toggle ? 0 : document.body.scrollHeight);
        toggle = !toggle;
    });

    $("#error").on("click", function () {
        $(this).addClass("hidden");
    });

});
