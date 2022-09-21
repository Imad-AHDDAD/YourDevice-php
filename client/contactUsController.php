<?php

   if(isset($_POST['name_client']) && isset($_POST['email_client']) && isset($_POST['client_message'])){
      
      $client_name = filter_var($_POST['name_client'] , FILTER_SANITIZE_STRING);
      $client_email = filter_var($_POST['email_client'] , FILTER_VALIDATE_EMAIL);
      $client_message = filter_var($_POST['client_message'] , FILTER_SANITIZE_STRING);

      if($client_email && $client_message && $client_name){
         
               $message = "<!DOCTYPE html>
               <html lang='en'>
               <head>
                 <meta charset='UTF-8'>
                 <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                 <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                 <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css'>
                 <style>
                  h1{
                    text-align : center;
                    color: #2C3E50;
                  }
               
                  h1 span{
                   color: #cd313b;
                  }
               
                 </style>
               </head>
               <body>
                 <h1>Email From Your Website <span>YOUR DEVICE</span></h1>
                 <table class='table table-striped mx-auto mt-5'>
                   <tr>
                     <th style='color: #cd313b;' class='text-center'>Client Name</th>
                     <th style='color: #cd313b;' class='text-center'>Client Email</th>
                     <th style='color: #cd313b;' class='text-center'>Client Message</th>
                   </tr>
                   <tr>
                     <td style='color: #2C3E50; padding: 1rem 3rem' class='fs-5'>$client_name</td>
                     <td style='color: #2C3E50; padding: 1rem 3rem' class='fs-5'>$client_email</td>
                     <td style='color: #2C3E50; padding: 1rem 3rem' class='fs-5'>$client_message</td>
                   </tr>
                 </table>
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
               $mail->addAddress("imadahddad02@gmail.com", 'imad');  // Add a recipient 
               $mail->addReplyTo('ahddadmailer@gmail.com', 'reply');
               
               $mail->isHTML(true);                                  // Set email format to HTML
               
               $mail->Subject = 'Message Form Your Website : YOUR DEVICE';
               $mail->Body    = $message;
               $mail->AltBody = "Message From $client_name";
               
               if(!$mail->send()) {
                  header("Location: contactForm.php?error=message not sent !");
                  exit();
               } else {
                 include "../db_connection/db_conn.php";
                  $sql="INSERT INTO messagesClients(client_name , client_email , client_msg) VALUES ('$client_name' , '$client_email' , '$client_message')";
                  $stmt=$conn->prepare($sql);
                  if($stmt->execute()){
                    header("Location: contactForm.php?success=message sent successfully");
                    exit();
                  }else{
                    header("Location: contactForm.php?success=message sent successfully but not saved on db");
                    exit();
                  }
                  
               }

      }else{
         header("Location: contactForm.php?error=incompleted informations");
         exit();
      }
   }else{
      header("Location: contactForm.php");
      exit();
   }

?>

