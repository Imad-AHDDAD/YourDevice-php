<?php

      session_start();

      if ($_SESSION['username_client_connected'] && $_SESSION['name_client_connected']){

      include "../db_connection/db_conn.php";
         
      $username_client = $_SESSION['username_client_connected'];
      $name_client = $_SESSION['name_client_connected'];
   
      $sql = "SELECT * FROM client WHERE username_client = '$username_client'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
      $id_client = $row['id_client'];

      $errorExists = 0;


      // la fonction qui verifie le nom
      function verifierNom($param){
         $regexNom = '/[a-z]{2,}/';
         return preg_match($regexNom, $param); // 1 si vrai
      }

      // la fonction qui verifie le numero de telephone
      function verifierPhone($param){
         $regex = '/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/'; 
         return (preg_match($regex, $param));
      }

      // la fonction qui verifie l'adresse'
      function verifierAddress($param){
         $regex = '/[a-zA-Z]{10,}/'; 
         return (preg_match($regex, $param));
      }

   if(isset($_POST['full_name_client']) && isset($_POST['phone_client']) && isset($_POST['country_client_select']) && isset($_POST['address_client'])){

      $full_name = filter_var($_POST['full_name_client'] , FILTER_SANITIZE_STRING);
      $phone = filter_var($_POST['phone_client'] , FILTER_SANITIZE_STRING);
      $country = filter_var($_POST['country_client_select'] , FILTER_SANITIZE_STRING);
      $address = filter_var($_POST['address_client'] , FILTER_SANITIZE_STRING);

      if(verifierNom($full_name) == 0 || empty($full_name)){
         $errorExists = 1;
      }

      if(verifierPhone($phone) == 0 || empty($phone)){
         $errorExists = 1;
      }

      if(verifierNom($address) == 0 || empty($address)){
         $errorExists = 1;
      }

      if(empty($country)){
         $errorExists = 1;
      }

      
      if($GLOBALS['errorExists']==0){
         include "../db_connection/db_conn.php";
         $sql2="UPDATE client SET name_client='$full_name' , phone_client='$phone' , country_client = '$country' , address_client='$address' WHERE id_client=$id_client";

         $stmt2 = $conn->prepare($sql2);
         if($stmt2->execute()){
            header("Location:client_profile.php?success2=modified successfully");
            exit();
         }else{
            header("Location:client_profile.php?error2=errorDB");
            exit();
         }

      }else{
         header("Location:client_profile.php?error2=invalid informations");
         exit();
      }

   }else{
      header("Location:clientLogin.php?error2");
      exit();
   }

}else{
   header("Location:clientLogin.php?error2");
   exit();
}
?>

