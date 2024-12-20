<?php

include '../component/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login1.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
   $select_admin->execute([$name]);
   
   if($select_admin->rowCount() > 0){
      $message[] = 'username already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm passowrd not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admin`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'new admin registered!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

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

<!-- register admin section starts  -->

<section class="form-container">

   <!-- <form action="" method="POST">
      <h3>register new</h3>
      <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" maxlength="20" required placeholder="confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" name="submit" class="btn">
   </form> -->


   <div class="row d-flex align-items-center justify-content-center mt-5 border-3 p-2 ">
    <div class="col-lg-11 col-xl-5" >
    <form action="" method="POST">
        <center><h3>register new</h3></center>
        <div class="mb-3">
        <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>
        <div class="mb-3">
        <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>

        <div class="mb-3">
        <input type="password" name="cpass" maxlength="20" required placeholder="confirm your password" class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>

        <div>
            <input type="submit" value="register now" name="submit" class="btn btn-primary">
        </div>
    </form>
    </div>
    </div>




</section>

<!-- register admin section ends -->







<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>