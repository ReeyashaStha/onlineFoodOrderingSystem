<?php

include '../component/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login1.php');
};

if(isset($_POST['add_product'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    // $descript = $_POST['descript'];
    // $descript = filter_var($descript, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if($select_products->rowCount() > 0){
        $message[] = 'product name already exists!';
    }else{
        if($image_size > 2000000){
            $message[] = 'image size is too large';
        }else{
            move_uploaded_file($image_tmp_name, $image_folder);

            $insert_product = $conn->prepare("INSERT INTO `products`(name, category, price, image) VALUES(?,?,?,?)");
            $insert_product->execute([$name, $category, $price, $image]);

            $message[] = 'new product added!';
        }

    }

}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/'.$fetch_delete_image['image']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    header('location:products1.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>

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

<!-- add products section starts  -->

<!-- <section class="add-products">

    

</section> -->

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

<!-- <div class="box-container">

<?php
    $show_products = $conn->prepare("SELECT * FROM `products`");
    $show_products->execute();
    if($show_products->rowCount() > 0){
        while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
?>
<div class="box">
    <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
    <div class="flex">
        <div class="price"><span>$</span><?= $fetch_products['price']; ?><span>/-</span></div>
        <div class="category"><?= $fetch_products['category']; ?></div>
    </div>
    <div class="name"><?= $fetch_products['name']; ?></div>
    <div class="flex-btn">
        <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
        <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
    </div>
</div>
<?php
        }
    }else{
        echo '<p class="empty">no products added yet!</p>';
    }
?>

</div> -->



   <center><h1> Products </h1></center>


   <!-- <form action="" method="POST" enctype="multipart/form-data">
        <h3>add product</h3>
        <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box">
        <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
        <select name="category" class="box" required>
            <option value="" disabled selected>select category --</option>
            <option value="main dish">main dish</option>
            <option value="fast food">fast food</option>
            <option value="drinks">drinks</option>
            <option value="desserts">desserts</option>
        </select>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
        <input type="submit" value="add product" name="add_product" class="btn">
    </form> -->



    <div class="row d-flex align-items-center justify-content-center mt-5 border-3 p-2 ">
    <div class="col-lg-11 col-xl-5" >
    <form action="" method="POST" enctype="multipart/form-data">
        <center><h4>Add products</h4></center>
        <div class="mb-3">
            <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="form-control">
        </div>
        <div class="mb-3">
            <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="form-control">
        </div>

        <div class="mb-3">
            <select name="category" class="form-control" required>
                <option value="" disabled selected>select category --</option>
                <option value="main dish">main dish</option>
                <option value="newari-food-items">Newari Special</option>
                <option value="non-veg">Non-veg</option>
                <option value="drinks">drinks</option>
                <!-- <option value="momo">momo</option>
                <option value="desserts">desserts</option> -->
            </select>
        </div>

        <div class="mb-3">
            <input type="file" name="image" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp" required>
        </div>
        <div>
        <input type="submit" value="add product" name="add_product" class="btn btn-primary">
        </div>
    </form>
    </div>
    </div>



    <table class="table">
        <thead>
            <tr>
            <th scope="col">Image</th>
            <th scope="col">Price</th>
            <th scope="col">Category</th>
            <th scope="col">Name</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
    
        <tbody>
            <tr>
            <?php
                $show_products = $conn->prepare("SELECT * FROM `products`");
                $show_products->execute();
                if($show_products->rowCount() > 0){
                   while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
            ?>
                    <td><img src="../uploaded_img/<?= $fetch_products['image']; ?>" height="100px" width="100px"  class="product_img" alt=""></td>
                    <td><?= $fetch_products['price']; ?></td>
                    <td><?= $fetch_products['category']; ?></td>
                    <td><?= $fetch_products['name']; ?></td>
                    <td><button class="btn btn-primary">
                        <a href="update_product1.php?update=<?= $fetch_products['id']; ?>"  class="text-light">update</a>
                    </button>&nbsp;<button class="btn btn-danger my-1">
                        <a href="products1.php?delete=<?= $fetch_products['id']; ?>" class="text-light" onclick="return confirm('delete this product?');">delete</a>
                    </button></td>
            </tr>
            
            <?php
            }
        }else{
            echo '<center><h3>you have no products</h3></center>';
        }
    ?>
        </tbody>
    </table>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>