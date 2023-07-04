<?php
require "studserver.php";
check_login();

// Retrieve the submitted form data
$qrid = $_POST['qrid'];
$lecturer_id = $_POST['lecturer_id'];
$student_id = $_POST['student_id'];
$student_name = $_POST['student_name'];
$lesson_id = $_POST['lesson_id'];
$lesson_name = $_POST['lesson_name'];

// Insert the data into the "attended_students" table
$insert_query = "INSERT INTO attended_students (qrid, lecturer_id, student_id, student_name, lesson_id, lesson_name) VALUES (?, ?, ?, ?, ?, ?)";
database_run($insert_query, [$qrid, $lecturer_id, $student_id, $student_name, $lesson_id, $lesson_name]);

// Redirect to a success page or do any other necessary actions
header("Location: studdashboard.php");
exit();
?>
