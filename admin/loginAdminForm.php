<?php
session_start();

   if(array_key_exists('username', $_SESSION)){
      header("Location:homeAdmin.php");
      exit;
   }else{
      session_unset();
      session_destroy();
   
?> 


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login | Admin</title>
   <link rel="stylesheet" href="../css/loginAdminForm.css">
</head>
<body>

   

   <form action="loginAdminController.php" method="POST">
      <h1>Admin | Login</h1>
      <label for="">Username:</label>
      <input name="username" type="text" required>         
      <label for="">Password:</label>
      <input name="password" type="password" required>        
      <button type="submit">Login</button>

      <?php
         if(isset($_GET["error"])){
      ?>
         <p class="error"><?php echo $_GET["error"] ?></p>
      <?php } ?>
   </form>

   
</body>
</html>

<?php
   }
?>