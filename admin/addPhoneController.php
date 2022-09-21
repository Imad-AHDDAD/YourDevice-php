<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){

      if(isset($_POST["phone_name"]) && isset($_POST["phone_desc"]) && isset($_POST["phone_old_price"]) && isset($_POST["phone_new_price"]) && isset($_POST["phone_stock"]) && $_FILES['phone_image']['name']){

         include "../db_connection/db_conn.php";

         $name = filter_var($_POST['phone_name'] , FILTER_SANITIZE_STRING);
         $desc = filter_var($_POST['phone_desc'] , FILTER_SANITIZE_STRING);

         $old = filter_var($_POST['phone_old_price'] , 	FILTER_SANITIZE_NUMBER_FLOAT);
         if($old == NULL) $old = 0;
         $new = filter_var($_POST['phone_new_price'] , 	FILTER_SANITIZE_NUMBER_FLOAT);
         $stock = filter_var($_POST['phone_stock'] , 	FILTER_SANITIZE_NUMBER_INT);

         $upload = "C:/wamp64/www/E-commerce/images/".basename($_FILES['phone_image']['name']);

         if(copy($_FILES['phone_image']['tmp_name'] , $upload)){
            $image=basename($_FILES['phone_image']['name']);
         }

         $sql = "INSERT INTO produit(nom_produit , libelle_produit, ancien_prix , nouveau_prix , img , qte_stock , categorie) VALUES ('$name' , '$desc', $old , $new , '$image' , $stock , 'phone')";

         $stmt = $conn->prepare($sql);
         if($stmt->execute()){
            header("Location:listphones.php?success=1 phone added");
            exit();
         }else{
            header("Location:addphoneForm.php?errorDB");
            exit();
         }
      }else{
         header("Location:addphoneForm.php?error=incompleted informations");
         exit();
      }
      
   
   }else{
      header("Location:loginAdminForm.php");
      exit();
   }
   
?>