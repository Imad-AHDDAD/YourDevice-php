<?php
session_start();
   if (array_key_exists('username_client_connected', $_SESSION) && array_key_exists('name_client_connected', $_SESSION)){ 
      header("Location:index.php");
      exit();
   }else{
      if($_SESSION["code_to_reset_password"] && $_SESSION["email_to_reset"]){

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Forgot Password | Verification code</title>
   <link rel="shortcut icon" href="../images/favicon.ico">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/index.css">
   <link rel="stylesheet" href="../css/clientLogin.css">
   <script src="../js/script.js"></script>
   <style>
      nav{
         top: 0;
      }
      .container{
         flex-direction: column;
      }
      .container p{
         color: #2C3E50;
         font-size: 1.7rem;
      }
      .container p span{
         color: #5cb85c;
         text-decoration: underline;
      }
   </style>
</head>
<body>

   <nav>
      <div class="logo">
         <label for=""><i class="fa-solid fa-gear"></i> YOUR <span>DEVICE</span></label>
      </div>
      
      <div class="menu_and_search">
         
         <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a class="login" href="listLaptops.php">Laptops</a></li>
            <li><a class="login" href="listPhones.php">Phones</a></li>
            <li><a href="contactForm.php">Contact</a></li>
            <li><a href="index.php#popular">Popular</a></li>
            <li><a class="login" href="clientLogin.php">Login<i class="fa-solid fa-right-to-bracket"></i></a></li>
         </ul>

         <div class="search">
            <form action="searchPage.php" method="GET">
               <input type="text" name="search_text" id="search" placeholder="search">
               <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
         </div>
         
      </div>
      <i id="menuIcon" class="fa-solid fa-bars"></i>
   </nav>

   <div class="container">
      <p>we have sent a confirmation code to your email : <span><?php echo $_SESSION['email_to_reset'] ?></span></p>
      <form action="VerificationFormToResetPasswordController.php" class="login" method="POST">
         <h1>Verification Code</h1>
         <input type="number" name="verification_code_to_reset_password" required>
         <button type="submit">Send</button>
         <?php 
            if(isset($_GET['error'])){
         ?>
         <p class="error"><?php echo $_GET['error']?></p>
         <?php } ?>
      </form>
   </div>

   
</body>
</html>

<?php
      }else{
         echo "no isset";
      }
}
?>