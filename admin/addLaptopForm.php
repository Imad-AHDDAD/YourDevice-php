<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){

      include "../db_connection/db_conn.php";
      $user = $_SESSION['username'];
      $nom = $_SESSION['nom'];
      $prenom = $_SESSION['prenom'];
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Laptop</title>
   <link rel="stylesheet" href="../css/homeAdmin.css">
   <link rel="stylesheet" href="../css/addProduct.css">
</head>
<body>

      <nav>
         <div><img src="../images/avatar.jpg" alt=""><label for=""><?php echo strtoupper($nom)." ".$prenom ?></label></div>
         <div><a href="homeAdmin.php" class="home">Home</a>
         <a href="logout.php">Logout</a></div>
      </nav>

   <section class="form">
      <form action="addLaptopController.php" method="POST" enctype="multipart/form-data">
         <h1>add Laptop</h1>
         <input required type="text" name="laptop_name" id="laptop_name" placeholder="laptop name">
         <textarea required cols="10" rows="5" name="laptop_desc" id="laptop_desc" placeholder="laptop Description"></textarea>
         <input type="number" name="laptop_old_price" id="laptop_old_price" placeholder="old price">
         <input required type="number" name="laptop_new_price" id="laptop_new_price" placeholder="new price">
         <label for="">image :</label>
         <input required type="file" name="laptop_image" id="laptop_image">
         <input required type="number" name="laptop_stock" placeholder="stock">
         <button type="submit">Add</button>

         <?php
            if(isset($_GET["error"])){
         ?>
            <p class="error"><?php echo $_GET["error"] ?></p>
         <?php } ?>

         <?php
            if(isset($_GET["success"])){
         ?>
            <p class="success"><?php echo $_GET["success"] ?></p>
         <?php } ?>
      </form>
   </section>
   
</body>
</html>

<?php 
   }else{
      header("Location:loginAdminForm.php");
      exit();
   }
?>