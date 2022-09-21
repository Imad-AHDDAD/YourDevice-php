<?php

if(!isset($_SESSION['values'])){
   $_SESSION['values']['FullNameCreate'] = "";
   $_SESSION['values']['emailCreate'] = "";
   $_SESSION['values']['phoneCreate'] = "";
   $_SESSION['values']['addressCreate'] = "";
   $_SESSION['values']['countryCreate'] = "";
   $_SESSION['values']['usernameCreate'] = "";
   $_SESSION['values']['passwordCreate'] = "";
   $_SESSION['values']['passwordCnfCreate'] = "";
}

if(!isset($_SESSION['errors'])){
   $_SESSION['errors']['FullNameCreate'] = "hidden";
   $_SESSION['errors']['emailCreate'] = "hidden";
   $_SESSION['errors']['phoneCreate'] = "hidden";
   $_SESSION['errors']['addressCreate'] = "hidden";
   $_SESSION['errors']['countryCreate'] = "hidden";
   $_SESSION['errors']['usernameCreate'] = "hidden";
   $_SESSION['errors']['passwordCreate'] = "hidden";
   $_SESSION['errors']['passwordCnfCreate'] = "hidden";
}

?>