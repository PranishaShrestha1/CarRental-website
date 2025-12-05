<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    // Stats Queries
    $sql = "SELECT id FROM tblusers";
    $query = $dbh->prepare($sql);
    $query->execute();
    $regusers = $query->rowCount();

    $sql1 = "SELECT id FROM tblvehicles";
    $query1 = $dbh->prepare($sql1);
    $query1->execute();
    $totalvehicle = $query1->rowCount();

    $sql2 = "SELECT id FROM tblbooking";
    $query2 = $dbh->prepare($sql2);
    $query2->execute();
    $bookings = $query2->rowCount();

    $sql3 = "SELECT id FROM tblbrands";
    $query3 = $dbh->prepare($sql3);
    $query3->execute();
    $brands = $query3->rowCount();
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Car Rental Portal | Admin Dashboard</title>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .report-tabs { margin: 20px 0; }
        .report-tabs button {
            padding: 10px 20px;
            margin-right: 10px;
            background: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
        }
        .report-tabs button.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-confirmed { background-color: #d4edda; color: #155724; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        .panel-report { margin-top: 20px; }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Reports Panel -->
                        <div class="panel panel-default panel-report">
                            <div class="panel-heading">Reports Dashboard</div>
                            <div class="panel-body">
                                <div class="report-tabs">
                                    <button id="bookingsTab" class="active">Bookings Report (<?= $bookings ?>)</button>
                                    <button id="vehiclesTab">Vehicle Popularity</button>
                                </div>

                                <!-- Bookings Report -->
                                <div id="bookingsReport">
                                    <h3>Car Rental Bookings Report</h3>
                                    <table id="bookingsTable" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Booking #</th>
                                                <th>Customer</th>
                                                <th>Vehicle</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                <th>Days</th>
                                                <th>Price/Day</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Booking Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $bookings_query = "SELECT b.*, u.FullName, u.ContactNo, u.EmailId, v.VehiclesTitle, v.PricePerDay 
                                                FROM tblbooking b
                                                JOIN tblusers u ON b.userEmail = u.EmailId
                                                JOIN tblvehicles v ON b.VehicleId = v.id
                                                ORDER BY b.PostingDate DESC";
                                            $query = $dbh->prepare($bookings_query);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {
                                                    $days = date_diff(date_create($result->FromDate), date_create($result->ToDate))->days;
                                                    $total = $days * $result->PricePerDay;
                                                    $status_class = $result->Status == 1 ? 'status-confirmed' : ($result->Status == 2 ? 'status-cancelled' : 'status-pending');
                                                    $status_text = $result->Status == 1 ? 'Confirmed' : ($result->Status == 2 ? 'Cancelled' : 'Pending');
                                            ?>
                                            <tr>
                                                <td><?= htmlentities($result->BookingNumber); ?></td>
                                                <td><?= htmlentities($result->FullName) . "<br>" . htmlentities($result->EmailId); ?></td>
                                                <td><?= htmlentities($result->VehiclesTitle); ?></td>
                                                <td><?= htmlentities($result->FromDate); ?></td>
                                                <td><?= htmlentities($result->ToDate); ?></td>
                                                <td><?= $days; ?></td>
                                                <td>Rs<?= number_format($result->PricePerDay, 2); ?></td>
                                                <td>Rs<?= number_format($total, 2); ?></td>
                                                <td><span class="status-badge <?= $status_class; ?>"><?= $status_text; ?></span></td>
                                                <td><?= htmlentities($result->PostingDate); ?></td>
                                            </tr>
                                            <?php }} ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Vehicles Report -->
                                <div id="vehiclesReport" style="display:none;">
                                    <h3>Vehicle Popularity Report</h3>
                                    <table id="vehiclesTable" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Vehicle</th>
                                                <th>Brand</th>
                                                <th>Bookings</th>
                                                <th>Days Rented</th>
                                                <th>Total Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $vehicles_query = "SELECT v.VehiclesTitle, b.BrandName, COUNT(bk.id) AS booking_count, 
                                                SUM(DATEDIFF(bk.ToDate, bk.FromDate)) AS total_days_rented,
                                                SUM(DATEDIFF(bk.ToDate, bk.FromDate) * v.PricePerDay) AS total_revenue
                                                FROM tblvehicles v
                                                JOIN tblbrands b ON v.VehiclesBrand = b.id
                                                LEFT JOIN tblbooking bk ON v.id = bk.VehicleId
                                                GROUP BY v.id
                                                ORDER BY booking_count DESC";
                                            $query = $dbh->prepare($vehicles_query);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {
                                            ?>
                                            <tr>
                                                <td><?= htmlentities($result->VehiclesTitle); ?></td>
                                                <td><?= htmlentities($result->BrandName); ?></td>
                                                <td><?= htmlentities($result->booking_count); ?></td>
                                                <td><?= htmlentities($result->total_days_rented ?? 0); ?></td>
                                                <td>Rs<?= number_format($result->total_revenue ?? 0, 2); ?></td>
                                            </tr>
                                            <?php }} ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>

    <script>
    $(document).ready(function () {
        const bookingsTable = $('#bookingsTable').DataTable({ dom: 'Bfrtip', buttons: ['copy', 'excel', 'pdf', 'print'], scrollX: true, pageLength: 10 });
        const usersTable = $('#usersTable').DataTable({ dom: 'Bfrtip', buttons: ['copy', 'excel', 'pdf', 'print'], scrollX: true, pageLength: 10 });
        const vehiclesTable = $('#vehiclesTable').DataTable({ dom: 'Bfrtip', buttons: ['copy', 'excel', 'pdf', 'print'], scrollX: true, pageLength: 10 });

        $('#bookingsTab').click(function () {
            $(this).addClass('active');
            $('#usersTab, #vehiclesTab').removeClass('active');
            $('#bookingsReport').show();
            $('#usersReport, #vehiclesReport').hide();
        });

        $('#usersTab').click(function () {
            $(this).addClass('active');
            $('#bookingsTab, #vehiclesTab').removeClass('active');
            $('#usersReport').show();
            $('#bookingsReport, #vehiclesReport').hide();
        });

        $('#vehiclesTab').click(function () {
            $(this).addClass('active');
            $('#bookingsTab, #usersTab').removeClass('active');
            $('#vehiclesReport').show();
            $('#bookingsReport, #usersReport').hide();
        });
    });
    </script>
</body>
</html>
<?php } ?>
