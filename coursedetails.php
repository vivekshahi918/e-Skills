<?php
include('./dbConnection.php');
include('./mainInclude/header.php');

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $_SESSION['course_id'] = $course_id;

    $sql = "SELECT * FROM course WHERE course_id = '$course_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo ' 
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="' . str_replace('..', '.', $row['course_img']) . '" class="card-img-top" alt="Course Image" />
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Course Name: ' . $row['course_name'] . '</h5>
                                <p class="card-text">Description: ' . $row['course_desc'] . '</p>
                                <p class="card-text">Duration: ' . $row['course_duration'] . '</p>';

            $stuLogEmail = $_SESSION['stuLogEmail'];
            $checkOrderSql = "SELECT * FROM courseorder WHERE stu_email = '$stuLogEmail' AND course_id = '$course_id' AND status = 'success'";
            $orderResult = $conn->query($checkOrderSql);

            if ($orderResult->num_rows > 0) {
                echo '<a href="http://localhost/e-Skills/student/watchcourse.php?course_id=' . $course_id . '" class="btn btn-success text-white font-weight-bolder float-right">Start Course</a>';
            } else {
                echo '
                    <form action="checkout.php" method="post">
                        <p class="card-text d-inline">Price: <small><del>$ ' . $row['course_original_price'] . '</del></small> 
                        <span class="font-weight-bolder">$ ' . $row['course_price'] . '</span></p>
                        <input type="hidden" name="id" value="' . $row["course_price"] . '">
                        <button type="submit" class="btn btn-primary text-white font-weight-bolder float-right" name="buy">Buy Now</button>
                    </form>';
            }

            echo '
                            </div>
                        </div>
                    </div>
                </div>';
        }
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <?php
        $lessonSql = "SELECT * FROM lesson WHERE course_id = '$course_id'";
        $lessonResult = $conn->query($lessonSql);

        if ($lessonResult->num_rows > 0) {
            echo '
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Lesson No.</th>
                        <th scope="col">Lesson Name</th>
                    </tr>
                </thead>
                <tbody>';

            $num = 0;
            while ($lessonRow = $lessonResult->fetch_assoc()) {
                $num++;
                echo ' 
                <tr>
                    <th scope="row">' . $num . '</th>
                    <td>' . $lessonRow["lesson_name"] . '</td>
                </tr>';
            }

            echo '</tbody>
            </table>';
        } else {
            echo '<p>No lessons available for this course.</p>';
        }
        ?>
    </div>
</div>

<?php
include('./mainInclude/footer.php');
?>