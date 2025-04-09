<?php
session_start();
include('config/config.php');
// include('config/checklogin.php');
// check_login();
//Delete Staff
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $adn = "DELETE FROM  bnhs_staff  WHERE  staff_id = ?";
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
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/bnhsfront.jpg); background-size: cover;"
      class="header  pb-8 pt-5 pt-md-8">
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
            <div class="card-header border-0">
              <div class="col">
                <h2 class="text-center mb-3 pt-3 text-uppercase">Inventory Custodian Slip</h2>
              </div>
              <div class="col text-right">
                <i></i>
                <a href="orders_reports.php" class="btn btn-sm btn-primary">
                  <i class="material-icons-sharp text-primary"></i>
                  Print files</a>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Entity Name</th>
                    <th scope="col">Fund Cluster</th>
                    <th scope="col">ICS No.</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Unit Cost</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Item Description</th>
                    <th scope="col">Inventory Item No.</th>
                    <th scope="col">Estimated Useful Life</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Position/Office</th>
                    <th scope="col">Date Received(by User)</th>
                    <th scope="col">Property Custodian</th>
                    <th scope="col">Position/Office</th>
                    <th scope="col">Date Received(by Custodian)</th>
                    <th scope="col">Receiver Name</th>
                    <th scope="col">Teacher's ID</th>
                    <th scope="col">Position</th>
                    <th scope="col">Date Inspected</th>
                    <th scope="col">Inspection Team</th>
                    <th scope="col">PTA Observer</th>
                    <th scope="col">Date Received</th>
                    <th scope="col">Property Custodian</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM  bnhs_staff  ORDER BY `bnhs_staff`.`created_at` DESC ";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($cust = $res->fetch_object()) {
                    ?>
                    <tr>
                      <td><?php echo $cust->staff_id; ?></td>
                      <td><?php echo $cust->staff_name; ?></td>
                      <td><?php echo $cust->staff_phoneno; ?></td>
                      <td><?php echo $cust->staff_email; ?></td>
                      <td><?php echo $cust->staff_id; ?></td>
                      <td><?php echo $cust->staff_name; ?></td>
                      <td><?php echo $cust->staff_phoneno; ?></td>
                      <td><?php echo $cust->staff_email; ?></td><td><?php echo $cust->staff_id; ?></td>
                      <td><?php echo $cust->staff_name; ?></td>
                      <td><?php echo $cust->staff_phoneno; ?></td>
                      <td><?php echo $cust->staff_email; ?></td><td><?php echo $cust->staff_id; ?></td>
                      <td><?php echo $cust->staff_name; ?></td>
                      <td><?php echo $cust->staff_phoneno; ?></td>
                      <td><?php echo $cust->staff_email; ?></td><td><?php echo $cust->staff_id; ?></td>
                      <td><?php echo $cust->staff_name; ?></td>
                      <td><?php echo $cust->staff_phoneno; ?></td>
                      <td><?php echo $cust->staff_email; ?></td><td><?php echo $cust->staff_id; ?></td>
                      <td><?php echo $cust->staff_name; ?></td>
                      <td><?php echo $cust->staff_phoneno; ?></td>
                      <td><?php echo $cust->staff_email; ?></td>
                      <td>
                        <a href="user_management.php?delete=<?php echo $cust->staff_id; ?>">
                          <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                          </button>
                        </a>

                        <a href="update_staff.php?update=<?php echo $cust->staff_id; ?>">
                          <button class="btn btn-sm btn-primary">
                            <i class="fas fa-user-edit"></i>
                            Update
                          </button>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
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