<?php

include '../component/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login1.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>resturant</title>
    <!-- bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" 
    crossorigin="anonymous">

    <!-- css link -->
    <link rel="stylesheet" href="../css/admin_style1.css">

    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

</head>
<body>
    <?php include '../component/admin_header1.php' ?>

    <!-- <div class="container" my-5 border>
        <h1> container</h1>
        <h3>welcome!</h3>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="update_profile.php" class="btn">update profile</a>
    </div> -->

<center><h1>Dashboard</h1></center><br><br>
    <div class="container" my-5 p-2>
        <div class="row" my-3 p-2>
            <div class="col" my-2 p-2>
                <h3>Welcome!</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <a href="update_profile1.php" class="btn btn-primary">Update profile</a><br><br>
                <!-- <p>  </p> -->
                <a href="admin_logout.php" onclick="return confirm('logout from account?');" class="btn btn-danger">Logout</a><br><br>
            </div>
            <div class="col" my-2>
            <h3>Total pendings</h3>
                <?php
                    $total_pendings = 0;
                    $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                    $select_pendings->execute(['pending']);
                    while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                        $total_pendings += $fetch_pendings['total_price'];
                    }
                ?>
                <p><span>RS.</span><?= $total_pendings; ?><span>/-</span></p>
                
                <a href="pending1.php" class="btn btn-primary">Pending orders</a>
            </div>
            <div class="col" p-2>
                <h3>Total completes</h3>
                <?php
                    $total_completes = 0;
                    $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                    $select_completes->execute(['completed']);
                    while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                        $total_completes += $fetch_completes['total_price'];
                    }
                ?>
                <p><span>RS.</span><?= $total_completes; ?><span>/-</span></p>
                <a href="completed1.php" class="btn btn-primary">Completed orders</a> 
            </div>
            <div class="col">
                <h3>Total orders</h3>
                <?php
                    $select_orders = $conn->prepare("SELECT * FROM `orders`");
                    $select_orders->execute();
                    $numbers_of_orders = $select_orders->rowCount();
                ?>
                <p><?= $numbers_of_orders; ?></p>
                
                <a href="placed_orders1.php" class="btn btn-primary">View orders</a>
            </div>

        </div>


        <div class="row">
            
            <div class="col">
                <h3>Products added</h3>
                <?php
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    $numbers_of_products = $select_products->rowCount();
                ?>
                <p><?= $numbers_of_products; ?></p>
                <a href="products1.php" class="btn btn-primary" >View products</a>
                
            </div>

            <div class="col">
            <h3>Users accounts</h3>
                <?php
                    $select_users = $conn->prepare("SELECT * FROM `users`");
                    $select_users->execute();
                    $numbers_of_users = $select_users->rowCount();
                ?>
                <p><?= $numbers_of_users; ?></p>
                <a href="users_accounts1.php" class="btn btn-primary">View users</a>
            </div>

            

            <div class="col">
                <h3>Messages</h3>
                <?php
                    $select_messages = $conn->prepare("SELECT * FROM `messages`");
                    $select_messages->execute();
                    $numbers_of_messages = $select_messages->rowCount();
                ?>
                <p><?= $numbers_of_messages; ?></p>
                <a href="messages1.php" class="btn btn-primary">View messages</a>
            </div>

            <div class="col" p-2>
                <h3>Reviews</h3>
                <?php
                    $select_review = $conn->prepare("SELECT * FROM `review`");
                    $select_review->execute();
                    $numbers_of_review = $select_review->rowCount();
                ?>
                <p><?= $numbers_of_review; ?></p>
                <a href="review1.php" class="btn btn-primary">View review</a>
            </div>
        </div>



    </div>






</body>
</html>

