<?php

   include "../db_connection/db_conn.php";
   if(isset($_GET['idCart'])){
      $id = filter_var($_GET['idCart'] , FILTER_SANITIZE_NUMBER_INT);

      if(empty($id)){
         header('HTTP/1.1 400 Bad Request');
         exit('le message ne doit pas etre vide');
      }
      $sql = "SELECT * FROM cart WHERE id_cart = $id";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $idProduct = $row['id_produit'];

      $sql2 = "SELECT * FROM produit WHERE id_produit = $idProduct";
      $stmt2 = $conn->prepare($sql2);
      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

      $qty = $row['qty'];
      $price = $row2['nouveau_prix'];
      $total = $row['total'];

      $newQty = $qty + 1;
      $newTotal = $newQty*$price;
      

      // update database
      $sql3 = "UPDATE cart SET qty = $newQty , total = $newTotal WHERE id_cart = $id";
      $stmt3 = $conn->prepare($sql3);
      if($stmt3->execute()){
         $stmt->execute();
         $row4 = $stmt->fetch(PDO::FETCH_ASSOC);
         echo json_encode($row4);
         $stmt->closeCursor();
      }
   
      // $result_array = [];
      // while($row =$stmt->fetch()){
      //    array_push($result_array, $row['nom_produit']);
      // }
   
      // echo json_encode($result_array);
      // $stmt->closeCursor();
   }

?>