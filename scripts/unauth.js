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

    $("#login_form").on("keyup", function(e) {
        if (e.keyCode === 13) {
            $("#log_in").trigger("click");
        }
    });

    $("#connect").on("click", function() {
        var form = $("#login_form");
        if (form.hasClass("hidden")) {
            form.toggleClass("hidden");
            $(".text").toggleClass("hidden");
            $("#email").focus();
            $(this).text("Inscription").css("backgroundColor", "#338436");
        } else {
            window.scrollTo(0, document.body.scrollHeight);
        }
    });

    $("#log_in").on("click", function() {
        var email = $("#email").val(),
            password = $("#password").val();
        $.ajax({
            url: "/2018/virtualdeck/unauth/check.php",
            method: "post",
            data: {email: email, password: password},
            success: function(data) {
                if (data.success === true) {
                    window.location.href = "/2018/virtualdeck/auth/home.php";
                } else {
                    $("#error").removeClass("hidden").text(data.message);
                }
            },
            error: function() {
                $("#error").removeClass("hidden").text("Une erreur est survenue");
            }
        });
    });

    $("#sign").on("click", function() {
        var username = $("#sign_username").val(),
            email = $("#sign_email").val(),
            password = $("#sign_password").val(),
            password2 = $("#sign_password2").val(),
            firstname = $("#sign_firstname").val(),
            lastname = $("#sign_lastname").val(),
            address = $("#sign_address").val(),
            city = $("#sign_city").val(),
            postal = $("#sign_postal").val(),
            phone = $("#sign_phone").val();
        $.ajax({
            url: "/2018/virtualdeck/unauth/sign.php",
            method: "post",
            data: {
                username: username,
                email: email,
                password: password,
                password2: password2,
                firstname: firstname,
                lastname: lastname,
                address: address,
                city: city,
                postal: postal,
                phone: phone
            },
            complete: function() {
                window.scrollTo(0,0);
            },
            success: function(data) {
                if (data.success === true) {
                    window.location.href = "/2018/virtualdeck/auth/home.php";
                } else {
                    $("#error").removeClass("hidden").text(data.message);
                }
            },
            error: function() {
                $("#error").removeClass("hidden").text("Une erreur est survenue");
            }
        });
    });

    $("#error").on("click", function () {
        $(this).addClass("hidden");
    });

});
