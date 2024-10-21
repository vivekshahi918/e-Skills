<!-- Start Contact Us -->
<div class="container mt-4" id="Contact"> 
    <h2 class="text-center mb-4">Contact US</h2> 
    <div class="row">  
        <div class="col-md-8"> 
            <form action="" method="post">
                <input type="text" class="form-control" name="name" placeholder="Name" required><br>
                <input type="text" class="form-control" name="subject" placeholder="Subject" required><br>
                <input type="email" class="form-control" name="email" placeholder="E-mail" required><br>
                <textarea class="form-control" name="message" placeholder="How can we help you?" style="height:150px;" required></textarea><br>
                <input class="btn btn-primary" type="submit" value="Send" name="submit"><br><br>
            </form>
        </div> <!-- End Contact Us 1st Column-->

        <div class="col-md-4 stripe text-white text-center">  <!-- Start Contact Us 2nd Column-->
            <h4>e-Skills</h4>
            <p>e-Skills, 
            Brahalganj, Gorakhpur, 
            Uttar Pradesh - 273412<br /> 
            Phone: +91 9555392624 <br />
            www.e_skills.com </p>
        </div> 
    </div> 
</div> 
<!-- End Contact Us -->

<?php
if(isset($_POST['submit'])){
    // Get form data
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Define the recipient email
    $to = "vivekshahi503@gmail.com"; // Your email address
    $headers = "From: " . $email . "\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "X-Mailer: PHP/" . phpversion();
    
    // Compose email body
    $body = "You have received a new message from the contact form on e-Skills.\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Subject: $subject\n";
    $body .= "Message:\n$message\n";

    // Send the email
    if(mail($to, $subject, $body, $headers)){
        echo '<div class="alert alert-success">Message sent successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Message sending failed. Please try again later.</div>';
    }
}
?>
