<?php
session_start();
include('config/config.php');
// include('config/checklogin.php');
// check_login();
//Delete Staff
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $adn = "DELETE FROM bnhs_staff WHERE staff_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $stmt->close();
  if ($stmt) {
    $success = "Deleted" && header("refresh:1; url=user_management.php");
  } else {
    $err = "Try Again Later";
  }
}
require_once('partials/_head.php');
?>

<body>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <style>
      /* Custom styles for inventory management tabs */
      .custom-tabs {
        margin-bottom: 15px;
      }

      .custom-tab-link {
        font-weight: bold;
        color: #495057;
        padding: 15px 30px;
        transition: color 0.3s, background-color 0.3s;
      }

      .custom-tab-link:hover {
        color: #0056b3;
        background-color: #f8f9fa;
      }
    </style>
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/bnhsfront.jpg); background-size: cover;"
      class="header pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="dropdown" style="padding: 20px; margin: 10px;">
              <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false" style="width: 300px; height: 45px;">
                Purchase Acceptance Report
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="inventory_management.php">Inspection and Acceptance Report</a></li>
                <li><a class="dropdown-item" href="ris.php">Requisition and Issue Slip</a></li>
                <li><a class="dropdown-item" href="ics.php">Inventory Custodian Slip</a></li>
              </ul>
            </div>


            <div class="card-body ">

              <form method="POST" action="save_building_info.php" class="border border-light p-4 rounded">
                <div class="container mt-4">
                <h2 class="text-center mb-4 text-uppercase"> Purchase Acceptance Report</h2>
                  <!-- Entity Info -->
                  <div class="row mt-3 mb-3">
                    <div class="col-md-4">
                      <label>Entity Name</label>
                      <input style="color: #000000;" type="text" class="form-control" name="entity_name" required>
                    </div>
                    <div class="col-md-4">
                      <label>Fund Cluster</label>
                      <input style="color: #000000;" type="text" class="form-control" name="fund_cluster" required>
                    </div>
                    <div class="col-md-4">
                      <label>PAR No.</label>
                      <input style="color: #000000;" type="text" class="form-control" name="par_no" required>
                    </div>
                  </div>

                  <!-- Item Info -->
                  <div class="row mb-3">
                    <div class="col-md-2">
                      <label>Quantity</label>
                      <input style="color: #000000;" type="number" class="form-control" name="quantity">
                    </div>
                    <div class="col-md-2">
                      <label>Unit</label>
                      <input style="color: #000000;" type="text" class="form-control" name="unit">
                    </div>
                    <div class="col-md-4">
                      <label>Description</label>
                      <input style="color: #000000;" type="text" class="form-control" name="description">
                    </div>
                    <div class="col-md-4">
                      <label>Property Number</label>
                      <input style="color: #000000;" type="text" class="form-control" name="property_number">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label>Date Acquired</label>
                      <input style="color: #000000;" type="date" class="form-control" name="date_acquired">
                    </div>
                    <div class="col-md-4">
                      <label>Unit Cost</label>
                      <input style="color: #000000;" type="text" class="form-control" name="unit_cost">
                    </div>
                    <div class="col-md-4">
                      <label>Total Amount</label>
                      <input style="color: #000000;" type="text" class="form-control" name="total_amount">
                    </div>
                  </div>

                  <!-- Receiver Section -->
                  <div class="sub-section receiver-section">Receiver</div>
                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label>End User Name</label>
                      <input style="color: #000000;" type="text" class="form-control" name="end_user_name">
                    </div>
                    <div class="col-md-4">
                      <label>Position/Office</label>
                      <input style="color: #000000;" type="text" class="form-control" name="receiver_position">
                    </div>
                    <div class="col-md-4">
                      <label>Date</label>
                      <input style="color: #000000;" type="date" class="form-control" name="receiver_date">
                    </div>
                  </div>

                  <!-- Issue Section -->
                  <div class="sub-section issue-section">Issue</div>
                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label>Property Custodian Name</label>
                      <input style="color: #000000;" type="text" class="form-control" name="custodian_name">
                    </div>
                    <div class="col-md-4">
                      <label>Position/Office</label>
                      <input style="color: #000000;" type="text" class="form-control" name="custodian_position">
                    </div>
                    <div class="col-md-4">
                      <label>Date</label>
                      <input style="color: #000000;" type="date" class="form-control" name="custodian_date">
                    </div>
                  </div>

                  <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </form>

            </div>

          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php
      require_once('partials/_mainfooter.php');
      ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>