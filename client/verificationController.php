<?php 

session_start();
include "../db_connection/db_conn.php";

if($_SESSION["code"] && $_SESSION["full_name"] && $_SESSION['email'] && $_SESSION['country'] && $_SESSION['address'] && $_SESSION['username_client_register'] && $_SESSION['password_client_register']){
   if(isset($_POST["client_verification_code"])){

      $code = filter_var($_POST["client_verification_code"] , FILTER_SANITIZE_NUMBER_INT);
      
      if($code == $_SESSION["code"]){

         $full_name = $_SESSION["full_name"];
         $email = $_SESSION['email'];
         $phone = $_SESSION['phone'];
         $country = $_SESSION['country'];
         $address = $_SESSION['address'];
         $username_client = $_SESSION['username_client_register'];
         $pass = $_SESSION['password_client_register'];

         $passChiffré = hash('md5' , $pass);
         $sql2 = "INSERT INTO client(name_client,email_client,phone_client,country_client,address_client , username_client ,pass) VALUES('$full_name','$email','$phone','$country','$address','$username_client','$passChiffré')";
         $stmt2 = $conn->prepare($sql2);
         if($stmt2->execute()){
            session_unset();
            session_destroy();
            header("Location:clientLogin.php?success=account created successfully");
            exit();
         }else{
            session_unset();
            session_destroy();
            header("Location:clientLogin.php?error2");
            exit();
         }

      }else{
         header("Location: VerificationForm.php?error=code incorrect !");
         exit();
      }
   }else{
      header("Location: VerificationForm.php?error");
      exit();
   }
}else{
   session_unset();
   session_destroy();
   header("Location: clientLogin.php?error");
   exit();
}

?>