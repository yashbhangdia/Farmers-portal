<?php
include('config.php');

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}

if(isset($_POST['add']))
{
  $key = $_POST['add'];
  $array = explode(",",$key,2);
  $pid = $array[0];
  $fid = $array[1];
  $cname = $_SESSION['username'];
  // $price = $_POST['price'];
  // echo $fname;

  $sql2 = mysqli_query($conn,"SELECT * FROM users WHERE username='$cname'");
  $row = mysqli_fetch_array($sql2);
  $cid = $row["userid"];

  $sql3 = mysqli_query($conn,"SELECT * FROM cart WHERE userid='$cid' and farmerid='$fid' and prodid='$pid' ");
  $row = mysqli_fetch_array($sql3);
  if($row)
  {
    $quantity=$row['cart_quantity']+1;
    $sql1 = "UPDATE cart SET cart_quantity='$quantity' WHERE userid='$cid' and farmerid='$fid' and prodid='$pid'";
    mysqli_query($conn,$sql1);
    if(mysqli_error($conn))
      echo("Errorcode: " . mysqli_errno($conn)); 

    if($row['flag']==0)
    {
      $sql1 = "UPDATE cart SET flag=1 WHERE userid='$cid' and farmerid='$fid' and prodid='$pid'";
      mysqli_query($conn,$sql1);
      if(mysqli_error($conn))
        echo("Errorcode: " . mysqli_errno($conn));
    }

  }
  else
  {
    $quantity=1;
    $sql1 = "INSERT INTO cart VALUES('$cid','$pid','$fid', '$quantity', 1)";
    mysqli_query($conn,$sql1);  
    if(mysqli_error($conn))
      echo("Errorcode: " . mysqli_errno($conn));  
  }
   
  header("Location: ../customer.php#shop");

}


?>