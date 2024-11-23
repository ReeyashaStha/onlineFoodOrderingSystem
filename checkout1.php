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
            color: white;
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

<div class="heading">
   <h3>checkout</h3>
   <p><a href="home.php">home</a> <span> / checkout</span></p>
</div>

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
                    <td><a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
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
    <p1 class="grand-total"><span class="name">Grand total : </span><span class="price">RS.<?= $grand_total; ?></span></p1>
</body>
</html>




<form action="" method="post">
<div class="cart-items">
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
      <!-- <p1 class="grand-total"><span class="name">Grand total : </span><span class="price">RS.<?= $grand_total; ?></span></p1> -->
      
   </div>

   <!-- <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>"> -->

   <div class="user-info">
      <!-- <h3>your info</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">update info</a> -->
      
      <a href="update_address.php" class="btn" >update address</a>
      <a href="map.php" class="btn" >view map</a><br>


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
      <!-- <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">RS.<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p> -->
      
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>

<div class="box1">


       <button id="payment-button" class="btn">Pay with Khalti</button><br>
      <select name="method" class="box" id="paay" required>
         <option value="" disabled selected>select payment method --</option>
         <option value="cash on delivery">cash on delivery</option>
         <option value="esewa" href="esewa.php">esewa</option>
         <option value="khalti" href="khalti.php">khalti</option> 
      </select>

      <input type="submit" value="place order" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
      <!-- <input value="Pay with esewa" type="submit" class="btn"> -->
   
   </div>
   

</form>
   
</section>


<!-- esewa -->

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
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>



<form action="https://uat.esewa.com.np/epay/main" method="POST">
         <input value="<?php echo $grand_total; ?>" name="tAmt" type="hidden">
         <input value="<?php echo $grand_total; ?>" name="amt" type="hidden">
         <input value="0" name="txAmt" type="hidden">
         <input value="0" name="psc" type="hidden">
         <input value="0" name="pdc" type="hidden">
         <input value="EPAYTEST" name="scd" type="hidden">
         <input value="<?php echo $pid; ?>" name="pid" type="hidden">
         <input value="http://localhost/food%20website%20backend/esuccess.php" type="hidden" name="su">
         <input value="http://localhost/food%20website%20backend/efail.php" type="hidden" name="fu">
         <div class="more-btn">
         <input value="Pay with esewa" type="submit" class="btn">
         </div>
      </form>



<!-- khalti -->

<!-- <button id="payment-button">Pay with Khalti</button> -->

<script>
        var config = {
            // replace the publicKey with yours
            "publicKey": "test_public_key_dc74e0fd57cb46cd93832aee0a390234",
            "productIdentity": "1234567890",
            "productName": "Dragon",
            "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
            "paymentPreference": [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT",
                ],
            "eventHandler": {
                onSuccess (payload) {
                    // hit merchant api for initiating verfication
                    console.log(payload);
                },
                onError (error) {
                    console.log(error);
                },
                onClose () {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function () {
            // minimum transaction amount must be 10, i.e 1000 in paisa.
            checkout.show({amount: <?= $grand_total*100; ?>});
        }
    </script>





<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>



    
</div>