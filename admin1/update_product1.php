<?php

include '../component/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login1.php');
};

if(isset($_POST['update'])){

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);

    $update_product = $conn->prepare("UPDATE `products` SET name = ?, category = ?, price = ? WHERE id = ?");
    $update_product->execute([$name, $category, $price, $pid]);

    $message[] = 'product updated!';

    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;

    if(!empty($image)){
        if($image_size > 2000000){
            $message[] = 'images size is too large!';
        }else{
            $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $pid]);
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('../uploaded_img/'.$old_image);
            $message[] = 'image updated!';
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
    <title>update product</title>

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

<!-- update product section starts  -->

<section class="update-product">

    <center><h1 class="heading">Update product</h1></center>
    <?php
        $update_id = $_GET['update'];
        $show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $show_products->execute([$update_id]);
        if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
    ?>
<div class="row d-flex align-items-center justify-content-center mt-5 border-3 p-5 ">
    <div class="col-lg-11 col-xl-5" >
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
            <img src="../uploaded_img/<?= $fetch_products['image']; ?>" height="150px" width="150px" alt="">
        </div>
        <div class="mb-3">
            <label class="form-label">Update name</label>
            <input type="text" required placeholder="enter product name" name="name" maxlength="100"  class="form-control" 

            value="<?= $fetch_products['name']; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Update price</label>
            <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" class="form-control" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
        </div>
        <div class="mb-3">
        <label class="form-label">Update category</label>
            <select name="category" class="form-control" required>
                <option selected value="<?= $fetch_products['category']; ?>"><?= $fetch_products['category']; ?></option>
                <option value="main dish">main dish</option>
                <option value="newari-food-items">Newari special</option>
                <option value="non-veg">Non-veg</option>
                <option value="drinks">drinks</option>
                <!-- <option value="momo">momo</option>
                <option value="desserts">desserts</option> -->
            </select>
        </div>
        <div class="mb-3 form-check">
            <input type="file" name="image" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp">
        </div>
        <div class="mb-3">
        <input type="submit" value="update" class="btn btn-primary" name="update">
            <a href="products1.php" class="btn btn-info">go back</a>
        </div>
    </form>
    </div>
</div>




    <!-- <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
        <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
        <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
        <span>update name</span>
        <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
        <span>update price</span>
        <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
        <span>update category</span>
        <select name="category" class="box" required>
            <option selected value="<?= $fetch_products['category']; ?>"><?= $fetch_products['category']; ?></option>
            <option value="main dish">main dish</option>
            <option value="fast food">fast food</option>
            <option value="drinks">drinks</option>
            <option value="desserts">desserts</option>
        </select>
        <span>update image</span>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
        <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="update">
            <a href="products1.php" class="option-btn">go back</a>
        </div>
    </form>
    <?php
            }
        }else{
            echo '<p class="empty">no products added yet!</p>';
        }
    ?> -->

</section>

<!-- update product section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>