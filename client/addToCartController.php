<?php
   session_start();
   if (array_key_exists('username_client_connected', $_SESSION) && array_key_exists('name_client_connected', $_SESSION)){    
      if(isset($_POST['id_product_to_add'])){
         include "../db_connection/db_conn.php";

         $id_product = $_POST['id_product_to_add'];
         $username_client = $_SESSION['username_client_connected'];

         $sql="SELECT * FROM client WHERE username_client = '$username_client'";
         $stmt = $conn->prepare($sql);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         $id_client = $row['id_client'];

         $sql4 = "SELECT * FROM produit WHERE id_produit = $id_product";
         $stmt4 = $conn->prepare($sql4);
         $stmt4->execute();
         $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
         $price = $row4['nouveau_prix'];

         $sql3 = "SELECT * FROM cart WHERE id_produit = $id_product AND id_client = $id_client";
         $stmt3 = $conn->prepare($sql3);
         $stmt3->execute();
         $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);

         if($row3){
            header("Location:buy_product_page.php?id_product=$id_product&error=this element is already added to your cart");
            exit();
         }else{

            $sql2 = "INSERT INTO cart(id_client , id_produit , total) VALUES ($id_client , $id_product , $price)";
            $stmt2 = $conn->prepare($sql2);
            if($stmt2->execute()){
               header("Location:buy_product_page.php?id_product=$id_product&success=added to your cart successfully");
               exit();
            }else{
               header("Location:buy_product_page.php?id_product=$id_product&error=failed to add this element to your cart");
               exit();
            }
         }

      }else{
         header("Location:clientLogin.php");
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