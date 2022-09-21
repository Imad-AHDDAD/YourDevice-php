<?php

   try{
   $servername = 'localhost';
   $dbname = 'e-commerce_db';
   $username = 'root';
   $password = '';

   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
   }catch (Exception $e)
   {
   $e->getMessage();
   }

?>