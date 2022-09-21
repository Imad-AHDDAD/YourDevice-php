<?php
session_start();
   if (array_key_exists('username_client_connected', $_SESSION) && array_key_exists('name_client_connected', $_SESSION)){ 
      header("Location:index.php");
      exit();
   }else{

      if(isset($_POST['client_email_reset_form'])){
         $email = filter_var($_POST['client_email_reset_form'] , FILTER_VALIDATE_EMAIL);
         if($email){
            include "../db_connection/db_conn.php";
            $sql = "SELECT * FROM client WHERE email_client = '$email'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
               
               
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
                        padding: 10px 15px;
                        position: relative;
                        top: 80px;
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
                     You have just Tried to reset your password on <span>YOUR DEVICE</span> - the best laptops and phones online store! <br>
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
               $mail->addAddress("$email", 'imad');  // Add a recipient 
               $mail->addReplyTo('ahddadmailer@gmail.com', 'reply');
               
               $mail->isHTML(true);                                  // Set email format to HTML
               
               $mail->Subject = 'YOUR DEVICE Account verification';
               $mail->Body    = $message;
               $mail->AltBody = 'YOUR DEVICE Account verification';
               
               if(!$mail->send()) {
                  header("Location: passwordResetForm.php?error=verification code not sent");
                  exit();
               } else {
                  session_start();
                  $_SESSION["code_to_reset_password"] = $verificationCode;
                  $_SESSION["email_to_reset"] = $email;
                  header("Location: VerificationFormToResetPassword.php");
                  exit();
               }



            }else{
               header("Location:passwordResetForm.php?error=Email Not Found");
               exit();
            }
         }else{
            header("Location:passwordResetForm.php?error=invalid email");
            exit();
         }
      }else{
         header("Location:passwordResetForm.php?error=invalid email");
         exit();
      }
   }
?>