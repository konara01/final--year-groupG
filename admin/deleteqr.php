<?php
    require_once('adminserver.php');


    if(isset($_POST['delete_qr'])) {
        $qrid = $_POST['qrid'];
        delete_qr($qrid);
        header("Location: report.php");
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
        <p>Are you sure you want to delete this qrcode?</p>
        <input type="hidden" name="qrid" value="<?php echo $_GET['qrid']; ?>">
        <button type="submit" name="delete_qr" class="yesdelete">Yes, delete</button>
        <a href="student.php" class="nodelete">No, cancel</a>
    </form>
</body>
</html>
