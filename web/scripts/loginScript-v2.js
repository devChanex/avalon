
function login() {

    var username = document.getElementById("username").value;

    var password = document.getElementById("password").value;

    if (username == "" || password == "") {
        promptError('Login Failed', 'Username and password cannot be empty!');
        return false;
    } else {

        var fd = new FormData();
        fd.append('service', 'loginService');
        fd.append('username', username);
        fd.append('password', password);
        $.ajax({
            url: "api.php",
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (result) {

                if (result.success) {
                    promptSuccessRedirect('Login Successful', 'You will be redirected shortly.', 'patientrecords.php');
                } else {
                    promptError('Login Failed', result.message);
                }
            },
            error: function (xhr) {
                promptError('Login Failed', "Error: " + xhr.responseText);
            }

        });

    }

}