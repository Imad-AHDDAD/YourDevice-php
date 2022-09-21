<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){

      if(isset($_POST["id_to_change"])){

         include "../db_connection/db_conn.php";
         $id = $_POST["id_to_change"];

         $date_delivery = date('m/d/Y h:i:s a', time());

         $sql1 = "UPDATE commande SET delivered = 'yes' , date_delivery = '$date_delivery' WHERE id_commande = $id";
         $stmt1 = $conn->prepare($sql1);
         if($stmt1->execute()){
            header("Location:listOrders.php?success=1 order changed to delivered");
            exit();
         }else{
            header("Location:listOrders.php?errorDB");
            exit();
         }


      }else{
         header("Location:listOrders.php?errorIsset");
         exit();
      }
      
   
   }else{
      header("Location:loginAdminForm.php");
      exit();
   }
   
?>