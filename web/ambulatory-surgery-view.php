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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="node_modules/jquery-toast-plugin/dist/jquery.toast.min.css">
    <link rel="stylesheet" href="dist/css/theme.min.css">
    <script src="src/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- aaddtional css -->
    <link rel="stylesheet" href="ccss/datatable.css">
    <link rel="stylesheet" href="ccss/custom.css">
    <style>
        .tab-pane {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            opacity: 0;
            transform: scale(1.2);
            /* start slightly zoomed */
            transition: opacity 0.5s ease, transform 0.5s ease;
            pointer-events: none;
        }

        .tab-pane.active {
            opacity: 1;
            transform: scale(1);
            /* normal size */
            pointer-events: all;
            position: relative;
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
                        <input type="hidden" id="ref"
                            value="<?php echo isset($_GET['ref']) ? htmlspecialchars($_GET['ref']) : ''; ?>">
                        <?php include_once('nav/loader.php'); ?>
                        <div class="col-md-12">
                            <div class="card">

                                <div class="card-header py-2">
                                    <h6 class="m-0 small fw-bold">General Information</h6>
                                </div>

                                <div class="card-body py-2">
                                    <div class="row g-2">

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">SurgRef No.</label>
                                            <input type="text" class="form-control form-control-sm" id="general_amid"
                                                readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Patient No.</label>
                                            <input type="text" class="form-control form-control-sm" id="general_pid"
                                                readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Patient Name</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="general_fullname" readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Gender</label>
                                            <input type="text" class="form-control form-control-sm" id="general_gender"
                                                readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Birthdate</label>
                                            <input type="date" class="form-control form-control-sm"
                                                id="general_birthdate" readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Age</label>
                                            <input type="text" class="form-control form-control-sm" id="general_age"
                                                readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Birthplace</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="general_birthplace" readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">PHIC No.</label>
                                            <input type="text" class="form-control form-control-sm" id="general_phic_no"
                                                readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Member Type</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="general_member_type" readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Physician</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="general_physician" readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Procedure</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="general_procedure" readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">Date / Time</label>
                                            <input type="datetime-local" class="form-control form-control-sm"
                                                id="general_datetime" readonly>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-12">


                            <div class="input-group bg-primary mb-3">
                                <span class="input-group-text bg-primary text-white"><i
                                        class="bi bi-layout-text-sidebar-reverse"></i></span>
                                <select class="form-select fw-semibold" id="tabSelect">
                                    <option value="#tab1" style="color: #fff; background-color: #007bff;">
                                        Pre-Requisites</option>
                                    <option value="#tab2" style="color: #fff; background-color: #339af0;">
                                        Ambulatory Surgery Patient Data</option>
                                    <option value="#tab3" style="color: #fff; background-color: #1c7ed6;">
                                        Vital Signs Sheet</option>
                                    <option value="#tab4" style="color: #fff; background-color: #228be6;">
                                        Physicians Order Sheet</option>
                                    <option value="#tab7" style="color: #fff; background-color: #1971c2;">
                                        Medication Sheet</option>
                                    <option value="#tab5" style="color: #fff; background-color: #1864ab;">
                                        Nurses Progress Notes</option>
                                    <option value="#tab6" style="color: #fff; background-color: #0b5ed7;">
                                        Operative Technique Form</option>
                                    <option value="#tab9" style="color: #fff; background-color: #0d6efd;">
                                        Instrument Count Sheet</option>
                                    <option value="#tab8" style="color: #fff; background-color: #084298;">OR
                                        Charges</option>
                                </select>
                            </div>


                            <!-- Tabs Navigation -->
                            <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab1" type="button" role="tab">Pre-Requisuites</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="consult-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab2" type="button" role="tab">Ambulatory Surgery Patient
                                        Data</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="vital-tab" data-bs-toggle="tab" data-bs-target="#tab3"
                                        type="button" role="tab">Vital Signs Sheet</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="physicianorder-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab4" type="button" role="tab">Physicians Order Sheet</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="medicationsheet-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab7" type="button" role="tab">Medication Sheet</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="nursesprogress-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab5" type="button" role="tab">Nurses Progress Notes</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="nursesprogress-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab6" type="button" role="tab">Operative Technique
                                        Form</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="instumentcountsheet-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab9" type="button" role="tab">Instrument Count Sheet</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="instumentcountsheet-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab8" type="button" role="tab">OR Charges</button>
                                </li>
                            </ul> -->

                            <!-- Tabs Content -->
                            <div class="tab-content border border-top-0 p-1" id="myTabContent"
                                style="height: 600px; overflow-y: auto;">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                    style="max-width:95%;margin: 0 auto;">
                                    <div id="consentFormSection">
                                        <h5 style="cursor: pointer; display: flex; align-items: center; gap: 6px;"
                                            onclick="toggleChecklistDetails('consentDetails', 'toggleIcon-consent')">
                                            <span id="toggleIcon-consent" style="transition: transform 0.2s;">▶</span>
                                            A. Informed Consent for Ambulatory Surgery
                                        </h5>

                                        <div id="consentDetails" style="display: none; margin-top: 10px;">
                                            <input type="hidden" id="consentid">
                                            <input type="hidden" id="consentpid"
                                                value="<?php echo isset($_GET['pid']) ? htmlspecialchars($_GET['pid']) : ''; ?>">

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="consent_fullname">Patient Name:</label>
                                                        <input type="text" class="form-control" id="consent_fullname"
                                                            placeholder="Patient Fullname">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="consent_surgery_date">Surgery Date:</label>
                                                        <input type="datetime-local" class="form-control"
                                                            id="consent_surgery_date">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="consent_physician">Physician Name:</label>
                                                        <input type="text" class="form-control" id="consent_physician"
                                                            placeholder="Physician">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <!-- <div class="form-group">
                                                        <label for="consent_nurse">Nurse In-Charge:</label>
                                                        <input type="text" class="form-control" id="consent_nurse"
                                                            placeholder="Nurse In-Charge">
                                                    </div> -->

                                                    <label for="itemname">Nurse In-Charge:</label>
                                                    <!-- Visible field (user types/sees this one) -->
                                                    <input list="consent_nurse_options" id="consent_nurse"
                                                        class="form-control" placeholder="Nurse In-Charge"
                                                        autocomplete="off">
                                                    <datalist id="consent_nurse_options">

                                                    </datalist>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="consent_procedure">Procedure:</label>
                                                        <input type="text" class="form-control" id="consent_procedure"
                                                            placeholder="Procedure">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="consent_exception">Exception:</label>
                                                        <input type="text" class="form-control" id="consent_exception"
                                                            placeholder="Exception">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-footer">
                                                <button type="button" class="btn btn-success px-4"
                                                    onclick="UpSertConsentData();">
                                                    Save Consent and Print
                                                </button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div id="PreOpCheckListSection">
                                        <input type="hidden" id="preopid">

                                        <h5 style="cursor: pointer; display: flex; align-items: center; gap: 6px;"
                                            onclick="toggleChecklistDetails('preopDetails', 'toggleIcon-preop')">
                                            <span id="toggleIcon-preop" style="transition: transform 0.2s;">▶</span>
                                            B. Pre-Operative Checklist
                                        </h5>

                                        <div id="preopDetails" style="display: none; margin-top: 10px;">
                                            <h6>Clinical Assessment</h6>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="preop_bp">Blood Pressure (BP):</label>
                                                        <input type="text" class="form-control" id="preop_bp"
                                                            placeholder="Blood Pressure">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="preop_rr">Respiratory Rate (RR):</label>
                                                        <input type="text" class="form-control" id="preop_rr"
                                                            placeholder="Respiratory Rate">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="preop_o2sat">O2 Saturation:</label>
                                                        <input type="text" class="form-control" id="preop_o2sat"
                                                            placeholder="O2 Saturation">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="preop_height">Height:</label>
                                                        <input type="text" class="form-control" id="preop_height"
                                                            placeholder="Height">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="preop_hr">Heart Rate (HR):</label>
                                                        <input type="text" class="form-control" id="preop_hr"
                                                            placeholder="Heart Rate">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="preop_temp">Temperature:</label>
                                                        <input type="text" class="form-control" id="preop_temp"
                                                            placeholder="Temperature">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="preop_lmp">Last Menstrual Period:</label>
                                                        <input type="text" class="form-control" id="preop_lmp"
                                                            placeholder="Last Menstrual Period">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="preop_weight">Weight:</label>
                                                        <input type="text" class="form-control" id="preop_weight"
                                                            placeholder="Weight">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="preop_allergies">Allergies Reviewed and
                                                            Documented:</label>
                                                        <input type="text" class="form-control" id="preop_allergies"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="preop_meal">Last Meal and Fluid:</label>
                                                        <input type="text" class="form-control" id="preop_meal"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="preop_lab">Laboratory and Diagnostic Results
                                                            in:</label>
                                                        <input type="text" class="form-control" id="preop_lab"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                            </div>

                                            <h6>Medications</h6>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="preop_dose">Last Dose Given:</label>
                                                        <input type="datetime-local" class="form-control"
                                                            id="preop_dose">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="preop_diagnosis">Diagnosis:</label>
                                                        <input type="text" class="form-control" id="preop_diagnosis"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-footer">
                                                <button type="button" class="btn btn-success px-4"
                                                    onclick="UpSertPreopData();">
                                                    Save Pre-Operative Checklist and Print
                                                </button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <hr>
                                    <div id="WHOCheckListSection">
                                        <input type="hidden" id="preopid">

                                        <h5 style="cursor: pointer; display: flex; align-items: center; gap: 6px;"
                                            onclick="toggleChecklistDetails('ChecklistDetails', 'toggleIcon-Who')">
                                            <span id="toggleIcon-Who" style="transition: transform 0.2s;">▶</span>
                                            C. WHO SURGICAL SAFETY CHECKLIST
                                        </h5>

                                        <div id="ChecklistDetails" style="display: none; margin-top: 10px;">
                                            <p>This checklist is used to enhance the safety of surgical procedures by
                                                ensuring that critical steps are completed before, during, and after
                                                surgery. It serves as a standardized tool to promote teamwork,
                                                communication, and patient safety in the operating room.</p>
                                            <div class="tab-footer">
                                                <button type="button" class="btn btn-success px-4"
                                                    onclick="printWHO();">
                                                    Print WHO Surgical Safety Checklist
                                                </button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <hr>



                                </div>
                                <div class="tab-pane fade show" id="tab2" role="tabpanel"
                                    style="max-width:95%;margin: 0 auto;">
                                    <h5 style="cursor: pointer; display: flex; align-items: center; gap: 6px;"
                                        onclick="toggleChecklistDetails('ambulatorydatasheet1', 'toggleIcon-predatasheet')">
                                        <span id="toggleIcon-predatasheet" style="transition: transform 0.2s;">▶</span>
                                        A. Preoperation Data Sheet
                                    </h5>

                                    <div id="ambulatorydatasheet1" style="display: none; margin-top: 10px;">
                                        <input type="hidden" id="amdataid">
                                        <h5>To be filled-out by staff nurse</h5>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="tab2_chiefComplaint" class="form-label"><strong>Chief
                                                        Complaint</strong></label>
                                                <input type="text" class="form-control" id="tab2_chiefComplaint">
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="consent_surgery_date">Arrival Date/Time:</label>
                                                    <input type="datetime-local" class="form-control" id="tab2_arrival">
                                                </div>
                                            </div>
                                        </div>


                                        <br>
                                        <strong>Initial Vital Signs:</strong>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_bp">Blood Pressure (BP):</label>
                                                    <input type="text" class="form-control" id="tab2_bp"
                                                        placeholder="Blood Pressure">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_pr">Pulse Rate (PR):</label>
                                                    <input type="text" class="form-control" id="tab2_pr"
                                                        placeholder="O2 Saturation">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_height">Height (cm):</label>
                                                    <input type="text" class="form-control" id="tab2_height"
                                                        placeholder="Height">
                                                </div>
                                            </div>



                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_temp">Temperature:</label>
                                                    <input type="text" class="form-control" id="tab2_temp"
                                                        placeholder="Temperature">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_rr">Respiratory Rate (RR):</label>
                                                    <input type="text" class="form-control" id="tab2_rr"
                                                        placeholder="Respiratory Rate">
                                                </div>
                                            </div>



                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_weight">Weight (kg):</label>
                                                    <input type="text" class="form-control" id="tab2_weight"
                                                        placeholder="Weight">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="painScaleInput" class="form-label">
                                                    <strong>Pain Rating Scale</strong>
                                                </label>

                                                <input type="hidden" id="painScaleInput" name="painScale" value="">



                                                <div class="d-flex justify-content-center align-items-stretch"
                                                    style="width: 100%;">

                                                    <button type="button" class="pain-btn" data-value="0"
                                                        style="flex:1;">
                                                        <div style="font-size:2rem;">😊</div>
                                                        <div>0 - No hurt</div>
                                                    </button>

                                                    <button type="button" class="pain-btn" data-value="1"
                                                        style="flex:1;">
                                                        <div style="font-size:2rem;">🙂</div>
                                                        <div>2 - Hurts little bit</div>
                                                    </button>

                                                    <button type="button" class="pain-btn" data-value="4"
                                                        style="flex:1;">
                                                        <div style="font-size:2rem;">😐</div>
                                                        <div>4 - Hurts little more</div>
                                                    </button>

                                                    <button type="button" class="pain-btn" data-value="6"
                                                        style="flex:1;">
                                                        <div style="font-size:2rem;">😣</div>
                                                        <div>6 - Hurts even more</div>
                                                    </button>

                                                    <button type="button" class="pain-btn" data-value="8"
                                                        style="flex:1;">
                                                        <div style="font-size:2rem;">😭</div>
                                                        <div>8 - Hurts whole lot</div>
                                                    </button>

                                                    <button type="button" class="pain-btn" data-value="10"
                                                        style="flex:1;">
                                                        <div style="font-size:2rem;">😫</div>
                                                        <div>10 - Hurts worst</div>
                                                    </button>

                                                </div>
                                            </div>




                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="tab2_illness_history" class="form-label">
                                                    <strong>History of Illness:</strong>
                                                </label>
                                                <textarea class="form-control" id="tab2_illness_history" rows="3"
                                                    placeholder="Enter history of illness here..."></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="tab2_past_medical_history" class="form-label">
                                                    <strong>Past Medical History:</strong>
                                                </label>
                                                <textarea class="form-control" id="tab2_past_medical_history" rows="3"
                                                    placeholder="Enter past medical history here..."></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="tab2_initial_impression" class="form-label">
                                                    <strong>Initial Impression:</strong>
                                                </label>
                                                <textarea class="form-control" id="tab2_initial_impression" rows="3"
                                                    placeholder="Enter chief initial impression here..."></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="tab2_surgical_plan" class="form-label">
                                                    <strong>Surgical Plan of Care:</strong>
                                                </label>
                                                <textarea class="form-control" id="tab2_surgical_plan" rows="3"
                                                    placeholder="Enter chief surgical plan here..."></textarea>
                                            </div>
                                        </div>
                                        <br>


                                        <div class="row">
                                            <div class="col-lg-12" style="gap: 15px;">


                                                <div class="form-group">
                                                    <label class="form-label mb-0"><strong>Anesthesia Plan of
                                                            Care:</strong></label>
                                                    <select class="form-control" id="anesthesia_plan">

                                                        <option value="">-- Select Anesthesia plan of care --</option>
                                                        <option value="General anesthesia - IV">General anesthesia - IV
                                                        </option>
                                                        <option value="General anesthesia - Inhalation">General
                                                            anesthesia - Inhalation</option>
                                                        <option value="Regional-Nerve Block">Regional-Nerve Block
                                                        </option>
                                                        <option value="Regional - Spinal">Regional - Spinal</option>
                                                        <option value="Regional - Epidural">Regional - Epidural</option>

                                                        <!-- 3. Local -->
                                                        <option value="Local">Local</option>
                                                    </select>
                                                </div>


                                                <!-- Modality checkboxes -->


                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="tab2_preop_orders" class="form-label">
                                                    <strong>Pre-op Orders / Preparation</strong>
                                                </label>
                                                <textarea class="form-control" id="tab2_preop_orders" rows="3"
                                                    placeholder="Enter chief surgical plan here..."></textarea>
                                            </div>
                                        </div>

                                        <div class="tab-footer">
                                            <button type="button" class="btn btn-success px-4"
                                                onclick="UpSertAmbulatoryData();">
                                                Save and Print
                                            </button>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 style="cursor: pointer; display: flex; align-items: center; gap: 6px;"
                                        onclick="toggleChecklistDetails('ambulatorydatasheet2', 'toggleIcon-discharge')">
                                        <span id="toggleIcon-discharge" style="transition: transform 0.2s;">▶</span>
                                        B. Condition Prior to Discharge
                                    </h5>

                                    <div id="ambulatorydatasheet2" style="
                                    display: none; 
                                    margin-top: 10px;">

                                        <div class="row">
                                            <div class="col-lg-6" style="font-size: 14px;">
                                                <label class="form-label" style="font-weight: bold;">Condition of
                                                    Discharge:</label><br>

                                                <label style="margin-right: 15px;">
                                                    <input type="radio" name="condition_of_discharge"
                                                        id="discharge_ambulatory" value="ambulatory">
                                                    Ambulatory
                                                </label>

                                                <label>
                                                    <input type="radio" name="condition_of_discharge"
                                                        id="discharge_wheelchair" value="wheelchair">
                                                    On Wheelchair
                                                </label>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="consent_surgery_date">Discharge Date/Time:</label>
                                                    <input type="datetime-local" class="form-control"
                                                        id="discharge_datetime">
                                                </div>
                                            </div>
                                        </div>


                                        <br>
                                        <strong>Initial Vital Signs:</strong>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_bp">Blood Pressure (BP):</label>
                                                    <input type="text" class="form-control" id="discharge_bp"
                                                        placeholder="Blood Pressure">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_pr">Pulse Rate (PR):</label>
                                                    <input type="text" class="form-control" id="discharge_pr"
                                                        placeholder="O2 Saturation">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_height">O₂ Sat:</label>
                                                    <input type="text" class="form-control" id="discharge_osat"
                                                        placeholder="Height">
                                                </div>
                                            </div>



                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_temp">Temperature:</label>
                                                    <input type="text" class="form-control" id="discharge_temp"
                                                        placeholder="Temperature">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_rr">Respiratory Rate (RR):</label>
                                                    <input type="text" class="form-control" id="discharge_rr"
                                                        placeholder="Respiratory Rate">
                                                </div>
                                            </div>

                                        </div>



                                        <div class="row">
                                            <div class="col-lg-12" style="gap: 15px;">
                                                <label class="form-label mb-0"><strong>Parameters for
                                                        Discharge:</strong></label>

                                                <!-- Modality checkboxes -->
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input-discharge-param" type="checkbox"
                                                        id="discharge_param1" value="local">
                                                    <label class="form-check-label" for="anesthesia_local">Patient is
                                                        fully awake and oriented.</label>
                                                </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input-discharge-param" type="checkbox"
                                                        id="discharge_param2" value="local">
                                                    <label class="form-check-label" for="anesthesia_local">Wound
                                                        dressings are dry, intact and in place.</label>
                                                </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input-discharge-param" type="checkbox"
                                                        id="discharge_param3" value="local">
                                                    <label class="form-check-label" for="anesthesia_local">Patient has
                                                        stable vital signs.</label>
                                                </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input-discharge-param" type="checkbox"
                                                        id="discharge_param4" value="local">
                                                    <label class="form-check-label" for="anesthesia_local">Patient can
                                                        maintain mobility with minimal assistance.</label>
                                                </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input-discharge-param" type="checkbox"
                                                        id="discharge_param5" value="local">
                                                    <label class="form-check-label" for="anesthesia_local">Patient
                                                        accompanied by a responsible person/adult.</label>
                                                </div>


                                                <!-- Separator -->

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">

                                                <label for="itemname">Nurse-In-Charge:</label>
                                                <!-- Visible field (user types/sees this one) -->
                                                <input list="discharge_nurse_options" id="discharge_nurse"
                                                    class="form-control" placeholder="Medication" autocomplete="off">
                                                <datalist id="discharge_nurse_options">
                                                    <option value="">Loading...</option>
                                                </datalist>
                                            </div>
                                            <div class="col-lg-6">

                                                <label for="itemname">Surgeon:</label>
                                                <input list="discharge_surgeon_options" id="discharge_surgeon"
                                                    class="form-control" placeholder="Surgeon" autocomplete="off">
                                                <datalist id="discharge_surgeon_options">
                                                    <option value="">Loading...</option>
                                                </datalist>
                                            </div>

                                        </div>




                                        <div class="tab-footer">
                                            <button type="button" class="btn btn-success px-4"
                                                onclick="UpSertAmbulatoryDischarge();">
                                                Save and Print
                                            </button>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="tab-pane fade show" id="tab3" role="tabpanel"
                                    style="max-width:95%;margin: 0 auto;">
                                    <a href="#" onclick='UpSertVitalData();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-plus fa-sm text-white-50"></i> Save </a>
                                    <a href="#" onclick='printVitalSheet();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                            class="fas fa-print fa-sm text-white-50"></i> Print</a><br>
                                    <hr>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="hidden" id="vital_sign_doc_id">

                                            <textarea class="form-control" id="vital_sign_doc" rows="30"
                                                placeholder="Vital Sign"></textarea>

                                        </div>
                                    </div>


                                </div>

                                <div class="tab-pane fade show" id="tab4" role="tabpanel"
                                    style="max-width:95%;margin: 0 auto;">
                                    <a href="#" onclick='UpSertAmpoData();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-plus fa-sm text-white-50"></i> Save </a>
                                    <a href="#" onclick='printAmpoSheet();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                            class="fas fa-print fa-sm text-white-50"></i> Print</a><br>
                                    <hr>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="hidden" id="pos_doc_id">

                                            <textarea class="form-control" id="pos_doc" rows="30"
                                                placeholder=""></textarea>

                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade show" id="tab5" role="tabpanel"
                                    style="max-width:95%;margin: 0 auto;">
                                    <a href="#" onclick='UpSertAmpnData();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-plus fa-sm text-white-50"></i> Save </a>
                                    <a href="#" onclick='printAmpnSheet();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                            class="fas fa-print fa-sm text-white-50"></i> Print</a><br>
                                    <hr>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="hidden" id="amnpnid">
                                            <label for="tab2_bp">Nurse Progress Notes:</label>
                                            <textarea class="form-control" id="nurse_progress_notes" rows="30"
                                                placeholder="Nurse Progress Notes"></textarea>

                                        </div>
                                    </div>

                                    <!-- <div class="table-responsive">


                                        <table id="datatable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Focus</th>
                                                    <th>Data/Action/Response</th>
                                                    <th class="nosort">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dataTableBody_ampn">


                                            </tbody>
                                        </table>
                                        <template id="ampn_rowtemplate">
                                            <tr>

                                                <td class="ampn_date"></td>
                                                <td class="ampn_time"></td>
                                                <td class="ampn_focus"></td>
                                                <td class="ampn_data"></td>

                                                <td>
                                                    <div class="table-actions">
                                                        <button type="button"
                                                            class="btn social-btn bg-success ampn-edit-data-btn">
                                                            <i class="ik ik-edit"></i>
                                                        </button>

                                                        <button type="button"
                                                            class="btn social-btn bg-danger ampn-delete-data-btn">
                                                            <i class="ik ik-trash"></i>
                                                        </button>



                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </div> -->


                                </div>
                                <div class="tab-pane fade show" id="tab6" role="tabpanel"
                                    style="max-width:95%;margin: 0 auto;">

                                    <h5 style="cursor: pointer; display: flex; align-items: center; gap: 6px;"
                                        onclick="toggleChecklistDetails('ambulatory_optech', 'toggleIcon-optech')">
                                        <span id="toggleIcon-optech" style="transition: transform 0.2s;">▼</span>
                                        Operative Technique Form
                                    </h5>

                                    <div id="ambulatory_optech" style="
                                    /* display: none;  */
                                    margin-top: 10px;">
                                        <input type="hidden" id="amtechid_input">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="consent_surgery_date">Date/Time Started:</label>
                                                    <input type="datetime-local" class="form-control"
                                                        id="optech_datetime_started">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="consent_surgery_date">Date/Time Ended:</label>
                                                    <input type="datetime-local" class="form-control"
                                                        id="optech_datetime_ended">
                                                </div>
                                            </div>
                                        </div>


                                        <br>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="tab2_bp">Preoperative Diagnosis:</label>
                                                    <input type="text" class="form-control"
                                                        id="optech_preop_diagnosis_input"
                                                        placeholder="Preoperative Diagnosis">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="tab2_bp">Operative Procedure(s):</label>
                                                    <input type="text" class="form-control"
                                                        id="optech_op_procedure_input"
                                                        placeholder="Operative Procedure">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="tab2_bp">Postoperative Diagnosis:</label>
                                                    <input type="text" class="form-control"
                                                        id="optech_posop_diagnosis_input"
                                                        placeholder="Postoperative Diagnosis">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="tab2_bp">Narrative of Technique with Operative
                                                        Findings:</label>
                                                    <textarea class="form-control" id="optech_narative_input" rows="3"
                                                        placeholder="Narrative of Technique with Operative Findings"></textarea>

                                                </div>
                                            </div>

                                            <div style="margin-top: 10px;">
                                                <label>Upload / Paste Images:</label>

                                                <button class="btn btn-primary" id="upload-btn" type="button">Select
                                                    Images</button>
                                                <input type="file" id="file-input" multiple style="display:none;">
                                                <div id="image-preview" style="margin-top:10px;"></div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">


                                                <label for="itemname">Surgeon:</label>
                                                <!-- Visible field (user types/sees this one) -->
                                                <input list="optech_surgeon_input_options" id="optech_surgeon_input"
                                                    class="form-control" placeholder="Surgeon" autocomplete="off">
                                                <datalist id="optech_surgeon_input_options">
                                                    <option value="">Loading...</option>
                                                </datalist>
                                            </div>
                                            <div class="col-lg-4">


                                                <label for="itemname">Assistant:</label>
                                                <!-- Visible field (user types/sees this one) -->
                                                <input list="optech_assistant_input_options" id="optech_assistant_input"
                                                    class="form-control" placeholder="Assistant" autocomplete="off">
                                                <datalist id="optech_assistant_input_options">
                                                    <option value="">Loading...</option>
                                                </datalist>
                                            </div>
                                            <div class="col-lg-4">

                                                <label for="itemname">Anethesiologist:</label>
                                                <!-- Visible field (user types/sees this one) -->
                                                <input list="optech_anesthesiologist_input_options"
                                                    id="optech_anesthesiologist_input" class="form-control"
                                                    placeholder="Anethesiologist" autocomplete="off">
                                                <datalist id="optech_anesthesiologist_input_options">
                                                    <option value="">Loading...</option>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">

                                                <label for="itemname">Scrub Nurse:</label>
                                                <!-- Visible field (user types/sees this one) -->
                                                <input list="optech_scrub_nurse_input_options"
                                                    id="optech_scrub_nurse_input" class="form-control"
                                                    placeholder="Scrub Nurse" autocomplete="off">
                                                <datalist id="optech_scrub_nurse_input_options">
                                                    <option value="">Loading...</option>
                                                </datalist>
                                            </div>
                                            <div class="col-lg-6">


                                                <label for="itemname">Circulating Nurse:</label>
                                                <!-- Visible field (user types/sees this one) -->
                                                <input list="optech_circulating_nurse_input_options"
                                                    id="optech_circulating_nurse_input" class="form-control"
                                                    placeholder="Circulating Nurse" autocomplete="off">
                                                <datalist id="optech_circulating_nurse_input_options">
                                                    <option value="">Loading...</option>
                                                </datalist>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_bp">Instrument Count:</label>
                                                    <input type="text" class="form-control"
                                                        id="optech_instrument_count_input"
                                                        placeholder="Instrument Count">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_bp">Needle Count:</label>
                                                    <input type="text" class="form-control"
                                                        id="optech_needle_count_input" placeholder="Needle Count">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tab2_bp">Sponge Count:</label>
                                                    <input type="text" class="form-control"
                                                        id="optech_sponge_count_input" placeholder="Sponge Count">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-footer">
                                            <button type="button" class="btn btn-success px-4"
                                                onclick="UpSertOperativeTechnique();">
                                                Save and Print
                                            </button>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="tab-pane fade show" id="tab7" role="tabpanel"
                                    style="max-width:95%;margin: 0 auto;">
                                    <a href="#" onclick='UpSertMSData();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-plus fa-sm text-white-50"></i> Save </a>
                                    <a href="#" onclick='printMedicationSheet();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                            class="fas fa-print fa-sm text-white-50"></i> Print</a><br>
                                    <hr>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="hidden" id="medication_sheet_doc_id">

                                            <textarea class="form-control" id="medication_sheet_doc" rows="0"
                                                placeholder=""></textarea>

                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade show" id="tab8" role="tabpanel"
                                    style="max-width:95%;margin: 0 auto;">
                                    <a href="#" onclick='saveAllInstruments();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-save fa-sm text-white-50"></i> Save</a>
                                    <a href="#" onclick='printORCharges();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                            class="fas fa-print fa-sm text-white-50"></i> Print</a><br>
                                    <hr>
                                    <div class="table-responsive">


                                        <table id="datatable_ins" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Classification</th>
                                                    <th>Instrument</th>
                                                    <th>Qty</th>
                                                    <th class="nosort">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dataTableBody_ins">


                                            </tbody>
                                        </table>
                                        <template id="instrument_rowtemplate">
                                            <tr>
                                                <td class="ins_supid" style="display:none;"></td>
                                                <td class="ins_classification"></td>
                                                <td class="ins_instument"></td>
                                                <td class="ins_qty"></td>

                                            </tr>
                                        </template>


                                    </div>
                                </div>

                                <div class="tab-pane fade show" id="tab9" role="tabpanel"
                                    style="max-width:95%;margin: 0 auto;">
                                    <a href="#" onclick='UpSertInstrumentCountdata();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-save fa-sm text-white-50"></i> Save </a>
                                    <a href="#" onclick='printInstrumentCountSheet();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                            class="fas fa-print fa-sm text-white-50"></i> Print</a><br>
                                    <hr>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="hidden" id="instument_count_doc_id">
                                            <label for="tab2_bp">Instrument Count Sheet:</label>
                                            <textarea class="form-control" id="instrument_count_doc" rows="30"
                                                placeholder="Instrument Count"></textarea>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="dataModalAmpo" tabindex="-1" role="dialog"
                aria-labelledby="fullwindowModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fullwindowModalLabel">Physicians Order


                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body" style="padding: 50px;">
                            <input type="hidden" id="ampoid_input">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="tab2_bp">Date Time:</label>
                                        <input type="datetime-local" class="form-control" id="ampo_datetime_input"
                                            placeholder="Blood Pressure">
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label for="tab2_bp">Note:</label>
                                        <input type="text" class="form-control" id="ampo_note_input" placeholder="Note">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="tab2_bp">Order:</label>
                                        <input type="text" class="form-control" id="ampo_order_input"
                                            placeholder="Doctor's Order">
                                    </div>
                                </div>
                            </div>




                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-primary" onclick="UpSertAmpoData();">Save</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="dataModalMs" tabindex="-1" role="dialog" aria-labelledby="dataModalMsLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dataModalMsLabel">Medication Sheet Form


                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body" style="padding: 50px;">
                            <input type="hidden" id="ms_msid_input">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="tab2_bp">Date Time:</label>
                                        <input type="datetime-local" class="form-control" id="ms_datetime_input"
                                            placeholder="Blood Pressure">
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <label for="itemname">Medications:</label>
                                    <!-- Visible field (user types/sees this one) -->
                                    <input list="ms_medication_input_options" id="ms_medication_input"
                                        class="form-control" placeholder="Medication" autocomplete="off">
                                    <datalist id="ms_medication_input_options">
                                        <option value="">Loading...</option>
                                    </datalist>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tab2_bp">Stock Dose:</label>
                                        <input type="text" class="form-control" id="ms_stock_dose_input"
                                            placeholder="Stock Dose">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tab2_bp">Dosage:</label>
                                        <input type="text" class="form-control" id="ms_dosage_input"
                                            placeholder="Dosage">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tab2_bp">Route:</label>
                                        <input type="text" class="form-control" id="ms_route_input" placeholder="Route">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tab2_bp">Frequency:</label>
                                        <input type="text" class="form-control" id="ms_frequency_input"
                                            placeholder="Frequency">
                                    </div>
                                </div>
                            </div>




                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-primary" onclick="UpSertMSData();">Save</button>
                        </div>
                    </div>
                </div>
            </div>



            <div class="modal fade" id="dataModalMsNurse" tabindex="-1" role="dialog"
                aria-labelledby="fullwindowModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fullwindowModalLabel">Medication Sheet Form


                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body" style="padding: 50px;">
                            <input type="hidden" id="ms_nurse_msnid_input">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="tab2_bp">Date Time:</label>
                                        <input type="datetime-local" class="form-control" id="ms_nurse_datetime_input"
                                            placeholder="Blood Pressure">
                                    </div>
                                </div>
                                <div class="col-lg-9">


                                    <label for="itemname">Nurse:</label>
                                    <!-- Visible field (user types/sees this one) -->
                                    <input list="ms_nurse_nurse_input_options" id="ms_nurse_nurse_input"
                                        class="form-control" placeholder="Nurse" autocomplete="off">
                                    <datalist id="ms_nurse_nurse_input_options">

                                    </datalist>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="tab2_bp">PRN/Stat/Single Dose Meds:</label>
                                        <input type="text" class="form-control" id="ms_nurse_remarks_input"
                                            placeholder="PRN/Stat/Single Dose Meds">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-primary" onclick="UpSertMSNurseData();">Save</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pako@2.1.0/dist/pako.min.js"></script>



    <script>


    </script>



    <!-- other plugins -->
    <script src="scripts/promptScript-v1.js"></script>
    <script src="scripts/topbarScript-v1.js"></script>
    <script src="scripts/constants.js"></script>
    <script src="scripts/dynamicScripts-v5.js"></script>
    <script src="scripts/ambulatory-view-v7.js"></script>
    <script src="scripts/tableScripts-v1.js"></script>


</body>

</html>