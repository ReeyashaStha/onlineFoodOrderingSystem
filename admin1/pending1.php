<?php

include '../component/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login1.php');
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

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

<!-- placed orders section starts  -->

<section class="placed-orders">

   <center><h1 class="heading">Pending orders</h1></center>



   <table class="table">
        <thead>
            <tr>
            <th scope="col">user id</th>
            <th scope="col">placed on</th>
            <th scope="col">name </th>
            <th scope="col">email</th>
            <th scope="col">number</th>
            <th scope="col">address</th>
            <th scope="col">total products</th>
            <th scope="col">total price</th>
            <th scope="col">payment method</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
    
        <tbody>
            <tr>
            <?php

                $select_orders = $conn->prepare("SELECT * FROM `orders` WhERE payment_status='pending'");
                $select_orders->execute();
                if($select_orders->rowCount() > 0){
                    
                    while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                  
                        
            ?>
            
                    <td><?= $fetch_orders['user_id']; ?></td>
                    <td><?= $fetch_orders['placed_on']; ?></td>
                    <td><?= $fetch_orders['name']; ?></td>
                    <td><?= $fetch_orders['email']; ?></td>
                    <td><?= $fetch_orders['number']; ?></td>
                    <td><?= $fetch_orders['address']; ?></td>
                    <td><?= $fetch_orders['total_products']; ?></td>
                    <td>RS.<?= $fetch_orders['total_price']; ?></td>
                    <td><?= $fetch_orders['method']; ?></td>
                    <td>
                    <form action="" method="POST">
                        <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                        <select name="payment_status" class="drop-down">
                            <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                            <option value="pending">pending</option>
                            <option value="completed">completed</option>
                        </select>
                        <div class="flex-btn">
                            <td>
                            <input type="submit" value="update" class="btn btn-primary" name="update_payment">
                            <button class="btn btn-danger my-1"><a href="placed_orders1.php?delete=<?= $fetch_orders['id']; ?>" class="text-light" onclick="return confirm('delete this order?');">delete</a></button></td>
                        </div>
                    </form>
                    <td>
            </tr>

            <?php
            }
        }else{
            echo '<p class="empty">no pending orders yet!</p>';
         }
    ?>
        </tbody>
    </table>



</section>

<!-- placed orders section ends -->









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>