<?php
require "studserver.php";
check_login();
// Get the student ID from the session
$student_id = $_SESSION['USER']->student_id;

// $student = database_run($student_query, [$student_id])[0];
// Get the maid ID from the URL parameter
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
}
// Get the maid ID from the URL parameter
if (isset($_GET['qrid'])) {
    $qrid = $_GET['qrid'];
}
$student_query = "SELECT student_id, student_name FROM students WHERE student_id = ?";
$student = database_run($student_query, [$student_id])[0];


$qrcode_query = "SELECT qrid, lecturer_id, lesson_id, lesson_name, date, time, image_name FROM qrcode WHERE qrid = ?";
$qrcode = database_run($qrcode_query, [$qrid])[0];

?>

<html>  
<head>  
    <title>Qr scan</title>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>  
    <link rel="stylesheet" type="text/css" href="css/style.css/">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="../lecturers/html5-qrcode.min.js"></script>

</head>
<body> 
<style>
  .result {
    background-color: green;
    color: #fff;
    padding: 20px;
  }
  .row {
    display: flex;
  }
</style>

<div class="row">
  <div class="col">
    <div style="width: 400px;" id="reader"></div>
  </div>
  <form method="post" id="attendanceForm" action="qrserver.php">
  <div class="Qrcode-details">
    <input type="hidden" name="qrid" id="qrid" value="<?php echo $qrcode->qrid; ?>">
    <input type="hidden" name="lecturer_id" id="lecturer_id" value="<?php echo $qrcode->lecturer_id; ?>">
        <input type="hidden" name="student_id" id="student_id" value="<?php echo $student->student_id; ?>">
        <input type="hidden" name="student_name" id="student_name" value="<?php echo $student->student_name; ?>">
        <input type="hidden" name="lesson_id" id="lesson_id" value="<?php echo $qrcode->lesson_id; ?>">
       <input type="hidden" name="lesson_name" id="lesson_name" value="<?php echo $qrcode->lesson_name; ?>">
        <h3><?php echo $qrcode->lesson_name; ?></h3>
                    
            <p><strong>Date:</strong> <?php echo $qrcode->date; ?></p>
            
            <p><strong>Time Required to be:</strong> <?php echo $qrcode->time; ?></p>
        </div>
  </form>
  <div class="col" style="padding: 30px;">
    <h4>SCAN RESULT</h4>
    <div id="result">Result Here</div>
  </div>
</div>


<script>
  // Initialize the QR code scanner
  var html5QrcodeScanner = new Html5QrcodeScanner("reader", {
    fps: 10, // Number of frames per second to scan the QR code
    qrbox: 250 // Size of the QR code scanner box
  });

function onScanSuccess(qrCodeMessage) {
  // Retrieve the form element
  var form = document.getElementById("attendanceForm");

  // Submit the form
  form.submit();
}

  // Start scanning the QR code
  html5QrcodeScanner.render(onScanSuccess);
</script>
