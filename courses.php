<?php
  include('./dbConnection.php');
  // Header Include from mainInclude 
  include('./mainInclude/header.php'); 
?>  
<div class="container-fluid bg-dark"> <!-- Start Course Page Banner -->
  <div class="row">
    <img src="./image/coursebanner.jpg" alt="courses" style="height:500px; width:100%; object-fit:cover; box-shadow:10px;"/>
  </div> 
</div> <!-- End Course Page Banner -->

<div class="container mt-5"> <!-- Start All Course -->
  <h1 class="text-center">All Courses</h1>
  <div class="row mt-4"> <!-- Start All Course Row -->
  <?php
      $sql = "SELECT * FROM course";
      $result = $conn->query($sql);
      if($result->num_rows > 0){ 
        while($row = $result->fetch_assoc()){
          $course_id = $row['course_id'];
          $stuLogEmail = $_SESSION['stuLogEmail'] ?? '';

          // Check if the course is already purchased by the logged-in user
          $checkOrderSql = "SELECT * FROM courseorder WHERE stu_email = '$stuLogEmail' AND course_id = '$course_id' AND status = 'success'";
          $orderResult = $conn->query($checkOrderSql);

          // Set button text and link based on purchase status
          if ($orderResult->num_rows > 0) {
            // If purchased, set to "Open" button with a link to the course page
            $buttonText = "Open";
            $buttonLink = "watchcourse.php?course_id=$course_id";
            $buttonClass = "btn-success"; // styling for "Open" button
          } else {
            // If not purchased, set to "Enroll" button with a link to course details
            $buttonText = "Enroll";
            $buttonLink = "coursedetails.php?course_id=$course_id";
            $buttonClass = "btn-primary"; // styling for "Enroll" button
          }

          echo ' 
            <div class="col-sm-4 mb-4">
              <a href="coursedetails.php?course_id='.$course_id.'" class="btn" style="text-align: left; padding:0px;">
                <div class="card">
                  <img src="'.str_replace('..', '.', $row['course_img']).'" class="card-img-top" alt="Course Image" />
                  <div class="card-body">
                    <h5 class="card-title">'.$row['course_name'].'</h5>
                    <p class="card-text">'.$row['course_desc'].'</p>
                  </div>
                  <div class="card-footer">
                    <p class="card-text d-inline">Price: <small><del>&#8377 '.$row['course_original_price'].'</del></small> 
                    <span class="font-weight-bolder">&#8377 '.$row['course_price'].'<span></p> 
                    <a class="btn '.$buttonClass.' text-white font-weight-bolder float-right" href="'.$buttonLink.'">'.$buttonText.'</a>
                  </div>
                </div>
              </a>
            </div>
          ';
        }
      }
    ?> 
    </div><!-- End All Course Row -->   
  </div><!-- End All Course -->   
 
<?php 
  // Contact Us
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
              if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                  $s_img = $row['stu_img'];
                  $n_img = str_replace('../','',$s_img)
            ?>
              <div class="testimonial">
                <p class="description">
                <?php echo $row['f_content'];?>  
                </p>
                <div class="pic">
                  <img src="<?php echo $n_img; ?>" alt=""/>
                </div>
                <div class="testimonial-prof">
                  <h4><?php echo $row['stu_name']; ?></h4>
                  <small><?php echo $row['stu_occ']; ?></small>
                </div>
              </div>
              <?php }} ?>
            </div>
          </div>
        </div>
    </div>  <!-- End Students Testimonial -->

    <div class="container-fluid bg-danger"> <!-- Start Social Follow -->
        <div class="row text-white text-center p-1">
        </div>
    </div>

<?php 
  // Footer Include from mainInclude 
  include('./mainInclude/footer.php'); 
?>
