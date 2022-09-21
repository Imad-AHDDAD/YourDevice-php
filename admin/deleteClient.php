<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){

      if(isset($_POST['id_to_delete'])){
         include "../db_connection/db_conn.php";

         $id = $_POST['id_to_delete'];
         $sql = "DELETE FROM client WHERE id_client = '$id'";
         $stmt= $conn->prepare($sql);
         if($stmt->execute()){
            header("Location: listClients.php?success=1 Client deleted");
            exit();
         }else{
            header("Location: listClients.php?errorDB");
            exit();
         }
      }else{
         header("Location: listClients.php?error");
         exit();
      }


   }else{
      header("Location:loginAdminForm.php");
      exit();
   }
   
?>