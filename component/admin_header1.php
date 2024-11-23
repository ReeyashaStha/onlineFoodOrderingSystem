<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    /* Custom styling */
    .sidebar {
      height: 100%;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: rgb(79, 56, 150);
      padding-top: 20px;
    }
    .sidebar a {
      padding: 10px 15px;
      text-decoration: none;
      font-size: 18px;
      color: #ffffff;
      display: block;
    }
    .sidebar a:hover {
      background-color: lightblue;
    }
    .content {
      margin-left: 250px; /* Width of the sidebar */
      padding: 20px;
    }
  </style>




<body>
    
</body>
</html>

<?php
    if(isset($message)){
        foreach($message as $message){
            echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
?>


<!-- <nav class="navbar navbar-expand-lg bg-info " id="navbar" >
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard1.php" id="logo">
                <!-- <span><img src="../imgages/cat-1.png" alt="" width="30px" id="logo"></span> -->
                <a class="nav-link active" aria-current="page" href="dashboard1.php">mtb</a>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                aria-expanded="false" aria-label="Toggle navigation">
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard1.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="products1.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="placed_orders1.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin_accounts1.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="users_accounts1.php">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="messages1.php">Message</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> -->
    <div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar">
            <a class="navbar-brand" href="dashboard1.php" id="logo">
                <!-- <span><img src="../imgages/cat-1.png" alt="" width="30px" id="logo"></span> -->
                <a class="nav-link active" aria-current="page" href="dashboard1.php">mtb</a>
            </a>
                <a class="nav-link active" aria-current="page" href="dashboard1.php">Home</a>
                <a class="nav-link active" aria-current="page" href="products1.php">Products</a>
                <a class="nav-link active" aria-current="page" href="placed_orders1.php">Orders</a>
                <a class="nav-link active" aria-current="page" href="admin_accounts1.php">Admin</a>
                <!-- <a class="nav-link active" aria-current="page" href="users_accounts1.php">User</a>
                <a class="nav-link active" aria-current="page" href="messages1.php">Message</a> -->
            </div>
        </div>


  

    <div class="col-md-9">
            <!-- Top Content Area -->
            <div class="top-content">
                <!-- Content for the top area -->
                <h2></h2>
            
            </div>
            



            













      <!-- <?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?> -->

<!-- <header class="header">

   <section class="flex">

      <a href="dashboard1.php" class="logo"><span>mtb</span></a>

      <nav class="navbar">
         <a href="dashboard1.php">home</a>
         <a href="products1.php">products</a>
         <a href="placed_orders1.php">orders</a>
         <a href="admin_accounts1.php">admins</a>
         <a href="users_accounts1.php">users</a>
         <a href="messages1.php">messages</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div> -->

      <!-- <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">update profile</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">login</a>
            <a href="register_admin.php" class="option-btn">register</a>
         </div>
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
      </div> -->

      
<!-- 
   </section> -->







  

  <!-- Bootstrap and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>







</header>


