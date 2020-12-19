<?php
include('config.php');

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}


if(isset($_POST['add']))
{
  $pid = $_POST['prodid'];
  $fname = $_SESSION['username'];
  $quantity=$_POST['quantity'];
  $price = $_POST['price'];
  echo $fname;

  $sql2 = mysqli_query($conn,"SELECT * FROM farmer WHERE username='$fname'");
  $row = mysqli_fetch_array($sql2);
  $fid = $row["farmerid"];

$sql1 = "INSERT INTO myshop VALUES('$pid','$fid','$quantity','$price')";
mysqli_query($conn,$sql1);

if(mysqli_error($conn))
    echo("Errorcode: " . mysqli_errno($conn));
   
else
  header("Location: welcomefarmer.php");

}
?>