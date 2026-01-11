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

    <style>
        /* Optional: simple animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
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
                                    <a href="https://registration.avalonwoundcare.ph/"
                                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-plus fa-sm text-white-50"></i> Register</a>
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
                                                <option value="PatientNo">PatientNo</option>
                                                <option value="Fullname">Fullname</option>
                                                <option value="Birthdate">Birthdate</option>
                                                <option value="Age">Age</option>
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
                                            <tbody id="patientTableBody">
                                                <?php include_once('nav/loader.php'); ?>

                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                                <template id="patientRowTemplate">
                                    <tr>
                                        <td class="id"></td>
                                        <td class="name"></td>
                                        <td class="birth_date"></td>
                                        <td class="gender"></td>
                                        <td class="age"></td>
                                        <td class="contact"></td>
                                        <td class="email"></td>
                                        <td>
                                            <div class="table-actions">
                                                <button type="button"
                                                    class="btn social-btn bg-primary edit-profile-btn">
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




                                <div class="modal fade" id="patientModal" tabindex="-1" role="dialog"
                                    aria-labelledby="fullwindowModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="fullwindowModalLabel">Patient No: <span
                                                        id="patientNo"></span></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body" style="padding: 50px;">

                                                <input type="hidden" id="patientId">

                                                <div class="row">

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Firstname</label>
                                                            <input type="text" class="form-control" id="Firstname"
                                                                placeholder="Firstname">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Middlename</label>
                                                            <input type="text" class="form-control" id="Middlename"
                                                                placeholder="Middlename">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Lastname</label>
                                                            <input type="text" class="form-control" id="Lastname"
                                                                placeholder="Lastname">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Suffix</label>
                                                            <input type="text" class="form-control" id="Suffix"
                                                                placeholder="Suffix">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername2">Birth Date</label>
                                                            <input type="date" class="form-control" id="datepicker">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Birth Place</label>
                                                            <input type="text" class="form-control" id="BirthPlace"
                                                                placeholder="Birthplace">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Nationality</label>
                                                            <input type="text" class="form-control" id="Nationality"
                                                                placeholder="Nationality">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Gender</label>
                                                            <select class="form-control" id="Gender">
                                                                <option value="">-- Select --</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Marital Status</label>
                                                            <select class="form-control" id="MaritalStatus">
                                                                <option value="">-- Select --</option>
                                                                <option value="Single">Single</option>
                                                                <option value="Married">Married</option>
                                                                <option value="Divorced">Divorced</option>
                                                                <option value="Widowed">Widowed</option>
                                                                <option value="Separated">Separated</option>
                                                                <option value="CivilUnion">Civil Union / Domestic
                                                                    Partnership</option>
                                                                <option value="Other">Other</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Religion</label>
                                                            <input type="text" class="form-control" id="Religion"
                                                                placeholder="Religion">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Present Address</label>
                                                            <input type="text" class="form-control" id="PresentAddress"
                                                                placeholder="Present Address">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Contact Number</label>
                                                            <input type="text" class="form-control" id="ContactNumber"
                                                                placeholder="Contact Number">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Email Address</label>
                                                            <input type="text" class="form-control" id="EmailAddress"
                                                                placeholder="Email Address">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Occupation</label>
                                                            <input type="text" class="form-control" id="Occupation"
                                                                placeholder="Occupation">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Office Address</label>
                                                            <input type="text" class="form-control" id="OfficeAddress"
                                                                placeholder="Office Address">
                                                        </div>
                                                    </div>


                                                </div>
                                                <hr>
                                                <div class="row">

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Phllhealth Card #</label>
                                                            <input type="text" class="form-control"
                                                                id="PhilHealthNumber" placeholder="Phllhealth Card #">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Member Type</label>
                                                            <select class="form-control" id="MemberType"
                                                                onchange="memberTypeChange();">
                                                                <option value="">-- Select Account Type --</option>
                                                                <option value="S - Employed Private">S - Employed
                                                                    Private</option>
                                                                <option value="G - Employer Government">G - Employer
                                                                    Government</option>
                                                                <option value="I - Indigent">I - Indigent</option>
                                                                <option value="NS - Individual Paying">NS - Individual
                                                                    Paying</option>
                                                                <option value="NO - OFW">NO - OFW</option>
                                                                <option value="PS - Non Paying Private">PS - Non Paying
                                                                    Private</option>
                                                                <option value="PG - Non Paying Government">PG - Non
                                                                    Paying Government
                                                                </option>
                                                                <option value="P - Lifetime Member">P - Lifetime Member
                                                                </option>
                                                                <option value="None Member">None Member
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Philhealth Employer
                                                                Number</label>
                                                            <input type="text" class="form-control"
                                                                id="PhilHealthEmployerNumber"
                                                                placeholder="Philhealth Employer Number">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Philhealth Employer
                                                                Name</label>
                                                            <input type="text" class="form-control"
                                                                id="PhilhealthEmployerName"
                                                                placeholder="Philhealth Employer Name">
                                                        </div>
                                                    </div>



                                                </div>
                                                <hr>
                                                <div class="row">

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">HMO #:</label>
                                                            <input type="text" class="form-control" id="hmoNumber"
                                                                onchange="hmo_memberTypeChange();" placeholder="HMO #">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">HMO Member Type:</label>
                                                            <select class="form-control" id="hmoMemberType">
                                                                <option value="">-- Select HMO Member Type --</option>
                                                                <option value="NA">N/A</option>
                                                                <option value="Principal">Principal</option>
                                                                <option value="Dependent">Dependent</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Health Insurance:</label>
                                                            <input type="text" class="form-control" id="hmo"
                                                                placeholder="Health Insurance">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Company:</label>
                                                            <input type="text" class="form-control" id="hmo_company"
                                                                placeholder="Company">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Valid ID
                                                                Presented:</label>
                                                            <input type="text" class="form-control" id="valid_id"
                                                                placeholder="Valid ID Presented Details">
                                                        </div>
                                                    </div>

                                                </div>
                                                <hr>
                                                <div class="row">

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Emergency Contact
                                                                Person</label>
                                                            <input type="text" class="form-control"
                                                                id="EmergencyContactPerson"
                                                                placeholder="Emergency Contact Person">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Emergency Contact
                                                                Number</label>
                                                            <input type="text" class="form-control"
                                                                id="EmergencyContactNumber"
                                                                placeholder="Emergency Contact Number">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Relationship</label>
                                                            <input type="text" class="form-control" id="Relationship"
                                                                placeholder="Relationship">
                                                        </div>
                                                    </div>

                                                </div>
                                                <hr>
                                                <div class="row mt-3">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Allergies</label>

                                                            <!-- None (Top) -->
                                                            <div class="form-check mb-3">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="allergyNone">
                                                                <label class="form-check-label"
                                                                    for="allergyNone">None</label>
                                                            </div>

                                                            <!-- Other Options in Same Row -->
                                                            <div class="row">
                                                                <!-- Drug -->
                                                                <div class="col-md-4">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="allergyDrug">
                                                                        <label class="form-check-label"
                                                                            for="allergyDrug">Drug</label>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm mt-1"
                                                                        placeholder="Please specify" id="drugSpecify">
                                                                </div>

                                                                <!-- Food -->
                                                                <div class="col-md-4">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="allergyFood">
                                                                        <label class="form-check-label"
                                                                            for="allergyFood">Food</label>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm mt-1"
                                                                        placeholder="Please specify" id="foodSpecify">
                                                                </div>

                                                                <!-- Others -->
                                                                <div class="col-md-4">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="allergyOthers">
                                                                        <label class="form-check-label"
                                                                            for="allergyOthers">Others</label>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm mt-1"
                                                                        placeholder="Please specify" id="othersSpecify">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Current Medications -->
                                                <div class="row mt-3">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="currentMedications">Current
                                                                Medication(s)</label>
                                                            <textarea class="form-control" id="currentMedications"
                                                                rows="3"
                                                                placeholder="List any current medications..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row">

                                                    <div class="col-lg-12 text-left">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="isAgree" checked disabled>
                                                            <span class="custom-control-label">&nbsp;I hereby confirm
                                                                that the
                                                                information provided above is true and correct
                                                                to the best of my knowledge.</span>
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="UpdateProfile();">Save changes</button>
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
    <script src="scripts/dynamicScripts-v4.js"></script>
    <script src="scripts/patientrecords-v14.js"></script>
    <script src="scripts/tableScripts-v1.js"></script>


</body>

</html>