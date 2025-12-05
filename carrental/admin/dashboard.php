<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {    
    header('location:index.php');
}
else {
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

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .chart-container {
            position: relative;
            margin: auto;
            height: 250px;
            width: 100%;
        }
    </style>
</head>

<body>
<?php include('includes/header.php');?>

<div class="ts-main-content">
    <?php include('includes/leftbar.php');?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Dashboard</h2>
                    
                    <!-- Stats Cards Row 1 -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body bk-primary text-light">
                                    <div class="stat-panel text-center">
                                        <?php 
                                        $sql ="SELECT id from tblusers ";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $regusers=$query->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1 "><?php echo htmlentities($regusers);?></div>
                                        <div class="stat-panel-title text-uppercase">Reg Users</div>
                                    </div>
                                </div>
                                <a href="reg-users.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body bk-success text-light">
                                    <div class="stat-panel text-center">
                                        <?php 
                                        $sql1 ="SELECT id from tblvehicles ";
                                        $query1 = $dbh->prepare($sql1);
                                        $query1->execute();
                                        $totalvehicle=$query1->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1 "><?php echo htmlentities($totalvehicle);?></div>
                                        <div class="stat-panel-title text-uppercase">Listed Vehicles</div>
                                    </div>
                                </div>
                                <a href="manage-vehicles.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body bk-info text-light">
                                    <div class="stat-panel text-center">
                                        <?php 
                                        $sql2 ="SELECT id from tblbooking ";
                                        $query2= $dbh->prepare($sql2);
                                        $query2->execute();
                                        $bookings=$query2->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1 "><?php echo htmlentities($bookings);?></div>
                                        <div class="stat-panel-title text-uppercase">Total Bookings</div>
                                    </div>
                                </div>
                                <a href="manage-bookings.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body bk-warning text-light">
                                    <div class="stat-panel text-center">
                                        <?php 
                                        $sql3 ="SELECT id from tblbrands ";
                                        $query3= $dbh->prepare($sql3);
                                        $query3->execute();
                                        $brands=$query3->rowCount();
                                        ?>                                              
                                        <div class="stat-panel-number h1 "><?php echo htmlentities($brands);?></div>
                                        <div class="stat-panel-title text-uppercase">Listed Brands</div>
                                    </div>
                                </div>
                                <a href="manage-brands.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats Cards Row 2 -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body bk-primary text-light">
                                    <div class="stat-panel text-center">
                                        <?php 
                                        $sql4 ="SELECT id from tblsubscribers ";
                                        $query4 = $dbh->prepare($sql4);
                                        $query4->execute();
                                        $subscribers=$query4->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1 "><?php echo htmlentities($subscribers);?></div>
                                        <div class="stat-panel-title text-uppercase">Subscribers</div>
                                    </div>
                                </div>
                                <a href="manage-subscribers.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body bk-success text-light">
                                    <div class="stat-panel text-center">
                                        <?php 
                                        $sql6 ="SELECT id from tblcontactusquery ";
                                        $query6 = $dbh->prepare($sql6);
                                        $query6->execute();
                                        $query=$query6->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1 "><?php echo htmlentities($query);?></div>
                                        <div class="stat-panel-title text-uppercase">Queries</div>
                                    </div>
                                </div>
                                <a href="manage-conactusquery.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body bk-info text-light">
                                    <div class="stat-panel text-center">
                                        <?php 
                                        $sql5 ="SELECT id from tbltestimonial ";
                                        $query5= $dbh->prepare($sql5);
                                        $query5->execute();
                                        $testimonials=$query5->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1 "><?php echo htmlentities($testimonials);?></div>
                                        <div class="stat-panel-title text-uppercase">Testimonials</div>
                                    </div>
                                </div>
                                <a href="testimonials.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body bk-danger text-light">
                                    <div class="stat-panel text-center">
                                        <?php 
                                        $bookings_count = $dbh->query("SELECT COUNT(*) FROM tblbooking")->fetchColumn();
                                        ?>
                                        <div class="stat-panel-number h1"><?php echo htmlentities($bookings_count);?></div>
                                        <div class="stat-panel-title text-uppercase">Reports</div>
                                    </div>
                                </div>
                                <a href="reports.php" class="block-anchor panel-footer text-center">View Reports &nbsp; <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics Charts Section -->
                    <div class="panel panel-default">
                        <div class="panel-heading">Rental Analytics</div>
                        <div class="panel-body">
                            <div class="row">
                                <!-- Most Rented Vehicles Chart -->
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Top 5 Most Rented Vehicles</div>
                                        <div class="panel-body">
                                            <div class="chart-container">
                                                <canvas id="mostRentedVehicles"></canvas>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <small>Helps identify which vehicles to stock more of</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Most Popular Brands Chart -->
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Top 5 Most Popular Brands</div>
                                        <div class="panel-body">
                                            <div class="chart-container">
                                                <canvas id="popularBrands"></canvas>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <small>Shows which brands customers prefer most</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- Payment Methods Chart -->
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Payment Methods Distribution</div>
                                        <div class="panel-body">
                                            <div class="chart-container">
                                                <canvas id="paymentMethods"></canvas>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <small>Helps optimize payment processing options</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Monthly Rental Trends -->
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Monthly Rental Trends (Last 6 Months)</div>
                                        <div class="panel-body">
                                            <div class="chart-container">
                                                <canvas id="monthlyTrends"></canvas>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <small>Identifies seasonal patterns for better planning</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/Chart.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/main.js"></script>

<script>
$(document).ready(function() {
    // Function to initialize all charts
    function initializeCharts(data) {
        // 1. Most Rented Vehicles Chart (Bar Chart)
        var vehiclesCtx = document.getElementById('mostRentedVehicles').getContext('2d');
        var vehiclesChart = new Chart(vehiclesCtx, {
            type: 'bar',
            data: {
                labels: data.vehicleNames,
                datasets: [{
                    label: 'Number of Rentals',
                    data: data.vehicleCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Most Rented Vehicles (All Time)'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // 2. Popular Brands Chart (Doughnut Chart)
        var brandsCtx = document.getElementById('popularBrands').getContext('2d');
        var brandsChart = new Chart(brandsCtx, {
            type: 'doughnut',
            data: {
                labels: data.brandNames,
                datasets: [{
                    data: data.brandCounts,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Most Popular Brands'
                    },
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
        
        // 3. Booking Status Chart (Pie Chart - replaces Payment Methods)
        var statusCtx = document.getElementById('paymentMethods').getContext('2d');
        var statusChart = new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: data.statusLabels,
                datasets: [{
                    data: data.statusCounts,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Booking Status Distribution'
                    },
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
        
        // 4. Monthly Trends by Fuel Type (Line Chart)
        var trendsCtx = document.getElementById('monthlyTrends').getContext('2d');
        var trendsChart = new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: data.months,
                datasets: data.fuelDatasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Rentals by Fuel Type'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    // Load chart data via AJAX
    $.ajax({
        url: 'getDashboardData.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if(data.error) {
                console.error(data.error);
                // Display error message to user
                $('.chart-container').html('<div class="alert alert-danger">Error loading chart data: ' + data.error + '</div>');
                return;
            }
            
            // Initialize charts with the received data
            initializeCharts(data);
        },
        error: function(xhr, status, error) {
            console.error("Error loading chart data:", error);
            // Display error message to user
            $('.chart-container').html('<div class="alert alert-danger">Failed to load chart data. Please try again.</div>');
        }
    });
});
</script>
</body>
</html>
<?php } ?>