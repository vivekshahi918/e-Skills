<?php
session_start(); 

require_once 'lib/stripe-php-16.2.0/init.php';
require_once 'dbConnection.php'; 

// Set your secret key
\Stripe\Stripe::setApiKey('sk_test_51PtRXWHGfWb0iHWocoZmKgfQIWg3wy3UhPOPlMaM4thPWqwHOIaT3rphtVjdwQAdLcqLoSM0NsCWnKmc1LlUDBXU00vquOmX0x');


$token = $_POST['stripeToken'];
$custId = $_POST['CUST_ID'];
$amount = $_POST['TXN_AMOUNT']/85; 

// Prevent using the same token multiple times
if (!isset($_SESSION['stripe_token'])) {
    $_SESSION['stripe_token'] = $token; 
} else {
    
    if ($_SESSION['stripe_token'] === $token) {
        echo "<script>alert('Payment has already been processed.');</script>";
        exit();
    }
}


unset($_SESSION['stripe_token']);

$orderId = 'ORDS' . uniqid(); 

try {
    $charge = \Stripe\Charge::create([
        'amount' => $amount,
        'currency' => 'usd',
        'description' => 'Payment for Order ' . $orderId,
        'source' => $token,
    ]);

    
    $stmt = $conn->prepare("INSERT INTO courseorder (order_id, stu_email, course_id, status, respmsg, amount, order_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    
    $status = 'success';
    $respmsg = 'Payment successful';
    $courseId = $_SESSION['course_id']; 
    $stuEmail = $_SESSION['stuLogEmail']; 

    
    $stmt->bind_param("ssissss", $orderId, $stuEmail, $courseId, $status, $respmsg, $amount, date('Y-m-d'));

    if ($stmt->execute()) {
        
        header("Location: success.php?order_id=$orderId&cust_id=$custId");
        exit();
    } else {
        
        echo "<script>alert('Error saving order: " . $stmt->error . "');</script>";
    }
} catch (\Stripe\Exception\CardException $e) {
    
    echo "<script>alert('Payment failed: " . $e->getMessage() . "');</script>";
}

unset($_SESSION['stripe_token']);
?>
