<?php
session_start();
include('config/config.php'); // Ensure this file contains a valid $mysqli connection

if (isset($_POST['submit'])) {
  $code = $_POST['codes'];

  // Check if the code exists in the database
  $checkQuery = "SELECT COUNT(*) FROM verification_codes WHERE code = ?";
  $checkStmt = $mysqli->prepare($checkQuery);
  if ($checkStmt) {
    $checkStmt->bind_param('i', $code);
    $checkStmt->execute();
    $checkStmt->bind_result($codeCount);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($codeCount > 0) {
      // Code found, redirect to change_password.php
      header("Location: change_password.php");
      exit();
    } else {
      $err = "Invalid code";
    }
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