<?php

include('config.php');
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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .table{
            width : 70%;
            border-radius: 20px;

        }
        .table1{
            margin:auto;
        }
    </style>
    <title>Products</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
        <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> <?php echo "Welcome ". $_SESSION['username']?></a>
      </li>
  </ul>
  </div>


  </div>
</nav>

<div class="container mt-4">
<h3>Currently available Products</h3>
<hr>
</div>
<div class="container">
<form method="POST" action="insert.php">
 <div class="form-group">
    <label for="id">ID</label>
    <input type="text" class="form-control" name="prodid" placeholder="Enter Id of the product">
 </div>
 <div class="form-group">
    <label for="quantity">Quantinty</label>
    <input type="text" class="form-control" name="quantity"  placeholder="Enter Quantity in kilograms">  
  </div>
  
 <div class="form-group">
    <label for="price">Price</label>
    <input type="text" class="form-control" name="price" placeholder="Enter Price">
 </div>

<?php $results = mysqli_query($conn, "SELECT * from product");?>
<div class="table1">

<center><table class="table table-striped table-dark" >
<thead class="thead-dark">
    <tr>
    <th scope="col">Product id</th>
    <th scope="col">Name</th>
    <th scope="col">Type</th>
    </tr>
</thead>
    <tbody>
    <?php while($row = mysqli_fetch_array($results)){?>
    <tr>
        <td><?php echo $row['prodid'];?></td>
        <td><?php echo $row['prodname'];?></td>
        <td><?php echo $row['prodtype'];?></td>
        <td><button type="submit" class="btn btn-success" name="add" value = "<?php echo $row['prodid'];?>">Add to Shop</button></td>
    </tr>
    <?php } ?>
    </tbody>
</table></center>
    </div>
    </form>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>