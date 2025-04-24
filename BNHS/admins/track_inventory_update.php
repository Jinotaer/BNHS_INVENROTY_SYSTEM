<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

// Get the table name and ID from URL
$table = isset($_GET['table']) ? $_GET['table'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate table name to prevent SQL injection
$valid_tables = [
    'inspection_acceptance_reports',
    'inventory_custodian_slip',
    'requisition_and_issue_slip',
    'property_acknowledgement_receipt'
];

if (!in_array($table, $valid_tables) || $id <= 0) {
    $_SESSION['error'] = "Invalid request";
    header("Location: track_inventory.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $updates = [];
    $params = [];
    $types = '';

    // Common fields across all tables
    $common_fields = [
        'entity_name' => 's',
        'fund_cluster' => 's',
        'item_description' => 's',
        'quantity' => 'i',
        'unit' => 's',
        'unit_cost' => 'd',
        'total_cost' => 'd',
        'remarks' => 's'
    ];

    // Add table-specific fields
    switch ($table) {
        case 'inspection_acceptance_reports':
            $additional_fields = [
                'iar_no' => 's',
                'iar_date' => 's',
                'supplier' => 's',
                'po_no_date' => 's',
                'req_office' => 's',
                'responsibility_center' => 's'
            ];
            break;
        case 'inventory_custodian_slip':
            $additional_fields = [
                'ics_no' => 's',
                'inventory_item_no' => 's',
                'estimated_useful_life' => 's',
                'end_user_name' => 's',
                'end_user_position' => 's',
                'date_received_user' => 's',
                'custodian_name' => 's',
                'custodian_position' => 's',
                'date_received_custodian' => 's'
            ];
            break;
        // Add cases for other tables as needed
    }

    $fields = array_merge($common_fields, $additional_fields ?? []);

    // Build update query
    foreach ($fields as $field => $type) {
        if (isset($_POST[$field]) && $_POST[$field] !== '') {
            $updates[] = "`$field` = ?";
            $params[] = $_POST[$field];
            $types .= $type;
        }
    }

    if (!empty($updates)) {
        $sql = "UPDATE `$table` SET " . implode(', ', $updates) . " WHERE id = ?";
        $params[] = $id;
        $types .= 'i';

        $stmt = $mysqli->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$params);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Record updated successfully";
                header("Location: track_inventory.php");
                exit;
            } else {
                $_SESSION['error'] = "Error updating record: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Error preparing statement: " . $mysqli->error;
        }
    }
}

// Fetch current record
$sql = "SELECT * FROM `$table` WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    $_SESSION['error'] = "Record not found";
    header("Location: track_inventory.php");
    exit;
}

require_once('partials/_head.php');
?>

<body>
    <!-- Sidenav -->
    <?php require_once('partials/_sidebar.php'); ?>
    
    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <?php require_once('partials/_topnav.php'); ?>
        <!-- Header -->
        <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
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
                            <h3 class="mb-0">Update Inventory Item</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <!-- Common Fields -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Entity Name</label>
                                            <input type="text" name="entity_name" class="form-control" value="<?php echo htmlspecialchars($item['entity_name'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fund Cluster</label>
                                            <input type="text" name="fund_cluster" class="form-control" value="<?php echo htmlspecialchars($item['fund_cluster'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Item Description</label>
                                            <textarea name="item_description" class="form-control"><?php echo htmlspecialchars($item['item_description'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="number" name="quantity" class="form-control" value="<?php echo htmlspecialchars($item['quantity'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Unit</label>
                                            <input type="text" name="unit" class="form-control" value="<?php echo htmlspecialchars($item['unit'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Unit Cost</label>
                                            <input type="number" step="0.01" name="unit_cost" class="form-control" value="<?php echo htmlspecialchars($item['unit_cost'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Total Cost</label>
                                            <input type="number" step="0.01" name="total_cost" class="form-control" value="<?php echo htmlspecialchars($item['total_cost'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php if ($table === 'inventory_custodian_slip'): ?>
                                <!-- ICS Specific Fields -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ICS Number</label>
                                            <input type="text" name="ics_no" class="form-control" value="<?php echo htmlspecialchars($item['ics_no'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Inventory Item Number</label>
                                            <input type="text" name="inventory_item_no" class="form-control" value="<?php echo htmlspecialchars($item['inventory_item_no'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>End User Name</label>
                                            <input type="text" name="end_user_name" class="form-control" value="<?php echo htmlspecialchars($item['end_user_name'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>End User Position</label>
                                            <input type="text" name="end_user_position" class="form-control" value="<?php echo htmlspecialchars($item['end_user_position'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date Received (End User)</label>
                                            <input type="date" name="date_received_user" class="form-control" value="<?php echo htmlspecialchars($item['date_received_user'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Property Custodian Name</label>
                                            <input type="text" name="custodian_name" class="form-control" value="<?php echo htmlspecialchars($item['custodian_name'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Property Custodian Position</label>
                                            <input type="text" name="custodian_position" class="form-control" value="<?php echo htmlspecialchars($item['custodian_position'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date Received (Custodian)</label>
                                            <input type="date" name="date_received_custodian" class="form-control" value="<?php echo htmlspecialchars($item['date_received_custodian'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea name="remarks" class="form-control"><?php echo htmlspecialchars($item['remarks'] ?? ''); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" name="update" class="btn btn-success">Update Record</button>
                                    <a href="track_inventory.php" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 