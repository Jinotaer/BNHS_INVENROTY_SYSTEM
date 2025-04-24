<?php
session_start();
include('config/config.php'); // Ensure this file contains a valid $mysqli connection

if (isset($_POST['submit'])) {
  $code = $_POST['codes'];

  // Check if the code exists in the database with timestamp validation
  $checkQuery = "SELECT code, created_at FROM verification_codes WHERE code = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 10 MINUTE)";
  $checkStmt = $mysqli->prepare($checkQuery);
  if ($checkStmt) {
    $checkStmt->bind_param('i', $code);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
      // Code is valid and not expired
      header("Location: change_password.php");
      exit();
    } else {
      // Check if code exists but expired
      $expiredCheck = "SELECT code FROM verification_codes WHERE code = ?";
      $expiredStmt = $mysqli->prepare($expiredCheck);
      $expiredStmt->bind_param('i', $code);
      $expiredStmt->execute();
      $expiredStmt->store_result();
      
      if ($expiredStmt->num_rows > 0) {
        $err = "Verification code has expired. Please request a new one.";
      } else {
        $err = "Invalid code";
      }
      $expiredStmt->close();
    }
    $checkStmt->close();
  }
}
require_once('partials/_inhead.php');
?>

<body>
  <div class="containers">
    <img src="assets/img/brand/bnhs.png" alt="This is a Logo" style="width: 150px; height: auto; margin-bottom: 40px">
    <form method="POST" rule="form">

      <div class="field">
        <div class="input-fields">
          <input type="number" placeholder="Enter Code" name="codes" required>
        </div>
      </div>

      <div class="input-field buttons">
        <button type="submit" name="submit" style="background-color: #29126d">SUBMIT</button>
      </div>
      <div class="links">
        <p>Didn't receive a code? <a href="send_code.php">Resend Code</a></p>
      </div>
    </form>
  </div>
</body>
<footer class="text-muted fixed-bottom mb-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 text-left text-md-start">
        &copy; 2020 - <?php echo date('Y'); ?> - Developed By SOVATECH Company
      </div>
      <div class="col-md-6 text-right text-md-end">
        <a href="#" class="nav-link" target="_blank">BNHS INVENTORY SYSTEM</a>
      </div>
    </div>
  </div>
</footer>