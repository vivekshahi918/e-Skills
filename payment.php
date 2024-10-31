<?php
include('./dbConnection.php');
session_start();
if (!isset($_SESSION['stuLogEmail'])) {
    echo "<script> location.href='loginorsignup.php'; </script>";
} else {

    $orderId = $_POST['ORDER_ID'];
    $custId = $_POST['CUST_ID'];
    $txnAmount = $_POST['TXN_AMOUNT'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/all.min.css">
        <link rel="stylesheet" type="text/css" href="./css/style.css" />
        <title>Payment</title>
        <script src="https://js.stripe.com/v3/"></script>
        <style>
            .payment-container {
                max-width: 400px;
                margin: 50px auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                background-color: #fff;
            }

            .payment-container h3 {
                font-weight: bold;
                text-align: center;
                margin-bottom: 20px;
            }

            .form-group label {
                font-weight: 600;
            }

            #card-element {
                padding: 10px;
                border: 1px solid #ced4da;
                border-radius: 4px;
                background-color: #f9f9f9;
            }

            #card-errors {
                color: #e3342f;
                margin-top: 10px;
            }

            .btn-primary {
                width: 100%;
                background-color: #007bff;
                border: none;
            }

            .btn-secondary {
                width: 100%;
                margin-top: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <div class="payment-container">
                <h3>Checkout</h3>
                <form id="payment-form" method="POST" action="process_payment.php">
                    <input type="hidden" name="ORDER_ID" value="<?php echo htmlspecialchars($orderId); ?>" />
                    <input type="hidden" name="CUST_ID" value="<?php echo htmlspecialchars($custId); ?>" />
                    <input type="hidden" name="TXN_AMOUNT" value="<?php echo htmlspecialchars($txnAmount); ?>" />

                    <div class="form-group">
                        <label for="full-name">Full Name</label>
                        <input type="text" id="full-name" class="form-control" placeholder="First and last name" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" class="form-control" placeholder="Street address" required>
                    </div>

                    <div class="form-group">
                        <label for="card-element">Credit or Debit Card</label>
                        <div id="card-element" class="form-control"></div>
                        <div id="card-errors" role="alert"></div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Pay Now - $<?php echo $txnAmount; ?></button>
                    <a href="./checkout.php" class="btn btn-secondary mt-2">Back</a>
                </form>
                <small class="form-text text-muted text-center mt-3">Note: Complete Payment by Clicking Pay Now</small>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/all.min.js"></script>

        <script>
            // Initialize Stripe
            var stripe = Stripe('pk_test_51PtRXWHGfWb0iHWoDEkw2VcmrqXSEpOz7aUCYR7Eng2FapFq66x8F5n3L6VobfrTug4Stmiwk5KEJBi335bamiVG00Nb3JXhm0');
            var elements = stripe.elements();

            // Custom styling for the Stripe element
            var style = {
                base: {
                    color: "#32325d",
                    fontSize: "16px",
                    "::placeholder": {
                        color: "#aab7c4"
                    }
                },
                invalid: {
                    color: "#e3342f",
                    iconColor: "#e3342f"
                }
            };

            // Create an instance of the card Element
            var card = elements.create('card', {
                style: style
            });
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element
            card.on('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server
                        var hiddenInput = document.createElement('input');
                        hiddenInput.setAttribute('type', 'hidden');
                        hiddenInput.setAttribute('name', 'stripeToken');
                        hiddenInput.setAttribute('value', result.token.id);
                        form.appendChild(hiddenInput);

                        // Submit the form
                        form.submit();
                    }
                });
            });
        </script>
    </body>

    </html>
<?php
}
?>