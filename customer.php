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
	<title>Customer</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <link rel="stylesheet" type="text/css" href="./css/customstyle1.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"><img src="./assets/Logokrishi.png" class="img-responsive"></a>
        </div>
        <div class="navtoggle">
	        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	        	<span class="navbar-toggler-icon"></span>
	        </button>
    	</div>
        <div id="navbar" class="collapse navbar-collapse stroke">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="#shop">Shop</a></li>
            <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
            <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="./php/logout.php">Log Out</a></li>
          </ul>
        </div>
      </div>
    </nav>

	<div class="image">
		<h1 class="heading">Products Made With Love</h1>
		<p><a href="#shop"><button class="btn btn-large buy">Shop Now</button></a></p>
	</div>

	<div id="about" class="about row m-0">
		<div class="col-lg-3">
			<div class="row m-0">
				<div class="col-lg-4">
					<h1>01</h1>
				</div>
				<div class="col-lg-5 abouticon">
					<img src="./assets/vegetable.svg" class="img-responsive" width="100%">
				</div>
			</div>
			<div>
				<h4>ALWAYS FRESH</h4>
			</div>
			<div>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="row">
				<div class="col-lg-4"><h1>02</h1></div>
				<div class="col-lg-5 abouticon">
					<img src="./assets/plant.svg" class="img-responsive" width="100%">
				</div>
			</div>
			<div>
				<h4>100% ORGANIC</h4>
			</div>
			<div>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="row">
				<div class="col-lg-4"><h1>03</h1></div>
				<div class="col-lg-5 abouticon">
					<img src="./assets/fertilizer.svg" class="img-responsive" width="100%">
				</div>
			</div>
			<div>
				<h4>NO ADDITIVES</h4>
			</div>
			<div>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="row">
				<div class="col-lg-4"><h1>04</h1></div>
				<div class="col-lg-5 abouticon">
					<img src="./assets/orchard.svg" class="img-responsive" width="100%">
				</div>
			</div>
			<div>
				<h4>MODERN FARM</h4>
			</div>
			<div>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>
	</div>

	<div class="container-fluid" id="shop" style="padding-top: 10%;">
		<div class="heading">
			<h1 align="center">OUR  PRODUCTS</h1>
		</div>
		<div class="subhead">
			<p>Fresh from the Farm!</p>
		</div>
	</div>

	<?php
		require_once "./php/config.php";
		$results = mysqli_query($conn, "SELECT * from product");
	?>

	<div class="container-fluid py-3">
		<!-- <div class="row prod m-0"> -->
		<?php
		$i=0;
		while($row = mysqli_fetch_array($results))
		{
				if($i%3==0)
				{ ?>
					<div class="row prod m-0 py-3">
				<?php } ?>
				
				<div class="product col-lg-4">
				<div class="card">
					<img class="card-img-top" src="./assets/<?php echo $row["prodname"]; ?>.png" alt="Card image cap">
					<div class="card-body">
						<h5 class="card-title" id=<?php echo $row['prodid']; ?> > <?php echo $row['prodname']; ?> </h5>
						<p class="card-text py-2"><?php 
							$prodid = $row['prodid'];
							$res = mysqli_query($conn, "SELECT * from myshop where prodid='$prodid' and price = (select min(price) from myshop where prodid='$prodid')");
							$row1 = mysqli_fetch_array($res);
							if($row1)
							{
								echo "₹",$row1['price'], " per kg";	
							}
							else
							{
								echo "Out Of Stock";
							}
							
						?></p>
						<form id="addcart" action="http://localhost/Farmer/php/addtocart.php" method="post">
							<button name="add" class="btn addtocart" value="<?php echo $row['prodid'],",",$row1['farmerid'],",",$row1['price']; ?>" onclick="adding('<?php echo $row['prodname']; ?>')">
								<span><i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i></span>
							</button>
						</form>
					</div>
				</div>
				</div>
				<?php if($i%3==2)
				{ ?>
					</div>
				<?php } ?>

				<?php $i++; ?>

		<?php } ?>
	</div>

	<div class="container-fluid text-center mt-5">
		<a href="cart.php"><button class="btn" style="font-weight: 600; padding: 20px; background-color: #ffcd3c;">GO TO CART <span><i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i></span></button></a>
	</div>

	<div class="container-fluid py-2 mt-5" style="background-color: #216353; font-weight: 600;">
    	<div class="col-lg-12 text-center">
    		© 2020 Copyright <a href="#" style="text-decoration: none; color: inherit">KrishiMitra</a>
    	</div>
    </div>

    <script type="text/javascript">
    	function adding(prod)
    	{
    		alert("1 kg "+prod+" added to cart");
    	}
    </script>

	<script type="text/javascript" src="./scripts/customscript.js"></script>

</body>
</html>