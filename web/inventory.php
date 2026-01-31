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
                                    <h6 class="m-0 font-weight-bold">Stocks : Supplies / Equipments / Other Charges</h6>
                                    <a href="#" onclick='openModal();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-plus fa-sm text-white-50"></i> Add Stock</a>
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
                                                <option value="invid">InvRef#</option>
                                                <option value="itemname">Name</option>
                                                <option value="date_expiry">Date Expiry</option>
                                                <option value="qty_onhand">Qty Onhand</option>
                                                <option value="date_received">Date Received</option>
                                                <option value="a.updated_at">Updated</option>

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
                                                    <th>InvRef#</th>
                                                    <th>ItemRef#</th>
                                                    <th class="nosort">Name</th>
                                                    <th>Date Received</th>
                                                    <th>Qty Received</th>
                                                    <th>Qty Onhand</th>
                                                    <th>Qty Consumed</th>
                                                    <th>Qty Dispossed</th>
                                                    <th>Date Expiry</th>
                                                    <th>Remarks</th>
                                                    <th>Updated Date</th>
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
                                        <td class="invid"></td>
                                        <td class="supid"></td>
                                        <td class="itemname"></td>
                                        <td class="date_received"></td>
                                        <td class="qty_received"></td>
                                        <td class="qty_onhand"></td>
                                        <td class="qty_consumed"></td>
                                        <td class="qty_dispossed"></td>
                                        <td class="date_expiry"></td>
                                        <td class="remarks"></td>
                                        <td class="updated_at"></td>

                                        <td>
                                            <div class="table-actions">
                                                <button type="button" class="btn social-btn bg-primary edit-data-btn">
                                                    <i class="ik ik-edit"></i>
                                                </button>

                                                <button type="button" class="btn social-btn bg-danger dispose-data-btn"
                                                    data-toggle="tooltip" data-placement="top" title="Dispose Item">
                                                    <i class="ik ik-trash"></i>
                                                </button>
                                                <button type="button" class="btn social-btn bg-success history-data-btn"
                                                    data-toggle="tooltip" data-placement="top" title="Dispose Item">
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
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="fullwindowModalLabel">Inventory Reference #:
                                                    <span id="itemid"></span>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body" style="padding: 50px;">

                                                <input type="hidden" id="recordid">

                                                <div class="row">

                                                    <div class="col-lg-6">


                                                        <label for="itemname">Medicine</label>

                                                        <!-- Visible field (user types/sees this one) -->
                                                        <input list="medicineOptions" id="itemname" class="form-control"
                                                            placeholder="Type medicine code or name" autocomplete="off"
                                                            onchange="setSupplyId();">

                                                        <datalist id="medicineOptions">

                                                        </datalist>

                                                        <!-- Hidden field (this is submitted to backend) -->
                                                        <input type="hidden" id="invidmodal" name="invidmodal">

                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Quantity Received</label>
                                                            <input type="number" class="form-control" id="qty_received"
                                                                placeholder="Quantity Received">
                                                        </div>
                                                    </div>




                                                </div>

                                                <div class="row">

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Date Received</label>
                                                            <input type="date" class="form-control" id="date_received"
                                                                placeholder="Item Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Expiration Date</label>
                                                            <input type="date" class="form-control" id="date_expiry"
                                                                placeholder="Item Name">
                                                        </div>
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


                                <div class="modal fade" id="disposaldataModal" tabindex="-1" role="dialog"
                                    aria-labelledby="fullwindowModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="fullwindowModalLabel">Item Dispossal:
                                                    <span id="dispossalitemid"></span>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body" style="padding: 50px;">
                                                Item Name : <strong><span id="dispossalItemName"></span></strong>
                                                <input type="hidden" id="dispossal_recordid">

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Dispossal Date</label>
                                                            <input type="date" class="form-control" id="dispossal_date"
                                                                placeholder="Item Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Dispossal
                                                                Quantity</label>
                                                            <input type="number" class="form-control" id="qty_dispossal"
                                                                placeholder="Dispossal Quantity">
                                                        </div>
                                                    </div>




                                                </div>





                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="itemdisposal();">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="historydataModal" tabindex="-1" role="dialog"
                                    aria-labelledby="fullwindowModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="fullwindowModalLabel">Item History:
                                                    <span id="historyitemid"></span>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body" style="padding: 50px;">
                                                Item Name : <strong><span id="historyItemName"></span></strong>
                                                <input type="hidden" id="history_recordid">
                                                <table id="datatable" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>InvRef#</th>
                                                            <th>Type</th>
                                                            <th>Qty</th>
                                                            <th>Date</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="historydataTableBody">
                                                        <?php include_once('nav/loader.php'); ?>

                                                    </tbody>
                                                </table>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <template id="historydataRowTemplate">
                                    <tr>
                                        <td class="invsubid"></td>
                                        <td class="type"></td>
                                        <td class="history_qty"></td>
                                        <td class="history_date"></td>

                                    </tr>
                                </template>

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
    <script src="scripts/inventory-v3.js"></script>
    <script src="scripts/tableScripts-v1.js"></script>


</body>

</html>