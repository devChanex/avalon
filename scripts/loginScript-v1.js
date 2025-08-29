
function login() {

    var username = document.getElementById("username").value;

    var password = document.getElementById("password").value;

    if (username == "" || password == "") {
        promptError('Login Failed', 'Username and password cannot be empty!');
        return false;
    } else {

        var fd = new FormData();
        fd.append('username', username);
        fd.append('password', password);
        $.ajax({
            url: "https://core.avalonwoundcare.ph/loginService.php",
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (result) {

                if (result.success) {
                    promptSuccessRedirect('Login Successful', 'You will be redirected shortly.', 'basecode.php');
                } else {
                    promptError('Login Failed', result.message);
                }
            }
        });

    }

}