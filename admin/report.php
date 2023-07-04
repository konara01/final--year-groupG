<?php

require "adminserver.php";
check_login();
// Get the customer ID from the session
$admin_id = $_SESSION['USER']->admin_id;
// Get customer and maid information

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>  Adminprofile  </title>

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
  <style type="text/css">
           *{
               padding: 0;
               margin: 0;
               text-decoration: none;
               list-style: none;
               box-sizing: border-box; 
           }
           body{
                background-color: lightgray;
                padding-top: 80px;
                font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            }
            

            .checkbtn{
                font-size: 30px;
                color: black;
                float: right;
                line-height: 80px;
                margin-right: 40px;
                cursor: pointer;
                display: none;
            }

            #check{
                display: none;

            }
           

        div.content {
            margin-left: 200px;
            padding: 1px 200px;
            height: 1000px;
        }
        .wrap{
          padding: 250px;
   border-radius: 10px;
   padding: 12px;
   background-color: #ce955194;
   max-width: fit-content;
        }


      /* CSS code for the table */
      table {
        border-collapse: collapse;
        width: fit-content;
        margin-top: 20px;
        border-radius: 10px;

      }

      th, td {
        text-align: left;
        padding: 8px;
        /* border-radius: 10px; */

      }

      th {
        background-color: #0663e0d4;
        color: black;

      }

      tr:hover {
        background-color: #ddd;
      }
      /* Styles for the Edit button */
      .edit-button {
          
            background-color: #111110;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        /* Styles for the Delete button */
        .delete-button {
            background-color: #c5cacf;
            color: #111110;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        </style>
        
    </head>


  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="d-flex flex-column">

      <div class="profile">

        <!-- <img src="../assets/img/profile-img.jpg" alt="" class="img-fluid rounded-circle"> -->
        <!-- <h1 class="text-light"><a href="index.html">Name</a></h1> -->

        <h1>Hi <?=$_SESSION['USER']->admin_name?></h1>
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
        <li><a href= "admin.php"><i class="bx bx-home"></i>Dashboard</a></li>
          <li><a href="students/students.php"><i class="bx bx-user"></i> <span>Students</span></a></li>
          <li><a href="lecturers/lecturers.php"><i class="bx bx-user"></i> <span>Lecturers</span></a></li>
          <li><a href="report.php"><i class="bx bx-user"></i> <span>Report</span></a></li>
          <li><a href="logout.php"><i class="bx bx-user"></i> <span>Logout</span></a></li>

        <!--
          <li><a href="#"><i class="bi bi-file-text"></i> <span>Attendance</span></a></li>
        -->
        </ul>
      </nav>



    </div>
  </header><!-- End Header -->

  <div class="content">
  
  
  <div class="wrap">
<table>
      <h1>Qrs generated</h1>
      <thead>
    <tr>
    <th>QRid</th>
      <th>QR image</th>
      <th>Lesson name</th>
      <th>Date</th>
      <th>Time</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    // Retrieve data from the database
    $qrcodes = get_all_qrcodes();
    
    // Loop through the data and display it in the table
    foreach ($qrcodes as $qrcode) {
      echo "<tr>";
      echo "<td>" . $qrcode->qrid . "</td>";
      echo "<td><img src='../lecturers/" . $qrcode->image_name . "' width='150' height='120' alt='Passport Image'></td>";
      echo "<td>" . $qrcode->lesson_name . "</td>";
      echo "<td>" . $qrcode->date . "</td>";
      echo "<td>" . $qrcode->time . "</td>";
      echo "<td>";
      echo "<a href='deleteqr.php?qrid=" . $qrcode->qrid . "' onclick='return confirm(\"Are you sure you want to delete this user?\")' class='edit-button'>Delete</a>";
      echo "</td>";
      echo "</tr>";
    }
    ?>
  </tbody>
</table>



<table>
      <h1>Qrs generated</h1>
      <thead>
    <tr>
    <th>QRid</th>
    <th>Student Name</th>
    <th>Lesson name</th>
      <th>Date and Time entered</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    // Retrieve data from the database
    $attend = get_total_submitted_attendance();
    
    // Loop through the data and display it in the table
    foreach ($attend as $atten) {
      echo "<tr>";
      echo "<td>" . $qrcode->qrid . "</td>";
      echo "<td>" . $atten->student_name . "</td>";
      echo "<td>" . $atten->lesson_name . "</td>";
      echo "<td>" . $atten->datetime . "</td>";
      echo "<td>";
      echo "<a href='displayqr.php?qrid=" . $atten->id . "' onclick='return confirm(\"Are you sure you want to delete this user?\")' class='edit-button'>Delete</a>";
      echo "</td>";
      echo "</tr>";
    }
    ?>
  </tbody>
</table>


