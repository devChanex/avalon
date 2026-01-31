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
    <link rel="stylesheet" href="ccss/custom.css">


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
                                    <h6 class="m-0 font-weight-bold">Ambulatory Surgery</h6>
                                    <a href="#" onclick='openModal();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-plus fa-sm text-white-50"></i> New Ambulatory Surgery</a>
                                </div>
                                <div class="card-body" style="min-height: 600px;display: block;  ">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <!-- Sort By (Left) -->
                                        <div class="search-md">

                                            <input placeholder="Search..." type="text" class="form-control"
                                                style="width: 300px;" id="searchInput">
                                        </div>
                                        <div>
                                            Sort By:
                                            <select class="form-control select2 d-inline-block" id="sortBy"
                                                onchange="pageRefresh('sortBy');" style="width: 120px;">
                                                <option value="amid">surgref#</option>
                                                <option value="fullname">PatientName</option>
                                                <option value="surgery_date">Date</option>
                                                <option value="physician">Physician</option>
                                                <option value="procedure">Procedure</option>


                                            </select>
                                            <select class="form-control select2 d-inline-block" id="sort"
                                                onchange="pageRefresh('sort');" style="width: 100px;">
                                                <option value="Asc">Asc</option>
                                                <option value="Desc">Desc</option>
                                            </select>
                                        </div>

                                        <!-- Search (Right) -->

                                    </div>

                                    <div class="table-responsive">


                                        <table id="datatable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>surgref#</th>
                                                    <th>PatientNo</th>
                                                    <th>Patient Name</th>
                                                    <th>Date</th>
                                                    <th>Physician</th>
                                                    <th>Procedure</th>
                                                    <th>Updated</th>
                                                    <th class="nosort">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dataTableBody">
                                                <?php include_once('nav/loader.php'); ?>

                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                                <template id="dataRowTemplate">
                                    <tr>
                                        <td class="conref"></td>
                                        <td class="patientid"></td>
                                        <td class="patientname"></td>

                                        <td class="surgery_date"></td>
                                        <td class="physician"></td>
                                        <td class="procedures"></td>

                                        <td class="updated"></td>
                                        <td>
                                            <div class="table-actions">
                                                <button type="button" class="btn social-btn bg-primary edit-data-btn">
                                                    <i class="ik ik-edit"></i>
                                                </button>
                                                <button type="button" class="btn social-btn bg-success view-data-btn">
                                                    <i class="ik ik-eye"></i>
                                                </button>


                                            </div>
                                        </td>
                                    </tr>
                                </template>

                                <div id="pagination" class="align-items-center d-flex justify-content-center mb-3">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination mb-0" id="paginationList">
                                            <!-- JS will populate here -->
                                        </ul>
                                        <div id="pageInfo" class="mt-2 text-muted text-center"></div>
                                    </nav>
                                </div>




                                <div class="modal fade" id="dataModal" tabindex="-1" role="dialog"
                                    aria-labelledby="fullwindowModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="fullwindowModalLabel">Ambulatory Surgery
                                                    Initial Form

                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body" style="padding: 50px;">

                                                <input type="hidden" id="recordid">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Ambulatory Surgery Ref
                                                                #</label>
                                                            <input type="text" class="form-control" id="ambrefNo"
                                                                placeholder="Ambulatory Ref #" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Surgery Date</label>
                                                            <input type="datetime-local" class="form-control"
                                                                id="surgery_date" placeholder="Item Name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-lg-6">
                                                        <label for="itemname">Patient Name:</label>
                                                        <!-- Visible field (user types/sees this one) -->
                                                        <input list="patientOptions" id="patientname"
                                                            class="form-control" placeholder="Type patient name"
                                                            autocomplete="off" onchange="loadPatientDetails();">
                                                        <datalist id="patientOptions">
                                                        </datalist>

                                                        <!-- Hidden field (this is submitted to backend) -->
                                                        <input type="hidden" id="pid" name="invidmodal" onchange="">

                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="itemname">Attending Physician:</label>
                                                        <!-- Visible field (user types/sees this one) -->
                                                        <input list="physicianOptions" id="physician"
                                                            class="form-control" placeholder="Type Physician Name"
                                                            autocomplete="off">
                                                        <datalist id="physicianOptions">
                                                        </datalist>
                                                    </div>




                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label for="itemname">Procedure:</label>
                                                        <!-- Visible field (user types/sees this one) -->
                                                        <input type="text" id="procedures" class="form-control"
                                                            placeholder="Input Procedure">

                                                    </div>
                                                </div>



                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="UpSertData();">Save</button>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="scripts/dynamicScripts-v6.js"></script>
    <script src="scripts/ambulatory-v3.js"></script>
    <script src="scripts/tableScripts-v1.js"></script>


</body>

</html>