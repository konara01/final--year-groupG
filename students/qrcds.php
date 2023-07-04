<?php
require "studserver.php";
check_login();
// Get the student ID from the session
$student_id = $_SESSION['USER']->student_id;
$student_query = "SELECT image FROM students WHERE student_id = ?";
// $student_id = $_SESSION['student_id'];
$qrcodes = get_all_qrcodes($student_id);

$student = database_run($student_query, [$student_id])[0];




?>

<html>  
<head>  
    <title>Qr scan</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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
                .contents {
            padding-left: 400px;
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

      <!-- <img src="../assets/img/profile-img.jpg" alt="" class="img-fluid rounded-circle"> -->
      <!-- <h1 class="text-light"><a href="index.html">Name</a></h1> -->
      <img src="img/<?php echo $student->image; ?>" width="40" height="100" alt="Passport Image">

      <h1>Hi <?=$_SESSION['USER']->student_name?></h1>
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
        <li><a href= "studdashboard.php"><i class="bx bx-home"></i>Home</a></li>
        <li><a href="#about"><i class="bx bx-file-blank"></i> <span>My Report</span></a></li>
        <li><a href="studtimetable.php"><i class="bx bx-user"></i> <span>My schedule</span></a></li>
        <li><a href="qrcds.php"><i class="bi bi-qr-code-scan"></i> <span>My scanners</span></a></li>
        <li><a href="logout.php"><i class="bi bi-qr-code-scan"></i> <span>Logout</span></a></li>

      <!--
        <li><a href="#"><i class="bi bi-file-text"></i> <span>Attendance</span></a></li>
      -->
      </ul>
    </nav>

  </div>
</header><!-- End Header -->
  <div class="contents">          
   <div class="table-responsive">  
    <h3 style="align-items: center; ">QR Scanning</h3><br/>
    <div class="box">
    <?php
    // Retrieve data from the database
    // $qrcodes = get_all_qrcodes();

    // Loop through the data and display it as profile cards
    foreach ($qrcodes as $qrcode) {
    ?>
    <div class="qrcode-card">
        <div class="Qrcode-details">
            <h3><?php echo $qrcode->lesson_name; ?></h3>
            <p><strong>Date:</strong> <?php echo $qrcode->date; ?></p>
            <p><strong>Time Required to be:</strong> <?php echo $qrcode->time; ?></p>
        </div>
        <div class="qrcode-actions">
            <a href="scannow.php?qrid=<?php echo $qrcode->qrid; ?>&student_id=<?php echo $student_id; ?>" class="book-button">Scan QrCode</a>
        </div>
    </div>
    <?php } ?>
</div>
    </div>
   </div>  
  </div>
 </body>  
</html>  
