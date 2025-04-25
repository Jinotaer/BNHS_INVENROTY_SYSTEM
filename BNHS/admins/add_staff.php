<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
//Add staff
if (isset($_POST['addstaff'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["staff_id"]) || empty($_POST["staff_name"]) || empty($_POST['staff_email']) || empty($_POST['staff_password'])) {
    $err = "Blank Values Not Accepted";
  } elseif ($_POST['staff_password'] !== $_POST['staff_pass_confirm']) {
    $err = "Password doesn't match.";
  } else {
    $staff_name = $_POST['staff_name'];
    $staff_email = $_POST['staff_email'];
    $staff_password = sha1(md5($_POST['staff_password'])); //Hash This 
    $staff_id = $_POST['staff_id'];

    $stmt = $pdo->prepare("SELECT * FROM bnhs_staff WHERE staff_email = ?");
    $stmt -> execute([$staff_email]);

    if($stmt -> rowCount() > 0) {
      $err = "Email is already exist";
      header("refresh:1; url=add_staff.php");
  } else {
    //Insert Captured information to a database table
    $postQuery = "INSERT INTO bnhs_staff (staff_id, staff_name, staff_email, staff_password) VALUES(?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ssss', $staff_id, $staff_name, $staff_email, $staff_password);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "staff Added" && header("refresh:1; url=user_management.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
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
    <div style="background-image: url(assets/img/theme/front.png); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
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
              <h3>Please fill all fields</h3>
            </div>
            <div class="card-body">
              <form method="POST">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Staff ID</label>
                    <input type="text" name="staff_id" class="form-control" style="color: black;" value=""> <!-- Added visible input for Staff ID -->
                  </div>
                  <div class="col-md-6">
                    <label>Staff Name</label>
                    <input type="text" name="staff_name" class="form-control" style="color: black;" value=""> <!-- Corrected 'stafS_name' to 'staff_name' -->
                  </div>
                </div>
                <hr>
                <div class="form-row" style="margin-top: 10px;">
                  <div class="col-md-6">
                    <label>Staff Email</label>
                    <input type="email" name="staff_email" class="form-control" style="color: black;" value="">
                  </div>
                  <div class="col-md-6">
                    <label>Staff Password</label>
                    <input type="password" name="staff_password" class="form-control" style="color: black;" value="">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Staff Password</label>
                    <input type="password" name="staff_pass_confirm" class="form-control" style="color: black;" value=""  >
                  </div>
                  <!-- <div class="col-md-6">
                    <label>Staff Phone Number</label>
                    <input type="text" name="staff_phoneno" class="form-control" value="">
                  </div> -->
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="addstaff" value="Add staff" class="btn btn-primary" value="">
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