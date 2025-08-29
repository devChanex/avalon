var interval = window.setInterval(function () {
    loginChecker();
}, 5000);

loginChecker();

function loginChecker() {

    var fd = new FormData();
    fd.append("service", "loggedChecker");
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {

            if (result == "logged") {
                location.href = "basecode.php";
            }
        }
    });

}