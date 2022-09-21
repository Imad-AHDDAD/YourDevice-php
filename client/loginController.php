<?php
session_start();
$_SESSION['user'] = "";
   if(isset($_POST['client_username']) && isset($_POST['client_password'])){
      $user_login = filter_var($_POST['client_username'] , FILTER_SANITIZE_STRING);
      $pass_login = filter_var($_POST['client_password'] , FILTER_SANITIZE_STRING);
      
      if(!$user_login){
         header("Location:clientLogin.php?error=invalid username");
         exit();
      }else if(!$pass_login){
         header("Location:clientLogin.php?error=incorrect password");
         exit();
      }else{
         include "../db_connection/db_conn.php";
         $sql = "SELECT * FROM client WHERE username_client = '$user_login'";
         $stmt = $conn->prepare($sql);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         if($row){
            if($row['username_client'] == "$user_login"){
               $passChiffré = hash('md5' , $pass_login);
               if($row['pass'] == "$passChiffré"){
                  session_start();
                  $_SESSION['username_client_connected'] = $user_login;
                  $_SESSION['name_client_connected'] = $row['name_client'];
                  if(isset($_SESSION['url'])) 
                     $url = $_SESSION['url'];
                  else 
                     $url = "index.php?connecté";
                  header("Location: $url"); 
                  exit();
               }else{
                  session_start();
                  $_SESSION['user'] = $user_login;
                  header("Location:clientLogin.php?error=incorrect password");
                  exit();
               }
            }else{
               header("Location:clientLogin.php?error=incorrect username");
               exit();
            }
         }else{
            header("Location:clientLogin.php?error=invalid username");
            exit();
         }
      }
   }else{
      header("Location:clientLogin.php?error");
      exit();
   }
?>