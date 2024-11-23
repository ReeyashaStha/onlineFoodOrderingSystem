<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- <div class="heading">
   <h3>about us</h3>
   <p><a href="home.php">home</a> <span> / about</span></p>
</div> -->

<!-- about section starts  -->

<section class="about">
<h1 class="title">About us</h1>
   <div class="row">

      <div class="image">
         <img src="images/newariKhajaSet.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Welcome to mtb, where culinary passion meets unparalleled hospitality. Here's why discerning diners like you choose us:

Culinary Excellence: Our chefs are dedicated to crafting exquisite dishes that tantalize your taste buds and leave a lasting impression. Using only the freshest, locally-sourced ingredients, we create culinary masterpieces that celebrate flavors from around the world.

Ambiance: Step into our cozy yet sophisticated dining space, where every detail is designed to enhance your dining experience. Whether you're enjoying an intimate dinner for two or celebrating a special occasion with friends and family, our ambiance sets the perfect backdrop for memorable moments.

Exceptional Service: At mtb, hospitality is more than just a job—it's our passion. From the moment you walk through our doors, our attentive staff is committed to ensuring your comfort and satisfaction. We go above and beyond to anticipate your needs and exceed your expectations.

Community Commitment: We're proud to be a part of the vibrant [City/Town] community, and we believe in giving back. Through partnerships with local farmers, artisans, and charitable organizations, we strive to make a positive impact both inside and outside our walls.

Customer-Centric Approach: Your feedback is invaluable to us. We're constantly evolving and improving to better serve you, our valued guests. Whether you have dietary restrictions, special requests, or simply want to share your experience, we're here to listen and ensure every visit is exceptional.</p>
         <a href="menu.php" class="btn">our menu</a>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- steps section starts  -->



<!-- steps section ends -->





















<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->=








</body>
</html>