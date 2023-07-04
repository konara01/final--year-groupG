<?php

require "lecserver.php";


?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>  Userprofile  </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../asset/css/style2.css" rel="stylesheet">
<style>
            div.content {
            margin-left: 200px;
            padding: 1px 160px;
            height: 1000px;
        }
    /* CSS code for the table */
    table {
        border-collapse: collapse;
        width: fit-content;
        margin-top: 20px;
      }

      th, td {
        text-align: left;
        padding: 8px;
      }

      th {
        background-color: #f0d69f;
        color: black;
      }

      tr:nth-child(even) {
        background-color: #f2f2f2;
      }

      tr:hover {
        background-color: #ddd;
      }
</style>
</head>
<body>

  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="d-flex flex-column">

      <div class="profile">

        <img src="../assets/img/profile-img.jpg" alt="" class="img-fluid rounded-circle">

        <h1 class="text-light"><a href="index.html">prof.</a></h1>
        <div class="social-links mt-3 text-center">
         <!--
          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
          <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        -->
        </div>
      </div>

      <nav id="navbar" class="nav-menu navbar">
        <ul>
          <li><a href= "lectdashboard.php"><i class="bx bx-home"></i>Home</a></li>
          <li><a href="#"><i class="bx bx-file-blank"></i> <span>My Report</span></a></li>
          <li><a href="timetable.php"><i class="bx bx-user"></i> <span>My schedule</span></a></li>
          <li><a href="qrcodes.php"><i class="bi bi-qr-code-scan"></i> <span>My scanners</span></a></li>
          <li><a href="attend.php"><i class="bi bi-file-text"></i> <span>Attendance</span></a></li>
          <li><a href="logout.php"><i class="bi bi-file-text"></i> <span>Logout</span></a></li>

        </ul>
      </nav>



    </div>
  </header><!-- End Header -->


<div class="container">

 <nav>
     <input type="checkbox" id="check">
     <label for="check" class="checkbtn">
        <i class="fa fa-reorder"></i>
     </label>

</div>
<div class="content">

<h1>Students Dashboard</h1>
    <table>
      <thead>
    <tr>
        <th>ID</th>
      <th>Full Name</th>
      <th>Lesson Name</th>

    </tr>
  </thead>
  <tbody>
    <?php
    // Retrieve data from the database
    $students = get_total_studentsreg();
    
    // Loop through the data and display it in the table
    foreach  ($students as $student) {
      echo "<tr>";
      echo "<td>" . $student->student_id . "</td>";
      echo "<td>" . $student->student_name . "</td>";
      echo "<td>" . $student->lesson_name . "</td>";
      echo "<td>";
    echo "</td>";
      echo "</tr>";
    }
    ?>
  