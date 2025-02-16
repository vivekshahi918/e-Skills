<?php
include('./dbConnection.php');

include('./mainInclude/header.php');
?>
<div class="container-fluid remove-vid-marg">
  <div class="vid-parent">
    <video playsinline autoplay muted loop>
      <source src="video/b2.mp4" />
    </video>
    <div class="vid-overlay">
      <div class="vid-content">
        <h1 class="my-content">Welcome to e-Skills</h1>
        <small class="my-content">The future belongs to those who believe in the beauty of their skills.</small><br />
        <?php
        if (!isset($_SESSION['is_login'])) {
          echo '<a class="btn btn-danger mt-3" href="#" data-toggle="modal" data-target="#stuRegModalCenter">Get Started</a>';
        } else {
          echo '<a class="btn btn-primary mt-3" href="Student/studentProfile.php">My Profile</a>';
        }
        ?>
      </div>
    </div>

</div>

<div class="container-fluid bg-danger txt-banner">
  <div class="row bottom-banner">
    <div class="col-sm">
      <h5> <i class="fas fa-book-open mr-3"></i> 100+ Online Courses</h5>
    </div>
    <div class="col-sm">
      <h5><i class="fas fa-users mr-3"></i> Expert Instructors</h5>
    </div>
    <div class="col-sm">
      <h5><i class="fas fa-keyboard mr-3"></i> Lifetime Access</h5>
    </div>
    <div class="col-sm">
      <h5><i class="fas fa-rupee-sign mr-3"></i> Money Back Guarantee*</h5>
    </div>
  </div>
</div>

<div class="container mt-5">
  <h1 class="text-center">Popular Course</h1>
  <div class="card-deck mt-4">
    <?php
    $sql = "SELECT * FROM course LIMIT 3";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $course_id = $row['course_id'];
        $stuLogEmail = $_SESSION['stuLogEmail'] ?? '';


        $checkOrderSql = "SELECT * FROM courseorder WHERE stu_email = '$stuLogEmail' AND course_id = '$course_id' AND status = 'success'";
        $orderResult = $conn->query($checkOrderSql);

        if ($orderResult->num_rows > 0) {
          $buttonText = "Open";
          $buttonLink = "student/watchcourse.php?course_id=$course_id";
          $buttonClass = "btn-success";
        } else {
          $buttonText = "Enroll";
          $buttonLink = "coursedetails.php?course_id=$course_id";
          $buttonClass = "btn-primary";
        }

        echo '
            <a href="coursedetails.php?course_id=' . $course_id . '" class="btn" style="text-align: left; padding:0px; margin:0px;">
              <div class="card">
                <img src="' . str_replace('..', '.', $row['course_img']) . '" class="card-img-top" alt="Guitar" />
                <div class="card-body">
                  <h5 class="card-title">' . $row['course_name'] . '</h5>
                  <p class="card-text">' . $row['course_desc'] . '</p>
                </div>
                <div class="card-footer">
                  <p class="card-text d-inline">Price: <small><del>&#8377 ' . $row['course_original_price'] . '</del></small> 
                  <span class="font-weight-bolder">&#8377 ' . $row['course_price'] . '<span></p> 
                  <a class="btn ' . $buttonClass . ' text-white font-weight-bolder float-right" href="' . $buttonLink . '">' . $buttonText . '</a>
                </div>
              </div>
            </a>';
      }
    }
    ?>
  </div>
  <div class="card-deck mt-4">
    <?php
    $sql = "SELECT * FROM course LIMIT 3,3";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $course_id = $row['course_id'];
        $stuLogEmail = $_SESSION['stuLogEmail'] ?? '';

        // Check if the course is already purchased by the logged-in user
        $checkOrderSql = "SELECT * FROM courseorder WHERE stu_email = '$stuLogEmail' AND course_id = '$course_id' AND status = 'success'";
        $orderResult = $conn->query($checkOrderSql);

        // Set button text and link based on purchase status
        if ($orderResult->num_rows > 0) {
          // If purchased, set to "Open" button with a link to the course page
          $buttonText = "Open";
          $buttonLink = "student/watchcourse.php?course_id=$course_id";
          $buttonClass = "btn-success"; // styling for "Open" button
        } else {
          // If not purchased, set to "Enroll" button with a link to course details
          $buttonText = "Enroll";
          $buttonLink = "coursedetails.php?course_id=$course_id";
          $buttonClass = "btn-primary"; // styling for "Enroll" button
        }

        echo '
              <a href="coursedetails.php?course_id=' . $course_id . '" class="btn" style="text-align: left; padding:0px; margin:0px;">
                <div class="card">
                  <img src="' . str_replace('..', '.', $row['course_img']) . '" class="card-img-top" alt="Course Image" />
                  <div class="card-body">
                    <h5 class="card-title">' . $row['course_name'] . '</h5>
                    <p class="card-text">' . $row['course_desc'] . '</p>
                  </div>
                  <div class="card-footer">
                    <p class="card-text d-inline">Price: <small><del>&#8377 ' . $row['course_original_price'] . '</del></small> 
                    <span class="font-weight-bolder">&#8377 ' . $row['course_price'] . '<span></p> 
                    <a class="btn ' . $buttonClass . ' text-white font-weight-bolder float-right" href="' . $buttonLink . '">' . $buttonText . '</a>
                  </div>
                </div>
              </a>';
      }
    }
    ?>
  </div>
  <div class="text-center m-2">
    <a class="btn btn-danger btn-sm" href="courses.php">View All Course</a>
  </div>
</div>

<?php

include('./contact.php');
?>


<div class="container-fluid mt-5" style="background-color: #4B7289" id="Feedback">
  <h1 class="text-center testyheading p-4"> Student's Feedback </h1>
  <div class="row">
    <div class="col-md-12">
      <div id="testimonial-slider" class="owl-carousel">
        <?php
        $sql = "SELECT s.stu_name, s.stu_occ, s.stu_img, f.f_content FROM student AS s JOIN feedback AS f ON s.stu_id = f.stu_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $s_img = $row['stu_img'];
            $n_img = str_replace('../', '', $s_img)
        ?>
            <div class="testimonial">
              <p class="description">
                <?php echo $row['f_content']; ?>
              </p>
              <div class="pic">
                <img src="<?php echo $n_img; ?>" alt="" />
              </div>
              <div class="testimonial-prof">
                <h4><?php echo $row['stu_name']; ?></h4>
                <small><?php echo $row['stu_occ']; ?></small>
              </div>
            </div>
        <?php }
        } ?>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid bg-danger">
  <div class="row text-white text-center p-1">
  </div>
</div>

<div class="container-fluid p-4" style="background-color:#E9ECEF">
  <div class="container" style="background-color:#E9ECEF">
    <div class="row text-center">
      <div class="col-sm">
        <h3 style="text-decoration: underline; text-align: center; margin: 20px 0;">About Us</h3>
        <p>At e-Skills, we provide expert-led courses designed to help individuals enhance their skills and achieve success. Our mission is to make learning accessible, practical, and impactful for everyone.</p>
      </div>
      <div class="col-sm">
        <h3 style="text-decoration: underline; text-align: center; margin: 20px 0;">Category</h3>
        <a class="text-dark" href="#">Web Development</a><br />
        <a class="text-dark" href="#">Web Designing</a><br />
        <a class="text-dark" href="#">Android App Dev</a><br />
        <a class="text-dark" href="#">iOS Development</a><br />
        <a class="text-dark" href="#">Data Analysis</a><br />
      </div>
      <div class="col-sm">
        <h3 style="text-decoration: underline; text-align: center; margin: 20px 0;" >Contact Us</h3>
        <p>eSkills Pvt Ltd <br> Near Chandra Petrolpump <br> Gorakhpur, Utter Pradesh <br> Ph. +91 9555392624 </p>
      </div>
    </div>
  </div>
</div>

<?php
include('./mainInclude/footer.php');

?>