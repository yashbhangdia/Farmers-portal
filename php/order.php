<?php

include('config.php');
session_start();
$farmer = $_SESSION['username'];
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}

$query= mysqli_query($conn,"SELECT * FROM farmer WHERE  username='$farmer'");
$row = mysqli_fetch_array($query);
$farmerid = $row['farmerid'];



if(isset($_POST['update'])){
  $orderid=$_POST['update'];
  $sql="Update myorder set status= status + 1 where orderid = {$orderid} and farmerid={$farmerid}";
  mysqli_query($conn,$sql);

  $sql = "Select * from myorder where orderid={$orderid} and farmerid={$farmerid}"; //list of items in the order
  $query = mysqli_query($conn,$sql);
  while($orderinfo = mysqli_fetch_array($query)){

  if($orderinfo['status'] == 1)
  {
    $orderquant = $orderinfo['quantity'];
    $farmerid = $orderinfo['farmerid'];
    $prodid = $orderinfo['prodid'];
    $sql="Update myshop set quantity= quantity - {$orderquant} where farmerid = {$farmerid} and prodid={$prodid}";
    mysqli_query($conn,$sql);
  }
}


}

if(isset($_POST['delete'])){
  $orderid=$_POST['delete'];
  $sql = "Select * from myorder where orderid={$orderid} and farmerid={$farmerid}";
  $query = mysqli_query($conn,$sql);
  while($orderinfo = mysqli_fetch_array($query)){
  $orderquant = $orderinfo['quantity'];
  $farmerid = $orderinfo['farmerid'];
  $prodid = $orderinfo['prodid'];
  $sql="Update myorder set status= 6 where orderid = {$orderid}";
  mysqli_query($conn,$sql);
  $sql="Update myshop set quantity= quantity + {$orderquant} where farmerid = {$farmerid} and prodid={$prodid}";
  mysqli_query($conn,$sql);
  }
}



?>


<!doctype html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    
    <!-- Compiled and minified CSS -->
 <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">  -->
 
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        
   
    <title>Products</title>
    <style>
     .back {
        margin:  20px;
        background-color: white !important;
        border-color: white !important;
      } 
       *{
       font-family: 'Poppins', sans-serif;
      }

      table {
  margin-top:  -50px;
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
  width: 150px;
  background-color: #007bff;
  color: #fff;
}


tr:hover {background-color:#dbdbdb;}

.card{
  width: 50% !important;
  border-radius: 10px;
  height: 110%;

}
#orderid{
  border-radius: 10px;
  text-indent: 10px;
  background-color: #ffd369;
}
.card-action{
  padding-left: 20px !important;
  padding-bottom: 10px;
}
    </style>
     
  </head>
  <body>

   <nav class="nav-wrapper navbar navbar-expand-lg navbar-dark bg-dark">
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
        <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/ffffff/user-male.png"> <?php echo " ". $_SESSION['username']?></a>
      </li>
  </ul>
  </div>


  </div>
</nav> 

<!--------------------------------------------NAV BAR OVER------------------------------------------------------->
<div class="container">
    <div class="container mt-4">
          <h3><b>Your Orders </b><img src="https://img.icons8.com/fluent-systems-regular/64/000000/purchase-order.png"></h3>
     <hr>
    </div>
    <hr>
<form method="POST" action="order.php">

  <?php
    $query= mysqli_query($conn,"SELECT * FROM myorder WHERE status < 4 AND farmerid='$farmerid' group by orderid having count(*)>=1");
   ?>

    <?php while($result = mysqli_fetch_array($query)){?>

  <div class="row">
    <div class="col s12 m6">
      <div class="card">
      
          <span class="card-title"><h3 id="orderid"><b>ORDER id : <?php echo $result['orderid'];?> </b></h3></span>
          <div class="card-body">
          <table class=table-striped>
        <thead>
          <tr>
              <th>Item Name</th>
              <th>Quantity</th>
              <th>Amount</th>
          </tr>
        </thead>

        <tbody>
          
          <?php 
            $orderid = $result['orderid'];
            $sql1= mysqli_query($conn ," SELECT * from myorder where orderid='$orderid' and farmerid='$farmerid'");

            while($rows = mysqli_fetch_array($sql1)){
            $prodid = $rows['prodid'];
             $sql = mysqli_query($conn, "SELECT * from product WHERE prodid='$prodid'");
             $row1 = mysqli_fetch_array($sql);
             $name = $row1['prodname'];
             
             $sql3 = mysqli_query($conn, "SELECT * from myorder WHERE orderid='$orderid' and farmerid='$farmerid' and prodid='$prodid'");
             $row2 = mysqli_fetch_array($sql3);
             $quant=$row2['quantity'];
             $amount=$row2['amount'];
             $status=$row2['status'];
          
            ?>
            <tr>
            <td><?php echo $name;?></td>
            <td><?php echo $quant;?></td>
            <td><?php echo $amount;?></td>
            </tr>
             <?php } ?></p><br>

        </tbody>
       </table>
  

        </div>
        <div class="card-action">
          <button type="submit" class="btn btn-success" name="update" value = "<?php echo $result['orderid'];?>">
        <?php
           if($result['status']==0) echo "Accept";
           if($result['status']==1) echo "Dispatch";
           if($result['status']==2) echo "Transit";
           if($result['status']==3) echo "Delivered";
        ?>
       </button>
       <button type="submit" class="btn btn-danger" name="delete" value = "<?php echo $result['orderid'];?>">Cancel</button>
     </div>
        
      </div>
    </div>
  </div>
</form>
 <br> <br> <br>
 <?php } ?>

</div>


   





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>