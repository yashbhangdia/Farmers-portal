<?php
require_once "config.php";

$username = $password = $confirm_password = $addr = $mobile = $name = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST")
{

    // Check if username is empty
    if(empty(trim($_POST["email"])))
    {
        $username_err = "Username cannot be blank";
    }
    else
    {

      //echo ($_POST["email"]);

      if(!isset($_POST['checkbox1']))
      {
        $sql = "SELECT userid FROM users WHERE username = ?";
      }
      else
      {
        $sql = "SELECT farmerid FROM farmer WHERE username = ?";
      }
        //$stmt = mysqli_stmt_init($conn);
        //echo "hi";
        $stmt = mysqli_prepare($conn, $sql);
        //echo "hello : ", $stmt;
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST["email"]);
            //echo "username::: ", $param_username;

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else
                {
                    $username = trim($_POST["email"]);
                    //echo "username: : ", $username;
                }
            }
            else
            {
                echo "Something went wrong";
            }
            mysqli_stmt_close($stmt);
        }


      }


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
    $addr = trim($_POST['addr']);
    $mobile = trim($_POST['mobile']);
    $name = trim($_POST['name']);
    $gender = trim($_POST['gender']);   
}
// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
    die($password_err);
}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
  if(!isset($_POST['checkbox1']))
  {
    $sql = "INSERT INTO users (username,password,name,address,mobile,gender) VALUES (?,?,?,?,?,?)";
  } else {
    $sql = "INSERT INTO farmer (username,password,name,address,mobile,gender) VALUES (?,?,?,?,?,?)";
  }
   

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_password,$param_name,$param_address,$param_mobile,$param_gender);

        // Set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_address = $addr;
        $param_name = $name;
        $param_mobile = $mobile;
        $param_gender = $gender;
      

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            //echo "Username: ", $param_username;  
            header("location: ../index.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/styleregister.css">
    <title>Register</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color: #3797a4!important;">
  <a class="navbar-brand" href="/Farmers-portal/index.html">Krishi Mitra</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="..//index.html">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login3.php">Login</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3>Please Register Here:</h3>
<hr>
<form action="" method="post">

    <div class="form-group">
      <label for="inputEmail4">Name</label>
      <input type="text" class="form-control" name="name" id="inputEmail4" placeholder="Name"required>
    </div>
 
    <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email</label>
      <input type="email" class="form-control" name="email" id="inputEmail4" placeholder="Email"required>
    </div>

    <div class="form-group col-md-6">
      <label for="inputEmail4">Mobile</label>
      <input type="text" class="form-control" name="mobile" id="inputEmail4" placeholder="10-digit Mobile no"required>
    </div>
    </div>


    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputPassword4">Password</label>
        <input type="password" class="form-control" name ="password" id="inputPassword4" placeholder="Password" required>
      </div>

      <div class="form-group col-md-6">
        <label for="inputPassword4">Confirm Password</label>
        <input type="password" class="form-control" name ="confirm_password" id="inputPassword" placeholder="Confirm Password" required>
      </div>
    </div>

    <div class="form-row">
    <div class="form-group col-md-4">
      <label for="gender">Gender</label>
      <select id="gender" name="mobile" class="form-control">
        <option selected></option>
        <option>Male</option>
        <option>Female</option>
        <option>Others</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="inputAddress2">Address</label>
    <input type="text" class="form-control" name = "addr" id="inputAddress2" placeholder="Address" required>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City</label>
      <input type="text" class="form-control" id="inputCity"required>
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Zip</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck" name="checkbox1">
      <label class="form-check-label" for="gridCheck">
        Click here if you are a Farmer
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Register</button>
</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
