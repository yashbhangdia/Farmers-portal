<?php
include('config.php');

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}

if(isset($_POST['confirm']))
{
	$cname = $_SESSION['username'];
	$sql = mysqli_query($conn,"SELECT * FROM users WHERE username='$cname'");
	$row = mysqli_fetch_array($sql);
	$cid = $row["userid"];

	$sql2 = mysqli_query($conn,"SELECT * from myorder where orderid=(select max(orderid) FROM myorder)");
	$row2 = mysqli_fetch_array($sql2);
	$orderid = "";
	if($row2)
	{
		$orderid = $row2['orderid'] + 1;  //if already exists
	}
	else
	{
		$orderid = 1;	//first order
	}
	$results = mysqli_query($conn, "SELECT * from cart where userid=$cid and flag=1");

	while($row = mysqli_fetch_array($results))
	{
		$pid = $row['prodid'];
		$fid = $row['farmerid'];	
		$sql1 = mysqli_query($conn,"SELECT * FROM myshop WHERE prodid='$pid' and farmerid='$fid'");
		$row1 = mysqli_fetch_array($sql1);
		$price = $row1['price'];
		$quantity = $row['cart_quantity'];
		$total = $price*$quantity;
		
		$sql3 = mysqli_query($conn, "INSERT into myorder values('$orderid', '$cid', '$pid', '$fid', '$total', 0, '$quantity', now())");
		if(mysqli_error($conn))
      		echo("Errorcode: " . mysqli_errno($conn)); 
	}

	$results = mysqli_query($conn, "SELECT * from cart where userid=$cid and flag=1");
	while($row = mysqli_fetch_array($results))
	{
		$pid = $row['prodid'];
		$fid = $row['farmerid'];
		$sql4 = "UPDATE cart SET cart_quantity=0, flag=0 WHERE userid='$cid' and farmerid='$fid' and prodid='$pid'";
  	    mysqli_query($conn,$sql4);
	    if(mysqli_error($conn))
	      echo("Errorcode: " . mysqli_errno($conn));	
	}

	header("Location: ../profile.php#myorders");
}

?>