<?php

include '../component/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login1.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages1.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>
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

<!-- messages section starts  -->

    <center><h1> Messages </h1></center>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">Name</th>
            <th scope="col">Number</th>
            <th scope="col">Email</th>
            <th scope="col">Message</th>
            <th scope="col">Edit</th>
            </tr>
        </thead>
    
        <tbody>
            <tr>
            <?php
                $select_messages = $conn->prepare("SELECT * FROM `messages`");
                $select_messages->execute();
                if($select_messages->rowCount() > 0){
                    while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
            ?>
                    <td><?= $fetch_messages['name']; ?></td>
                    <td><?= $fetch_messages['number']; ?></td>
                    <td><?= $fetch_messages['email']; ?></td>
                    <td><?= $fetch_messages['message']; ?></td>
                    <td><button class="btn btn-danger my-1"><a href="messages1.php?delete=<?= $fetch_messages['id']; ?>" class="text-light" onclick="return confirm('delete this message?');">delete</a></button></td>
            </tr>

            <?php
            }
        }else{
            echo '<center><h3>you have no messages</h3></center>';
        }
    ?>
        </tbody>
    </table>


<!-- messages section ends -->


<!-- custom js file link  -->
<!-- <script src="../js/admin_script.js"></script> -->

</body>
</html>