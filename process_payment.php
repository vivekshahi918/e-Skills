<?php
session_start(); // Start the session to use session variables

require_once 'lib/stripe-php-16.2.0/init.php';
require_once 'dbConnection.php'; // Include your database connection

// Set your secret key
\Stripe\Stripe::setApiKey('sk_test_51PtRXWHGfWb0iHWocoZmKgfQIWg3wy3UhPOPlMaM4thPWqwHOIaT3rphtVjdwQAdLcqLoSM0NsCWnKmc1LlUDBXU00vquOmX0x');

// Retrieve the token, the charge amount, and other necessary details
$token = $_POST['stripeToken'];
$custId = $_POST['CUST_ID'];
$amount = $_POST['TXN_AMOUNT'] * 100; // Convert to cents

// Prevent using the same token multiple times
if (!isset($_SESSION['stripe_token'])) {
    $_SESSION['stripe_token'] = $token; // Store the token in the session
} else {
    // Check if the current token matches the one in the session
    if ($_SESSION['stripe_token'] === $token) {
        echo "<script>alert('Payment has already been processed.');</script>";
        exit();
    }
}

// Clear the token after processing to allow new payments
unset($_SESSION['stripe_token']);

$orderId = 'ORDS' . uniqid(); // Generate a unique order ID

try {
    // Create a charge: this will charge the user's card
    $charge = \Stripe\Charge::create([
        'amount' => $amount,
        'currency' => 'usd',
        'description' => 'Payment for Order ' . $orderId,
        'source' => $token,
    ]);

    // Payment was successful, now save to the database
    $stmt = $conn->prepare("INSERT INTO courseorder (order_id, stu_email, course_id, status, respmsg, amount, order_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    // Prepare the variables for binding
    $status = 'success';
    $respmsg = 'Payment successful';
    $courseId = $_SESSION['course_id']; // Replace with the actual course ID or retrieve it from your form
    $stuEmail = $_SESSION['stuLogEmail']; // Get the student's email

    // Bind parameters
    $stmt->bind_param("ssissss", $orderId, $stuEmail, $courseId, $status, $respmsg, $amount, date('Y-m-d'));

    if ($stmt->execute()) {
        // Redirect to a success page
        header("Location: success.php?order_id=$orderId&cust_id=$custId");
        exit();
    } else {
        // Handle database insertion error
        echo "<script>alert('Error saving order: " . $stmt->error . "');</script>";
    }
} catch (\Stripe\Exception\CardException $e) {
    // Payment failed
    echo "<script>alert('Payment failed: " . $e->getMessage() . "');</script>";
}

// Clear the session variable after successful payment
unset($_SESSION['stripe_token']);
?>
