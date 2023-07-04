<?php
    require_once('../adminserver.php');


    if(isset($_POST['delete_students'])) {
        $student_id = $_POST['student_id'];
        delete_students($student_id);
        header("Location: students.php");
        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete users</title>
    <style>
        body{
    background: lightgray ;
    

}

.container{
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 90vh;
}

.box{
    background: white;
    display: flex;
    flex-direction: column;
    padding: 25px 25px;
    border-radius: 15px;
    box-shadow:
  16.7px 10.2px 1.4px rgba(0, 0, 0, 0.008),
  25.9px 15.7px 3.3px rgba(0, 0, 0, 0.016),
  30.2px 18.3px 6.1px rgba(0, 0, 0, 0.025),
  33.4px 20.3px 10.9px rgba(0, 0, 0, 0.033),
  43.1px 26.2px 20.5px rgba(0, 0, 0, 0.042),
  135px 82px 49px rgba(0, 0, 0, 0.05)

}

.form-box{
    width: 450px;
    margin: 0px 10px;
    
}

.box, .form-box{
    margin: -3em 0 0 0%;

}
        /* Styles for the Edit button */
        .nodelete{
            background-color: darkgreen;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
        }

        /* Styles for the Delete button */
        .yesdelete {
            background-color: orangered;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            margin-left: 25%;
        }

        </style>
</head>
<body>
<div class="container">

<div class="box form-box">

    <div class="field ">
    <h2>Confirm Deletion</h2>
    <form method="post">
        <p>Are you sure you want to delete this Driver?</p>
        <input type="hidden" name="student_id" value="<?php echo $_GET['student_id']; ?>">
        <button type="submit" name="delete_students" class="yesdelete">Yes, delete</button>
        <a href="students.php" class="nodelete">No, cancel</a>
    </form>
</body>
</html>
