<?php
$staff_id = $_SESSION['staff_id'];
//$login_id = $_SESSION['login_id'];
$ret = "SELECT * FROM   bnhs_staff  WHERE staff_id = '$staff_id'";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($staff = $res->fetch_object()) {

  ?>
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light" id="sidenav-main" style="background: linear-gradient(to bottom right, #d9f0ff, #ffffff);">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
        aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="pt-1 nav-logo-container" href="dashboard.php">
        <img src="assets/img/theme/logos.png" class="nav-logo" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="assets/img/theme/user-a-min.png">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href="change_profile.php" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="dashboard.php">
                <img src="assets/img/brand/bnhs.png "class="nav-logo-collapse" alt="..." >
              </a>
            </div>
          </div>
        </div>
        <!-- Form -->
        <form class="mt-4 mb-3 d-md-none">
          <div class="input-group input-group-rounded input-group-merge">
            <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search"
              aria-label="Search">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <span class="fa fa-search"></span>
              </div>
            </div>
          </div>
        </form>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
              <i><span class="material-icons-sharp text-primary">dashboard</span></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="inventory_management.php">
              <i><span class="material-icons-sharp text-primary">inventory_2</span></i> Inventory Management
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="track_inventory.php">
              <i><span class="material-icons-sharp text-primary">plagiarism</span></i> Track Inventory
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link dropdown-toggle" href="#reportsSubmenu" data-toggle="collapse" aria-expanded="false">
              <i><span class="material-icons-sharp text-primary">description</span></i> Reports
            </a>
            <ul class="collapse list-unstyled ml-3" id="reportsSubmenu">
            <li class="nav-item">
                <a class="nav-link" href="display_iar.php" style="padding: 3px 24px;">
                  <i><span class="material-icons-sharp text-primary">format_list_bulleted</span></i> IAR
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="display_ris.php" style="padding: 3px 24px;">
                  <i><span class="material-icons-sharp text-primary">format_list_bulleted</span></i> RIS
                </a>
              </li>
              <li class="nav-item" >
                <a class="nav-link" href="display_ics.php" style="padding: 3px 24px;">
                  <i><span class="material-icons-sharp text-primary">format_list_bulleted</span></i> ICS
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="display_par.php" style="padding: 3px 24px;">
                  <i><span class="material-icons-sharp text-primary">format_list_bulleted</span></i> PAR
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link dropdown-toggle" href="#AuditsSubmenu" data-toggle="collapse" aria-expanded="false">
              <i><span class="material-icons-sharp text-primary">fact_check</span></i> Audits
            </a>
            <ul class="collapse list-unstyled ml-3" id="AuditsSubmenu" >
              <li class="nav-item">
                <a class="nav-link" href="rpcppe.php" style="padding: 3px 24px;">
                  <i><span class="material-icons-sharp text-primary">format_list_bulleted</span></i> RPCPPE
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="rpcsp.php" style="padding: 3px 24px;">
                  <i><span class="material-icons-sharp text-primary">format_list_bulleted</span></i> RPCSP
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="change_profile.php">
              <i><span class="material-icons-sharp text-primary">settings</span></i> Settings
            </a>
          </li>
        </ul>
        <div class="sidebar-footer mt-auto">
          <hr class="my-3">
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <a class="nav-link" href="logout.php" id="logoutBtn">
                <i><span class="material-icons-sharp text-primary">logout</span></i> Log Out
              </a>
            </li>
          </ul>
        </div>

      </div>
    </div>
  </nav>

<?php } ?>