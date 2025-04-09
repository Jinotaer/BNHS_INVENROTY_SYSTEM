<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bukidnon National High School Inventory System</title>
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/brand/bnhs.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/img/brand/bnhs.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/brand/bnhs.png">
  <meta name="theme-color" content="#ffffff">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap 5 JavaScript Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery (still used for your print function) -->
  <script src="assets/js/jquery.js"></script>

  <style>
    body {
      margin-top: 20px;
    }

    @media print {
      #printBtn {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="container mt-5" id="printableArea">
    <div id="list" class="mx-auto col-10 col-md-10">
      <div class="text-center mb-4">
        <h5 class="fw-bold">REPORT ON THE PHYSICAL COUNT OF PROPERTY, PLANT AND EQUIPMENT</h5>
        <h6 class="text-muted">IT EQUIPMENT</h6>
        <p>As of <strong><?php echo strtoupper(date('F Y')); ?></strong></p>
      </div>

      <p><strong>Fund Cluster:</strong> __________________________</p>
      <p>
        <strong>For which:</strong> CodeAstro Lounge &nbsp;&nbsp;
        <strong>Administrative Officer:</strong> John Doe &nbsp;&nbsp;
        <strong>As of:</strong> <?php echo date('F d, Y'); ?>
      </p>

      <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
          <thead class="table-light">
            <tr>
              <th>ARTICLE</th>
              <th>DESCRIPTION</th>
              <th>PROPERTY NO.</th>
              <th>UNIT OF MEASURE</th>
              <th>UNIT VALUE</th>
              <th>QTY PER CARD</th>
              <th>QTY PER COUNT</th>
              <th>SHORTAGE/ OVERAGE</th>
              <th>REMARKS</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $ret = "SELECT * FROM bnhs_staff";
            $stmt = $mysqli->prepare($ret);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($staff = $res->fetch_object()) {
            ?>
              <tr>
                <td>IT EQUIPMENT</td>
                <td><?php echo htmlspecialchars($staff->description ?? ''); ?></td>
                <td><?php echo htmlspecialchars($staff->property_no ?? ''); ?></td>
                <td>pcs</td>
                <td><?php echo htmlspecialchars($staff->unit_value ?? ''); ?></td>
                <td><?php echo htmlspecialchars($staff->qty_per_card ?? ''); ?></td>
                <td><?php echo htmlspecialchars($staff->qty_per_count ?? ''); ?></td>
                <td>0</td>
                <td>Good Condition</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <div class="row text-center mt-5">
        <div class="col-md-4 mb-4">
          <p>Certified Correct:</p><br><br>
          <strong>__________________________</strong><br>
          <em>Inventory Committee Chair</em>
        </div>
        <div class="col-md-4 mb-4">
          <p>Approved by:</p><br><br>
          <strong>__________________________</strong><br>
          <em>School Head / Admin Officer</em>
        </div>
        <div class="col-md-4 mb-4">
          <p>Verified by:</p><br><br>
          <strong>__________________________</strong><br>
          <em>COA Representative</em>
        </div>
      </div>
    </div>
  </div>

  <!-- Print Button -->
  <div id="printBtn" class="text-center my-4">
    <button onclick="printContent('list');" class="btn btn-primary btn-lg">
      <i class="bi bi-printer"></i> Print
    </button>
  </div>

  <script>
    function printContent(el) {
      var restorepage = $('body').html();
      var printcontent = $('#' + el).clone();
      $('body').empty().html(printcontent);
      window.print();
      $('body').html(restorepage);
    }
  </script>
</body>

</html>
