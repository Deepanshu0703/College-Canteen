<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading" style="background: url(./images/headersea.png) no-repeat;">
      <h3>about us</h3>
      <p> <a href="home.php">home</a> / about </p>
   </div>

   <section class="about">

      <div class="flex">

         <div class="image">
            <img src="images/about-img.jpg" alt="">
         </div>

         <div class="content">
            <h3>why choose us?</h3>
            <p>We are the group of three person Who started to make a comm website for all the Canteens in our Institute premises and we will have the Data of all ,their menu and staff.</p>
            <p>Each and every time we ensure that we give what we have proimised and not just that if you found anything not good into the food never hesitate to contact us, we are responsive!! </p>
            <a href="contact.php" class="btn">contact us</a>
         </div>
      </div>
   </section>

   <section class="reviews">
      <h1 class="title">Student's reviews</h1>
      <div class="box-container">
         <div class="box">
            <img src="images/pic-1.jpg" alt="">
            <p>Best Ordering Website with manu userfriendly options, pretty decent.Many of the dishes were available from the menu. I tried the Badam Milk, Great Taste. Don't think just order.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Deepanshu Kumar</h3>
         </div>

         <div class="box">
            <img src="images/pic-2.jpg" alt="">
            <p>Ordered from this website by chance pretty decent . Many of the dishes were available from the menu. We tried the Kadhai Paneer, was delicious.I think it's a decent place to Order Quality food.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Akshay Anand</h3>
         </div>

         <div class="box">
            <img src="images/pic-3.jpg" alt="">
            <p>What a fantastic food and food quality . I just loved each and every bite of it . It was just amazing. I am sure i will order each and every time from this website.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Abhi kumar Gupta</h3>
         </div>

      </div>
   </section>

   <section class="show-products">
      <h1 class="title">Our Staff</h1>
      <div class="box-container">

         <?php
         $select_worker = mysqli_query($conn, "SELECT * FROM `worker`") or die('query failed');
         if (mysqli_num_rows($select_worker) > 0) {
            while ($fetch_worker = mysqli_fetch_assoc($select_worker)) {
         ?>
               <div class="box">
                  <img style="width:100% ;" src="worker_img/<?php echo $fetch_worker['image']; ?>" alt="">
                  <div class="name">
                     <h1 style="font-size: 3rem;"><?php echo $fetch_worker['name']; ?></h1>
                  </div>
                  <div class="name">
                     <h1 style="font-size: 2.5rem;"><?php echo $fetch_worker['position']; ?></h1>
                  </div>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">no Worker added yet!</p>';
         }
         ?>
      </div>

   </section>

   </section>
   <?php include 'footer.php'; ?>
   <script src="js/script.js"></script>

</body>

</html>