<?php
   session_start();
   if(isset($_GET['id_product'])){
      include "../db_connection/db_conn.php";
      $id = $_GET['id_product'];

      $req="SELECT min(id_produit) AS min_id , max(id_produit) AS max_id FROM produit";
      $stmt0 = $conn->prepare($req);
      $stmt0->execute();
      $row0 = $stmt0->fetch(PDO::FETCH_ASSOC);

      $min = $row0['min_id'];
      $max = $row0['max_id'];

      if($id >= $min && $id <= $max){

         $sql = "SELECT * FROM produit WHERE id_produit = $id";
         $stmt = $conn->prepare($sql);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo $row['nom_produit'] ?></title>
   <link rel="shortcut icon" href="../images/favicon.ico">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/index.css">
   <link rel="stylesheet" href="../css/buy_product_page.css">
   <style>
      nav{
         top: 0;
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

         .qte{
            display: flex;
            gap: 1rem;
            font-size: 2rem;
            justify-content : flex-start;
            align-items: center;
            margin-top: 2rem;
         }

         h5{
            color: #cd313b;
            font-size: 1.7rem;
            margin-top: 1rem;
            margin-bottom: -1rem;
         }

         .qte i{
            color: #5cb85c;
            cursor: pointer;
            border: .1rem solid #2C3E50;
            padding: .5rem;
            border-radius: .5rem;
         }

         .qte input{
            color: #2C3E50;
            font-weight: 600;
            padding: 0 1rem;
            width: 5rem;
            height: 4rem;
            font-size : 2rem;
            text-align: center;
         }

         .qte input::-webkit-outer-spin-button,
         .qte input::-webkit-inner-spin-button {
         -webkit-appearance: none;
         margin: 0;
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
   <script src="../js/paiementPage.js"></script>
   <script src="../js/searchScript.js"></script>
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
                  <p><?php echo $row['libelle_produit'] ?></p>
                  <p style="color: #cd313b"><?php if($row['qte_stock'] > 0) echo "avalaible"; ?></p>
                  <label><?php echo $row['nouveau_prix']." $" ?></label>
                  <form action="addToCartController.php" class="addCart" method="POST">
                     <input type="text" name="url" id="url" hidden value=<?php echo $_SERVER['REQUEST_URI']; ?>>
                     <button name="id_product_to_add" value="<?php echo $id ?>" class="add">add to cart</button></form>
                  <form action="paiementPage.php" class="buyProduct" method="POST">
                  <h5>Quantity :</h5>
                     <div class="qte">
                           <i id="moins" class="fa-solid fa-minus"></i><input type="number" name="qte_commande" value="1" id="qte" readonly><i id="plus" class="fa-solid fa-plus"></i>
                     </div>
                     <input type="text" name="url" id="url" hidden value=<?php echo $_SERVER['REQUEST_URI']; ?>>
                     <button name="id_product_to_buy" type="submit" value="<?php echo $id ?>" class="buy">buy now</button>
                  </form>

                  <?php 
                     if(isset($_GET['error'])){
                  ?>
                  <p class="error"><?php echo $_GET['error']?></p>
                  <?php } ?>

                  <?php 
                     if(isset($_GET['success'])){
                  ?>
                  <p class="success"><?php echo $_GET['success']?></p>
                  <?php } ?>
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
         header("Location:index.php?errorId=$id");
         exit();
      }
   }else{
      header("Location:clientLogin.php");
      exit();
   }
?>
