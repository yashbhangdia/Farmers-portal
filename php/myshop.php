<?php

include("config.php");
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}


?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
      .divform{
        padding:20px;
      }
      input[type="text"] {
        width: 100%;
        border:none;
        border-bottom: 1px solid #1890ff;
        padding: 5px 10px;
        background: transparent;
        outline: none;
      }
      .back {
        margin:  20px;
        background-color: white !important;
        border-color: white !important;
      }
      *{
       font-family: 'Poppins', sans-serif;
      }
      #head{
        background-color: #fff !important;
      }
    
    table {
  border-collapse: collapse;
  border-radius: 1em;
  overflow: hidden;
  padding: 20px;
  width: 100%;
  text-indent: 20px;
  background-color: #f5f5f5;
}
th{
  height: 50px;
}
tr:hover {background-color:#dbdbdb;}

    </style>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Welcome farmer!</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="back btn btn-primary" href="welcomefarmer.php" role="button"><img src="https://img.icons8.com/android/24/000000/back.png"/><span class="sr-only">(current)</span></a>
   <a class="navbar-brand" href="#"><img src="../assets/Logokrishi.png"/></a>
  <a class="navbar-brand" href="#">Farmer</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="welcomefarmer.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>

     
    </ul>

  <div class="navbar-collapse collapse">
  <ul class="navbar-nav ml-auto">
  <li class="nav-item active">
        <a class="nav-link" href="#">
          <img src="https://img.icons8.com/metro/26/ffffff/user-male.png"> <?php echo " ". $_SESSION['username']?>

        </a>
      </li>
  </ul>
  </div>
  </div>
</nav>


<form method="POST" action="updatemyshop.php">
<?php 
$user = $_SESSION['username'];
$sql2 = mysqli_query($conn,"SELECT * FROM farmer WHERE username='$user'");
$row = mysqli_fetch_array($sql2);
$fid = $row["farmerid"];
$results = mysqli_query($conn, "SELECT * from myshop WHERE farmerid = '$fid'");

    ?>

<hr>
<div class="divform">


  <h2> <b>My Shop </b> <img style="padding:10px;" src="https://img.icons8.com/android/48/000000/shop.png"/>  </h2>
  <br>
<div class="form-row">
   
    <div class="form-group col-md-6">
      <label for="quantity"><h4>Quantity</label> 
      <input type="text" class="form-control" name="quantity" placeholder="Enter Quantity to update in kgs">
    </div>
   

    <div class="form-group col-md-6">
      <label for="inputEmail4"> <h4> Price</label> 
      <input type="text" class="form-control" name="price" placeholder="Enter updated price">
    </div>
    
</div>

<table class="table-striped">
<thead style="background-color: #ffc107;">
    <tr>
    <th scope="col">Product id</th>
    <th scope="col">Product Image</th>
    <th scope="col">Name</th>
    <th scope="col">Quantity</th>
    <th scope="col">Price</th>
     <th scope="col">Action</th>
     <th scope="col"></th>

    </tr>
</thead>
    <tbody>
    <?php while($row = mysqli_fetch_array($results)){?>
    <tr>
        <td><?php echo $row['prodid'];?></td>

        <td><?php $idprod = $row['prodid'];
             $sql = mysqli_query($conn, "SELECT * from product WHERE prodid='$idprod'");
             $row1 = mysqli_fetch_array($sql);
             $img = "../assets/".$row1['prodname']."."."png";
             echo "<img src='{$img}' width='20%' height='30%'>";?></td>
        <td><?php echo $row1['prodname'];?>  
         </td>
        <td><?php echo $row['quantity'];?></td>
        <td><?php echo $row['price'];?></td>
        
        <td><button type="submit" class="btn btn-danger" name="delete" value = "<?php echo $row['prodid'];?>">Delete</button></td>
        <td><button type="submit" class="btn btn-success" name="update" value = "<?php echo $row['prodid'];?>">Update</button></td>
    </tr>
    <?php } ?>
    </tbody>
</table>
</form>
 <div class="row py-2 mt-3" style=" font-weight: 600;">
        <div class="col-lg-12 text-center">
          © 2020 Copyright <a href="#" style="text-decoration: none; color: inherit">KrishiMitra</a>
        </div>
        </div>
</div>

   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>