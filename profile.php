<?php

include('./php/config.php');

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Customer Profile</title>
	<!-- Meta tags for responsiveness-->
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="./css/profilestyle.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
	
	<nav class="navbar navbar-dark navbar-expand-lg fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="customer.php#shop"><button class="btn mr-5" style="background-color: white;"><i class="fa fa-chevron-left" aria-hidden="true"></i></button></a>
          <a class="navbar-brand" href="#"><img src="./assets/Logokrishi.png" class="img-responsive"></a>
        </div>
        <div class="navtoggle">
	        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	        	<span class="navbar-toggler-icon"></span>
	        </button>
    	</div>
        <div id="navbar" class="collapse navbar-collapse stroke">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="customer.php#shop">Shop</a></li>
            <li class="nav-item"><a class="nav-link" href="#myorders">My Orders</a></li>
            <li class="nav-item"><a class="nav-link" href="./php/logout.php">Log Out</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <?php 
      $uname = $_SESSION['username'];
      $sql = mysqli_query($conn, "SELECT * from users where username='$uname'");
      $row = mysqli_fetch_array($sql);
      $gender = $row['gender'];
    ?>

    <div class="image">
    	<div class="heading text-center">
           <img src="./assets/<?php 
              if(strcmp($gender,"Female")==0)
              {
                echo "woman";
              }
              else
              {
                echo "man";
              }

            ?>.png" class="img-responsive" width="10%">
			   <h1>Hello 
          <?php 
          echo $row['name']; ?></h1>
		  </div>
  		<div class="subhead">
  			<p>Happy Shopping!</p>
  		</div>
    </div>

    <div class="container-fluid" id="myorders" style="padding-top: 7%;">
      <div class="text-center">
        <h1 style="font-weight: 600; font-size: 3.5em; letter-spacing: 2px; color: #34626c;">YOUR ORDERS</h1>
        <hr width="40%" align="text-center" style="border-width: 4px; background-color: #999;">
      </div>

      <?php 
      $status_array = array("Not Accepted", "Accepted", "Dispatched", "In-Transit", "Delivered", "_", "Cancelled by farmer");

      $cid = $row['userid'];
      $sql1 = mysqli_query($conn,"SELECT orderid from myorder where userid='$cid' group by orderid having count(*)>=1");
      while($row1=mysqli_fetch_array($sql1))
      {
          $oid = $row1[0]; ?>

          <div class="order pt-5">
          <div class="row"> 
            <div class="col-lg-4">
              <h1><span style="background-color: #ffd369; border-radius: 10px; padding: 10px;">Order # <?php echo $oid; ?></span></h1>
            </div>
            <div class="col-lg-4 pt-2">
              <h4>
                <?php 
                $sql3 = mysqli_query($conn,"SELECT orderdate from myorder where userid='$cid' and orderid=$oid");
                $row3=mysqli_fetch_array($sql3);
                $date=date_create($row3[0]);
                echo "Date: ",date_format($date,"d/m/Y");
               ?>
               </h4>
            </div>
          </div>
          <div class="row pt-4">

      <?php

          $sql4 = mysqli_query($conn,"SELECT farmerid from myorder where userid='$cid' and orderid='$oid' group by farmerid having count(*)>=1");
          while($row4=mysqli_fetch_array($sql4))
          {
              $fid = $row4[0];
              $sql5 = mysqli_query($conn, "SELECT * from farmer where farmerid='$fid'");
              $row5 = mysqli_fetch_array($sql5);
              $fname = $row5['name']; 
              $sql6 = mysqli_query($conn, "SELECT DISTINCT status from myorder where userid='$cid' and orderid='$oid' and farmerid='$fid'");
              $row6 = mysqli_fetch_array($sql6);
              $status = $row6[0];
              ?>
              <div class="col-lg-4">
                  <div class="farmer table-responsive">
                    <h4>Farmer name: <?php echo $fname; ?> </h4>
                    <h4><span class="
                    <?php
                    switch($status)
                    {
                      case 0:
                        echo "badge badge-secondary";
                        break;
                      case 1:
                        echo "badge badge-info";
                        break;
                      case 2:
                        echo "badge badge-dark";
                        break;
                      case 3:
                        echo "badge badge-warning";
                        break;
                      case 4:
                        echo "badge badge-success";
                        break;
                      case 6:
                        echo "badge badge-danger";
                        break;
                      default:
                        echo "Not Available";
                        break;
                    } 
                    ?>"> <?php echo $status_array[$status]; ?> </span> </h4>
                    <table class="table table-borderless">
              <?php
              $sql7 = mysqli_query($conn, "SELECT * from myorder where userid='$cid' and orderid='$oid' and farmerid='$fid'");
              while(($row7 = mysqli_fetch_array($sql7)))
              {
                  $pid = $row7['prodid'];
                  $sql8 = mysqli_query($conn, "SELECT * from product where prodid='$pid'");
                  $row8 = mysqli_fetch_array($sql8);
                  $pname = $row8['prodname'];
                  $quant = $row7['quantity'];
                  $amount = $row7['amount'];
                  ?>

                  <tr>
                    <td>
                    <?php echo $pname; ?>
                    </td>
                    <td>
                     x <?php echo $quant; ?> (kg)
                    </td>
                    <td>
                    ₹<?php echo $amount; ?>
                    </td>
                  </tr>

              <?php } ?>
              </table>
              </div>
              </div>
          
         <?php } ?>
      </div>
      </div>
      <?php } ?>            
                    
    </div>

    <div class="container-fluid py-2 mt-3" style="background-color: #3797a4; font-weight: 600;">
        <div class="col-lg-12 text-center">
          © 2020 Copyright <a href="#" style="text-decoration: none; color: inherit">KrishiMitra</a>
        </div>
        </div>

    <script type="text/javascript" src="./scripts/cart.js"></script>

</body>
</html>