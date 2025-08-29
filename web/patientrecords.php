<?php

require_once 'properties.php';

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $system_name; ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="favicon.ico" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="node_modules/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="node_modules/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="node_modules/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="node_modules/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="node_modules/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="node_modules/weather-icons/css/weather-icons.min.css">
    <link rel="stylesheet" href="node_modules/c3/c3.min.css">
    <link rel="stylesheet" href="node_modules/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="node_modules/owl.carousel/dist/assets/owl.carousel.css">
    <link rel="stylesheet" href="node_modules/owl.carousel/dist/assets/owl.theme.default.css">

    <link rel="stylesheet" href="node_modules/jquery-toast-plugin/dist/jquery.toast.min.css">
    <link rel="stylesheet" href="dist/css/theme.min.css">
    <script src="src/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- aaddtional css -->
    <link rel="stylesheet" href="ccss/datatable.css">
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class="wrapper nav-collapsed menu-collapsed">
        <?php include_once('nav/topbar.php'); ?>

        <div class="page-wrap">
            <?php include_once('nav/sidebar.php'); ?>
            <div class="main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="m-0 font-weight-bold">Patients Record</h6>
                                    <a href="https://registration.qualitreatdentalclinic.ph"
                                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-plus fa-sm text-white-50"></i> Register</a>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <!-- Sort By (Left) -->
                                        <div>
                                            Sort By:
                                            <select class="form-control select2 d-inline-block" style="width: 200px;">
                                                <option value="PatientNo">PatientNo</option>
                                                <option value="Fullname">Fullname</option>
                                                <option value="Birthdate">Birthdate</option>
                                                <option value="Age">Age</option>
                                            </select>
                                        </div>

                                        <!-- Search (Right) -->
                                        <div class="search-sm">
                                            <input placeholder="Search..." type="text" class="form-control"
                                                style="width: 300px;">
                                        </div>
                                    </div>


                                    <table id="datatable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>PatientNo</th>
                                                <th class="nosort">Fullname</th>
                                                <th>Birthdate</th>
                                                <th>Gender</th>
                                                <th>Age</th>
                                                <th>Contact Number</th>
                                                <th>Email Address</th>
                                                <th class="nosort">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>001</td>

                                                <td>Erich Heaney</td>
                                                <td>04/03/1994</td>
                                                <td>Male</td>
                                                <td>31</td>
                                                <td>9913292079</td>
                                                <td>erich@example.com</td>
                                                <td>
                                                    <div class="table-actions">
                                                        <button type="button" class="btn social-btn bg-primary"><i
                                                                class="ik ik-eye"></i></button>
                                                        <button type="button" class="btn social-btn bg-success"><i
                                                                class="ik ik-edit-2"></i></button>
                                                        <button type="button" class="btn social-btn bg-danger"><i
                                                                class="ik ik-trash-2"></i></button>

                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>002</td>
                                                <td>Olivia Benson</td>
                                                <td>12/11/1990</td>
                                                <td>Female</td>
                                                <td>33</td>
                                                <td>9876543210</td>
                                                <td>olivia@example.com</td>
                                                <td>
                                                    <div class="table-actions">
                                                        <button type="button" class="btn social-btn bg-primary"><i
                                                                class="ik ik-eye"></i></button>
                                                        <button type="button" class="btn social-btn bg-success"><i
                                                                class="ik ik-edit-2"></i></button>
                                                        <button type="button" class="btn social-btn bg-danger"><i
                                                                class="ik ik-trash-2"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>003</td>
                                                <td>Liam Smith</td>
                                                <td>23/07/1988</td>
                                                <td>Male</td>
                                                <td>35</td>
                                                <td>9123456789</td>
                                                <td>liam@example.com</td>
                                                <td>
                                                    <div class="table-actions">
                                                        <button type="button" class="btn social-btn bg-primary"><i
                                                                class="ik ik-eye"></i></button>
                                                        <button type="button" class="btn social-btn bg-success"><i
                                                                class="ik ik-edit-2"></i></button>
                                                        <button type="button" class="btn social-btn bg-danger"><i
                                                                class="ik ik-trash-2"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>004</td>
                                                <td>Emma Johnson</td>
                                                <td>15/02/1992</td>
                                                <td>Female</td>
                                                <td>31</td>
                                                <td>9234567890</td>
                                                <td>emma@example.com</td>
                                                <td>
                                                    <div class="table-actions">
                                                        <button type="button" class="btn social-btn bg-primary"><i
                                                                class="ik ik-eye"></i></button>
                                                        <button type="button" class="btn social-btn bg-success"><i
                                                                class="ik ik-edit-2"></i></button>
                                                        <button type="button" class="btn social-btn bg-danger"><i
                                                                class="ik ik-trash-2"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>005</td>
                                                <td>Noah Davis</td>
                                                <td>09/09/1995</td>
                                                <td>Male</td>
                                                <td>28</td>
                                                <td>9345678901</td>
                                                <td>noah@example.com</td>
                                                <td>
                                                    <div class="table-actions">
                                                        <button type="button" class="btn social-btn bg-primary"><i
                                                                class="ik ik-eye"></i></button>
                                                        <button type="button" class="btn social-btn bg-success"><i
                                                                class="ik ik-edit-2"></i></button>
                                                        <button type="button" class="btn social-btn bg-danger"><i
                                                                class="ik ik-trash-2"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>006</td>
                                                <td>Ava Martinez</td>
                                                <td>30/06/1993</td>
                                                <td>Female</td>
                                                <td>30</td>
                                                <td>9456789012</td>
                                                <td>ava@example.com</td>
                                                <td>
                                                    <div class="table-actions">
                                                        <button type="button" class="btn social-btn bg-primary"><i
                                                                class="ik ik-eye"></i></button>
                                                        <button type="button" class="btn social-btn bg-success"><i
                                                                class="ik ik-edit-2"></i></button>
                                                        <button type="button" class="btn social-btn bg-danger"><i
                                                                class="ik ik-trash-2"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>007</td>
                                                <td>James Wilson</td>
                                                <td>18/01/1989</td>
                                                <td>Male</td>
                                                <td>36</td>
                                                <td>9567890123</td>
                                                <td>james@example.com</td>
                                                <td>
                                                    <div class="table-actions">
                                                        <button type="button" class="btn social-btn bg-primary"><i
                                                                class="ik ik-eye"></i></button>
                                                        <button type="button" class="btn social-btn bg-success"><i
                                                                class="ik ik-edit-2"></i></button>
                                                        <button type="button" class="btn social-btn bg-danger"><i
                                                                class="ik ik-trash-2"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>008</td>
                                                <td>Sophia Taylor</td>
                                                <td>05/05/1996</td>
                                                <td>Female</td>
                                                <td>27</td>
                                                <td>9678901234</td>
                                                <td>sophia@example.com</td>
                                                <td>
                                                    <div class="table-actions">
                                                        <button type="button" class="btn social-btn bg-primary"><i
                                                                class="ik ik-eye"></i></button>
                                                        <button type="button" class="btn social-btn bg-success"><i
                                                                class="ik ik-edit-2"></i></button>
                                                        <button type="button" class="btn social-btn bg-danger"><i
                                                                class="ik ik-trash-2"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>009</td>
                                                <td>Benjamin Clark</td>
                                                <td>22/08/1991</td>
                                                <td>Male</td>
                                                <td>32</td>
                                                <td>9789012345</td>
                                                <td>benjamin@example.com</td>
                                                <td>
                                                    <div class="table-actions">
                                                        <button type="button" class="btn social-btn bg-primary"><i
                                                                class="ik ik-eye"></i></button>
                                                        <button type="button" class="btn social-btn bg-success"><i
                                                                class="ik ik-edit-2"></i></button>
                                                        <button type="button" class="btn social-btn bg-danger"><i
                                                                class="ik ik-trash-2"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>010</td>
                                                <td>Isabella Moore</td>
                                                <td>11/12/1994</td>
                                                <td>Female</td>
                                                <td>29</td>
                                                <td>9890123456</td>
                                                <td>isabella@example.com</td>
                                                <td>
                                                    <div class="table-actions">
                                                        <button type="button" class="btn social-btn bg-primary"><i
                                                                class="ik ik-eye"></i></button>
                                                        <button type="button" class="btn social-btn bg-success"><i
                                                                class="ik ik-edit-2"></i></button>
                                                        <button type="button" class="btn social-btn bg-danger"><i
                                                                class="ik ik-trash-2"></i></button>
                                                    </div>
                                                </td>
                                            </tr>



                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" id="currentPage" value="1">
                                <div id="pagination" class="align-items-center d-flex justify-content-center mb-3">

                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination mb-0">
                                            <li class="page-item">
                                                <a class="page-link first" href="#">
                                                    <i class="ik ik-chevrons-left"></i>
                                                </a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link prev" href="#">
                                                    <i class="ik ik-chevron-left"></i>
                                                </a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item active">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link next" href="#" aria-label="Next">
                                                    <i class="ik ik-chevron-right"></i>
                                                </a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link last" href="#">
                                                    <i class="ik ik-chevrons-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php include_once('nav/activityLogs.php'); ?>
            <?php include_once('nav/footer.php'); ?>


        </div>
    </div>




    <?php include_once("nav/appsModal.php"); ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="node_modules/screenfull/dist/screenfull.js"></script>
    <script src="node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>


    <script src="node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="node_modules/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="node_modules/jvectormap/tests/assets/jquery-jvectormap-world-mill-en.js"></script>
    <script src="node_modules/moment/moment.js"></script>
    <script src="node_modules/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="node_modules/d3/dist/d3.min.js"></script>
    <script src="node_modules/c3/c3.min.js"></script>
    <script src="js/tables.js"></script>
    <script src="js/widgets.js"></script>
    <script src="js/charts.js"></script>
    <script src="dist/js/theme.min.js"></script>
    <!-- <script src="js/datatables.js"></script> -->
    <script src="node_modules/jquery-toast-plugin/dist/jquery.toast.min.js"></script>



    <!-- other plugins -->
    <script src="scripts/promptScript-v1.js"></script>
    <script src="scripts/topbarScript-v1.js"></script>
    <script src="scripts/dynamicScripts-v1.js"></script>


</body>

</html>