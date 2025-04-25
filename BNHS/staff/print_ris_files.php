<?php
session_start();
include('config/config.php');
require_once __DIR__ . '/assets/vendor/autoload.php'; // Ensure this path is correct

$mpdf = new \Mpdf\Mpdf();
ob_start(); // Start output buffering
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

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        strong {
            font-weight: bold;
            font-size: 12px;
        }

        h5,
        h6 {
            text-align: center;
            margin: 0;
            padding: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }


        th,
        .tds {
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .mt-5 {
            margin-top: 30px;
        }

        .mb-4 {
            margin-bottom: 20px;
        }

        img {
            width: auto;
            height: 120px;
            display: block;
            margin: auto;
        }

        tbody .tdnormal {
            font-weight: normal;
            font-size: 10px;
        }

        tbody .tds {
            font-weight: normal;
            font-size: 10px;
        }

        .table-light {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container mt-5" id="printableArea">
        <div class="text-center mb-4">
            <img src="assets/img/brand/bnhs.png" alt="BNHS Logo" class="img-fluid">
        </div>

        <div id="list" class="mx-auto col-10 col-md-10">
            <div class="text-center mb-4">
                <h4 class="fw-bold">REQUISITION AND ISSUE SLIP</h4>
            </div>

            <?php
            $ret = "SELECT * FROM requisition_and_issue_slip ORDER BY `created_at` DESC";
            $stmt = $mysqli->prepare($ret);
            $stmt->execute();
            $res = $stmt->get_result();
            $ics = $res->fetch_object();

            if ($ics) {
            ?>

                <table>
                    <tr>
                        <td class="half">
                            <p><strong>Entity Name : </strong><?php echo htmlspecialchars($ics->entity_name ?? ''); ?></p>
                        </td>
                        <td class="half">
                            <p><strong>Fund Cluster : </strong><?php echo htmlspecialchars($ics->fund_cluster ?? ''); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="half" style="border: 1px solid black; padding: 5px;">
                            <p><strong>Division :</strong> <?php echo htmlspecialchars($ics->division ?? ''); ?></p> <br>
                            <p><strong>Office :</strong> <?php echo htmlspecialchars($ics->office ?? ''); ?></p> <br>
                        </td>
                        <td class="half" style="border: 1px solid black; padding: 5px;">
                            <p><strong> Responsibility Center Code : </strong><?php echo htmlspecialchars($ics->responsibility_code ?? ''); ?></p> <br>
                            <p> <strong>RIS No. :</strong> <?php echo htmlspecialchars($ics->ris_no ?? ''); ?></p> <br>
                        </td>
                    </tr>
                </table>

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="tds" colspan="4" scope="col">Requisition</th>
                                <th class="tds" colspan="2" scope="col">Stock Available?</th>
                                <th class="tds" colspan="3" scope="col">Issue</th>
                            </tr>

                            <tr>
                                <th class="tds">Stock No.</th>
                                <th class="tds">Unit</th>
                                <th class="tds">Description</th>
                                <th class="tds">Quantity</th>
                                <th class="tds" scope="col">Yes</th>
                                <th class="tds">No</th>
                                <th class="tds">Quantity</th>
                                <th class="tds">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Reset the result pointer
                            $res->data_seek(0);
                            while ($row = $res->fetch_object()) {
                            ?>
                                <tr>
                                    <td class="tds"><?php echo htmlspecialchars($row->stock_no ?? ''); ?></td>
                                    <td class="tds"><?php echo htmlspecialchars($row->unit ?? ''); ?></td>
                                    <td class="tds"><?php echo htmlspecialchars($row->item_description ?? ''); ?></td>
                                    <td class="tds"><?php echo htmlspecialchars($row->requested_qty ?? ''); ?></td>
                                    <td class="tds"><?php echo htmlspecialchars($row->stock_available_yes ?? ''); ?></td>
                                    <td class="tds"><?php echo htmlspecialchars($row->stock_available_no ?? ''); ?></td>
                                    <td class="tds"><?php echo htmlspecialchars($row->issued_qty ?? ''); ?></td>
                                    <td class="tds"><?php echo htmlspecialchars($row->remarks ?? ''); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>

            <?php
            $ret = "SELECT * FROM requisition_and_issue_slip ORDER BY `created_at` DESC";
            $stmt = $mysqli->prepare($ret);
            $stmt->execute();
            $res = $stmt->get_result();
            $ics = $res->fetch_object();

            if ($ics)
            ?>
            <table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%;">
                <tr>
                    <td style="width: 15%; vertical-align: top; height: 30px;"><strong>Purpose:</strong></td>
                    <td style="height: 30px;"><?php echo htmlspecialchars($ics->purpose ?? ''); ?></td>
                    <br>
                    <br>
                    <br>
                </tr>

            </table>

            <table class="table table-bordered  align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="tds" style="width: 20%" scope="col"></th>
                        <th class="tds" scope="col">Requested by:</th>
                        <th class="tds" scope="col">Approved by:</th>
                        <th class="tds" scope="col">Issued by:</th>
                        <th class="tds" scope="col">Received by:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="text-align: left;">Signature :</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Print Name:</th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->requested_by_name ?? ''); ?></th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->approved_by_name ?? ''); ?></th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->issued_by_name ?? ''); ?></th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->received_by_name ?? ''); ?></th>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Designation :</th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->requested_by_designation ?? ''); ?></th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->approved_by_designation ?? ''); ?></th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->issued_by_designation ?? ''); ?></th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->received_by_designation ?? ''); ?></th>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Date :</th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->requested_by_date ?? ''); ?></th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->approved_by_date ?? ''); ?></th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->issued_by_date ?? ''); ?></th>
                        <th class="tdnormal"><?php echo htmlspecialchars($ics->received_by_date ?? ''); ?></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php
$html = ob_get_clean();
$mpdf->WriteHTML($html);
$mpdf->Output("RIS_Report_" . date("Y_m_d") . ".pdf", 'I'); // 'I' to display inline
?>