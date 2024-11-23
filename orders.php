<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
        table {
            border-collapse: collapse;
            margin: 0 auto;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
            font-size: 20px;
        }
        th{
            background-color: #ffaa49;
        }
        tr {
            background-color: #fe9e30bb;
            color: black;
        }
        p1 {
            font-size: 40px; /* Adjust font size as needed */
        }
        .box1 {
            border: 1px solid #000;
            padding: 10px;
            background-color: white;
            margin: 0 auto; /* Center the box horizontally */
            width: 100%; /* Adjust the width as needed */
        }
        .box {
            border: 1px solid #000;
            padding: 10px;
            background-color: white;
            margin: 0 auto; /* Center the box horizontally */
            width: 100%; /* Adjust the width as needed */
        }
    </style>
</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- <div class="heading">
   <h3>orders</h3>
   <p><a href="html.php">home</a> <span> / orders</span></p>
</div> -->

<section class="orders">

   <h1 class="title">your orders</h1>

   <!-- <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>number : <span><?= $fetch_orders['number']; ?></span></p>
      <p>address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
      <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>total price : <span>RS.<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p>payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

   </div> -->

   <table>
    <tr>
        <th>Placed on</th>
        <th>Name</th>
        <th>Email</th>
        <th>Number</th>
        <th>Address</th>
        <th>Payment method</th>
        <th>Your orders</th>
        <th>Total price</th>
        <th>Payment status</th>
    </tr>
    <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
                    <td><?= $fetch_orders['placed_on']; ?></td>
                    <td><?= $fetch_orders['name']; ?></td>
                    <td><?= $fetch_orders['email']; ?></td>
                    <td><?= $fetch_orders['number']; ?></td>
                    <td><?= $fetch_orders['address']; ?></td>
                    <td><?= $fetch_orders['method']; ?></td>
                    <td><?= $fetch_orders['total_products']; ?></td>
                    <td>RS.<?= $fetch_orders['total_price']; ?>/-</td>
                    <td><span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span></td>
                    
                </tr>
                
            <?php
            }
        }else{
            echo '<center><h3>you have empty cart</h3></center>';
        }
      }
    ?>
    
</table>

</section>










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>