<?php
   session_start();
   if (array_key_exists('username_client_connected', $_SESSION) && array_key_exists('name_client_connected', $_SESSION)){    
      if(isset($_POST['qte_commande']) && isset($_POST['id_product_to_buy'])){
         include "../db_connection/db_conn.php";

         $id = $_POST['id_product_to_buy'];
         $sql = "SELECT * FROM produit WHERE id_produit = $id";
         $stmt = $conn->prepare($sql);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);

         $price = $row['nouveau_prix'];
         $qte = $_POST['qte_commande'];
         $total = $price*$qte;
   ?>
   
   <!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Payment | <?php echo $row['nom_produit'] ?></title>
      <link rel="shortcut icon" href="../images/favicon.ico">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <link rel="stylesheet" href="../css/index.css">
      <link rel="stylesheet" href="../css/buy_product_page.css">
      <script src="../js/searchScript.js"></script>
      <style>
         nav{
            top: 0;
         }

         #paypal-button-container{
            margin-top: 2rem;
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
               <li><a class="login" href="listPhones">Phones</a></li>
               <li><a href="contactForm.php">Contact</a></li>
               <li><a href="index.php#popular">Popular</a></li>
               <li>
                  <?php if (array_key_exists('username_client_connected', $_SESSION) && array_key_exists('name_client_connected', $_SESSION)){ ?>
                     <a class="login" href="client_profile.php"><i class="fa-solid fa-user user"></i> <?php echo $_SESSION['name_client_connected'] ?></i></a>
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
   
      <h1 class="title"><?php echo $row['nom_produit'] ?></h1>
   
      <section class="container">
         <div class="row">
            <div class="image">
               <img src="<?php echo "../images/".$row['img'] ?>" alt="image">
            </div>
            <div class="content">
                     <h1><?php echo $row['nom_produit'] ?></h1>
                     <label><?php echo $row['nouveau_prix']." $" ?></label>
                     <p>Quantity = <?php echo $qte ?></p>
                     <p>Total = <?php echo $total." $" ?></p>
                     <!-- Replace "test" with your own sandbox Business account app client ID -->
                     <script src="https://www.paypal.com/sdk/js?client-id=Aat3313ZCFWa-HNNGPnn5zGrUIZPOJxuOM9iQv9AGtDRMvS3WSiq3KCuP-5fD6bOCxBieQZe3VS-TgBH&currency=USD"></script>
                     <!-- Set up a container element for the button -->
                     <div id="paypal-button-container"></div>
                     <script>
                        paypal.Buttons({
                        // Sets up the transaction when a payment button is clicked
                        createOrder: (data, actions) => {
                           return actions.order.create({
                              purchase_units: [{
                              amount: {
                                 value: '<?php echo $total ?>' // Can also reference a variable or function
                              }
                              }]
                           });
                        },
                        // Finalize the transaction after payer approval
                        onApprove: (data, actions) => {
                           return actions.order.capture().then(function(orderData) {
                              // Successful capture! For dev/demo purposes:
                              console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                              const transaction = orderData.purchase_units[0].payments.captures[0];
                              console.log(orderData);
                              // alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                              // const element = document.getElementById('paypal-button-container');
                              // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                              // Or go to another URL:
                              // actions.redirect('onApprove.php');
                              // window.location.replace("onApprove.php");

                              let id_payment = orderData.purchase_units[0].payments.captures[0].id;
                              let status_payment = orderData.purchase_units[0].payments.captures[0].status;
                              let value_payment = orderData.purchase_units[0].payments.captures[0].amount.value;
                              let currency_payment = orderData.purchase_units[0].payments.captures[0].amount.currency_code;
                              let payer_id = orderData.payer.payer_id;
                              let payer_name = orderData.payer.name.given_name + " " + orderData.payer.name.surname;
                              let payer_address = orderData.payer.address.address_line_1 + " " + orderData.payer.address.admin_area_2 + " " + orderData.payer.address.postal_code;
                              let id_product = <?php echo $id ?>;
                              let qty = <?php echo $qte ?>;

                              createCookie("id_payment", id_payment);
                              createCookie("status_payment", status_payment);
                              createCookie("value_payment", value_payment);
                              createCookie("currency_payment", currency_payment);
                              createCookie("id_product", id_product);
                              createCookie("qty", qty);
                              createCookie("payer_id", payer_id);
                              createCookie("payer_address", payer_address);
                              createCookie("payer_name", payer_name);
                                 
                              
                              function createCookie(name, value) {
                              let expires;
                                 let date = new Date();
                                 date.setTime(date.getTime() + (60 * 1000 * 5));
                                 expires = "; expires=" + date.toGMTString();
                                 document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
                              }

                             
                              window.location.replace("onApprove.php");

                           });
                        }
                        }).render('#paypal-button-container');
                     </script>
            </div>
         </div>

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
         header("Location:index.php?errorIsset");
         exit();
      }
   }else{
      if(isset($_POST['url'])){
         session_start();
         $_SESSION['url'] = $_POST['url'];
      }
      header("Location:clientLogin.php");
      exit();
   }

?>