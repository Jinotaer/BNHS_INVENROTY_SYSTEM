<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

function sanitize($data)
{
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
                            <form class="border border-light p-4 rounded">
                                <div class="container mt-4">
                                    <h2 class="text-center mb-4 text-uppercase">View <?php echo str_replace('_', ' ', ucfirst($source_table)); ?></h2>

                                    <!-- Common Fields -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Entity Name</label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" value="<?php echo $item['entity_name'] ?? 'N/A'; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Fund Cluster</label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" value="<?php echo $item['fund_cluster'] ?? 'N/A'; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label"><?php echo strtoupper($source_table === 'inspection_acceptance_reports' ? 'IAR' : 
                                                                     ($source_table === 'inventory_custodian_slip' ? 'ICS' : 
                                                                     ($source_table === 'requisition_and_issue_slip' ? 'RIS' : 'PAR'))); ?> No.</label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" 
                                                                   value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'iar_no' : 
                                                                             ($source_table === 'inventory_custodian_slip' ? 'ics_no' : 
                                                                             ($source_table === 'requisition_and_issue_slip' ? 'ris_no' : 'par_no'))] ?? 'N/A'; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Quantity</label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" value="<?php echo $item['quantity'] ?? '0'; ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Unit</label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" value="<?php echo $item['unit'] ?? 'N/A'; ?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Item Description</label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" value="<?php echo $item['item_description'] ?? 'N/A'; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Property/Stock/Inventory Item No.</label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" 
                                                                   value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'property_number' : 
                                                                             ($source_table === 'inventory_custodian_slip' ? 'inventory_item_no' : 
                                                                             ($source_table === 'requisition_and_issue_slip' ? 'stock_no' : 'property_number'))] ?? 'N/A'; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Date Acquired</label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" value="<?php echo $item['date_acquired'] ?? 'N/A'; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Unit Cost</label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" value="<?php echo number_format($item['unit_cost'] ?? 0, 2); ?>" readonly>
                                        </div>
                                    </div>

                                    <!-- Receiver/End User/Requested By Fields -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Receiver Name' : 
                                                                         ($source_table === 'inventory_custodian_slip' ? 'End User Name' : 
                                                                         ($source_table === 'requisition_and_issue_slip' ? 'Requested By Name' : 'Received By Name')); ?></label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" 
                                                                   value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'receiver_name' : 
                                                                             ($source_table === 'inventory_custodian_slip' ? 'end_user_name' : 
                                                                             ($source_table === 'requisition_and_issue_slip' ? 'requested_by_name' : 'received_by_name'))] ?? 'N/A'; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Receiver Position' : 
                                                                         ($source_table === 'inventory_custodian_slip' ? 'End User Position' : 
                                                                         ($source_table === 'requisition_and_issue_slip' ? 'Requested By Position' : 'Received By Position')); ?></label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" 
                                                                   value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'receiver_position' : 
                                                                             ($source_table === 'inventory_custodian_slip' ? 'end_user_position' : 
                                                                             ($source_table === 'requisition_and_issue_slip' ? 'requested_by_position' : 'received_by_position'))] ?? 'N/A'; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Receiver Date' : 
                                                                         ($source_table === 'inventory_custodian_slip' ? 'End User Date' : 
                                                                         ($source_table === 'requisition_and_issue_slip' ? 'Requested By Date' : 'Received By Date')); ?></label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" 
                                                                   value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'receiver_date' : 
                                                                             ($source_table === 'inventory_custodian_slip' ? 'end_user_date' : 
                                                                             ($source_table === 'requisition_and_issue_slip' ? 'requested_by_date' : 'received_by_date'))] ?? 'N/A'; ?>" readonly>
                                        </div>
                                    </div>

                                    <!-- Custodian/Issued By Fields -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Property Custodian' : 
                                                                         ($source_table === 'inventory_custodian_slip' ? 'Custodian Name' : 'Issued By Name'); ?></label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" 
                                                                   value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'property_custodian' : 
                                                                             ($source_table === 'inventory_custodian_slip' ? 'custodian_name' : 'issued_by_name')] ?? 'N/A'; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Custodian Position' : 
                                                                         ($source_table === 'inventory_custodian_slip' ? 'Custodian Position' : 'Issued By Position'); ?></label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" 
                                                                   value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'custodian_position' : 
                                                                             ($source_table === 'inventory_custodian_slip' ? 'custodian_position' : 'issued_by_position')] ?? 'N/A'; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label"><?php echo $source_table === 'inspection_acceptance_reports' ? 'Custodian Date' : 
                                                                         ($source_table === 'inventory_custodian_slip' ? 'Custodian Date' : 'Issued By Date'); ?></label>
                                            <input style="color: #000000; background-color: #f8f9fa;" type="text" class="form-control" 
                                                                   value="<?php echo $item[$source_table === 'inspection_acceptance_reports' ? 'custodian_date' : 
                                                                             ($source_table === 'inventory_custodian_slip' ? 'custodian_date' : 'issued_by_date')] ?? 'N/A'; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="text-end mt-3">
                                        <a href="track_inventory.php" class="btn btn-primary">Back to List</a>
                                        <!-- <a href="track_inventory_update.php?id=<?php echo $record_id; ?>&table=<?php echo $source_table; ?>" class="btn btn-primary">Edit Record</a> -->
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
    </div>
</body>

</html>