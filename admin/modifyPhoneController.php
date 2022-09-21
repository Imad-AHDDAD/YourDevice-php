<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){

      if(isset($_POST["phone_name"]) && isset($_POST["phone_desc"]) && isset($_POST["phone_old_price"]) && isset($_POST["phone_new_price"]) && isset($_POST["phone_stock"]) && $_SESSION['id']){

         include "../db_connection/db_conn.php";
         $id = $_SESSION['id'];
         $name = filter_var($_POST['phone_name'] , FILTER_SANITIZE_STRING);
         $desc = filter_var($_POST['phone_desc'] , FILTER_SANITIZE_STRING);

         $old = filter_var($_POST['phone_old_price'] , 	FILTER_SANITIZE_NUMBER_FLOAT);
         if(!$old) $old = 0;
         $new = filter_var($_POST['phone_new_price'] , 	FILTER_SANITIZE_NUMBER_FLOAT);
         $stock = filter_var($_POST['phone_stock'] , 	FILTER_SANITIZE_NUMBER_INT);

         $upload = "C:/wamp64/www/E-commerce/images/".basename($_FILES['phone_image']['name']);

         if($_FILES['phone_image']['name']){
            if(copy($_FILES['phone_image']['tmp_name'] , $upload)){
               $image=basename($_FILES['phone_image']['name']);
               $sql = "UPDATE produit SET nom_produit='$name' , libelle_produit='$desc', ancien_prix='$old' , nouveau_prix='$new' , img='$image' , qte_stock='$stock' , categorie='phone' WHERE id_produit = $id";
            }
         }else{
            $sql = "UPDATE produit SET nom_produit='$name' , libelle_produit='$desc', ancien_prix='$old' , nouveau_prix='$new' , qte_stock='$stock' , categorie='phone' WHERE id_produit = $id";
         }

         $stmt = $conn->prepare($sql);
         if($stmt->execute()){
            header("Location:listPhones.php?success=1 phone Modified");
            exit();
         }else{
            header("Location:modifyPhoneForm.php?errorDB");
            exit();
         }
      }else{
         header("Location:modifyPhoneForm.php?error=incompleted informations");
         exit();
      }
      
   
   }else{
      header("Location:loginAdminForm.php");
      exit();
   }
   
?>