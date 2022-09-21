<?php

      session_start();
      $errorExists = 0;

      
      unset($_SESSION['values']);
      $_SESSION['values']['FullNameCreate'] = "";
      $_SESSION['values']['emailCreate'] = "";
      $_SESSION['values']['phoneCreate'] = "";
      $_SESSION['values']['addressCreate'] = "";
      $_SESSION['values']['countryCreate'] = "";
      $_SESSION['values']['usernameCreate'] = "";
      $_SESSION['values']['passwordCreate'] = "";
      $_SESSION['values']['passwordCnfCreate'] = "";

      unset($_SESSION['errors']);
      $_SESSION['errors']['FullNameCreate'] = "hidden";
      $_SESSION['errors']['emailCreate'] = "hidden";
      $_SESSION['errors']['phoneCreate'] = "hidden";
      $_SESSION['errors']['addressCreate'] = "hidden";
      $_SESSION['errors']['countryCreate'] = "hidden";
      $_SESSION['errors']['usernameCreate'] = "hidden";
      $_SESSION['errors']['password'] = "hidden";
      $_SESSION['errors']['passwordCnf'] = "hidden";


      // la fonction qui verifie le nom
      function verifierNom($param){
         $regexNom = '/[a-z]{2,}/';
         return preg_match($regexNom, $param); // 1 si vrai
      }

      // la fonction qui verifie l'email
      function verifierEmail($param){
         $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
         return (preg_match($regex, $param));
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

      // la fonction qui verifie le numero username
      function verifierUsername($param){
         $regex = '/^[a-zA-Z\-]+$/'; 
         return (preg_match($regex, $param));
      }

      // la fonction qui verifie le mot de passe
      function verifierPassword($param){
         $regex = '/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/'; 
         return (preg_match($regex, $param));
      }

       // la fonction qui verifie la confirmationdu mot de passe
      function verifierPasswordCnf($param1, $param2){
         return $param1 === $param2;
      }


   if(isset($_POST['full_name']) && isset($_POST['email_create']) && isset($_POST['phone_create']) && isset($_POST['country']) && isset($_POST['address_create']) && isset($_POST['username_create']) && isset($_POST['password_create']) && isset($_POST['password_Cnf_create'])){

      $full_name = filter_var($_POST['full_name'] , FILTER_SANITIZE_STRING);
      $email = filter_var($_POST['email_create'] , FILTER_VALIDATE_EMAIL);
      $phone = filter_var($_POST['phone_create'] , FILTER_SANITIZE_STRING);
      $country = filter_var($_POST['country'] , FILTER_SANITIZE_STRING);
      $address = filter_var($_POST['address_create'] , FILTER_SANITIZE_STRING);
      $username_client = filter_var($_POST['username_create'] , FILTER_SANITIZE_STRING);
      $pass = filter_var($_POST['password_create'] , FILTER_SANITIZE_STRING);
      $passCnf = filter_var($_POST['password_Cnf_create'] , FILTER_SANITIZE_STRING);

      if(verifierNom($full_name) == 0 || empty($full_name)){
         $errorExists = 1;
         $_SESSION['errors']['FullNameCreate']='showError';
      }

      if(verifierEmail($email) == 0 || empty($email)){
         $errorExists = 1;
         $_SESSION['errors']['emailCreate']='showError';
      }

      if(verifierPhone($phone) == 0 || empty($phone)){
         $errorExists = 1;
         $_SESSION['errors']['phoneCreate']='showError';
      }

      if(verifierNom($address) == 0 || empty($address)){
         $errorExists = 1;
         $_SESSION['errors']['addressCreate']='showError';
      }

      if(verifierUsername($username_client) == 0 || empty($username_client)){
         $errorExists = 1;
         $_SESSION['errors']['usernameCreate']='showError';
      }

      if(verifierPassword($pass) == 0 || empty($pass)){
         $errorExists = 1;
         $_SESSION['errors']['passwordCreate']='showError';
      }

      if(verifierPasswordCnf($pass , $passCnf) == 0 || empty($passCnf)){
         $errorExists = 1;
         $_SESSION['errors']['passwordCnfCreate']='showError';
      }
      
      if($GLOBALS['errorExists']==0){
         include "../db_connection/db_conn.php";
         $sql="SELECT * FROM client WHERE username_client = '$username_client' OR email_client";
         $stmt = $conn->prepare($sql);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);

         $sql2="SELECT * FROM client WHERE email_client = '$email'";
         $stmt2 = $conn->prepare($sql2);
         $stmt2->execute();
         $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

         if($row){
            header("Location:clientLogin.php?error2=username already used");
            exit();
         }else if($row2){
            header("Location:clientLogin.php?error2=email already used");
            exit();
         }else{
            if($pass == $passCnf){

               $verificationCode = rand();

               $message = "<!DOCTYPE html>
               <html lang='en'>
               <head>
                  <style>
                     body{
                        font-family: Bahnschrift;
                     }
                     body div{
                        
                        background-color: #2C3E50;
                        color: white;
                        font-size: 30px;
                        padding: 10px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                     }
               
                     p{
                        padding: 0 20%;
                        color: #2C3E50;
                        font-size: 22px;
                     }
               
                     p span{
                        color: #5cb85c;
                     }
               
                     p b{
                        background-color: #cd313b;
                        color: white;
                        padding: 5px 15px;
                        position: relative;
                        top: 100px;
                        font-size: 30px;
                        border: none;
                        border-radius: 10px;
                     }
                  </style>
               </head>
               <body>
               
                  <div>
                     <label>YOUR DEVICE</label>
                  </div>
                  <p>
                     Well done <span>"."$full_name"."</span> ,<br><br><br>
                     You have just joined <span>YOUR DEVICE</span> - the best laptops and phones online store! <br>
                     Just verify your email address with this verification code : <br>
                     <b>".$verificationCode."</b>
                  </p>
                  
               </body>
               </html>";

               require '../PHPMailer/PHPMailerAutoload.php';
               $mail = new PHPMailer;                                // Enable verbose debug output
               
               $mail->isSMTP();                                      // Set mailer to use SMTP
               $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
               $mail->SMTPAuth = true;                               // Enable SMTP authentication
               $mail->Username = 'ahddadmailer@gmail.com';           // SMTP username
               $mail->Password = 'sbvcrefjbjmaqzje';                 // SMTP password
               $mail->SMTPSecure = 'ssl';                            // Enable TLS 587 encryption, `ssl` also accepted 465
               $mail->Port = 465;                                    // TCP port to connect to
               
               $mail->setFrom('ahddadmailer@gmail.com', 'imad');
               $mail->addAddress("$email", "$full_name");  // Add a recipient 
               $mail->addReplyTo('ahddadmailer@gmail.com', 'reply');
               
               $mail->isHTML(true);                                  // Set email format to HTML
               
               $mail->Subject = 'YOUR DEVICE Account verification';
               $mail->Body    = $message;
               $mail->AltBody = 'YOUR DEVICE Account verification';
               
               if(!$mail->send()) {
                  header("Location: clientLogin.php?error2=verification code not sent");
                  exit();
                  // $mail->ErrorInfo
               } else {
                  session_start();
                  $_SESSION["code"] = $verificationCode;
                  $_SESSION["full_name"] = $full_name;
                  $_SESSION['email'] = $email;
                  $_SESSION['phone'] = $phone;
                  $_SESSION['country'] = $country;
                  $_SESSION['address'] = $address;
                  $_SESSION['username_client_register'] = $username_client;
                  $_SESSION['password_client_register'] = $pass;
                  header("Location: VerificationForm.php");
                  exit();
               }

            }else{
               header("Location:clientLogin.php?error2=incorrect password confirmation");
               exit();
            }
         }

      }else{
         $_SESSION['values']['FullNameCreate'] = $full_name;
         $_SESSION['values']['emailCreate'] = $email;
         $_SESSION['values']['phoneCreate'] = $phone;
         $_SESSION['values']['addressCreate'] = $address;
         $_SESSION['values']['usernameCreate'] = $username_client;
         header("Location:clientLogin.php?error2=incompleted informations");
         exit();
      }

   }else{
      header("Location:clientLogin.php?error2");
      exit();
   }
?>

