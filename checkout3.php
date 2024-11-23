<?php

include 'components/connect.php';
include 'esewa_setting.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $message[] = 'please add your address!';
      }else{
         
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'order placed successfully!';
      }
      
   }else{
      $message[] = 'your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <!-- khalti -->
   <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
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
   <h3>checkout</h3>
   <p><a href="home.php">home</a> <span> / checkout</span></p>
</div> -->

<section class="checkout">

   <h1 class="title">order summary</h1>
   <table>
    <tr>
        <th>Cart items</th>
        <th>Image</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total price</th>
        <th>Action</th>
    </tr>
    <?php
                $grand_total = 0;
                $cart_items[] = '';
                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $select_cart->execute([$user_id]);
                if($select_cart->rowCount() > 0){
                   while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
            ?>
                    <td><?= $fetch_cart['name']; ?></td>
                    <td><img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="" height="100px" width="100px"></td>
                    <td><?= $fetch_cart['quantity']; ?></td>
                    <td><?= $fetch_cart['price']; ?></td>
                    <td><?= $fetch_cart['quantity'] * $fetch_cart['price']; ?></td>
                    <td><a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>&nbsp;&nbsp;&nbsp;
                    <a href="cart.php" class="fas fa-shopping-cart"></a></td>
                    
                </tr>
                
            <?php
            }
        }else{
            echo '<center><h3>you have empty cart</h3></center>';
        }
    ?>
    
</table>


<?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <br>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
    <p1 class="grand-total"><span class="name">Grand total : </span><span class="price">RS.<?= $grand_total; ?></span></p1>&nbsp; &nbsp; &nbsp;

      <a href="checkout4.php" class="btn" >Checkout</a>

    <br><a href="update_address.php" class="btn" >update address</a>
      <a href="map.php" class="btn" >view map</a><br>
</body>
</html>