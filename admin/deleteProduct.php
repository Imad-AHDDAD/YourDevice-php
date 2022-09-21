<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){

      if(isset($_POST['id'])){
         include "../db_connection/db_conn.php";

         $id = $_POST['id'];
         $sql2 = "SELECT * FROM produit WHERE id_produit = '$id'";
         $stmt2= $conn->prepare($sql2);
         $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
         $categorie = $row2['categorie'];
         if($categorie == 'laptop') $redirect='listLaptops.php';
         else $redirect='listPhones.php';

         $sql = "DELETE FROM produit WHERE id_produit = '$id'";
         $stmt= $conn->prepare($sql);
         if($stmt->execute()){
            header("Location:".$redirect."?success=1 laptop deleted");
            exit();
         }else{
            header("Location:".$redirect."?errorDB");
            exit();
         }
      }else{
         header("Location:".$redirect."?error");
         exit();
      }


   }else{
      header("Location:loginAdminForm.php");
      exit();
   }
   
?>