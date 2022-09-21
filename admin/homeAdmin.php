<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){

      $user = $_SESSION['username'];
      $nom = $_SESSION['nom'];
      $prenom = $_SESSION['prenom'];

      include "../db_connection/db_conn.php";
      $sql2 = "SELECT * FROM messagesclients WHERE seen = 'NO'";
      $stmt2= $conn->prepare($sql2);
      $stmt2->execute();
      $nbrMsgNotSeen = 0;
      while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
         $nbrMsgNotSeen = $nbrMsgNotSeen + 1;
      }

   
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home | Admin</title>
   <link rel="stylesheet" href="../css/homeAdmin.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>

      <nav>
         <div><img src="../images/avatar.jpg" alt=""><label for=""><?php echo strtoupper($nom)." ".$prenom ?></label></div>
         <a href="logout.php">Logout</a>
      </nav>

      <section class="operations">

      <div class="op">
         <i class="fa-solid fa-laptop"></i>
         <div class="title">
            <h1>Laptops</h1>
         </div>
         <a href="listLaptops.php">List</a>
      </div>

      <div class="op">
         <i class="fa-solid fa-mobile-screen"></i>
         <div class="title">
            <h1>Phones</h1>
         </div>
         <a href="listPhones.php">List</a>
      </div>

      <div class="op">
         <i class="fa-solid fa-user-tie"></i>
         <div class="title">
            <h1>Clients</h1>
         </div>
         <a href="listClients.php">List</a>
      </div>

      <div class="op">
         <i class="fa-solid fa-cart-arrow-down"></i>
         <div class="title">
            <h1>Orders</h1>
         </div>
         <a href="listOrders.php">List</a>
      </div>

      <div class="op">
         <i class="fa-solid fa-money-bill"></i>
         <div class="title">
            <h1>Payments</h1>
         </div>
         <a href="listPayments.php">List</a>
      </div>

      <div class="op">
         <i class="fa-solid fa-message"></i>
         <div class="title">
            <h1>Inbox</h1>
         </div>
         <a href="messagesClients.php">See</a>
      </div>

      </section>

      <?php if($nbrMsgNotSeen != 0){ ?>
      <a href="messagesClients.php"><div class="messages">
         <div class="nbrMsgNotSeen"><?php echo $nbrMsgNotSeen ?></div>
         <i class="fa-solid fa-comment"></i>
      </div></a>
      <?php } ?>
   
</body>
</html>

<?php 
   }else{
      header("Location:loginAdminForm.php");
      exit();
   }
?>