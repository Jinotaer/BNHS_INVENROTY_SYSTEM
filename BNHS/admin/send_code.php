<?php
session_start();
include('config/config.php'); // Ensure this file contains a valid $mysqli connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets\vendor\autoload.php'; // Adjusted path to vendor/autoload.php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['add'])) {
  if (empty($_POST['admin_email'])) {
    $err = "Email is required";
  } else {
    $admin_email = $_POST['admin_email'];

    // Check if the email exists in the database
    $checkQuery = "SELECT COUNT(*) FROM bnhs_admin WHERE admin_email = ?";
    $checkStmt = $mysqli->prepare($checkQuery);
    if ($checkStmt) {
      $checkStmt->bind_param('s', $admin_email);
      $checkStmt->execute();
      $checkStmt->bind_result($emailCount);
      $checkStmt->fetch();
      $checkStmt->close();

      if ($emailCount == 0) {
        $err = "Email does not exist in the database.";
      } else {
        // Generate a random verification code
        $verification_code = rand(100000, 999999);

        // Store the code in the database (optional, if needed for verification later)
        $codeQuery = "INSERT INTO verification_codes (email, code) VALUES (?, ?)";
        $codeStmt = $mysqli->prepare($codeQuery);
        if ($codeStmt) {
          $codeStmt->bind_param('ss', $admin_email, $verification_code);
          $codeStmt->execute();
        } else {
          $err = "Error: " . $mysqli->error;
        }

        // Send the code via email using PHPMailer
        $mail = new PHPMailer(true);
        try {
          // Server settings
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
          $mail->SMTPAuth = true;
          $mail->Username = 'jjane0248@gmail.com'; // Replace with your SMTP username
          $mail->Password = 'cwbf hstm kdfr hxrd'; // Replace with your SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port = 587;

          // Recipients
          $mail->setFrom('no-reply@bnhs.com', 'BNHS Inventory System');
          $mail->addAddress($admin_email);

          // Content
          $mail->isHTML(true);
          $mail->Subject = 'Your Verification Code';
          $mail->Body = "Your verification code is: <b>$verification_code</b>";

          
          $mail->send();
          $success = "Verification code sent successfully to $admin_email";
          
          header("Location: verify_code.php");
          exit;
          // If successful, store email in session and redirect
          // $_SESSION['verify_email'] = $admin_email;
          // if (isset($_SESSION['verify_email'])) {
          //   header("Location: verify_code.php");
          //   exit;
          // }
        
        } catch (Exception $e) {
          $err = "Failed to send the verification code. Mailer Error: {$mail->ErrorInfo}";
        }
      }
    } else {
      $err = "Error: " . $mysqli->error;
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
          <input type="email" placeholder="Email" name="admin_email" required>
        </div>
      </div>

      <div class="input-field buttons">
        <button type="submit" name="add" style="background-color: #29126d">SEND CODE</button>
      </div>

    </form>
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