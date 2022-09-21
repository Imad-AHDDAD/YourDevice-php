<?php
   session_start();
   if ($_SESSION['username_client_connected'] && $_SESSION['name_client_connected']){

      if(isset($_POST['id_cart_to_delete'])){
         include "../db_connection/db_conn.php";
         $id = $_POST['id_cart_to_delete'];
         $sql = "DELETE FROM cart WHERE id_cart = $id";
         $stmt = $conn->prepare($sql);
         if($stmt->execute()){
            header("Location:client_profile.php?success=1 element deleted");
            exit();
         }else{
            header("Location:client_profile.php?errorDB");
            exit();
         }
      }else{
         header("Location:client_profile.php?error");
         exit();
      }
   }else{
      header("Location:clientLogin.php");
      exit();
   }
?>
      