<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){
      $user = $_SESSION['username'];
      $nom = $_SESSION['nom'];
      $prenom = $_SESSION['prenom'];

      if(isset($_GET['id_to_modify'])){
         $id = $_GET['id_to_modify'];
         include "../db_connection/db_conn.php";
         $sql = "SELECT * FROM client WHERE id_client = $id";
         $stmt = $conn->prepare($sql);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         if($row){
            // $name = $row['name_client'];
            // $email = $row['email_client'];
            // $phone = $row['phone_client'];
            // $country = $row['country_client'];
            // $address_client = $row['address_client'];
            $username_client = $row['username_client'];
            $pass = $row['pass'];
            $_SESSION['id'] = $id;
         }else{
            header("Location:listClients.php?error=client id don't exists");
            exit();
         }
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Modify Client</title>
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
      <form action="modifyClientController.php" method="POST">
         <h1>Modify Client</h1>
         
         <label for="">client username :</label>
         <input type="text" name="username_client" id="username_client" value="<?php echo $username_client ?>">
         <label for="">client password :</label>
         <input type="password" name="pass_client" id="pass_client" value="<?php echo $pass ?>">
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
         header("Location:listClients.php?errorDB");
         exit();
      }
   }else{
      header("Location:loginAdminForm.php");
      exit();
   }

?>