<!-- Start Contact Us -->
<div class="container mt-4" id="Contact"> 
    <h2 class="text-center mb-4">Contact US</h2> 
    <div class="row">  
        <div class="col-md-8"> 
            <form id="contact-form"> 
                <input type="text" class="form-control" name="name" placeholder="Name" required><br>
                <input type="text" class="form-control" name="phone" placeholder="Phone Number" required><br>
                <input type="email" class="form-control" name="email" placeholder="E-mail" required><br>
                <textarea class="form-control" name="message" placeholder="How can we help you?" style="height:150px;" required></textarea><br>
                
                <button type="submit" class="btn btn-primary">
                    Submit <i class="fa fa-paper-plane"></i>
                </button>
            </form>
        </div> 

        <div class="col-md-4 stripe text-white text-center"> 
            <h4>e-Skills</h4>
            <p>e-Skills, 
            Brahalganj, Gorakhpur, 
            Uttar Pradesh - 273412<br /> 
            Phone: +91 9555392624 <br />
            www.e_skills.com </p>
        </div> 
    </div> 
</div> 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/emailjs-com@2.6.4/dist/email.min.js"></script>
<script>
    (function() {
        emailjs.init("5SOnPPSi0ytOVQNRS"); // Replace with your actual EmailJS user ID
    })();

    $("#contact-form").submit(function (event) {
        event.preventDefault(); 
        
        // Use EmailJS to send the form data
        emailjs.sendForm('vivekshahi503', 'template_jkmzqgs', this)
        .then(function (response) {
            console.log('SUCCESS!', response.status, response.text);
            document.getElementById("contact-form").reset();
            alert("Form Submitted Successfully");
        }, function (error) {
            console.log('FAILED...', error);
            alert("Form Submission Failed! Please Try Again.");
        });
    });
</script>
