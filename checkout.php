<?php 
include('./dbConnection.php');
session_start();
if(!isset($_SESSION['stuLogEmail'])) {
  echo "<script> location.href='loginorsignup.php'; </script>";
} else {
  header("Pragma: no-cache");
  header("Cache-Control: no-cache");
  header("Expires: 0"); 
  $stuEmail = $_SESSION['stuLogEmail'];
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <title>Checkout</title>
  </head>
  <body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-6 offset-sm-3 jumbotron">
        <h3 class="mb-5">Welcome to E-Learning Payment Page</h3>
        <form method="post" action="payment.php">
          <div class="form-group row">
            <label for="ORDER_ID" class="col-sm-4 col-form-label">Order ID</label>
            <div class="col-sm-8">
              <input id="ORDER_ID" class="form-control" maxlength="20" name="ORDER_ID" value="<?php echo  "ORDS" . rand(10000,99999999)?>" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="CUST_ID" class="col-sm-4 col-form-label">Student Email</label>
            <div class="col-sm-8">
              <input id="CUST_ID" class="form-control" name="CUST_ID" value="<?php echo $stuEmail; ?>" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="TXN_AMOUNT" class="col-sm-4 col-form-label">Amount</label>
            <div class="col-sm-8">
              <input title="TXN_AMOUNT" class="form-control" type="text" name="TXN_AMOUNT" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>" readonly>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
            <a href="./courses.php" class="btn btn-secondary">Cancel</a>
          </div>
        </form>
        <small class="form-text text-muted">Note: Complete Payment by Clicking Proceed to Payment Button</small>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/all.min.js"></script>
  </body>
  </html>
 <?php } ?>
