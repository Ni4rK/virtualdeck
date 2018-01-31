var loadedVideos = {};

$(document).ready(function() {

    $("#home").on("click", function() {
        window.location.href = "/2018/virtualdeck/auth/home.php";
    });

    $("#logout").on("click", function() {
        window.location.href = "/2018/virtualdeck/auth/logout.php";
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
            url: "/auth/update.php",
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
                    $("#feedback").removeClass("inactive error inactive").addClass("success").text(data.message);
                } else {
                    $("#feedback").removeClass("success inactive").addClass("error").text(data.message);
                }
            },
            error: function() {
                $("#feedback").removeClass("success inactive").addClass("error").text("Une erreur est survenue");
            }
        });
    });

});
