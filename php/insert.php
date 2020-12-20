<?php
include('config.php');

session_start();


if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}

$fname = $_SESSION['username'];
$sql2 = mysqli_query($conn,"SELECT * FROM farmer WHERE username='$fname'");
$row = mysqli_fetch_array($sql2);
$fid = $row["farmerid"];


if(isset($_POST)&& !empty($_POST)){
    if(isset($_POST['add'])){
        $pid=stripslashes(mysqli_real_escape_string($conn,trim($_POST['proid'])));
        echo '<script type="text/javascript">alert("'.$pid.'");</script>';
        $farmerid=stripslashes(mysqli_real_escape_string($conn,trim($fid)));
        $qty=stripslashes(mysqli_real_escape_string($conn,trim($_POST['qty'])));
        $price=stripslashes(mysqli_real_escape_string($conn,trim($_POST['price'])));
        $sql="INSERT INTO myshop VALUES('$pid','$farmerid','$qty','$price')";
        if(mysqli_query($conn,$sql)){
            header("Location: myshop.php");
        }
        die(mysqli_error($conn));
    }
}
?>