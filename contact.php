<!-- Start Contact Us -->
<div class="container mt-4" id="Contact"> 
    <h2 class="text-center mb-4">Contact US</h2> 
    <div class="row">  
        <div class="col-md-8"> 
            <form id="contact-form"> <!-- Add id for jQuery to target -->
                <input type="text" class="form-control" name="name" placeholder="Name" required><br>
                <input type="text" class="form-control" name="phone" placeholder="Phone Number" required><br>
                <input type="email" class="form-control" name="email" placeholder="E-mail" required><br>
                <textarea class="form-control" name="message" placeholder="How can we help you?" style="height:150px;" required></textarea><br>
                
                <!-- Updated Submit Button -->
                <button type="submit" class="btn btn-primary">
                    Submit <i class="fa fa-paper-plane"></i>
                </button>
            </form>
        </div> <!-- End Contact Us 1st Column -->

        <div class="col-md-4 stripe text-white text-center"> <!-- Start Contact Us 2nd Column -->
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

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include EmailJS SDK -->
<script src="https://cdn.jsdelivr.net/npm/emailjs-com@2.6.4/dist/email.min.js"></script>
<script>
    (function() {
        emailjs.init("5SOnPPSi0ytOVQNRS"); // Replace with your actual EmailJS user ID
    })();

    // Handle form submission using jQuery
    $("#contact-form").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission
        
        // Use EmailJS to send the form data
        emailjs.sendForm('vivekshahi503', 'template_jkmzqgs', this)
        .then(function (response) {
            console.log('SUCCESS!', response.status, response.text);
            document.getElementById("contact-form").reset(); // Reset the form after successful submission
            alert("Form Submitted Successfully");
        }, function (error) {
            console.log('FAILED...', error);
            alert("Form Submission Failed! Please Try Again.");
        });
    });
</script>
