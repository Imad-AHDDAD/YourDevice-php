<?php
session_start();
use Dompdf\Dompdf;
require_once '../vendor/autoload.php';
include "../db_connection/db_conn.php";
if (array_key_exists('username_client_connected', $_SESSION) && array_key_exists('name_client_connected', $_SESSION)){ 
if($_COOKIE['id_payment'] && $_COOKIE['status_payment'] && $_COOKIE['value_payment'] && $_COOKIE['currency_payment'] && $_COOKIE['id_product'] && $_COOKIE['qty'] && $_COOKIE['payer_id'] && $_COOKIE['payer_address'] && $_COOKIE['payer_name']){
   
   $id_payment = $_COOKIE['id_payment'];
   $status_payment = $_COOKIE['status_payment'];
   $value_payment = $_COOKIE['value_payment'];
   $currency_payment = $_COOKIE['currency_payment'];

   $payer_id = $_COOKIE['payer_id'];
   $payer_address = $_COOKIE['payer_address'];
   $payer_name = $_COOKIE['payer_name'];
   $id_product = $_COOKIE['id_product']; 
   $qty = $_COOKIE['qty'];

   //le nom de produit et le prix
   $sql0 = "SELECT * FROM produit WHERE id_produit = $id_product";
   $stmt0 = $conn->prepare($sql0);
   $stmt0->execute();
   $row0 = $stmt0->fetch(PDO::FETCH_ASSOC);
   $nom_produit = $row0['nom_produit'];
   $price = $row0['nouveau_prix'];

   //l'id de client
   $username_client_connected = $_SESSION['username_client_connected'];
   $sql5 = "SELECT * FROM client WHERE username_client = '$username_client_connected'";
   $stmt5 = $conn->prepare($sql5);
   $stmt5->execute();
   $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
   $id_client_connected = $row5['id_client'];

   // enregistrer le paiement
   $sql1 = "INSERT INTO payments(id_payment , status_payment , value_payment , currency_payment , id_product , qty) VALUES('$id_payment','$status_payment',$value_payment,'$currency_payment',$id_product,$qty)";
   $stmt1 = $conn->prepare($sql1);

   // enregistrer la commande
   $sql2 = "INSERT INTO commande(id_product , id_client , qte , address_payer , id_payment , id_payer) VALUES($id_product,$id_client_connected,$qty,'$payer_address','$id_payment','$payer_id')";
   $stmt2 = $conn->prepare($sql2);

   if($stmt1->execute() && $stmt2->execute()){
      $sql3 = "SELECT * FROM produit WHERE id_produit = $id_product";
      $stmt3 = $conn->prepare($sql3);
      $stmt3->execute();
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $qte_stock = $row3['qte_stock'];
      $nbr_ventes = $row3['nbr_ventes'];
      $new_qte_stock = $qte_stock - $qty;
      $new_nbr_ventes = $nbr_ventes + $qty;

      $sql4="UPDATE produit SET qte_stock = $new_qte_stock , nbr_ventes = $new_nbr_ventes WHERE id_produit = $id_product";
      $stmt4 = $conn->prepare($sql4);
      if($stmt4->execute()){
         
         // generate pdf
         $date = date('d-m-y h:i:s');

         $sql6 = "SELECT * FROM client WHERE id_client = $id_client_connected";
         $stmt6 = $conn->prepare($sql6);
         $stmt6->execute();
         $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);

         $html='<!DOCTYPE html>
         <html lang="en">
         <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Facture</title>
            <style>
               *{
                  margin: 0;
                  padding: 0;
               }

               .content{
                  display: flex;
                  flex-direction: column;
                  padding: 50px 10% 0;
               }

               .content .logo{
                  background-color: #5cb85c;
                  padding: 20px 10px;
                  color: white;
                  margin: 30px 0;
                  font-size: 35px;
               }

               .content .date{
                  background-color: #5cb85c;
                  padding: 20px 10px;
                  color: white;
                  margin: 10px 0;
                  font-size: 20px;
               }

               .content .slogan{
                  font-size: 18px;
                  color: #2C3E50;
               }

               .content .infos{
                  display: flex;
                  flex-direction: column;
                  align-items: flex-start;
                  font-size: 22px;
                  color: #2C3E50;
                  border: 2px solid #2C3E50;
                  padding: 20px;
                  margin: 20px 0;

               }

               .content table{
                  width: 100%;
                  margin: 0 auto;
               }

               td , th{
                  padding: 10px 20px;
                  font-size: 22px;
               }

               th{
                  background-color: #cd313b;
                  color: white;
               }

               td{
                  color: #2C3E50;
                  border: 2px solid #2C3E50;
               }

               tr:last-child td{
                  background-color: #2C3E50;
                  color: white;
               }

               .titre{
                  text-align: center;
                  background-color: #2C3E50;
                  color: #fff;
                  padding: 10px;
                  margin: 20px 0;
               }

               hr{
                  color: #2C3E50;
                  margin-top: 50px;
               }

               .footer p{
                  color: #2C3E50;
                  text-align: center;
                  padding: 10px 0 30px;
                  font-size: 18px;
               }
            
            </style>
         </head>
         <body>

            <div class="content">
               <label class="logo">YOUR DEVICE</label><br>
               <label class="slogan">The best laptops and phones online store !</label><br>
               <div class="infos">
                  <label for="">CLIENT</label><br>
                  <label for="">'.strtoupper($row6['name_client']).'</label><br>
                  <label for="">Address : '.$row6['address_client'].'</label><br>
                  <label for="">Email : '.$row6['email_client'].'</label><br>
                  <label for="">Phone : '.$row6['phone_client'].'</label><br>
               </div>
               
               <label class="date">Date : '.$date.'</label><br>
               <h1 class="titre">PAYMENT RECEIPT</h1>
               
               <table>
                  <thead>
                     <tr><th colspan="4">PAYMENT N° : '.$id_payment.'</th></tr>
                     <tr>
                        <th>PRODUCT</th>
                        <th>QUANTITY</th>
                        <th>PRICE</th>
                        <th>TOTAL</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>'.$row3["nom_produit"].'</td>
                        <td>'.$qty.'</td>
                        <td>'.number_format($row3["nouveau_prix"] , 2).'</td>
                        <td>'.number_format($row3["nouveau_prix"] , 2).'</td>
                     </tr>
                     <tr>
                        <td colspan="2"></td>
                        <td>TOTAL</td>
                        <th>'.number_format($value_payment , 2)." ".$currency_payment.'</th>
                     </tr>
                     <tr><td colspan="4">YOUR DEVICE - THANK YOU FOR YOUR CONFIDENCE</td></tr>
                  </tbody>
               </table>

               <hr>
               <div class="footer">
                  <p>YOUR DEVICE<br>The best laptops and phones online store !<br>RC:xxxxxxx , CNSS:xxxxxx , Email : yourdevice@mail.xxx<br>address : FSTG-Marrakech - IRISI 1</p>
               </div>
            </div>
      
         </body>
         </html>';

         $dompdf = new Dompdf();
         $dompdf->loadHtml($html);
         $dompdf->setPaper('A4', 'portrait');
         $dompdf->render();

         $nameFacture = "../factures/receipt".$id_payment.".pdf";
         $n = "receipt".$id_payment;
         $sql2 = "UPDATE commande SET receipt = '$n' WHERE id_payment = '$id_payment'";
         $stmt2 = $conn->prepare($sql2);
         $stmt2->execute();

         $output = $dompdf->output();
         file_put_contents($nameFacture, $output);
      

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Payment | Success</title>
   <link rel="shortcut icon" href="../images/favicon.ico">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/index.css">
   <script src="../js/script.js"></script>
   <script src="../js/searchScript.js"></script>
   <style>
      .content{
         height: calc(100vh - 6rem);
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         gap: 2rem;
      }

      .content p{
         font-size: 2.5rem;
         color: #5cb85c;
         text-align: center;
         font-weight: 600;
      }

      .content table{
         width: 100%;
      }

      .content table th , .content table td{
         padding: 1rem 2rem;
         font-size: 2rem;
         text-align:center;
      }

      .content table td , .content table #head{
         color: #2C3E50;
         border: .1rem solid #2C3E50;
      }

      .content table tr:first-child th{
         background-color: #cd313b;
         color: white;
      }
      .content table tr:last-child td{
         background-color: #2C3E50;
         color: white;
         text-align: center;
      }

      .content a{
         background-color: #cd313b;
         padding: 1rem 2rem;
         border: none;
         border-radius: .5rem;
         color: white;
         font-size: 2rem;
      }

      nav{
         top: 0;
      }

      @media (max-width: 1250px){
         .content{
            margin-top: 2rem;
         }
      }

      .user{
         margin-right: .5rem;
      }

      #cart{
         cursor: pointer;
         width: 10rem;
         height: 10rem;
         position: fixed;
         bottom: 2rem;
         right: 2rem;
         display: flex;
         flex-direction: column;
         justify-content : center;
         align-items: center;
         animation: Move 2s infinite;
      }

      #cart button{
         color: white;
         background-color: #cd313b;
         width: 3rem;
         height: 3rem;
         border : none;
         border-radius: 50%;
         position: absolute;
         top: 1rem;
         right: 1rem;
         z-index: 1000;
      }

      .fa-cart-shopping{
         color: white;
         background-color: #5cb85c;
         padding: 2rem;
         font-size: 2rem;
         border: none;
         border-radius: 50%;
      }

      /* key frames */
      @keyframes Move {
         0% { transform: translate(0 ,0);}
         20% { transform: translate(0 ,-.6rem);}
         40% { transform: translate(0 ,.6rem);}
         60% { transform: translate(0 ,-.6rem);}
         80% { transform: translate(0 ,.6rem);}
         100% { transform: translate(0 ,0);}
      }
   </style>
</head>
<body>

   <nav>
      <div class="logo">
         <label for=""><i class="fa-solid fa-gear"></i> YOUR <span>DEVICE</span></label>
      </div>
      
      <div class="menu_and_search">
         
         <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a class="login" href="listLaptops.php">Laptops</a></li>
            <li><a class="login" href="listPhones.php">Phones</a></li>
            <li><a href="contactForm.php">Contact</a></li>
            <li><a href="index.php#popular">Popular</a></li>
            <li>
               <?php if (array_key_exists('username_client_connected', $_SESSION) && array_key_exists('name_client_connected', $_SESSION)){ ?>
                  <a class="login" href="client_profile.php"><i class="fa-solid fa-user user"></i><?php echo $_SESSION['name_client_connected'] ?></i></a>
               <?php }else{
                  session_unset();
                  session_destroy();
               ?>
                  <a class="login" href="clientLogin.php">Login<i class="fa-solid fa-right-to-bracket"></i></a>
               <?php } ?>
            </li>
         </ul>

         <div class="search">
            <form action="searchPage.php" method="GET">
               <input type="text" name="search_text" id="search" placeholder="search">
               <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <div id="list">
               
            </div>
         </div>
         
      </div>
      <i id="menuIcon" class="fa-solid fa-bars"></i>
   </nav>

   <section class="content">
      <table>
         <tr><th colspan="4">ID-Payment : <?php echo $id_payment ?></th></tr>
         <tr>
            <th id="head">Product</th>
            <th id="head">Quantity</th>
            <th id="head">Price</th>
            <th id="head">Total</th>
         </tr>
         <tr>
            <td><?php echo $nom_produit; ?></td>
            <td><?php echo $qty; ?></td>
            <td><?php echo $price; ?></td>
            <td><?php echo $value_payment;?></td>
         </tr>
         <tr></tr>
         <tr></tr>
         <tr><td colspan="4">YOUR DEVICE - THANK YOU FOR YOUR CONFIDENCE</td></tr>
      </table>

      <a href="../factures/receipt<?php echo $id_payment?>.pdf" target="_blank">DOWNLOAD PDF</a><br>
   </section>

   <section class="footer">

      <div class="box-container">

         <div class="box" id="contact">
            <h3>contact info</h3>
            <a href="#"><i class="fas fa-phone"></i> +212 600 000 000 </a>
            <a href="#"><i class="fas fa-envelope"></i> ouremailaddress@gmail.com </a>
            <a href="#"><i class="fas fa-map-marker-alt"></i> Country , CITY - POSTAL CODE </a>
         </div>

         <div class="box">
            <h3>follow us</h3>
            <a target="_blank" href="#"><i class="fab fa-facebook-f"></i> facebook </a>
            <a target="_blank" href="#"><i class="fab fa-instagram"></i> instagram </a>
            <a target="_blank" href="#"><i class="fab fa-linkedin"></i> linkedin </a>
         </div>

         <div class="box">
            <img src="../images/pub-footer.gif" alt="pub-footer">
         </div>

         <div class="box">
            <img src="../images/pub-footer2.gif" alt="pub-footer">
         </div>

      </div>

      <div class="credit"><i class="fa-solid fa-gear"></i> YOUR DEVICE | <span>All rights reserved </span><span id="year"></span> </div>

   </section>

   <?php if (array_key_exists('username_client_connected', $_SESSION) && array_key_exists('name_client_connected', $_SESSION)){
      $username_client = $_SESSION['username_client_connected'];
      include "../db_connection/db_conn.php";
      $sql="SELECT * FROM client WHERE username_client = '$username_client'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $id_client = $row['id_client'];

      $sql2 = "SELECT * FROM cart WHERE id_client = '$id_client'";
      $stmt2 = $conn->prepare($sql2);
      $stmt2->execute();

      $number = 0;
      while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
         $number = $number + 1;
      }
      
   ?>
   
      <a href="client_profile.php"><div id="cart">
      <?php if($number != 0){?><button><?php echo $number; ?></button><?php } ?>
         <i class="fa-solid fa-cart-shopping"></i>
      </div></a>

   <?php } ?>
   
</body>
</html>

<?php  
         }else{
            header("Location:index.php?errorpayment");
            exit();
         }
         
      }else{
         header("Location:index.php?errorpayment");
         exit();
      }

   }else{
      header("Location:index.php?errorpayment");
      exit();
   }
}else{
   header("Location:clientLogin?errorpayment");
   exit();
}
?>