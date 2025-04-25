<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

function sanitize($data) {
    return htmlspecialchars(trim($data));
}

$tables = [
  'inspection_acceptance_reports',
  'inventory_custodian_slip',
  'requisition_and_issue_slip',
  'property_acknowledgement_receipt'
];

// Get parameters
$source_table = isset($_GET['table']) ? $_GET['table'] : '';
$record_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate
if (!in_array($source_table, $tables) || $record_id <= 0) {
    die("Invalid table or ID.");
}

// Fetch existing record
$query = "SELECT * FROM `$source_table` WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $record_id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    die("Record not found.");
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Gather input based on table type
    $fields = [];
    $values = [];
    $updates = [];

    switch($source_table) {
        case 'inspection_acceptance_reports':
            $fields = [
                'entity_name', 'fund_cluster', 'iar_no', 'quantity', 'unit', 'item_description',
                'property_number', 'date_acquired', 'unit_cost', 'total_cost', 'receiver_name',
                'receiver_position', 'receiver_date', 'property_custodian', 'custodian_position',
                'custodian_date'
            ];
            break;
        case 'inventory_custodian_slip':
            $fields = [
                'entity_name', 'fund_cluster', 'ics_no', 'quantity', 'unit', 'item_description',
                'inventory_item_no', 'date_acquired', 'unit_cost', 'total_cost', 'end_user_name',
                'end_user_position', 'end_user_date', 'custodian_name', 'custodian_position',
                'custodian_date'
            ];
            break;
        case 'requisition_and_issue_slip':
            $fields = [
                'entity_name', 'fund_cluster', 'ris_no', 'quantity', 'unit', 'item_description',
                'stock_no', 'date_acquired', 'unit_cost', 'total_cost', 'requested_by_name',
                'requested_by_position', 'requested_by_date', 'issued_by_name', 'issued_by_position',
                'issued_by_date'
            ];
            break;
        case 'property_acknowledgement_receipt':
            $fields = [
                'entity_name', 'fund_cluster', 'par_no', 'quantity', 'unit', 'item_description',
                'property_number', 'date_acquired', 'unit_cost', 'total_cost', 'received_by_name',
                'received_by_position', 'received_by_date', 'issued_by_name', 'issued_by_position',
                'issued_by_date'
            ];
            break;
    }

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $updates[] = "`$field` = ?";
            $values[] = sanitize($_POST[$field]);
        }
    }

    if (!empty($updates)) {
        $setClause = implode(', ', $updates);
        $sql = "UPDATE `$source_table` SET $setClause WHERE id = ?";
        
        // Debug information
        error_log("SQL Query: " . $sql);
        error_log("Table: " . $source_table);
        error_log("Updates: " . print_r($updates, true));
        error_log("Values: " . print_r($values, true));
        
        $stmt = $mysqli->prepare($sql);
        
        if ($stmt === false) {
            $err = "Error preparing statement: " . $mysqli->error;
            error_log("MySQL Error: " . $mysqli->error);
        } else {
            // Create an array of references for bind_param
            $types = str_repeat('s', count($values)) . 'i';
            $values[] = $record_id;
            
            // Bind parameters directly
            $stmt->bind_param($types, ...$values);

            if ($stmt->execute()) {
                $success = "Record updated successfully.";
                header("Location: track_inventory.php");
                exit();
            } else {
                $err = "Update failed: " . $stmt->error;
                error_log("Execute Error: " . $stmt->error);
            }
            $stmt->close();
        }
    }
}

require_once('partials/_head.php');
?>

<body>
<?php require_once('partials/_sidebar.php'); ?>
<div class="main-content">
<?php require_once('partials/_topnav.php'); ?>

<div style="background-image: url(assets/img/theme/bnhsfront.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
  <span class="mask bg-gradient-dark opacity-8"></span>
</div>

<div class="container-fluid mt--8">
  <div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-body">
          <form method="POST" class="border border-light p-4 rounded">
            <div class="container mt-4">
              <h2 class="text-center mb-4 text-uppercase">Update <?php echo str_replace('_', ' ', ucfirst($source_table)); ?></h2>

              <!-- <?php if (isset($err)): ?>
                <div class="alert alert-danger"><?php echo $err; ?></div>
              <?php endif; ?>
              
              <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
              <?php endif; ?> -->

              <!-- Common Fields -->
              <div class="row mb-3">
                <div class="col-md-4">
                  <label class="form-label">Entity Name</label>
                  <input style="color: #000000;" type="text" name="entity_name" class="form-control" value="<?php echo $item['entity_name'] ?? ''; ?>">
                </div>
                <div class="col-md-4">
                  <label class="form-label">Fund Cluster</label>
                  <input style="color: #000000;" type="text" name="fund_cluster" class="form-control" value="<?php echo $item['fund_cluster'] ?? ''; ?>">
                </div>
                <div class="col-md-4">
                  <label class="form-label"><?php echo strtoupper($source_table === 'inspection_acceptance_reports' ? 'IAR' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'ICS' : 
                                     ($source_table === 'requisition_and_issue_slip' ? 'RIS' : 'PAR'))); ?> No.</label>
                  <input style="color: #000000;" type="text" name="<?php echo $source_table === 'inspection_acceptance_reports' ? 'iar_no' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'ics_no' : 
                                     ($source_table === 'requisition_and_issue_slip' ? 'ris_no' : 'par_no')); ?>" 
                         class="form-control" 
                         value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'iar_no' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'ics_no' : 
                                     ($source_table === 'requisition_and_issue_slip' ? 'ris_no' : 'par_no'))] ?? ''; ?>">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-3">
                  <label class="form-label">Quantity</label>
                  <input style="color: #000000;" type="number" name="quantity" class="form-control" value="<?php echo $item['quantity'] ?? ''; ?>">
                </div>
                <div class="col-md-3">
                  <label class="form-label">Unit</label>
                  <input style="color: #000000;" type="text" name="unit" class="form-control" value="<?php echo $item['unit'] ?? ''; ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Item Description</label>
                  <input style="color: #000000;" type="text" name="item_description" class="form-control" value="<?php echo $item['item_description'] ?? ''; ?>">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-4">
                  <label class="form-label">Property/Stock/Inventory Item No.</label>
                  <input style="color: #000000;" type="text" name="<?php echo $source_table === 'inspection_acceptance_reports' ? 'property_number' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'inventory_item_no' : 
                                     ($source_table === 'requisition_and_issue_slip' ? 'stock_no' : 'property_number')); ?>" 
                         class="form-control" 
                         value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'property_number' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'inventory_item_no' : 
                                     ($source_table === 'requisition_and_issue_slip' ? 'stock_no' : 'property_number'))] ?? ''; ?>">
                </div>
                <div class="col-md-4">
                  <label class="form-label">Date Acquired</label>
                  <input style="color: #000000;" type="date" name="date_acquired" class="form-control" value="<?php echo $item['date_acquired'] ?? ''; ?>">
                </div>
                <div class="col-md-4">
                  <label class="form-label">Unit Cost</label>
                  <input style="color: #000000;" type="number" step="0.01" name="unit_cost" class="form-control" value="<?php echo $item['unit_cost'] ?? ''; ?>">
                </div>
              </div>

              <!-- Receiver/End User/Requested By Fields -->
              <div class="row mb-3">
                <div class="col-md-4">
                  <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Receiver Name' : 
                             ($source_table === 'inventory_custodian_slip' ? 'End User Name' : 
                             ($source_table === 'requisition_and_issue_slip' ? 'Requested By Name' : 'Received By Name')); ?></label>
                  <input style="color: #000000;" type="text" name="<?php echo $source_table === 'inspection_acceptance_reports' ? 'receiver_name' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'end_user_name' : 
                                     ($source_table === 'requisition_and_issue_slip' ? 'requested_by_name' : 'received_by_name')); ?>" 
                         class="form-control" 
                         value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'receiver_name' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'end_user_name' : 
                                     ($source_table === 'requisition_and_issue_slip' ? 'requested_by_name' : 'received_by_name'))] ?? ''; ?>">
                </div>
                <div class="col-md-4">
                  <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Receiver Position' : 
                             ($source_table === 'inventory_custodian_slip' ? 'End User Position' : 
                             ($source_table === 'requisition_and_issue_slip' ? 'Requested By Position' : 'Received By Position')); ?></label>
                  <input style="color: #000000;" type="text" name="<?php echo $source_table === 'inspection_acceptance_reports' ? 'receiver_position' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'end_user_position' : 
                                     ($source_table === 'requisition_and_issue_slip' ? 'requested_by_position' : 'received_by_position')); ?>" 
                         class="form-control" 
                         value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'receiver_position' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'end_user_position' : 
                                     ($source_table === 'requisition_and_issue_slip' ? 'requested_by_position' : 'received_by_position'))] ?? ''; ?>">
                </div>
                <div class="col-md-4">
                  <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Receiver Date' : 
                             ($source_table === 'inventory_custodian_slip' ? 'End User Date' : 
                             ($source_table === 'requisition_and_issue_slip' ? 'Requested By Date' : 'Received By Date')); ?></label>
                  <input style="color: #000000;" type="date" name="<?php echo $source_table === 'inspection_acceptance_reports' ? 'receiver_date' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'end_user_date' : 
                                     ($source_table === 'requisition_and_issue_slip' ? 'requested_by_date' : 'received_by_date')); ?>" 
                         class="form-control" 
                         value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'receiver_date' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'end_user_date' : 
                                     ($source_table === 'requisition_and_issue_slip' ? 'requested_by_date' : 'received_by_date'))] ?? ''; ?>">
                </div>
              </div>

              <!-- Custodian/Issued By Fields -->
              <div class="row mb-3">
                <div class="col-md-4">
                  <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Property Custodian' : 
                             ($source_table === 'inventory_custodian_slip' ? 'Custodian Name' : 'Issued By Name'); ?></label>
                  <input style="color: #000000;" type="text" name="<?php echo $source_table === 'inspection_acceptance_reports' ? 'property_custodian' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'custodian_name' : 'issued_by_name'); ?>" 
                         class="form-control" 
                         value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'property_custodian' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'custodian_name' : 'issued_by_name')] ?? ''; ?>">
                </div>
                <div class="col-md-4">
                  <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Custodian Position' : 
                             ($source_table === 'inventory_custodian_slip' ? 'Custodian Position' : 'Issued By Position'); ?></label>
                  <input style="color: #000000;" type="text" name="<?php echo $source_table === 'inspection_acceptance_reports' ? 'custodian_position' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'custodian_position' : 'issued_by_position'); ?>" 
                         class="form-control" 
                         value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'custodian_position' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'custodian_position' : 'issued_by_position')] ?? ''; ?>">
                </div>
                <div class="col-md-4">
                  <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Custodian Date' : 
                             ($source_table === 'inventory_custodian_slip' ? 'Custodian Date' : 'Issued By Date'); ?></label>
                  <input style="color: #000000;" type="date" name="<?php echo $source_table === 'inspection_acceptance_reports' ? 'custodian_date' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'custodian_date' : 'issued_by_date'); ?>" 
                         class="form-control" 
                         value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'custodian_date' : 
                                     ($source_table === 'inventory_custodian_slip' ? 'custodian_date' : 'issued_by_date')] ?? ''; ?>">
                </div>
              </div>

              <div class="text-end mt-3">
                <a href="track_inventory.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Record</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php require_once('partials/_mainfooter.php'); ?>
</div>
<?php require_once('partials/_scripts.php'); ?>
</body>
</html>
