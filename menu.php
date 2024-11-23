<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>menu</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
        .rounded-box {
            border-radius: 10px;
            background-color: white;
            padding: 20px;
            width: 250px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .image-section img {
            display: block;
            margin: 0 auto;
            border-radius: 50%; /* To make the image rounded */
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .text-section {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- <div class="heading">
   <h3>our menu</h3>
   <p><a href="home.php">home</a> <span> / menu</span></p>
</div> -->

<!-- menu section starts  -->

<section class="category">
<h1 class="title">Menus</h1>
   <!-- <h1 class="title">food category</h1> -->

   <div class="box-container">

      
        
         <div class="rounded-box">
            <div class="image-section">
            <a href="category.php?category=main dish">
               <img src="images/cat-2.png" alt="">
            </a>
            </div>
            <div class="text-section">
            <h3>Main dishes</h3>
            </div>
         </div>
         <div class="rounded-box">
            <div class="image-section">
            <a href="category.php?category=newari-food-items">
            <img src="images/newari.jpg" alt="">
            </a>
            </div>
            <div class="text-section">
            <h3>Newari dishes</h3>
            </div>
         </div>
         <div class="rounded-box">
            <div class="image-section">
            <a href="category.php?category=non-veg">
            <img src="images/non-veg.webp" alt="">
            </a>
            </div>
            <div class="text-section">
            <h3>Non veg</h3>
            </div>
         </div>
         <div class="rounded-box">
            <div class="image-section">
            <a href="category.php?category=drinks">
            <img src="images/cat-3.png" alt="">
            </a>
            </div>
            <div class="text-section">
            <h3>Drinks</h3>
            </div>
         </div>
         
      <!-- <a href="category.php?category=main dish" class="fas fa-glass-whiskey fa-lg"> 
         <img src="images/cat-2.png" alt="">
         <h3>main dishes</h3>
      </a> 

      <a href="category.php?category=newari-food-items" class="fas fa-glass-whiskey">
         <img src="images/newari.jpg" alt="">
         <h3>Newari Special</h3>
      </a>

      <a href="category.php?category=non-veg" class="fas fa-glass-whiskey">
         <img src="images/non-veg.webp" alt="">
         <h3>Non-Veg</h3>
      </a>

      <a href="category.php?category=drinks" class="fas fa-glass-whiskey">
         <img src="images/cat-3.png" alt="">
         <h3>drinks</h3>
      </a> -->



   </div>

</section>


<section class="products">

   <!-- <h1 class="title">All dishes</h1> -->

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="flex">
            <div class="price"><span>RS.</span><?= $fetch_products['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2"">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>

   </div>

</section>


<!-- menu section ends -->
























<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>