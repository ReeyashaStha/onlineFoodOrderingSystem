<?php

include '../component/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login1.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
    $delete_admin->execute([$delete_id]);
    header('location:admin_accounts1.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admins accounts</title>

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

<!-- admins accounts section starts  -->

<section class="accounts">

   <center><h1 class="heading">Admin accounts</h1></center>

   <!-- <div class="box-container"> -->

   <!-- <div class="box">
      <p>register new admin</p>
      <a href="register_admin.php" class="option-btn">register</a>
   </div> -->

   <!-- <?php
      $select_account = $conn->prepare("SELECT * FROM `admin`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <p> admin id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
      <div class="flex-btn">
         <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('delete this account?');">delete</a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="update_profile1.php" class="option-btn">update</a>';
            }
         ?>
      </div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no accounts available</p>';
   }
   ?> 

   </div>-->

   <form action="register_admin1.php" method="POST">
        
        <div class="mb-3">
            <label>Register new admin: </label>
            <input type="submit" value="register" name="submit" class="btn btn-primary">
            
        </div>

    </form>



   <table class="table">
        <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Admin name</th>
            <th scope="col">Delete</th>
            <th scope="col">Update</th>
            </tr>
        </thead>
    
        <tbody>
            <tr>
            <?php
               $select_account = $conn->prepare("SELECT * FROM `admin`");
               $select_account->execute();
               if($select_account->rowCount() > 0){
                  while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
            ?>
                    <td><?= $fetch_accounts['id']; ?></td>
                    <td><?= $fetch_accounts['name']; ?></td>
                    <td><a href="admin_accounts1.php?delete=<?= $fetch_accounts['id']; ?>" class="btn btn-danger" onclick="return confirm('delete this account?');">delete</a></td>
                    <!-- <td><a href="update_profile.php?update=<?= $fetch_accounts['id']; ?>" class="option-btn">update</a></td> -->
                    <td><?php
                     if($fetch_accounts['id'] == $admin_id){
                        echo '<a href="update_profile1.php" class="btn btn-primary">update</a>';
                     }
                  ?></td>
            </tr>

            <?php
            }
         }else{
            echo '<p class="empty">no accounts available</p>';
         }
    ?>
        </tbody>
    </table>

</section>

<!-- admins accounts section ends -->




















<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>