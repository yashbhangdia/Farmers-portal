<?php
session_start();
include("config.php");

$farmer = $_SESSION['username'];
$query= mysqli_query($conn,"SELECT * FROM farmer WHERE  username='$farmer'");
$row = mysqli_fetch_array($query);
$fid = $row['farmerid'];

if(isset($_POST['delete']))
{
  $id = $_POST['delete'];
  echo $id;


  // sql to delete a record
  $sql = "DELETE FROM myshop WHERE prodid = $id"; 
  
  if (mysqli_query($conn, $sql)) {
      mysqli_close($conn);
      header('Location: myshop.php'); //If book.php is your main page where you list your all records
      exit;
  } else {
      echo "Error deleting record";
  }
 

}


if(isset($_POST['update']))
{
  $id = $_POST['update'];
  
  $quantity = $_POST['quantity'];
  $price = $_POST['price'];
  

  // sql to delete a record
  $sql = "UPDATE myshop SET quantity='$quantity' ,price='$price' WHERE prodid=$id AND farmerid=$fid ";
  
  if (mysqli_query($conn, $sql)) {
      mysqli_close($conn);
      header('Location: myshop.php'); 
      exit;
  } 
  else {
    die('Could not update data: ');
  }
 

}