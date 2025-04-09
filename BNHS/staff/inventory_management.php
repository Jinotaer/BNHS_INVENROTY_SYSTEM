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
                Inspection and Acceptance Report
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="ris.php">Requisition and Issue Slip</a></li>
                <li><a class="dropdown-item" href="ics.php">Inventory Custodian Slip</a></li>
                <li><a class="dropdown-item" href="par.php">Purchase Acceptance Report</a></li>
              </ul>
            </div>

            <div class="card-body ">
              <form method="POST" action="save_building_info.php" class="border border-light p-4 rounded">
                <div class="container mt-4">
                  <h2 class="text-center mb-4 text-uppercase">Inspection and Acceptance Report</h2>

                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label class="form-label">Entity Name</label>
                      <input style="color: #000000" type="text" class="form-control" name="entity_name" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Fund Cluster</label>
                      <input style="color: #000000" type="text" class="form-control" name="fund_cluster" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Supplier</label>
                      <input style="color: #000000" type="text" class="form-control" name="supplier" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label class="form-label">PO No. / Date</label>
                      <input style="color: #000000" type="text" class="form-control" name="po_no_date" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Requisitioning Office/Dept.</label>
                      <input style="color: #000000" type="text" class="form-control" name="req_office" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Responsibility Center</label>
                      <input style="color: #000000" type="text" class="form-control" name="responsibility_center">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label class="form-label">IAR No.</label>
                      <input style="color: #000000" type="text" class="form-control" name="iar_no">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">IAR Date</label>
                      <input style="color: #000000" type="date" class="form-control" name="iar_date">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Invoice No. / Date</label>
                      <input style="color: #000000" type="text" class="form-control" name="invoice_no_date">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-3">
                      <label class="form-label">Stock / Property No.</label>
                      <input style="color: #000000" type="text" class="form-control" name="stock_no">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Remarks</label>
                      <input style="color: #000000" type="text" class="form-control" name="remarks">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Item Description</label>
                      <input style="color: #000000" type="text" class="form-control" name="item_description">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-2">
                      <label class="form-label">Unit</label>
                      <input style="color: #000000" type="text" class="form-control" name="unit">
                    </div>
                    <div class="col-md-2">
                      <label class="form-label">Qty</label>
                      <input style="color: #000000" type="number" class="form-control" name="quantity">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Unit Price</label>
                      <input style="color: #000000" type="text" class="form-control" name="unit_price">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Total Price</label>
                      <input style="color: #000000" type="text" class="form-control" name="total_price">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label class="form-label">Receiver Name</label>
                      <input style="color: #000000" type="text" class="form-control" name="receiver_name">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Teacher's ID</label>
                      <input style="color: #000000" type="text" class="form-control" name="teacher_id">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Position</label>
                      <input style="color: #000000" type="text" class="form-control" name="position">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label class="form-label">Date Inspected</label>
                      <input style="color: #000000" type="date" class="form-control" name="date_inspected">
                    </div>
                    <div class="col-md-5">
                      <label class="form-label">Inspection Team (comma separated)</label>
                      <input style="color: #000000" type="text" class="form-control" name="inspectors"
                        placeholder="e.g., Joan Savage, Nelson British, Bles Sings">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Barangay Councilor</label>
                      <input style="color: #000000" type="text" class="form-control" name="inspectors">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label class="form-label">PTA Observer</label>
                      <input style="color: #000000" type="text" class="form-control" name="pta_observer">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Date Received</label>
                      <input style="color: #000000" type="date" class="form-control" name="date_received">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Property Custodian</label>
                      <input style="color: #000000" type="text" class="form-control" name="property_custodian">
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