<?php
session_start();
include('includes/config.php');
header('Content-Type: application/json');

try {
    // 1. Top 5 Most Rented Vehicles (from tblbooking)
    $vehicleQuery = $dbh->query("
        SELECT v.VehiclesTitle, COUNT(b.id) as rental_count 
        FROM tblbooking b
        JOIN tblvehicles v ON b.VehicleId = v.id
        GROUP BY v.VehiclesTitle
        ORDER BY rental_count DESC
        LIMIT 5
    ");
    $vehicleData = $vehicleQuery->fetchAll(PDO::FETCH_ASSOC);

    // 2. Top 5 Most Popular Brands (from tblbooking via tblvehicles)
    $brandQuery = $dbh->query("
        SELECT b.BrandName, COUNT(tbk.id) as rental_count 
        FROM tblbooking tbk
        JOIN tblvehicles v ON tbk.VehicleId = v.id
        JOIN tblbrands b ON v.VehiclesBrand = b.id
        GROUP BY b.BrandName
        ORDER BY rental_count DESC
        LIMIT 5
    ");
    $brandData = $brandQuery->fetchAll(PDO::FETCH_ASSOC);

    // 3. Booking Status Distribution (since PaymentMethod doesn't exist)
    $statusQuery = $dbh->query("
        SELECT 
            CASE 
                WHEN Status = 1 THEN 'Confirmed'
                ELSE 'Pending'
            END as booking_status,
            COUNT(id) as status_count 
        FROM tblbooking
        GROUP BY booking_status
    ");
    $statusData = $statusQuery->fetchAll(PDO::FETCH_ASSOC);

    // 4. Monthly Rental Trends by Fuel Type (from tblbooking via tblvehicles)
    $monthlyQuery = $dbh->query("
        SELECT 
            DATE_FORMAT(b.PostingDate, '%b %Y') as month,
            v.FuelType,
            COUNT(b.id) as booking_count
        FROM tblbooking b
        JOIN tblvehicles v ON b.VehicleId = v.id
        WHERE b.PostingDate >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        GROUP BY DATE_FORMAT(b.PostingDate, '%Y-%m'), v.FuelType
        ORDER BY b.PostingDate ASC, v.FuelType
    ");
    $monthlyData = $monthlyQuery->fetchAll(PDO::FETCH_ASSOC);

    // Process monthly data to group by fuel type
    $fuelTypes = [];
    $months = [];
    $monthlyBookingsByFuel = [];

    foreach ($monthlyData as $row) {
        if (!in_array($row['month'], $months)) {
            $months[] = $row['month'];
        }
        if (!in_array($row['FuelType'], $fuelTypes)) {
            $fuelTypes[] = $row['FuelType'];
        }
        $monthlyBookingsByFuel[$row['FuelType']][$row['month']] = $row['booking_count'];
    }

    // Prepare datasets for the line chart
    $fuelDatasets = [];
    $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
    
    foreach ($fuelTypes as $index => $fuelType) {
        $data = [];
        foreach ($months as $month) {
            $data[] = $monthlyBookingsByFuel[$fuelType][$month] ?? 0;
        }
        
        $fuelDatasets[] = [
            'label' => $fuelType,
            'data' => $data,
            'backgroundColor' => $colors[$index % count($colors)],
            'borderColor' => $colors[$index % count($colors)],
            'borderWidth' => 2,
            'fill' => false
        ];
    }

    // Prepare response
    $response = [
        'vehicleNames' => array_column($vehicleData, 'VehiclesTitle'),
        'vehicleCounts' => array_column($vehicleData, 'rental_count'),
        'brandNames' => array_column($brandData, 'BrandName'),
        'brandCounts' => array_column($brandData, 'rental_count'),
        'statusLabels' => array_column($statusData, 'booking_status'),
        'statusCounts' => array_column($statusData, 'status_count'),
        'months' => $months,
        'fuelDatasets' => $fuelDatasets
    ];

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>