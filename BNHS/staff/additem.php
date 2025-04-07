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
            <!-- Tabs -->
            <ul class="nav nav-tabs custom-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active custom-tab-link" id="teachers-tab" data-toggle="tab" href="#teachers"
                  role="tab" aria-controls="teachers" aria-selected="true">Teachers</a>
              </li>
              <li class="nav-item">
                <a class="nav-link custom-tab-link" id="staff-tab" data-toggle="tab" href="#staff" role="tab"
                  aria-controls="staff" aria-selected="false">Staff</a>
              </li>
              <li class="nav-item">
                <a class="nav-link custom-tab-link" id="admins-tab" data-toggle="tab" href="#admins" role="tab"
                  aria-controls="admins" aria-selected="false">Admins</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <!-- Teachers Tab -->
              <div class="tab-pane fade show active" id="teachers" role="tabpanel" aria-labelledby="teachers-tab">
                <div class="card-header border-0">
                  <div class="row align-items-center">
                    <a href="add_teacher.php" class="btn btn-outline-success mx-3">
                      <i class="fas fa-user-plus"></i>
                      Add New Teacher
                    </a>
                    <div class="col text-right">
                      <a href="orders_reports.php" class="btn btn-sm btn-primary">See all</a>
                    </div>
                  </div>

                </div>

                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ret = "SELECT * FROM bnhs_staff ORDER BY created_at DESC";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($teacher = $res->fetch_object()) {
                        ?>
                        <tr>
                          <td><?php echo $teacher->teacher_id; ?></td>
                          <td><?php echo $teacher->teacher_name; ?></td>
                          <td><?php echo $teacher->teacher_subject; ?></td>
                          <td><?php echo $teacher->teacher_email; ?></td>
                          <td>
                            <a href="update_teacher.php?update=<?php echo $teacher->teacher_id; ?>">
                              <button class="btn btn-sm btn-primary">
                                <i class="fas fa-user-edit"></i> Update
                              </button>
                            </a>
                            <a href="delete_teacher.php?delete=<?php echo $teacher->teacher_id; ?>">
                              <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
                              </button>
                            </a>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- Staff Tab -->
              <div class="tab-pane fade" id="staff" role="tabpanel" aria-labelledby="staff-tab">
              <div class="card-header border-0">
                  <div class="row align-items-center">
                    <a href="add_teacher.php" class="btn btn-outline-success mx-3">
                      <i class="fas fa-user-plus"></i>
                      Add New Staff
                    </a>
                    <div class="col text-right">
                      <a href="orders_reports.php" class="btn btn-sm btn-primary">See all</a>
                    </div>
                  </div>

                </div>

                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ret = "SELECT * FROM bnhs_staff ORDER BY created_at DESC";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($staff = $res->fetch_object()) {
                        ?>
                        <tr>
                          <td><?php echo $staff->staff_id; ?></td>
                          <td><?php echo $staff->staff_name; ?></td>
                          <td><?php echo $staff->staff_phoneno; ?></td>
                          <td><?php echo $staff->staff_email; ?></td>
                          <td>
                            <a href="update_staff.php?update=<?php echo $staff->staff_id; ?>">
                              <button class="btn btn-sm btn-primary">
                                <i class="fas fa-user-edit"></i> Update
                              </button>
                            </a>
                            <a href="delete_staff.php?delete=<?php echo $staff->staff_id; ?>">
                              <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
                              </button>
                            </a>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- Admins Tab -->
              <div class="tab-pane fade" id="admins" role="tabpanel" aria-labelledby="admins-tab">
              <div class="card-header border-0">
                  <div class="row align-items-center">
                    <a href="add_teacher.php" class="btn btn-outline-success mx-3">
                      <i class="fas fa-user-plus"></i>
                      Add New Admin
                    </a>
                    <div class="col text-right">
                      <a href="orders_reports.php" class="btn btn-sm btn-primary">See all</a>
                    </div>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Role</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ret = "SELECT * FROM bnhs_admins ORDER BY created_at DESC";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($admin = $res->fetch_object()) {
                        ?>
                        <tr>
                          <td><?php echo $admin->admin_id; ?></td>
                          <td><?php echo $admin->admin_name; ?></td>
                          <td><?php echo $admin->admin_role; ?></td>
                          <td><?php echo $admin->admin_email; ?></td>
                          <td>
                            <a href="update_admin.php?update=<?php echo $admin->admin_id; ?>">
                              <button class="btn btn-sm btn-primary">
                                <i class="fas fa-user-edit"></i> Update
                              </button>
                            </a>
                            <a href="delete_admin.php?delete=<?php echo $admin->admin_id; ?>">
                              <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
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