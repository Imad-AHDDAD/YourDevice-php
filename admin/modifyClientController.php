<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){

      if(isset($_POST["username_client"]) && isset($_POST["pass_client"]) && $_SESSION['id']){

         include "../db_connection/db_conn.php";
         $id = $_SESSION['id'];
         $username_client = filter_var($_POST['username_client'] , FILTER_SANITIZE_STRING);
         $pass_client = filter_var($_POST['pass_client'] , FILTER_SANITIZE_STRING);

         $sql1 = "SELECT * FROM client WHERE id_client = $id";
         $stmt1 = $conn->prepare($sql1);
         $stmt1->execute();
         $row1=$stmt1->fetch(PDO::FETCH_ASSOC);


         if(!$username_client || empty($username_client)){
            $new_username = $row1['username_client'];
         }else if(!$pass_client || empty($pass_client)){
            $new_pass = $row1['pass'];
         }else{
            $sql2 = "SELECT * FROM client WHERE username_client = '$username_client'";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute();
            $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
            if($row2){
               header("Location:modifyClientForm.php?id_to_modify=$id&error=username already used");
               exit();
            }else{
               $new_username = $username_client;
               $new_pass = hash('md5',$pass_client);
            }
         }

         $sql3 = "UPDATE client SET username_client = '$new_username' , pass = '$new_pass' WHERE id_client=$id";
         $stmt3 = $conn->prepare($sql3);
         if($stmt3->execute()){
            header("Location:listClients.php?success=1 Client Modified");
            exit();
         }else{
            header("Location:modifyClientForm.php?id_to_modify=$id&errorDB");
            exit();
         }

      }else{
         header("Location:modifyClientForm.php?id_to_modify=4&errorisset");
         exit();
      }
      
   
   }else{
      header("Location:loginAdminForm.php");
      exit();
   }
   
?>