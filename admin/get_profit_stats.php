<?php
session_start();
include('includes/config.php');  // Changed from 'config.php' to 'includes/config.php'

header('Content-Type: application/json');

try {
    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Verify database connection
    if (!$dbh) {
        throw new Exception("Database connection failed");
    }

    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    
    $monthlyProfits = array_fill(0, 12, 0);
    $monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    
    // Debug: Log the received year
    error_log("Requested year: " . $year);

    // Get monthly profits
    $sql = "SELECT MONTH(payment_date) as month, SUM(amount) as total 
            FROM tblpayments 
            WHERE payment_status = 'completed' AND YEAR(payment_date) = :year
            GROUP BY MONTH(payment_date)";
    
    $query = $dbh->prepare($sql);
    $query->bindParam(':year', $year, PDO::PARAM_INT);
    
    if (!$query->execute()) {
        $errorInfo = $query->errorInfo();
        throw new Exception("Database query failed: " . $errorInfo[2]);
    }
    
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    foreach ($results as $row) {
        if (isset($row->month) {
            $monthlyProfits[$row->month - 1] = floatval($row->total);
        }
    }
    
    // Debug output
    error_log("Results: " . print_r($results, true));
    error_log("Monthly profits: " . print_r($monthlyProfits, true));
    
    echo json_encode([
        'success' => true,
        'months' => $monthNames,
        'profits' => $monthlyProfits,
        'year' => $year
    ]);
    
} catch (PDOException $e) {
    error_log("PDO Error: " . $e->getMessage());
    echo json_encode([
        'error' => 'Database error: ' . $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode([
        'error' => 'Error: ' . $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}
?>