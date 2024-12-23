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

   <h1 class="title">Checkout</h1>

<form action="" method="post">

   <div class="cart-items">
      <h3>Items</h3>
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
      <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">RS.<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
      <p class="grand-total"><span class="name">Total :</span><span class="price">RS.<?= $grand_total; ?></span></p>
      <a href="checkout3.php" class="btn">veiw order summary</a>
   </div>

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

   <div class="user-info">
      <!-- <h3>your info</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">update info</a> -->
      <!-- <h3>delivery address</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
      <a href="update_address.php" class="btn">update address</a>
      <a href="map.php" class="btn">view map</a> -->


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


      <!-- <form action="<?php echo $epay_url;?>" method="POST">
         <input value="<?php echo $grand_total; ?>" name="tAmt" type="hidden">
         <input value="<?php echo $grand_total; ?>" name="amt" type="hidden">
         <input value="0" name="txAmt" type="hidden">
         <input value="0" name="psc" type="hidden">
         <input value="100" name="pdc" type="hidden">
         <input value="EPAYTEST" name="scd" type="hidden">
         <input value="ee2c3ca1-696b-4cc5-a6be-2c40d929d453" name="pid" type="hidden">
         <input value="http://merchant.com.np/page/esewa_payment_success?q=su" type="hidden" name="su">
         <input value="http://merchant.com.np/page/esewa_payment_failed?q=fu" type="hidden" name="fu">
         <input value="Submit" type="submit">
      </form> -->


<!-- khalti -->
      <button id="payment-button" class="btn">Pay with Khalti</button>&nbsp;&nbsp;&nbsp;<input value="Pay with esewa" type="submit" class="btn"><br>
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
         <input value="http://localhost/mtb/esuccess.php" type="hidden" name="su">
         <input value="http://localhost/mtb/efail.php" type="hidden" name="fu">
         <div class="more-btn">
         <input value="Pay with esewa" type="submit" class="btn">
         </div>
      </form>



<!-- khalti -->

<!-- <button id="payment-button">Pay with Khalti</button> -->

<script>
        var config = {
            // replace the publicKey with yours
            "publicKey": "test_public_key_70a95e0f68a8443aa549e4345233cc4d",
            "productIdentity": "1234567890",
            "productName": "Dragon",
            "productUrl": "http://localhost/mtb/checkout4.php",  
            //http://gameofthrones.wikia.com/wiki/Dragons
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

</body>
</html>


test_public_key_70a95e0f68a8443aa549e4345233cc4d

test_secret_key_336ab0100e8746ca82031b92bdbf66db