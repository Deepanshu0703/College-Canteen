<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_worker'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $pos = mysqli_real_escape_string($conn, $_POST['pos']);
   $price = $_POST['salary'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'worker_img/'.$image;

//    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

//    if(mysqli_num_rows($select_product_name) > 0){
//       $message[] = 'product name already added';
//    }else{
      $add_worker_query = mysqli_query($conn, "INSERT INTO `worker` (`id`, `name`, `salary`, `position`, `image`) VALUES (NULL, '$name', '$price', '$pos', '$image');") or die('query 1 failed');

      if($add_worker_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Worker added successfully!';
         }
      }else{
         $message[] = 'Worker could not be added!';
      }
   }
// }

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `worker` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('worker_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `worker` WHERE id = '$delete_id'") or die('query failed');
   header('location:Workers.php');
}

if(isset($_POST['update_worker'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_pos = $_POST['update_pos'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `worker` SET name = '$update_name',position = '$update_pos', salary = '$update_price' WHERE id ='$update_p_id';") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:Workers.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Workers</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">Workers</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Add New WOrker</h3>
      <input type="text" name="name" class="box" placeholder="enter name" required>
      <input type="number" min="0" name="salary" class="box" placeholder="enter salary" required>
      <input type="text"  name="pos" class="box" placeholder="enter position" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add Worker" name="add_worker" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $select_worker = mysqli_query($conn, "SELECT * FROM `worker`") or die('query failed');
         if(mysqli_num_rows($select_worker) > 0){
            while($fetch_worker = mysqli_fetch_assoc($select_worker)){
      ?>
      <div class="box">
         <img style="width:100% ;"  src="worker_img/<?php echo $fetch_worker['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_worker['name']; ?></div>
         <div class="name"><?php echo $fetch_worker['position']; ?></div>
         <div class="price">&#8377;<?php echo $fetch_worker['salary']; ?>/-</div>
         <a href="Workers.php?update=<?php echo $fetch_worker['id']; ?>" class="option-btn">update</a>
         <a href="Workers.php?delete=<?php echo $fetch_worker['id']; ?>" class="delete-btn" onclick="return confirm('delete this Worker?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no Worker added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `worker` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="worker_img/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter worker name">
      <input type="text" name="update_pos" value="<?php echo $fetch_update['position']; ?>" class="box" required placeholder="enter worker psosition">
      <input type="number" name="update_price" value="<?php echo $fetch_update['salary']; ?>" min="0" class="box" required placeholder="enter Worker salary">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_worker" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>







<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>