<?php 

require "studserver.php";
check_login();
// Get the customer ID from the session
$student_id = $_SESSION['USER']->student_id;
// Get customer and maid information
$student_query = "SELECT image FROM students WHERE student_id = ?";

$student = database_run($student_query, [$student_id])[0];


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>My Dashboard</title>


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


  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

    <!-- ======= Facts Section ======= -->
    <section id="facts" class="facts">
      <div class="container">

        <div class="section-title">
          <h2>Report</h2>
          <p></p>
        </div>

        <div class="row no-gutters">
        <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="count-box">
              <i class="bi bi-collection"></i>
          <span data-purecounter-start="0" data-purecounter-end="<?php echo get_total_studcourse(); ?>" data-purecounter-duration="1" class="purecounter"></span>
          <p><strong>Total Courses registered</strong></p>
          <p><?php echo get_total_studcourse(); ?></p>
        </div>
      </div>

 
          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="count-box">
              <i class="bi bi-qr-code"></i>
              <span data-purecounter-start="0" data-purecounter-end="<?php echo get_total_scanned_codes(); ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Total scanned codes</strong></p>
              <p><?php echo get_total_scanned_codes(); ?></p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="300">
            <div class="count-box">
              <i class="bi bi-stack"></i>
              <span data-purecounter-start="0" data-purecounter-end="<?php echo get_total_submitted_attendance(); ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Total submitted attendance</strong></p>
              <p><?php echo get_total_submitted_attendance(); ?></p>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Facts Section -->

    
    <section id="services" class="services">
      <div class="container">

        <div class="section-title">
        <!--  <h2>My schedule</h2>
         -->
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 icon-box" data-aos="fade-up">
            <div class="icon"><i class="bi bi-briefcase"></i></div>
            <h4 class="title"><a href="studtimetable.php">My schedule</a></h4>
            <p class="description">Click my schedule link to see the time table for the present day </p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
            <div class="icon"><i class="bi bi-card-checklist"></i></div>
            <h4 class="title"><a href="coursereg.php">Course registered</a></h4>
            <p class="description">Click the course registered link to register or view courses which you registered  </p>
          </div>
         <!--
          <div class="col-lg-4 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
            <div class="icon"><i class="bi bi-bar-chart"></i></div>
            <h4 class="title"><a href="">Student Registered</a></h4>
            <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
          </div>
        -->
          <div class="col-lg-4 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
            <div class="icon"><i class="bi bi-binoculars"></i></div>
            <h4 class="title"><a href="qrcds.php">Scan QR code</a></h4>
            <p class="description">Click the link to scan QR code displayed for taking attendance </p>
          </div>
         
         <!--

          <div class="col-lg-4 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
            <div class="icon"><i class="bi bi-brightness-high"></i></div>
            <h4 class="title"><a href="">Nemo Enim</a></h4>
            <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
            <div class="icon"><i class="bi bi-calendar4-week"></i></div>
            <h4 class="title"><a href="">Eiusmod Tempor</a></h4>
            <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi</p>
          </div>
        </div>
-->
      </div>
    </section>

   
    <!-- 
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row" data-aos="fade-in">

          <div class="col-lg-5 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>Kijitonyama, Dar es salaam , Tanzania</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>danielkonara25@gmail.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>+255 692983642</p>
              </div>

              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
            </div>

          </div>

          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="name">Your Name</label>
                  <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="name">Your Email</label>
                  <input type="email" class="form-control" name="email" id="email" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Subject</label>
                <input type="text" class="form-control" name="subject" id="subject" required>
              </div>
              <div class="form-group">
                <label for="name">Message</label>
                <textarea class="form-control" name="message" rows="10" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section> 

     -->

  </main>


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/purecounter/purecounter.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/typed.js/typed.min.js"></script>
  <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>