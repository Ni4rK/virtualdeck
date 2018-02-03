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

    $("#feedback").on("click", function () {
        $(this).removeClass("success error").addClass("inactive");
    });

    $("#update").on("click", function() {
        var holoLensIpAddress = $("#holoLensIpAddress").val(),
            username = $("#pseudo").val(),
            email = $("#email").val(),
            passwordold = $("#password_old").val(),
            password = $("#password").val(),
            password2 = $("#password2").val(),
            firstname = $("#firstname").val(),
            lastname = $("#lastname").val(),
            address = $("#address").val(),
            city = $("#city").val(),
            postal = $("#postal").val(),
            phone = $("#phone").val();
        $.ajax({
            url: "http://virtualdeck.local.com/auth/update.php",
            data: {
                holoLensIpAddress: holoLensIpAddress,
                username: username,
                email: email,
                passwordold: passwordold,
                password: password,
                password2: password2,
                firstname: firstname,
                lastname: lastname,
                address: address,
                city: city,
                postal: postal,
                phone: phone
            },
            method: "post",
            success: function(data) {
                if (data.success === true) {
                    $("#feedback").removeClass("inactive error inactive").addClass("success").val(data.message);
                } else {
                    $("#feedback").removeClass("success inactive").addClass("error").val(data.message);
                }
            },
            error: function() {
                $("#feedback").removeClass("success inactive").addClass("error").val("An error occured");
            }
        });
    });

});
