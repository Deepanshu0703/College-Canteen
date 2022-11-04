<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($check_cart_numbers) > 0) {
      $message[] = 'already added to cart!';
   } else {
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <section class="home" style="min-height: 70vh;
   background:linear-gradient(rgba(0,0,0,.7), rgba(0,0,0,.7)), url(./images/home-bg.jpg) no-repeat;
   background-size: cover;
   background-position: center;
   display: flex;
   align-items: center;
   justify-content: center;">

      <div class="content">
         <h3>Tasty and Quality Food at Door step.</h3>
         <p>We are IIITDM official website for all the Canteen related stuff, You can oreder and see the menu in our Institute's Canteens.</p>
         <a href="about.php" class="white-btn">discover more</a>
      </div>

   </section>

   <section class="products">

      <h1 class="title">latest products</h1>

      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
         ?>
               <form action="" method="post" class="box">
                  <img class="image" style="width:100% ;" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                  <div class="name"><?php echo $fetch_products['name']; ?></div>
                  <div class="price">&#8377;<?php echo $fetch_products['price']; ?>/-</div>
                  <input type="number" min="1" name="product_quantity" value="1" class="qty">
                  <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                  <input type="submit" value="add to cart" name="add_to_cart" class="btn">
               </form>
         <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>
      </div>

      <div class="load-more" style="margin-top: 2rem; text-align:center">
         <a href="shop.php" class="option-btn">load more</a>
      </div>

   </section>

   <section class="about">

      <div class="flex">

         <div class="image">
            <img src="images/about-img.jpg" alt="">
         </div>

         <div class="content">
            <h3>about us</h3>
            <p>We are the group of three person Who started to make a comm website for all the Canteens in our Institute premises and we will have the Data of all ,their menu and staff. </p>
            <a href="about.php" class="btn">read more</a>
         </div>

      </div>

   </section>

   <section class="home-contact">

      <div class="content">
         <h3>have any questions?</h3>
         <p>If Yes!! Great don't Hesitate to ask Us , we are more than Happy to answer your query, So please ask.</p>
         <a href="contact.php" class="white-btn">contact us</a>
      </div>

   </section>
   <?php include 'footer.php'; ?>


</body>

</html>