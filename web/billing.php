<?php

require_once 'properties.php';

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        <?php echo $system_name; ?>
    </title>
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
                                    <h6 class="m-0 font-weight-bold">Billing Record</h6>
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
                                                <option value="BillDate">BillDate</option>
                                                <option value="BillNo">BillNo</option>
                                                <option value="PatientNo">PatientNo</option>
                                                <option value="Fullname">Fullname</option>

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
                                                    <th>BillNo</th>
                                                    <th>BillDate</th>
                                                    <th class="nosort">PatienNo</th>
                                                    <th>Fullname</th>
                                                    <th>ReferenceNo</th>
                                                    <th>Transaction Type</th>
                                                    <th>Physician</th>
                                                    <th>Total Amount</th>
                                                    <th>Payment Type</th>
                                                    <th>Balance</th>
                                                    <th class="nosort">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody id="billTableBody">
                                                <?php include_once('nav/loader.php'); ?>

                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                                <template id="billRowTemplate">
                                    <tr>
                                        <td class="billid"></td>
                                        <td class="billdate"></td>
                                        <td class="id"></td>
                                        <td class="name"></td>
                                        <td class="ReferenceNo"></td>
                                        <td class="transactiontype"></td>
                                        <td class="physician"></td>
                                        <td class="total"></td>
                                        <td class="paymentType"></td>
                                        <td class="balance"></td>

                                        <td>
                                            <div class="table-actions">
                                                <button type="button"
                                                    class="btn social-btn bg-primary edit-profile-btn">
                                                    <i class="ik ik-eye"></i>
                                                </button>

                                                <button type="button"
                                                    class="btn social-btn bg-warning edit-payment-btn">
                                                    <i class="ik ik-credit-card"></i>
                                                </button>

                                                <button type="button" class="btn social-btn bg-success edit-print-btn">
                                                    <i class="fas fa-print"></i>
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







                            </div>
                        </div>

                        <!-- OPD Modal -->
                        <div class="modal fade" id="opd-modal" tabindex="-1" role="dialog"
                            aria-labelledby="fullwindowModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="fullwindowModalLabel">Billing

                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body" style="padding: 50px;">

                                        <input type="hidden" id="opd-recordid">
                                        <input type="hidden" id="opd-patientId">
                                        <input type="hidden" id="opd-referenceid">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Bill Number</label>
                                                    <input type="text" class="form-control" id="opd-billno"
                                                        placeholder="Consultation Ref #" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Transaction Type</label>
                                                    <input type="text" class="form-control" id="opd-transactiontype"
                                                        placeholder="Transaction Type" readonly>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Bill Date</label>
                                                    <input type="date" class="form-control" id="opd-billdate"
                                                        placeholder="Item Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Patient Name</label>
                                                    <input type="text" class="form-control" id="opd-patient"
                                                        placeholder="Consultation Ref #" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Physician:</label>
                                                    <input type="text" class="form-control" id="opd-physician"
                                                        placeholder="Consultation Ref #" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Payment Type:</label>
                                                    <select class="form-control" id="opd-paymenttype">
                                                        <option value="Cash">Cash</option>
                                                        <option value="HMO">HMO</option>
                                                        <option value="PHIC">PhIlhealth</option>
                                                        <option value="PWD/Senior">PWD/Senior</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <strong>OR Charges</strong>
                                        <!-- Editable Table -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm align-middle">
                                                <thead class="table-light text-center">
                                                    <tr>
                                                        <th style="width:5%"></th>
                                                        <th style="width:65%">Charge Item</th>
                                                        <th style="width:30%">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="or_charges_table_body">
                                                    <!-- Default Row -->
                                                    <tr>
                                                        <td class="text-center">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm remove-row"
                                                                title="Remove Row" onclick="removeORChargeRow()">
                                                                ×
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="e.g. Consultation Fee">
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                class="form-control form-control-sm text-end"
                                                                placeholder="0.00" step="0.01"
                                                                oninput="calculateORChargesTotal()">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="table-light fw-bold">
                                                        <td>
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                id="add_row" onclick="addORChargeRow()">
                                                                +
                                                            </button>

                                                        </td>
                                                        <td class="text-end" style="text-align: center;">
                                                            Total:
                                                        </td>

                                                        <td class="text-end">
                                                            <input type="number"
                                                                class="form-control form-control-sm text-end"
                                                                id="or_charges_total" placeholder="0.00"
                                                                style="text-align:right;" readonly>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>


                                        <hr>
                                        <strong>Other Charges</strong>
                                        <!-- Editable Table -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm align-middle">
                                                <thead class="table-light text-center">
                                                    <tr>
                                                        <th style="width:5%"></th>
                                                        <th style="width:65%">Charge Item</th>
                                                        <th style="width:30%">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="charges_table_body">
                                                    <!-- Default Row -->
                                                    <tr>
                                                        <td class="text-center">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm remove-row"
                                                                title="Remove Row" onclick="removeChargeRow()">
                                                                ×
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="e.g. Consultation Fee">
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                class="form-control form-control-sm text-end"
                                                                placeholder="0.00" step="0.01"
                                                                oninput="calculateChargesTotal()"
                                                                style="text-align:right;">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="table-light fw-bold">
                                                        <td>
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                id="add_row" onclick="addChargeRow()">
                                                                +
                                                            </button>

                                                        </td>
                                                        <td class="text-end" style="text-align: center;">
                                                            Total:
                                                        </td>

                                                        <td class="text-end">
                                                            <input type="number"
                                                                class="form-control form-control-sm text-end"
                                                                id="charges_total" placeholder="0.00"
                                                                style="text-align:right;" readonly>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>



                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="updateBilling();">Save</button>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of OPD Modal -->



                        <!-- Payment Modal -->
                        <div class="modal fade" id="payment-modal" tabindex="-1" role="dialog"
                            aria-labelledby="fullwindowModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="fullwindowModalLabel">Payments

                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body" style="padding: 50px;">

                                        <input type="hidden" id="payment-recordid">
                                        <input type="hidden" id="payment-patientId">
                                        <input type="hidden" id="payment-referenceid">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Bill Number</label>
                                                    <input type="text" class="form-control" id="payment-billno"
                                                        placeholder="Consultation Ref #" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Transaction Type</label>
                                                    <input type="text" class="form-control" id="payment-transactiontype"
                                                        placeholder="Transaction Type" readonly>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Bill Date</label>
                                                    <input type="date" class="form-control" id="payment-billdate"
                                                        placeholder="Item Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Patient Name</label>
                                                    <input type="text" class="form-control" id="payment-patient"
                                                        placeholder="Consultation Ref #" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Physician:</label>
                                                    <input type="text" class="form-control" id="payment-physician"
                                                        placeholder="Consultation Ref #" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Total Amount Due:</label>
                                                    <input type="text" class="form-control" id="total-amountDue"
                                                        placeholder="Consultation Ref #" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <strong>Payments</strong>
                                        <!-- Editable Table -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm align-middle">
                                                <thead class="table-light text-center">
                                                    <tr>
                                                        <th style="width:5%"></th>
                                                        <th style="width:30%">Amount</th>
                                                        <th style="width:30%">Mode of Payment</th>
                                                        <th style="width:30%">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="payment_table_body">
                                                    <!-- Default Row -->
                                                    <tr>
                                                        <td class="text-center">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm remove-row"
                                                                title="Remove Row" onclick="removePaymentRow()">
                                                                ×
                                                            </button>
                                                        </td>

                                                        <td>
                                                            <input type="number"
                                                                class="form-control form-control-sm text-end"
                                                                placeholder="0.00" step="0.01"
                                                                oninput="calculatePaymentTotal()"
                                                                style="text-align:right;">
                                                        </td>

                                                        <td>
                                                            <select class="form-control" id="paymenttype">
                                                                <option value="Cash">Cash</option>
                                                                <option value="HMO">HMO</option>
                                                                <option value="PHIC">PhIlhealth</option>
                                                                <option value="Bank Transfer">Bank Transfer</option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="date" class="form-control form-control-sm"
                                                                placeholder="e.g. Consultation Fee">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="table-light fw-bold">
                                                        <td style="text-align:center;">
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                id="add_row" onclick="addPaymentRow()">
                                                                +
                                                            </button>

                                                        </td>
                                                        <td class="text-end" style="text-align: center;" colspan="2">
                                                            Total:
                                                        </td>

                                                        <td class="text-end">
                                                            <input type="number"
                                                                class="form-control form-control-sm text-end"
                                                                id="payment_total" placeholder="0.00"
                                                                style="text-align:right;" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr class="table-light fw-bold">
                                                        <td>


                                                        </td>
                                                        <td class="text-end" style="text-align: center;" colspan="2">
                                                            Remaining Balance:
                                                        </td>

                                                        <td class="text-end">
                                                            <input type="number"
                                                                class="form-control form-control-sm text-end"
                                                                id="remaining_balance" placeholder="0.00"
                                                                style="text-align:right;" readonly>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>






                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="updatePayment();">Save</button>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Payment Modal -->
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
    <script src="scripts/dynamicScripts-v5.js"></script>
    <script src="scripts/bill-v3.js"></script>
    <script src="scripts/tableScripts-v1.js"></script>


</body>

</html>