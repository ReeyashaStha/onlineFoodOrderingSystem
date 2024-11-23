<?php

include '../component/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login1.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_order->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   header('location:users_accounts1.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

   <!-- bootstrap link -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" 
        crossorigin="anonymous">
        
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style1.css">

</head>
<body>

<?php include '../component/admin_header1.php' ?>

<!-- user accounts section starts  -->

<section class="accounts">



   <center><h1 class="heading">Users account</h1></center>

   <table class="table">
        <thead>
            <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Address</th>
            <th scope="col">Number</th>
            <th scope="col">Delete</th>
            </tr>
        </thead>
    
        <tbody>
            <tr>
            <?php
                $select_account = $conn->prepare("SELECT * FROM `users`");
                $select_account->execute();
                if($select_account->rowCount() > 0){
                    while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
            ?>
                    <td><?= $fetch_accounts['id']; ?></td>
                    <td><?= $fetch_accounts['name']; ?></td>
                    <td><?= $fetch_accounts['email']; ?></td>
                    <td><?= $fetch_accounts['address']; ?></td>
                    <td><?= $fetch_accounts['number']; ?></td>
                    <td><button class="btn btn-danger my-1"><a href="users_accounts1.php?delete=<?= $fetch_accounts['id']; ?>" class="text-light" onclick="return confirm('delete this account?');">delete</a></button></td>
            </tr>

            <?php
            }
        }else{
            echo '<center><h3>no accounts available</h3></center>';
        }
    ?>
        </tbody>
    </table>

</section>

<!-- user accounts section ends -->







<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>