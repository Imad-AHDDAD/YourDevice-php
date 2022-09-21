<?php
session_start();
if (array_key_exists('username_client_connected', $_SESSION) && array_key_exists('name_client_connected', $_SESSION)){ 
   header("Location:index.php");
   exit();
}else{
   if($_SESSION["code_to_reset_password"] && $_SESSION["email_to_reset"]){
      $email =  $_SESSION["email_to_reset"];
      if(isset($_POST['new_password']) && isset($_POST['new_password_cnf'])){
         $pass = filter_var($_POST['new_password'] , FILTER_SANITIZE_STRING);
         $passCnf = filter_var($_POST['new_password_cnf'] , FILTER_SANITIZE_STRING);

         if(!$pass){
            header("Location: formToSetNewPassAfterReseting.php?error=invalid password");
            exit();
         }else if(!$passCnf){
            header("Location: formToSetNewPassAfterReseting.php?error=invalid password confirmation");
            exit();
         }else{
            if($pass == $passCnf){
               include "../db_connection/db_conn.php";
               $passToSet = hash('md5',$pass);
               $sql = "UPDATE client SET pass = '$passToSet' WHERE email_client = '$email'";
               $stmt = $conn->prepare($sql);
               if($stmt->execute()){
                  header("Location: clientLogin.php?success2=Your password has been changed successfully");
                  exit();
               }else{
                  header("Location: formToSetNewPassAfterReseting.php?error=error server");
                  exit();
               }
            }else{
               header("Location: formToSetNewPassAfterReseting.php?error=invalid password confirmation");
               exit();
            }
         }
      }else{
         header("Location: formToSetNewPassAfterReseting.php?error=incompleted informations");
         exit();
      }

   }else{
      header("Location: clientLogin.php");
      exit();
   }
}
?>