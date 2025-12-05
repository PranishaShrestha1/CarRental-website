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
    
    <title>Drive Ease | Admin Dashboard</title>

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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .chart-container {
            position: relative;
            margin: auto;
            height: 300px;
            width: 100%;
        }
        .panel-chart {
            margin-top: 20px;
        }
        .month-slider {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .month-display {
            min-width: 120px;
            text-align: center;
            font-weight: bold;
        }
        #nextMonth[disabled], #prevMonth[disabled] {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .no-data-message {
            text-align: center;
            padding: 20px;
            font-size: 16px;
            color: #666;
        }
        .brand-table th {
            background-color: #3e454c;
            color: white;
        }
        .brand-table .total-row {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .percentage-cell {
            width: 100px;
        }
        .table-responsive {
            overflow-x: auto;
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

                    <!-- Brand Popularity Chart with Slider -->
                    <div class="panel panel-default panel-chart">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-6">Brand Popularity</div>
                                <div class="col-md-6 text-right">
                                    <div class="month-slider">
                                        <button class="btn btn-sm btn-default" id="prevMonth">
                                            <i class="fa fa-chevron-left"></i>
                                        </button>
                                        <label>Month:</label>
                                        <div class="month-display" id="monthDisplay"></div>
                                        <button class="btn btn-sm btn-default" id="nextMonth">
                                            <i class="fa fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="chart-container">
                                <canvas id="brandChart"></canvas>
                                <div id="noDataMessage" class="no-data-message" style="display:none;">
                                    No booking data available for this month
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Brand Popularity Data Table -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Brand Popularity Data - <span id="tableMonthDisplay"></span>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped brand-table" id="brandTable">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Brand Name</th>
                                            <th>Bookings</th>
                                            <th class="percentage-cell">Market Share</th>
                                        </tr>
                                    </thead>
                                    <tbody id="brandTableBody">
                                        <!-- Data will be inserted here by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                            <div id="noTableDataMessage" class="no-data-message" style="display:none;">
                                No booking data available for this month
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
<script src="js/fileinput.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/main.js"></script>

<script>
// Track the last month that had data
let lastDataMonth = null;
let lastDataYear = null;

// Get current date
const now = new Date();
const currentMonth = now.getMonth() + 1;
const currentYear = now.getFullYear();

// Track displayed month (starts as current month)
let displayedMonth = currentMonth;
let displayedYear = currentYear;

// Format month names for display
const monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"];

// Chart reference
let brandChart = null;
let brandDataTable = null;

// Update month display and button states
function updateControls() {
    // Update month display
    const monthDisplay = monthNames[displayedMonth - 1] + ' ' + displayedYear;
    $('#monthDisplay').text(monthDisplay);
    $('#tableMonthDisplay').text(monthDisplay);
    
    // Enable/disable next button
    const atCurrentMonth = (displayedMonth === currentMonth && displayedYear === currentYear);
    $('#nextMonth').prop('disabled', atCurrentMonth);
    
    // Enable/disable prev button (always enabled unless we want to set a limit)
    $('#prevMonth').prop('disabled', false);
}

// Show/hide chart and table based on data availability
function toggleDataVisibility(hasData) {
    if (hasData) {
        $('#brandChart').show();
        $('#noDataMessage').hide();
        $('#brandTable').show();
        $('#noTableDataMessage').hide();
        lastDataMonth = displayedMonth;
        lastDataYear = displayedYear;
    } else {
        $('#brandChart').hide();
        $('#noDataMessage').show();
        $('#brandTable').hide();
        $('#noTableDataMessage').show();
    }
}

// Update the table with brand data
function updateBrandTable(brands, bookings) {
    const tableBody = $('#brandTableBody');
    tableBody.empty();
    
    // Calculate total bookings for percentage calculation
    const totalBookings = bookings.reduce((sum, num) => sum + num, 0);
    
    // Create array of brand data with additional calculated fields
    const brandData = brands.map((brand, index) => ({
        brand,
        bookings: bookings[index],
        percentage: totalBookings > 0 ? Math.round((bookings[index] / totalBookings) * 100) : 0
    }));
    
    // Sort by number of bookings (descending)
    brandData.sort((a, b) => b.bookings - a.bookings);
    
    // Populate table rows
    brandData.forEach((item, index) => {
        const rowClass = index < 3 ? 'success' : ''; // Highlight top 3 brands
        tableBody.append(`
            <tr class="${rowClass}">
                <td>${index + 1}</td>
                <td>${item.brand}</td>
                <td>${item.bookings}</td>
                <td>
                    <div class="progress" style="margin-bottom: 0;">
                        <div class="progress-bar progress-bar-success" role="progressbar" 
                             aria-valuenow="${item.percentage}" aria-valuemin="0" aria-valuemax="100" 
                             style="width: ${item.percentage}%; min-width: 2em;">
                            ${item.percentage}%
                        </div>
                    </div>
                </td>
            </tr>
        `);
    });
    
    // Add total row
    if (brandData.length > 0) {
        tableBody.append(`
            <tr class="total-row">
                <td colspan="2"><strong>Total</strong></td>
                <td><strong>${totalBookings}</strong></td>
                <td><strong>100%</strong></td>
            </tr>
        `);
    }
    
    // Reinitialize DataTable if it exists
    if (brandDataTable) {
        brandDataTable.destroy();
    }
    brandDataTable = $('#brandTable').DataTable({
        "paging": false,
        "searching": false,
        "info": false,
        "order": [[2, "desc"]], // Default sort by bookings descending
        "columnDefs": [
            { "orderable": true, "targets": [0, 1, 2, 3] },
            { "className": "text-center", "targets": [0, 2, 3] }
        ]
    });
}

// Load chart data for currently displayed month
function loadChartData() {
    $.ajax({
        url: 'get_brand_stats.php',
        type: 'GET',
        data: { 
            month: displayedMonth,
            year: displayedYear
        },
        dataType: 'json',
        success: function(data) {
            if(data.error) {
                console.error(data.error);
                $('#brandChart').closest('.panel-body').html(
                    '<div class="alert alert-danger">Error loading brand data: ' + data.error + '</div>'
                );
                return;
            }
            
            if(data.brands.length === 0) {
                toggleDataVisibility(false);
                updateControls();
                return;
            } else {
                toggleDataVisibility(true);
            }
            
            // Create or update chart
            const ctx = document.getElementById('brandChart').getContext('2d');
            
            if (brandChart) {
                // Update existing chart
                brandChart.data.labels = data.brands;
                brandChart.data.datasets[0].data = data.bookings;
                brandChart.options.plugins.title.text = 'Brand Popularity - ' + monthNames[displayedMonth - 1] + ' ' + displayedYear;
                brandChart.update();
            } else {
                // Create new chart
                brandChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.brands,
                        datasets: [{
                            label: 'Number of Bookings',
                            data: data.bookings,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            hoverBackgroundColor: 'rgba(54, 162, 235, 1)',
                            hoverBorderColor: 'rgba(54, 162, 235, 1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Brand Popularity - ' + monthNames[displayedMonth - 1] + ' ' + displayedYear,
                                font: {
                                    size: 16
                                }
                            },
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' booking' + (context.parsed.y !== 1 ? 's' : '');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    stepSize: 1
                                },
                                title: {
                                    display: true,
                                    text: 'Number of Bookings'
                                }
                            },
                            x: {
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: 45,
                                    minRotation: 45
                                },
                                title: {
                                    display: true,
                                    text: 'Brands'
                                }
                            }
                        }
                    }
                });
            }
            
            // Update the table with the same data
            updateBrandTable(data.brands, data.bookings);
            updateControls();
        },
        error: function(xhr, status, error) {
            console.error("Error loading brand data:", error);
            $('#brandChart').closest('.panel-body').html(
                '<div class="alert alert-danger">Failed to load brand data. Please try again.</div>'
            );
        }
    });
}

// Navigation handlers
$('#prevMonth').click(function() {
    // Calculate previous month
    displayedMonth--;
    if (displayedMonth < 1) {
        displayedMonth = 12;
        displayedYear--;
    }
    
    loadChartData();
});

$('#nextMonth').click(function() {
    // Calculate next month
    displayedMonth++;
    if (displayedMonth > 12) {
        displayedMonth = 1;
        displayedYear++;
    }
    
    // Ensure we don't go beyond current month
    if (displayedYear > currentYear || 
        (displayedYear === currentYear && displayedMonth > currentMonth)) {
        displayedMonth = currentMonth;
        displayedYear = currentYear;
    }
    
    loadChartData();
});

// Initialize on page load
$(document).ready(function() {
    updateControls();
    loadChartData();
});
</script>
</body>
</html>
<?php } ?>