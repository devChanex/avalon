<?php

$page = basename($_SERVER['PHP_SELF']);
// Define page groups
$dashboard = ['dashboard.php'];
$patientRecord = ['patientrecords.php', 'patientregistration.php', 'patientview.php', 'patientedit.php'];

// Determine active states
$dashboardActive = in_array($page, $dashboard) ? 'active' : '';
$patientRecordActive = in_array($page, $patientRecord) ? 'active' : '';

echo '
  <div class="app-sidebar colored">
                <div class="sidebar-header">
                    <a class="header-brand" href="index.html">
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
                            
                        </nav>
                    </div>
                </div>
            </div>

';

?>