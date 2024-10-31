<?php
// Assuming session is already started and you have the necessary user info
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <title>Payment Successful</title>
</head>

<body>
<div class="container mt-5 d-flex flex-column align-items-center text-center">
    <h1>Payment Successful!</h1>
    <p>Your payment has been processed successfully.</p>
    <a href="Student/myCourse.php" class="btn btn-secondary">Go to My Courses</a>
</div>

</body>

</html>