window.addEventListener("DOMContentLoaded",function(){
   let year = document.getElementById("year");
   year.innerHTML = new Date().getFullYear();

   let menu = document.querySelector('#menuIcon');
   let nav = document.querySelector('.menu_and_search');
   

   menu.addEventListener("click",()=>{
   menu.classList.toggle('fa-xmark');
   nav.classList.toggle('on');
   });

   // let counter = 1;
   // setInterval(function(){
   //    document.getElementById('radio'+counter).checked=true;
   //    counter++;
   //    if(counter>3){
   //       counter = 1;
   //    }
   // } , 5000);

});

