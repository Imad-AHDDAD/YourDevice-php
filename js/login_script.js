window.addEventListener("DOMContentLoaded",function(){
   let year = document.getElementById("year");
   year.innerHTML = new Date().getFullYear();

   let menu = document.querySelector('#menuIcon');
   let nav = document.querySelector('.menu_and_search');
   

   menu.addEventListener("click",()=>{
   menu.classList.toggle('fa-xmark');
   nav.classList.toggle('on');
   });
   
   let button_create = document.getElementById("button_create");

   button_create.addEventListener("click",function(){
      button_create.style.display="none";
      document.getElementById("create_account_form").style.display="flex";
      document.getElementById('error2').style.display="none";
      document.getElementById('success').style.display="none";
      
   });

});