<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){

      if(isset($_POST["id_msg_seen"])){

         include "../db_connection/db_conn.php";
         $id = $_POST["id_msg_seen"];

         $date_seen= date('m/d/Y h:i:s a', time());

         $sql1 = "UPDATE messagesclients SET seen = 'YES' , date_seen = '$date_seen' WHERE id = $id";
         $stmt1 = $conn->prepare($sql1);
         if($stmt1->execute()){
            header("Location:messagesClients.php?success=1 order changed to seen");
            exit();
         }else{
            header("Location:messagesClients.php?errorDB");
            exit();
         }


      }else{
         header("Location:messagesClients.php?errorIsset");
         exit();
      }
      
   
   }else{
      header("Location:loginAdminForm.php");
      exit();
   }
   
?>