<?php
//This script will handle login
session_start();
 
// check if the user is already logged in
if(isset($_SESSION['username']) )
{
  $msg=$_SESSION['type'];
  
    if(strcmp($msg,"farmer")==0)
    {
    
    header("location: php/welcomefarmer.php");
    exit;
    }
    else{
      header("location: customer.php");
      exit;
    }
}
require_once "./php/config.php";
 
$username = $password = "";
$err = "";
 
// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
 
     if(!isset($_POST['farmer']))
      {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
        {
            $err = "Please enter username + password";
            die($err);
        }        
      } 
      else {
        $username = trim($_POST['farmername']);
        $password = trim($_POST['fpassword']);
        if(empty(trim($_POST['farmername'])) || empty(trim($_POST['fpassword'])))
        {
            $err = "Please enter username + password";
            die($err);
        }   
        
      }
 
if(empty($err))
{
  if(!isset($_POST['farmer']))
  {
    $sql = "SELECT userid, username, password FROM users WHERE username = ?";
  } 
  else {
    $sql = "SELECT farmerid, username, password FROM farmer WHERE username = ?";
  }
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;
 
                            //Redirect user to welcome page
                            echo '<script>alert("Successful login")</script>';
 
                            if(!isset($_POST['farmer']))
                            {
                              $_SESSION["type"] = "user";
                              header("location: customer.php");
                            } 
                            else {
                              header("location: ./php/welcomefarmer.php");
                              $_SESSION["type"] = "farmer";
                            }       
                        }
                    }
                }
    }
}

}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Farmer Website</title>
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
    <link rel="stylesheet" type="text/css" href="./css/indexstyle.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

	<nav class="navbar navbar-dark navbar-expand-lg fixed-top">
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
            <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
            <li class="nav-item"><a class="nav-link" href="#blogs">Blogs</a></li>
            <li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#at-login" style="cursor: pointer;">Log In</a></li>
            <li class="nav-item"><a class="nav-link" href="./php/register.php">Register</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="at-login-form">
    <div class="modal fade" id="at-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content wrapper">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> 
			</div>
			<div class="modal-body">
					<div class="title-text">
					<div class="title login">
			        Farmer Login
			      </div>
			      <div class="title signup">
			        Customer Login
			      </div>
			    </div>
				    <div class="form-container">
				        <div class="slide-controls">
				          <input type="radio" name="slide" id="login" checked>
				          <input type="radio" name="slide" id="signup">
				          <label for="login" class="slide login">Farmer</label>
				          <label for="signup" class="slide signup">Customer</label>
				          <div class="slider-tab">
				        </div>
				    </div>
				    <div class="form-inner">
				        <form action="#" class="login" method="post">
				            <div class="field">
				              <input type="text" placeholder="Email Address" name="farmername" required>
				            </div>
				            <div class="field">
				              <input type="password" placeholder="Password" name="fpassword" required>
				            </div>
				            <div class="pass-link">
				              <a href="#">Forgot password?</a></div>
				              <div class="field btn">
				                <div class="btn-layer">
				                </div>
				                <input type="submit" value="Sign in" name="farmer">
				            </div>
				            <div class="signup-link">
				                Not a member? <a href="./php/register.php">Signup now</a>
				            </div>
				        </form>
				        <form action="#" class="login" method="post">
				            <div class="field">
				                <input type="text" placeholder="Email Address" name="username" required>
				            </div>
				            <div class="field">
				                <input type="password" placeholder="Password" name="password" required>
				            </div>
				            <div class="pass-link">
				              <a href="#">Forgot password?</a>
				            </div>
				            <div class="field btn">
				                <div class="btn-layer">
				                </div>
				                <input type="submit" value="Sign in" name="user">
				            </div>
				            <div class="signup-link">
				              Not a member? <a href="./php/register.php">Signup now</a>
				            </div>
				        </form>
				      </div>
				    </div>
				</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</section>

	<div class="image text-center">
	   <h1 class="heading">Products Made With Love</h1>
	   <img src="./assets/hands.png">
	</div>

	<div id="about" class="about row m-0">
		<div class="col-lg-12">
			<h1>What We Do</h1>
	   		<p>Marginal farmers often struggle with the historic obstacle of technological isolation and have zero access to educational, scientific information and the market. KrishiMitra connects Farmers to Customers directly, eliminating the middlemen and empowering the Farmers. We bring products right from the farm to your kitchen. Krishi Mitra is a platform for customers to buy farm fresh products at their best prices online.</p>
		</div>
	</div>

	<div id="blogs" class="container-fluid info">
		<h1>Blogs</h1>
		<div class="bloghead"><h3>Eco-Friendly Practices</h3></div>
		<div class="row py-3 px-5">
			<div class="col-lg-4 blogimg">
		   		<img class = "img-responsive" src="https://blogs.worldbank.org/sites/default/files/blogs-images/2019-09/digital_agriculture3.jpg" width = "100%">
		   </div>
		   <div class="col-lg-8 blogtext">
		   		<h2>Eco-Friendly Practices</h2>
		   		<p style="padding: 1.5em 1em 1em 0em;">World needs, eco-friendly farming systems for sustainable agriculture. This is the need of the present day. There is an urgent need to develop farming techniques, which are sustainable from environmental, production, and socioeconomic points of view. The means to guarantee sufficient food production in the next decades and beyond is critical because modern agriculture production throughout the world does not appear to be sustainable in the long-term.
		   		<span><a href="https://biocyclopedia.com/index/medicinal_plants/cultivation/eco-friendly_farming.php">Read More >></a></span></p>
		   </div>
		</div>
		<hr width="90%" style="background-color: #fefefe;">
		<div class="bloghead"><h3>Top Government Schemes</h3></div>
		<div class="row py-3 px-5">
		   <div class="col-lg-8 blogtext">
		   		<h2>Top Government Schemes</h2>
		   		<p style="padding: 1.5em 1em 1em 0em;">The Pradhan Mantri Krishi Sinchayee Yojana (PMKSY) was launched during the year 2015-16 with the motto of ‘Har Khet Ko Paani’ for providing end-to end solutions in irrigation supply chain, viz. water sources, distribution network and farm level applications. The PMKSY not only focuses on creating sources for assured irrigation, but also creating protective irrigation by harnessing rain water at micro level through ‘Jal Sanchay’ and ‘Jal Sinchan’.
		   		<span><a href="http://agricoop.gov.in/divisiontype/rainfed-farming-system/programmes-schemes-new-initiatives">Read More >></a></span></p>
		   </div>
		   <div class="col-lg-4 blogimg">
		   		<img class = "img-responsive" src="https://www.instamojo.com/blog/wp-content/uploads/2020/01/government-schemes.png" width = "100%">
		   </div>
		</div>
		<hr width="90%" style="background-color: #fefefe;">
		<div class="bloghead"><h3>Use Of Digital Technology</h3></div>
		<div class="row py-3 px-5">
			<div class="col-lg-4 blogimg">
		   		<img class = "img-responsive" src="https://cybersciencelab.org/wp-content/uploads/2020/01/smart-agri.jpeg" width = "100%">
		   </div>
		   <div class="col-lg-8 blogtext">
		   		<h2>Use Of Digital Technology</h2>
		   		<p style="padding: 1.5em 1em 1em 0em;">Digital agriculture refers to tools that digitally collect, store, analyze, and share electronic data and/or information along the agricultural value chain. Other definitions, such as those from the United Nations Project Breakthrough, Cornell University, and Purdue University, also emphasize the role of digital technology in the optimization of food systems.
		   		<span><a href="https://en.wikipedia.org/wiki/Digital_agriculture#:~:text=Besides%20streamlining%20farm%20production%2C%20digital,costs%20throughout%20the%20value%20chain.">Read More >></a></span></p>
		   </div>
		</div>
	</div>

	<div class="container-fluid footer">
		<div class="row">
	    	<div class="col-lg-12 py-3 text-center" style="color: #3797a4; font-weight: 600; font-size: larger;">
	    		<hr width="30%" align="text-center" style="border-width: 2px; background-color: #999;">
	    		GET IN TOUCH WITH US!
	    		<hr width="30%" align="text-center" style="border-width: 2px; background-color: #999;">
	    	</div>
        </div>
		<div class="row footerhead">
			<div class="col-md-3 pt-3 mob">
              <h5><img src="./assets/Logo2.png" class="img-responsive"></h5>
            </div>
            <div class="col-md-3 pt-5 pl-3 mob">
              <a href="" style="text-decoration: none; color:#444;"><h5 style="font-size: 1.5em;">Login</h5></a>
            </div>
            <div class="col-md-3 pt-5 pl-3 contact">
              <a href="" style="text-decoration: none; color:#444;"><h5 style="font-size: 1.5em;">Contact Us</h5></a>
            </div>
		</div>

		<div class="row contact text-center text-md-left">
	        <div class="col-md-3 pl-3 pt-4 mob">
	            <h6 class="text-uppercase font-weight-bold">Products Made With Love</h6>
	        </div>
	        <div class="col-md-3 pl-3 pt-4 text-center text-md-left mob">
	            <a href="#" class="btn loginbtn" role="button" data-toggle="modal" data-target="#at-login">Sign In</a>
	            <h6 class="text-uppercase font-weight-bold pt-4">Not a member yet?</h6>
	            <p><i class="fa fa-handshake-o mr-3" aria-hidden="true"></i>Register Now</p>
	            <a href="./php/register.php" class="btn signupbtn" role="button">Sign up!</a>
	        </div>
	        <div class="col-md-3 pl-3 pt-4">
	          <h6><i class="fa fa-phone mr-3" aria-hidden="true"></i>8899776655</h6>
	          <h6><i class="fa fa-envelope mr-3 mt-4" aria-hidden="true"></i>ty34@gmail.com</h6>
	          <h6><i class="fa fa-home fa-lg mr-3 mt-4" aria-hidden="true"></i>VIT, Bibwewadi, Pune</h6>
	        </div>
	        <div class="col-md-3">
	        	<img src="./assets/mail.gif" class="img-responsive" width="100%">
	        </div>
	    </div>

	    <div class="row py-2 mt-3" style="background-color: #3797a4; font-weight: 600;">
	    	<div class="col-lg-12 text-center">
	    		© 2020 Copyright <a href="#" style="text-decoration: none; color: inherit">KrishiMitra</a>
	    	</div>
        </div>
	</div>

	<script type="text/javascript" src="./scripts/index.js"></script>
	<script>
  const loginText = document.querySelector(".title-text .login");
  const loginForm = document.querySelector("form.login");
  const loginBtn = document.querySelector("label.login");
  const signupBtn = document.querySelector("label.signup");
  const signupLink = document.querySelector("form .signup-link a");
  signupBtn.onclick = (()=>{ 
    loginForm.style.marginLeft = "-50%";
    loginText.style.marginLeft = "-50%";
    });
    loginBtn.onclick = (()=>{
    loginForm.style.marginLeft = "0%";
    loginText.style.marginLeft = "0%";
    });
    
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>