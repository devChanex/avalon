function logout() {

    var fd = new FormData();
    fd.append("service", "logOutService");
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            window.location.href = "index.php";
        },
        error: function (xhr) {
            alert("Error: " + xhr + " | Message" + xhr.responseText);
        }
    });

}

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
            if (result.message != "Logged") {
                location.href = "index.php";
            }
        },
        error: function (xhr) {
            alert("Error: " + xhr.responseText);
        }
    });

}