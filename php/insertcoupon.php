<?php
include('config.php');
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}

$farmer = $_SESSION['username'];
$query= mysqli_query($conn,"SELECT * FROM farmer WHERE  username='$farmer'");
$row = mysqli_fetch_array($query);
$fid = $row['farmerid'];



if(isset($_POST['save']))
{
  $discount = $_POST['discount'];
  $coupon = $_POST['coupon'];
  
  

$sql1 = "INSERT INTO coupon VALUES('$coupon','$fid', '$discount')";
mysqli_query($conn,$sql1);

if(mysqli_error($conn))
   echo " Record insertion error\n";
else
  header("Location: coupons.php");

}

if(isset($_POST['delete']))
{
  $id = $_POST['delete'];
  echo $id;


  // sql to delete a record
  $sql = "DELETE FROM `coupon` WHERE `coupon`.`couponid` = '$id' AND `coupon`.`farmerid` = '$fid'"; 
  
  if (mysqli_query($conn, $sql)) {
      mysqli_close($conn);
      header('Location: coupons.php');
      exit;
  } else {
      echo "Error deleting record";
  }
 

}

if(isset($_POST['update']))
{
  $id = $_POST['update'];
  $discount = $_POST['discount'];
  $coupon = $_POST['coupon'];

  // sql to delete a record
  $sql = "UPDATE `coupon` SET `discount` = '$discount' WHERE `coupon`.`couponid` = '$id' AND `coupon`.`farmerid` = '$fid'"; 
  
  if (mysqli_query($conn, $sql)) {
      mysqli_close($conn);
      header('Location: coupons.php'); 
      exit;
  } 
  else {
    die('Could not update data: ');
  }
 

}




/*$sql2 = "INSERT INTO personal VALUES('11810087','20', 'Yash Bhangdia', 'A','8965047800')";
$sql3 = "INSERT INTO personal VALUES('11810089','21', 'Rashi Bhansali', 'A','8665047802')";
$sql4 = "INSERT INTO personal VALUES('11810090','34', 'Dimple Chandn', 'A','8768046802')";


mysqli_query($connect,$sql2);
mysqli_query($connect,$sql3);
mysqli_query($connect,$sql4);*/

 
?>