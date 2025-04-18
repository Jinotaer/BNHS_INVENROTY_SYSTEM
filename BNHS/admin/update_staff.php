<?php
session_start();
include('config/config.php');
// include('config/checklogin.php');
include('config/code-generator.php');

// check_login();
//Add Customer
if (isset($_POST['updatestaff'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["staff_phoneno"]) || empty($_POST["staff_id"]) || empty($_POST["staff_name"]) || empty($_POST['staff_email']) || empty($_POST['staff_password'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $staff_name = $_POST['staff_name'];
    $staff_phoneno = $_POST['staff_phoneno'];
    $staff_email = $_POST['staff_email'];
    $staff_password = sha1(md5($_POST['staff_password'])); //Hash This 
    $update = $_GET['update'];

    //Insert Captured information to a database table
    $postQuery = "UPDATE bnhs_staff SET staff_name =?, staff_phoneno =?, staff_email =?, staff_password =? WHERE  staff_id =?";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('sssss', $staff_name, $staff_phoneno, $staff_email, $staff_password, $update);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "staff Added" && header("refresh:1; url=user_management.php");
    } else {
      $err = "Please Try Again Or Try Later";
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
    $update = $_GET['update'];
    $ret = "SELECT * FROM  bnhs_staff WHERE staff_id = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($cust = $res->fetch_object()) {
    ?>
      <!-- Header -->
      <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
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
                <h3>Please Fill All Fields</h3>
              </div>
              <div class="card-body">
                <form method="POST">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Staff ID</label>
                      <input type="text" name="staff_id" value="<?php echo $cust->staff_id; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Staff Name</label>
                      <input type="text" name="staff_name" value="<?php echo $cust->staff_name; ?>" class="form-control">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Staff Phone Number</label>
                      <input type="text" name="staff_phoneno" value="<?php echo $cust->staff_phoneno; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Staff Email</label>
                      <input type="email" name="staff_email" value="<?php echo $cust->staff_email; ?>" class="form-control">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Staff Password</label>
                      <input type="password" name="staff_password" class="form-control" value="">
                    </div>
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="updatestaff" value="Update staff" class="btn btn-success" value="">
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
    }
      ?>
      </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>