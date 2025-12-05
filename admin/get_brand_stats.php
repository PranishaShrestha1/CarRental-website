<?php
session_start();
include('includes/config.php');

header('Content-Type: application/json');

try {
    // Get month and year parameters
    $month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
    $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
    
    // Query to get most popular brands for specified month
    $sql = "SELECT b.BrandName, COUNT(*) as booking_count 
            FROM tblbooking bk
            JOIN tblvehicles v ON bk.VehicleId = v.id
            JOIN tblbrands b ON v.VehiclesBrand = b.id
            WHERE MONTH(bk.PostingDate) = :month 
            AND YEAR(bk.PostingDate) = :year
            GROUP BY b.id
            ORDER BY booking_count DESC
            LIMIT 5";
    
    $query = $dbh->prepare($sql);
    $query->bindParam(':month', $month, PDO::PARAM_INT);
    $query->bindParam(':year', $year, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $brands = [];
    $bookings = [];
    
    foreach ($results as $row) {
        $brands[] = $row['BrandName'];
        $bookings[] = $row['booking_count'];
    }
    
    echo json_encode([
        'brands' => $brands,
        'bookings' => $bookings,
        'month' => $month,
        'year' => $year
    ]);
    
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}


?>