<?php
session_start();
include('includes/config.php');

if (!isset($_GET['pidx']) || !isset($_GET['booking_id'])) {
    $_SESSION['payment_error'] = "Invalid payment response.";
    header("Location: my-booking.php");
    exit;
}

$pidx = $_GET['pidx'];
$booking_id = (int)$_GET['booking_id'];

// Verify payment with Khalti
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/lookup/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455',
        'Content-Type: application/json',
    ),
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(['pidx' => $pidx]),
));

$response = curl_exec($curl);
curl_close($curl);

if (!$response) {
    $_SESSION['payment_error'] = "Failed to verify payment with Khalti.";
    header("Location: my-booking.php?pay=$booking_id");
    exit;
}

$responseArray = json_decode($response, true);
$status = $responseArray['status'] ?? 'Failed';

if ($status !== 'Completed') {
    $_SESSION['payment_error'] = "Payment verification failed. Status: " . $status;
    header("Location: my-booking.php?pay=$booking_id");
    exit;
}

// Payment successful - record in database
$userEmail = $_SESSION['login'];
$transaction_id = $responseArray['transaction_id'] ?? uniqid('TXN');
$amount = ($responseArray['total_amount'] ?? 0) / 100; 
// Fetch user details
$sqlUser = "SELECT id, ContactNo FROM tblusers WHERE EmailId = :email LIMIT 1";
$queryUser = $dbh->prepare($sqlUser);
$queryUser->bindParam(':email', $userEmail, PDO::PARAM_STR);
$queryUser->execute();
$user = $queryUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['payment_error'] = "User not found.";
    header("Location: my-booking.php?pay=$booking_id");
    exit;
}

$userid = $user['id'];
$contact_no = $user['ContactNo'];

// Begin transaction
$dbh->beginTransaction();

try {
    // Insert payment record
    $sqlInsert = "INSERT INTO tblpayments (booking_id, userid, contact_no, amount, payment_method, payment_status, transaction_id) 
                  VALUES (:booking_id, :userid, :contact_no, :amount, 'Khalti', 'Paid', :transaction_id)";
    $queryInsert = $dbh->prepare($sqlInsert);
    $queryInsert->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $queryInsert->bindParam(':userid', $userid, PDO::PARAM_INT);
    $queryInsert->bindParam(':contact_no', $contact_no, PDO::PARAM_STR);
    $queryInsert->bindParam(':amount', $amount);
    $queryInsert->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);
    $queryInsert->execute();

    // Update booking status
    $sqlUpdate = "UPDATE tblbooking SET Status = 1 WHERE id = :booking_id";
    $queryUpdate = $dbh->prepare($sqlUpdate);
    $queryUpdate->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $queryUpdate->execute();

    $dbh->commit();

    $_SESSION['payment_success'] = "Payment completed successfully via Khalti!";
    header("Location: my-booking.php");
    exit;
} catch (Exception $e) {
    $dbh->rollBack();
    $_SESSION['payment_error'] = "Database error: " . $e->getMessage();
    header("Location: my-booking.php?pay=$booking_id");
    exit;
}
?>