function logout() {
    var fd = new FormData();
    $.ajax({
        url: "services/logOutService.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            window.location.href = "index.php";
        }
    });

}

var interval = window.setInterval(function () {
    loginChecker();
}, 5000);

loginChecker();

function loginChecker() {

    var fd = new FormData();
    $.ajax({
        url: "services/loggedChecker.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {

            if (result != "logged") {
                location.href = "index.php";
            }
        }
    });

}