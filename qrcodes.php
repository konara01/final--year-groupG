<?php
require "lecserver.php";
check_login();
// Retrieve data from the database
$lecturer_id = $_SESSION['lecturer_id']; // Assuming you have stored the lecturer ID in the session
$qrcodes = get_all_qrs($lecturer_id);


?>

<html>  

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<title>Qr scan</title>  
<script src="html5-qrcode.min.js"></script>
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
          .container{
            padding-left: 250px;
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
          <li><a href="timetable.php"><i class="bx bx-user"></i> <span>My schedule</span></a></li>
          <li><a href="qrcodes.php"><i class="bi bi-qr-code-scan"></i> <span>My scanners</span></a></li>
          <li><a href="attend.php"><i class="bi bi-file-text"></i> <span>Attendance</span></a></li>
          <li><a href="logout.php"><i class="bi bi-file-text"></i> <span>Logout</span></a></li>

        </ul>
      </nav>



    </div>
  </header><!-- End Header -->
  
  <div class="container">          
   <div class="table-responsive">  
    <h3 style="align-items: center; ">QR Scanning</h3><br/>
    <div class="box">
    <?php


    // Loop through the data and display it as profile cards
    foreach ($qrcodes as $qrcode) {
    ?>
    <div class="qrcode-card">
        <div class="qrcode-image">
            <img src="<?php echo $qrcode->image_name; ?>" width="30" height="20" alt="Qr code for todays attendance">
        </div>
        <div class="Qrcode-details">
            <h3><?php echo $qrcode->lesson_name; ?></h3>
            <p><strong>Date:</strong> <?php echo $qrcode->date; ?></p>
            <p><strong>Time Required to be:</strong> <?php echo $qrcode->time; ?></p>
            <div class="pick-button">
          <a href="displayqr.php?qrid=<?php echo $qrcode->qrid; ?>">
            <button type="button">Display for Scanning</button>
          </a>
        </div>
          </div>
    </div>
    <?php } ?>
</div>
    </div>
   </div>  
  </div>
 </body>  
</html>  
