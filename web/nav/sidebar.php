<?php

$page = basename($_SERVER['PHP_SELF']);
// Define page groups
$dashboard = ['dashboard.php'];
$patientRecord = ['patientrecords.php', 'patientregistration.php', 'patientview.php', 'patientedit.php'];
$configuration = ['supplies.php'];
$inventory = ['inventory.php', 'supplies.php'];
$opd = ['opdlist.php'];

// Determine active states
$dashboardActive = in_array($page, $dashboard) ? 'active' : '';
$patientRecordActive = in_array($page, $patientRecord) ? 'active' : '';
$configurationActive = in_array($page, $configuration) ? 'active' : '';
$inventoryActive = in_array($page, $inventory) ? 'active' : '';
$clinicalServicesActive = in_array($page, $opd) ? 'active' : '';

echo '
  <div class="app-sidebar colored">
                <div class="sidebar-header">
                    <a class="header-brand" href="#">
                        <div class="logo-img">
                            <img src="img/logo/square-logo.png" class="header-brand-img" style="max-height:30px;" alt="lavalite">
                        </div>
                        <span class="text">AWCC</span>
                    </a>
                    <button type="button" class="nav-toggle"><i data-toggle="collapsed"
                            class="ik toggle-icon ik-toggle-left"></i></button>
                    <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
                </div>

                <div class="sidebar-content ps ps--active-y">
                    <div class="nav-container">
                        <nav id="main-menu-navigation" class="navigation-main">
                           
                            <div class="nav-item ' . $dashboardActive . '"">
                                <a href="dashboard.php"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                            </div>
                           

                             <div class="nav-item ' . $patientRecordActive . '">
                                <a href="patientrecords.php"><i class="ik ik-users"></i><span>Patients Record</span></a>
                            </div>

                         

                              <div class="nav-item has-sub ' . $clinicalServicesActive . '">
                                    <a href="#"><i class="ik ik-activity"></i><span>Clinical Services</span></a>
                                
                                     <div class="submenu-content">
                                        <a href="opd-consultation.php" class="menu-item">OPD Consultation</a>   
                                    </div>

                                     <div class="submenu-content">
                                        <a href="#" class="menu-item">Ambulatory Surgery</a>   
                                    </div>

                                   
                                </div>
                         

                             <div class="nav-item has-sub ' . $inventoryActive . '">
                                    <a href="#"><i class="ik ik-box"></i><span>Inventory</span></a>
                                
                                     <div class="submenu-content">
                                        <a href="supplies.php" class="menu-item">Supplies & Others</a>   
                                    </div>

                                    <div class="submenu-content">
                                    <a href="inventory.php" class="menu-item">Stock Management</a>   
                                </div>
                                </div>
                         

                          
                            
                        </nav>
                    </div>
                </div>

                
            </div>

';

?>