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
                                    <h6 class="m-0 font-weight-bold">Instrument List</h6>
                                    <a href="#" onclick='openModal();'"
                                        class=" d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                            class="fas fa-plus fa-sm text-white-50"></i> Add</a>
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
                                                <option value="itemname">Name</option>
                                                <option value="type">Type</option>
                                                <option value="classification">Classification</option>
                                                <option value="prize">Price</option>
                                                <option value="created_at">Creation</option>
                                                <option value="updated_at">Updated</option>
                                                <option value="status">Status</option>
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
                                                    <th>Item Reference No</th>
                                                    <th class="nosort">Name</th>


                                                    <th>Type</th>
                                                    <th>Classification</th>
                                                    <th>Consumable</th>
                                                    <th>Revised Stock Level</th>
                                                    <th>Qty On Hand</th>
                                                    <th>Earliest Expiration</th>
                                                    <th>Cash</th>
                                                    <th>HMO</th>
                                                    <th>Discounted</th>
                                                    <th>Status</th>

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
                                        <td class="id"></td>
                                        <td class="name"></td>



                                        <td class="type"></td>
                                        <td class="classification"></td>
                                        <td class="isConsumable"></td>
                                        <td class="rsv"></td>
                                        <td class="qtyOnhand"></td>
                                        <td class="remarks"></td>
                                        <td class="cash"></td>
                                        <td class="hmo"></td>
                                        <td class="discounted"></td>
                                        <td class="status"></td>

                                        <td>
                                            <div class="table-actions">
                                                <button type="button" class="btn social-btn bg-primary edit-data-btn">
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
                                                <h5 class="modal-title" id="fullwindowModalLabel">Item Reference #:
                                                    <span id="itemid"></span>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body" style="padding: 50px;">

                                                <input type="hidden" id="recordid">

                                                <div class="row">

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Name</label>
                                                            <input type="text" class="form-control" id="itemname"
                                                                placeholder="Item Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Type</label>
                                                            <select class="form-control" id="type"
                                                                onchange="setConsumable()">
                                                                <option value="">-- Select --</option>
                                                                <option value="Supplies / Medicine">Supplies / Medicine
                                                                </option>
                                                                <option value="OR Charges">OR Charges</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Classification</label>
                                                            <select class="form-control" id="classification"
                                                                onchange="setConsumable()">
                                                                <option value="">-- Select --</option>
                                                                <option value="Machine / Equipment">Machine / Equipment
                                                                </option>
                                                                <option value="Fees">Fees</option>
                                                                <option value="PPE">PPE</option>
                                                                <option value="Anesthetic Agents">Anesthetic Agents
                                                                </option>
                                                                <option value="Narcotics">Narcotics</option>
                                                                <option value="IV Fluids">IV Fluids</option>
                                                                <option value="Gases">Gases</option>
                                                                <option value="Supplies">Supplies</option>
                                                                <option value="Sutures">Sutures</option>
                                                                <option value="Cleansing Agents">Cleansing Agents
                                                                </option>
                                                                <option value="Wound Care">Wound Care</option>

                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>
                                                Pricing:
                                                <div class="row">

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Cash:</label>
                                                            <input type="number" class="form-control" id="price-cash"
                                                                placeholder="Item Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">HMO:</label>
                                                            <input type="number" class="form-control" id="price-hmo"
                                                                placeholder="Item Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Discounted:</label>
                                                            <input type="number" class="form-control"
                                                                id="price-discounted" placeholder="Item Name">
                                                        </div>
                                                    </div>




                                                </div>

                                                <div class="row">

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Revised Stock
                                                                Level</label>
                                                            <input type="number" class="form-control" id="rsv"
                                                                placeholder="Revised Stock Level">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Status</label>
                                                            <select class="form-control" id="status">
                                                                <option value="">-- Select --</option>
                                                                <option value="Active">Active</option>
                                                                <option value="Inactive">Inactive</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Is Consumable</label>
                                                            <select class="form-control" id="isConsumable">
                                                                <option value="">-- Select --</option>
                                                                <option value="1">Yes</option>
                                                                <option value="0">No</option>

                                                            </select>
                                                        </div>
                                                    </div>



                                                </div>
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputUsername1">Description:</label>
                                                            <input type="text" class="form-control" id="description"
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
    <script src="scripts/suppliesconfig-v2.js"></script>
    <script src="scripts/tableScripts-v1.js"></script>


</body>

</html>