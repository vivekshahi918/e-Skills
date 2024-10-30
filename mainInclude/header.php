<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="css/all.min.css">

  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="css/owl.min.css">
  <link rel="stylesheet" type="text/css" href="css/owl.theme.min.css">
  <link rel="stylesheet" type="text/css" href="css/testyslider.css">

  <link rel="stylesheet" type="text/css" href="./css/style.css" />
  <title>e-Skills</title>

  <style>
    .navbar-text {
      min-width: 200px;
      text-align: center;
    }

    .op {
      background-color: #225470;
    }
  </style>
</head>

<body>
  <!-- Start Navigation -->
  <div class="op">
    <nav class="navbar navbar-expand-sm navbar-dark pl-5">
      <a href="index.php" class="navbar-brand">e-Skills</a>
      <span class="navbar-text" id="dynamicText">Learn and Implement</span>
      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="myMenu">
        <ul class="navbar-nav pl-5 custom-nav">
          <li class="nav-item custom-nav-item"><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item custom-nav-item"><a href="courses.php" class="nav-link">Courses</a></li>
          <?php
          session_start();
          if (isset($_SESSION['is_login'])) {
            echo '<li class="nav-item custom-nav-item"><a href="student/studentProfile.php" class="nav-link">My Profile</a></li> <li class="nav-item custom-nav-item"><a href="logout.php" class="nav-link">Logout</a></li>';
          } else {
            echo '<li class="nav-item custom-nav-item"><a href="#login" class="nav-link" data-toggle="modal" data-target="#stuLoginModalCenter">Login</a></li> <li class="nav-item custom-nav-item"><a href="#signup" class="nav-link" data-toggle="modal" data-target="#stuRegModalCenter">Signup</a></li>';
          }
          ?>
          <li class="nav-item custom-nav-item"><a href="#Feedback" class="nav-link">Feedback</a></li>
          <li class="nav-item custom-nav-item"><a href="#Contact" class="nav-link">Contact</a></li>
        </ul>
      </div>
    </nav>
  </div> <!-- End Navigation -->

  <script>
    const phrases = ["See that",
      "Think about",
      "Grow your skills",
      "Master new concepts",
      "Invest in your future",
      "Unlock potential",
      "Challenge yourself",
      "Achieve your goals",
      "Excel in your career",
      "Discover new paths",
      "Become an expert",
      "Enhance your knowledge",
      "Stay ahead",
      "Make progress"
    ];
    let index = 0;

    function changeText() {
      document.getElementById("dynamicText").textContent = phrases[index];
      index = (index + 1) % phrases.length;
    }

    setInterval(changeText, 2500); // 
  </script>
</body>

</html>