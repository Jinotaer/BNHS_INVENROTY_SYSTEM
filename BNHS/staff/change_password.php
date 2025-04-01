<?php
session_start();
include('config/config.php'); // Ensure this file contains a valid $mysqli connection

if (isset($_POST['change_password'])) {
    // Validate input
    if (empty($_POST['admin_id']) || empty($_POST['new_password'])) {
        $err = "All fields are required.";
    } elseif (strlen($_POST['new_password']) < 8) { // Validate password length
        $err = "Password must be at least 8 characters long.";
    } else {
        $admin_id = $_POST['admin_id'];
        $new_password = sha1(md5($_POST['new_password'])); // Hash the new password

        // Update the password in the database
        $updateQuery = "UPDATE bnhs_admin SET admin_password = ? WHERE admin_id = ?";
        $updateStmt = $mysqli->prepare($updateQuery);

        if ($updateStmt) {
            $updateStmt->bind_param('ss', $new_password, $admin_id);

            if ($updateStmt->execute()) {
                $success = "Password updated successfully.";
            } else {
                $err = "Error: " . $updateStmt->error; // Debugging: Show SQL error
            }
        } else {
            $err = "Error: " . $mysqli->error; // Debugging: Show SQL preparation error
        }
    }
}

require_once('partials/_inhead.php');
?>

<body>
  <div class="containers">
    <img src="assets/img/brand/bnhs.png" alt="This is a Logo" style="width: 150px; height: auto; margin-bottom: 40px">
    <form method="POST" rule="form">
      <div>
        <label for="admin_id">Admin ID:</label>
        <input type="text" id="admin_id" name="admin_id" required>
      </div>
      <div class="field create-password">
        <div class="input-field">
          <input class="username" type="password" placeholder="New Password" name="new_password" required />
        </div>
      </div>

      <div class="field create-password">
        <div class="input-field">
          <input class="username" type="password" placeholder="Confirm Password" name="confirm_password" required />
        </div>
      </div>
      
      <div class="input-field buttons">
        <button type="submit" name="change_password" style="background-color: #29126d">CHANGE PASSWORD</button>
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