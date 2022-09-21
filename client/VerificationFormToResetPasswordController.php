<?php
session_start();
if (array_key_exists('username_client_connected', $_SESSION) && array_key_exists('name_client_connected', $_SESSION)){ 
   header("Location:index.php");
   exit();
}else{
   if($_SESSION["code_to_reset_password"] && $_SESSION["email_to_reset"]){
      $email =  $_SESSION["email_to_reset"];
      $monCode = $_SESSION["code_to_reset_password"];
      if(isset($_POST['verification_code_to_reset_password'])){
         $codeEntered = filter_var($_POST['verification_code_to_reset_password'] , FILTER_SANITIZE_NUMBER_INT);
         if($monCode == $codeEntered){
            header("Location: formToSetNewPassAfterReseting.php");
            exit();
         }else{
            header("Location: VerificationFormToResetPassword.php?error=incorrect code");
            exit();
         }
      }else{
         header("Location: VerificationFormToResetPassword.php?error=ivalid code");
         exit();
      }
   }else{
      header("Location: clientLogin.php");
      exit();
   }
}
?>