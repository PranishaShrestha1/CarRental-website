<?php
session_start();
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
    $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;
    $payment_method = ucfirst(strtolower(trim($_POST['payment_method'])));
    $valid_methods = ['Cash', 'Khalti'];

    if ($booking_id <= 0 || $amount <= 0 || !in_array($payment_method, $valid_methods)) {
        $_SESSION['payment_error'] = "Invalid payment data.";
        header("Location: my-booking.php?pay=$booking_id");
        exit;
    }

    $userEmail = $_SESSION['login'];

    // Fetch user details
    $sqlUser = "SELECT id, ContactNo, FullName FROM tblusers WHERE EmailId = :email LIMIT 1";
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
    $name = $user['FullName'];

    if ($payment_method === 'Cash') {
        $transaction_id = uniqid('TXN');

        $sqlInsert = "INSERT INTO tblpayments (booking_id, userid, contact_no, amount, payment_method, payment_status, transaction_id) 
                      VALUES (:booking_id, :userid, :contact_no, :amount, :payment_method, 'Pending', :transaction_id)";
        $queryInsert = $dbh->prepare($sqlInsert);
        $queryInsert->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $queryInsert->bindParam(':userid', $userid, PDO::PARAM_INT);
        $queryInsert->bindParam(':contact_no', $contact_no, PDO::PARAM_STR);
        $queryInsert->bindParam(':amount', $amount);
        $queryInsert->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
        $queryInsert->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);

        if ($queryInsert->execute()) {
            $sqlUpdate = "UPDATE tblbooking SET Status = 1 WHERE id = :booking_id";
            $queryUpdate = $dbh->prepare($sqlUpdate);
            $queryUpdate->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
            $queryUpdate->execute();

            $_SESSION['payment_success'] = "Cash payment recorded. Booking confirmed, payment pending.";
            header("Location: my-booking.php");
            exit;
        } else {
            $_SESSION['payment_error'] = "Failed to record payment.";
            header("Location: my-booking.php?pay=$booking_id");
            exit;
        }
    } elseif ($payment_method === 'Khalti') {
        $amount_in_paisa = $amount * 100;
        $purchase_order_id = "BOOK_" . $booking_id . "_" . time();

        $postFields = array(
            "return_url" => "http://localhost/BIS/carrental/payment_response.php?booking_id=$booking_id",
            "website_url" => "http://localhost/BIS/carrental/",
            "amount" => $amount_in_paisa,
            "purchase_order_id" => $purchase_order_id,
            "purchase_order_name" => "Booking Payment #$booking_id",
            "customer_info" => array(
                "name" => $name,
                "email" => $userEmail,
                "phone" => $contact_no
            )
        );

        $jsonData = json_encode($postFields);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455', // Replace with real key
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            $_SESSION['payment_error'] = "Failed to initiate Khalti payment: " . $error;
            header("Location: my-booking.php?pay=$booking_id");
            exit;
        }

        $responseArray = json_decode($response, true);

        if (isset($responseArray['payment_url'])) {
            header('Location: ' . $responseArray['payment_url']);
            exit;
        } else {
            $_SESSION['payment_error'] = "Failed to initiate Khalti payment: " . ($responseArray['detail'] ?? 'Unknown error');
            header("Location: my-booking.php?pay=$booking_id");
            exit;
        }
    }
} else {
    header("Location: my-booking.php");
    exit;
}
?>
