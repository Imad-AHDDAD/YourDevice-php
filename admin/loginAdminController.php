<?php
   session_start();
   if(isset($_POST['username']) && isset($_POST['password'])){
      
      $user = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
      $pass = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
      
      // $date = date('d-m-y h:i:s');

      if(!$user){
         header("Location: loginAdminForm.php?error=invalid username");
         exit();
      }else if(!$pass){
         header("Location: loginAdminForm.php?error=invalid password");
         exit();
      }else{
         
         include '../db_connection/db_conn.php';

         $sql = "SELECT * FROM user WHERE username = '$user'";
         $stmt= $conn->prepare($sql);
         $stmt->execute();
         // le nombre de ligne trouvées
         // $row_count = $stmt->fetchColumn();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         if($row){
            $passMd5 = md5($pass);
            if($passMd5 === $row['pass']){
               $_SESSION['username'] = $user;
               $_SESSION['nom'] = $row['nom'];
               $_SESSION['prenom'] = $row['prenom'];
               header("Location: homeAdmin.php");
               exit();
            }else{
               session_unset();
               session_destroy();
               header("Location: loginAdminForm.php?error=invalid password");
               exit();
            }
         }else{
            session_unset();
            session_destroy();
            header("Location: loginAdminForm.php?error=invalid username");
            exit();
         }
         
          
      }

   }else{
      session_unset();
      session_destroy();
      header("Location:loginAdminForm.php");
      exit;
   }


?>