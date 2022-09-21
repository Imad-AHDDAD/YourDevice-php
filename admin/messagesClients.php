<?php
session_start();

   if($_SESSION['username'] && $_SESSION['nom'] && $_SESSION['prenom']){

      include "../db_connection/db_conn.php";
      $user = $_SESSION['username'];
      $nom = $_SESSION['nom'];
      $prenom = $_SESSION['prenom'];

      $sql = "SELECT * FROM messagesclients";
      $stmt= $conn->prepare($sql);
      $stmt->execute();
      // le nombre de ligne trouvées
      // $row_count = $stmt->fetchColumn();
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>
   <link rel="stylesheet" href="../css/homeAdmin.css">
   <link rel="stylesheet" href="../css/listProducts.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
   <script type='text/javascript' src='https://johannburkard.de/resources/Johann/jquery.highlight-4.js'></script>
   <style type='text/css'>

      .highlight {
         background-color: yellow;
         color: #2C3E50; 
      }
      .current {
         background-color: #5cb85c !important;
         color: #fff; 
         padding: 0 .5rem;
      }

      .content{
         margin-top: 7rem;
      }

   </style>
</head>
<body>

   <nav>
      <div><img src="../images/avatar.jpg" alt=""><label for=""><?php echo strtoupper($nom)." ".$prenom ?></label></div>

      <div id="frmMain">
         <input type="text" id="searchTerm" placeholder="Search in page ...">
         <button type="button" id="btnNext"><i class="fa-solid fa-chevron-down"></i></button>
         <button type="button" id="btnPrev"><i class="fa-solid fa-chevron-up"></i></button>
      </div>

      <div><a href="homeAdmin.php" class="home">Home</a>
      <a href="logout.php">Logout</a></div>
   </nav>

   <section class="content" id="bodyContainer">

      <table>
         <tr><th colspan="6">Messages</th></tr>
         <tr>
            <th>ID</th>
            <th>Sender name</th>
            <th>Sender email</th>
            <th>Message</th>
            <th>Date</th>
            <th></th>
         </tr>
         <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               if ($row['seen']=='YES'){
                  $classColor="oui";
                  $valueButton = "Seen on : ".$row['date_seen'];
                  $controller = "";

               }else{
                  $classColor="non";
                  $valueButton = "Mark as seen";
                  $controller = "markAsSeenMsg.php";
               }
         ?>
         <tr>
            <td class="<?php echo $classColor ?>"><?php echo $row['id'] ?></td>
            <td class="<?php echo $classColor ?>"><?php echo $row['client_name'] ?></td>
            <td class="<?php echo $classColor ?>"><?php echo $row['client_email'] ?></td>
            <td class="<?php echo $classColor ?>"><?php echo $row['client_msg'] ?></td>
            <td class="<?php echo $classColor ?>"><?php echo $row['date_msg'] ?></td>
            <td class="<?php echo $classColor ?>"><form style="margin: 0;" action="<?php echo $controller ?>" method="POST"><button type="submit" name='id_msg_seen' value="<?php echo $row['id'] ?>" class="Modify"><?php echo $valueButton ?></button></form></td>
         </tr>
         <?php } ?>
      </table>

      <?php
         if(isset($_GET["success"])){
      ?>
         <p class="success"><?php echo $_GET["success"] ?></p>
      <?php } ?>

   </section>

   
</body>

<script type='text/javascript'>
    var lstEl = null;
    var cntr = -1;

    $(document).ready(function() {
        $('#searchTerm').keyup(function() {
            lstEl = null;
            cntr = -1;
            var vl = document.getElementById('searchTerm').value;
            $("#bodyContainer").removeHighlight();
            $("#bodyContainer").highlight(vl);
        });

        $('#btnNext').click(function() {
            if (lstEl === null) {
                lstEl = $('#bodyContainer').find('span.highlight');
                if (!lstEl || lstEl.length === 0) {
                    lstEl = null;
                    return;
                }
            }
            if (cntr < lstEl.length - 1) {
                cntr++;
                var cntrlast = cntr -1;
                if (cntr > 0) {
                    $(lstEl[cntrlast]).removeClass('current');
                }

                var elm = lstEl[cntr];
                $(elm).addClass('current');
            } else
                alert("End of search reached!");
        });

        $('#btnPrev').click(function() {
            if (lstEl === null) {
                lstEl = $('#bodyContainer').find('span.highlight');
                if (!lstEl || lstEl.length === 0) {
                    lstEl = null;
                    return;
                }
            }
            if (cntr > 0) {
                cntr--;
                if (cntr < lstEl.length) {
                    $(lstEl[cntr + 1]).removeClass('current');
                }
                var elm = lstEl[cntr];
                $(elm).addClass('current');
            } else
                alert("Begining of search!");
        });
    });
</script>

</html>

<?php 
   }else{
      header("Location:loginAdminForm.php");
      exit();
   }
?>


