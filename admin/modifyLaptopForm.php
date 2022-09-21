<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){
      $user = $_SESSION['username'];
      $nom = $_SESSION['nom'];
      $prenom = $_SESSION['prenom'];

      if(isset($_POST['id'])){
         $id = $_POST['id'];
         include "../db_connection/db_conn.php";
         $sql = "SELECT * FROM produit WHERE id_produit = $id";
         $stmt = $conn->prepare($sql);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         if($row){
            $name = $row['nom_produit'];
            $desc = $row['libelle_produit'];
            $old = $row['ancien_prix'];
            $new = $row['nouveau_prix'];
            $image = $row['img'];
            $stock = $row['qte_stock'];
            $_SESSION['id'] = $id;
         }else{
            header("Location:listLaptops.php?errorDB");
            exit();
         }
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Modify Laptop</title>
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
      <form action="modifyLaptopController.php" method="POST" enctype="multipart/form-data">
         <h1>Modify Laptop</h1>
         <label for="">Laptop name:</label>
         <input required type="text" name="laptop_name" id="laptop_name" value="<?php echo $name ?>">
         <label for="">Laptop description:</label>
         <textarea required cols="10" rows="5" name="laptop_desc" id="laptop_desc"><?php echo $desc ?></textarea>
         <label for="">Laptop old price:</label>
         <input type="number" name="laptop_old_price" id="laptop_old_price" value="<?php echo $old ?>">
         <label for="">Laptop new price:</label>
         <input required type="number" name="laptop_new_price" id="laptop_new_price" value="<?php echo $new ?>">
         <label for="">image :</label>
         <input type="file" name="laptop_image" id="laptop_image">
         <label for="">Qte stock:</label>
         <input required type="number" name="laptop_stock"  value="<?php echo $stock ?>">
         <button type="submit">Modify</button>

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
         header("Location:listLaptops.php?errorDB");
         exit();
      }
   }else{
      header("Location:loginAdminForm.php");
      exit();
   }

?>