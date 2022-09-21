window.addEventListener("DOMContentLoaded",function(){
   let modify_click = document.getElementById('click_to_modify');
   modify_click.addEventListener('click',enableModify);



   // la fonction enableModify
   function enableModify(){
      modify_click.innerHTML="";
      
      document.getElementById('full_name_client').disabled = false;
      document.getElementById('phone_client').disabled = false;
      document.getElementById('address_client').disabled = false;
      document.getElementById('country_client').style.display = "none";
      document.getElementById('country_client_select').style.display = "block";

      document.getElementById('save').style.display = "block";
   }

});