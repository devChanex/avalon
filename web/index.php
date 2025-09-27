<?php

require_once 'properties.php';

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $system_name ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="favicon.ico" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="node_modules/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="node_modules/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="node_modules/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="node_modules/jquery-toast-plugin/dist/jquery.toast.min.css">
    <link rel="stylesheet" href="dist/css/theme.min.css">
    <script src="src/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>


    <div class="auth-wrapper">
        <div class="container-fluid h-100">
            <div class="row flex-row h-100 bg-white">
                <div class="col-xl-8 col-lg-6 col-md-3 p-0 d-md-block d-lg-block d-md-none d-sm-none d-none">
                    <div class="lavalite-bg" style="background-image: url('img/auth/login-bg.jpg'); ">
                        <div class="lavalite-overlay"></div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                    <div class="authentication-form mx-auto">
                        <div class="align-items-center justify-content-center d-flex mb-4">
                            <a href="#"><img src="<?php echo $logo_path; ?>" alt="" style="max-height: 100px;"></a>
                        </div>



                        <div class="form-group">
                            <input type="text" class="form-control text-center" placeholder="username" required=""
                                id="username">
                            <i class="ik ik-user"></i>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control text-center" placeholder="Password" required=""
                                id="password">
                            <i class="ik ik-lock"></i>
                        </div>

                        <div class="col text-right">
                            <a href="forgot-password.html">Forgot Password ?</a>
                        </div>
                        <div class="sign-btn text-center">
                            <input type="button" class="btn btn-danger btn-block" onclick="login();" value="Sign In">
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="scripts/indexScript-v2.js"></script>
    <script src="scripts/promptScript-v1.js"></script>
    <script src="scripts/loginScript-v2.js"></script>


    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="node_modules/screenfull/dist/screenfull.js"></script>
    <script src="dist/js/theme.js"></script>


    <script src="node_modules/jquery-toast-plugin/dist/jquery.toast.min.js"></script>


</body>

</html>