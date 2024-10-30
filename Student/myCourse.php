<?php
if (!isset($_SESSION)) {
    session_start();
}
define('TITLE', 'My Course');
define('PAGE', 'mycourse');
include('./stuInclude/header.php');
include_once('../dbConnection.php');

if (isset($_SESSION['is_login'])) {
    $stuLogEmail = $_SESSION['stuLogEmail'];
    error_log("Logged-in user email: $stuLogEmail");
} else {
    echo "<script> location.href='../index.php'; </script>";
}
?>

<div class="col-sm-7 mt-6 ml-5">
    <div class="row">
        <div class="jumbotron">
            <h4 class="text-center">All Courses</h4>
            <?php
            if (isset($stuLogEmail)) {
                $sql = "SELECT co.order_id, c.course_id, c.course_name, c.course_duration, c.course_desc, c.course_img, c.course_author, c.course_original_price, c.course_price 
                        FROM courseorder AS co 
                        JOIN course AS c ON c.course_id = co.course_id 
                        WHERE co.stu_email = '$stuLogEmail'";

                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="bg-light mb-3">
                            <h5 class="card-header"><?php echo htmlspecialchars($row['course_name']); ?></h5>
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="<?php echo htmlspecialchars($row['course_img']); ?>" class="card-img-top mt-4" alt="Course Image">
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="card-body">
                                        <p class="card-title"><?php echo htmlspecialchars($row['course_desc']); ?></p>
                                        <small class="card-text">Duration: <?php echo htmlspecialchars($row['course_duration']); ?></small><br />
                                        <small class="card-text">Instructor: <?php echo htmlspecialchars($row['course_author']); ?></small><br />
                                        <p class="card-text d-inline">Price: <small><del>&#8377 <?php echo htmlspecialchars($row['course_original_price']); ?></del></small>
                                            <span class="font-weight-bolder">&#8377 <?php echo htmlspecialchars($row['course_price']); ?></span>
                                        </p>
                                        <a href="watchcourse.php?course_id=<?php echo htmlspecialchars($row['course_id']); ?>" class="btn btn-primary mt-5 float-right">Watch Course</a>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php }
                } else {
                    if ($result) {
                        echo "<p class='text-center'>You have not enrolled in any courses yet.</p>";
                    } else {
                        echo "<p class='text-center'>Error retrieving courses: " . $conn->error . "</p>";
                    }
                }
            }
            ?>
            <hr />
        </div>
    </div>
</div>

</div>
<?php
include('./stuInclude/footer.php');
?>