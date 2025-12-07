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
    <link rel="stylesheet" href="node_modules/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="node_modules/@claviska/jquery-minicolors/jquery.minicolors.css">
    <link rel="stylesheet" href="dist/css/theme.min.css">
    <link rel="stylesheet" href="node_modules/datedropper/datedropper.min.css">
    <script src="src/js/vendor/modernizr-2.8.3.min.js"></script>
    <style>
        label {
            font-weight: bold;
        }
    </style>

</head>

<body>


    <div class="wrapper">
        <div class="container-fluid h-100">
            <div class="row flex-row h-100 bg-white">
                <div class="col-xl-12 col-lg-12 col-md-12 p-5">
                    <div class="authentication-form mx-auto">
                        <div class="align-items-center justify-content-center d-flex mb-4">
                            <a href="#"><img src="<?php echo $logo_path; ?>" alt="" style="max-height: 100px;"></a>


                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3>Patient Registration</h3>
                            </div>
                            <div class="card-body">


                                <div class="row">

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Firstname:</label>
                                            <input type="text" class="form-control" id="Firstname"
                                                placeholder="Firstname">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Middlename:</label>
                                            <input type="text" class="form-control" id="Middlename"
                                                placeholder="Middlename">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Lastname:</label>
                                            <input type="text" class="form-control" id="Lastname"
                                                placeholder="Lastname">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Suffix:</label>
                                            <input type="text" class="form-control" id="Suffix" placeholder="Suffix">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputUsername2">Birth Date:</label>
                                            <input type="text" class="form-control datetimepicker-input" id="datepicker"
                                                data-toggle="datetimepicker" data-target="#datepicker">

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Birth Place:</label>
                                            <input type="text" class="form-control" id="BirthPlace"
                                                placeholder="Birthplace">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Nationality:</label>
                                            <input type="text" class="form-control" id="Nationality"
                                                placeholder="Nationality">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Gender:</label>
                                            <select class="form-control" id="Gender">
                                                <option value="">-- Select --</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Marital Status:</label>
                                            <select class="form-control" id="MaritalStatus">
                                                <option value="">-- Select --</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Divorced">Divorced</option>
                                                <option value="Widowed">Widowed</option>
                                                <option value="Separated">Separated</option>
                                                <option value="CivilUnion">Civil Union / Domestic Partnership</option>
                                                <option value="Other">Other</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Religion:</label>
                                            <input type="text" class="form-control" id="Religion"
                                                placeholder="Religion">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Present Address:</label>
                                            <input type="text" class="form-control" id="PresentAddress"
                                                placeholder="Present Address">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Contact Number:</label>
                                            <input type="text" class="form-control" id="ContactNumber"
                                                placeholder="Contact Number">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Email Address:</label>
                                            <input type="text" class="form-control" id="EmailAddress"
                                                placeholder="Email Address">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Occupation:</label>
                                            <input type="text" class="form-control" id="Occupation"
                                                placeholder="Occupation">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Office Address:</label>
                                            <input type="text" class="form-control" id="OfficeAddress"
                                                placeholder="Office Address">
                                        </div>
                                    </div>


                                </div>
                                <hr>
                                <div class="row">

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Phllhealth Card #:</label>
                                            <input type="text" class="form-control" id="PhilHealthNumber"
                                                placeholder="Phllhealth Card #">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Member Type:</label>
                                            <select class="form-control" id="MemberType" onchange="memberTypeChange();">
                                                <option value="">-- Select Account Type --</option>
                                                <option value="S - Employed Private">S - Employed Private</option>
                                                <option value="G - Employer Government">G - Employer Government</option>
                                                <option value="I - Indigent">I - Indigent</option>
                                                <option value="NS - Individual Paying">NS - Individual Paying</option>
                                                <option value="NO - OFW">NO - OFW</option>
                                                <option value="PS - Non Paying Private">PS - Non Paying Private</option>
                                                <option value="PG - Non Paying Government">PG - Non Paying Government
                                                </option>
                                                <option value="P - Lifetime Member">P - Lifetime Member</option>
                                                <option value="Non Member">Non Member
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Philhealth Employer Number:</label>
                                            <input type="text" class="form-control" id="PhilHealthEmployerNumber"
                                                placeholder="Philhealth Employer Number">

                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Philhealth Employer Name:</label>
                                            <input type="text" class="form-control" id="PhilhealthEmployerName"
                                                placeholder="Philhealth Employer Name">
                                        </div>
                                    </div>


                                </div>
                                <hr>

                                <div class="row">

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Emergency Contact Person:</label>
                                            <input type="text" class="form-control" id="EmergencyContactPerson"
                                                placeholder="Emergency Contact Person">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Emergency Contact Number:</label>
                                            <input type="text" class="form-control" id="EmergencyContactNumber"
                                                placeholder="Emergency Contact Number">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Relationship:</label>
                                            <input type="text" class="form-control" id="Relationship"
                                                placeholder="Relationship">
                                        </div>
                                    </div>

                                </div>
                                <hr>
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Allergies:</label>

                                            <!-- None (Top) -->
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="allergyNone">
                                                <label class="form-check-label" for="allergyNone">None</label>
                                            </div>

                                            <!-- Other Options in Same Row -->
                                            <div class="row">
                                                <!-- Drug -->
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="allergyDrug">
                                                        <label class="form-check-label" for="allergyDrug">Drug</label>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm mt-1"
                                                        placeholder="Please specify" id="drugSpecify">
                                                </div>

                                                <!-- Food -->
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="allergyFood">
                                                        <label class="form-check-label" for="allergyFood">Food</label>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm mt-1"
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
                                                    <input type="text" class="form-control form-control-sm mt-1"
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
                                            <label for="currentMedications">Current Medication(s):</label>
                                            <textarea class="form-control" id="currentMedications" rows="3"
                                                placeholder="List any current medications..."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">

                                    <div class="col-lg-12 text-left">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="isAgree">
                                            <span class="custom-control-label">&nbsp;I hereby confirm that the
                                                information provided above is true and correct
                                                to the best of my knowledge.</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>







                    <div class="sign-btn text-center">
                        <input type="button" class="btn btn-primary btn-block" onclick="register();" value="Register">
                    </div>
                </div>



            </div>
        </div>
    </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="scripts/indexScript-v1.js"></script>
    <script src="scripts/promptScript-v1.js"></script>
    <script src="scripts/registerPatient-v3.js"></script>


    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="node_modules/screenfull/dist/screenfull.js"></script>
    <script src="dist/js/theme.js"></script>
    <script src="node_modules/moment/moment.js"></script>
    <script src="node_modules/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="node_modules/@claviska/jquery-minicolors/jquery.minicolors.min.js"></script>
    <script src="node_modules/datedropper/datedropper.min.js"></script>
    <script src="js/form-picker.js"></script>
    <script src="node_modules/jquery-toast-plugin/dist/jquery.toast.min.js"></script>


</body>

</html>