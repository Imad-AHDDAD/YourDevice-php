window.addEventListener("DOMContentLoaded",function(){
   let year = document.getElementById("year");
   year.innerHTML = new Date().getFullYear();

   let menu = document.querySelector('#menuIcon');
   let nav = document.querySelector('.menu_and_search');
   let button_create = document.getElementById("button_create");

   menu.addEventListener("click",()=>{
   menu.classList.toggle('fa-xmark');
   nav.classList.toggle('on');
   });

   let show_cart = document.getElementById("show_cart");
   show_cart.addEventListener("click" , show_cart_client);

   let show_profile = document.getElementById("show_profile");
   show_profile.addEventListener("click" , show_profile_client);

   let show_purchases = document.getElementById("show_purchases");
   show_purchases.addEventListener("click" , show_purchases_client);

   // let show_security = document.getElementById("security");
   // show_security.addEventListener("click" , show_security_client);

});

function show_cart_client(){
   document.getElementById("profile").style.display="none";
   document.getElementById("purchases_client").style.display="none";
   // document.getElementById("security_client").style.display="none";
   document.getElementById("cart_client").style.display="block";
   show_cart.classList.add('active');
   show_profile.classList.remove('active');
   show_purchases.classList.remove('active');
   // document.getElementById("security").classList.remove('active');
}

function show_profile_client(){
   document.getElementById("profile").style.display="block";
   document.getElementById("cart_client").style.display="none";
   document.getElementById("purchases_client").style.display="none";
   // document.getElementById("security_client").style.display="none";
   show_cart.classList.remove('active');
   show_profile.classList.add('active');
   show_purchases.classList.remove('active');
   // document.getElementById("security").classList.remove('active');
}

function show_purchases_client(){
   document.getElementById("profile").style.display="none";
   document.getElementById("cart_client").style.display="none";
   // document.getElementById("security_client").style.display="none";
   document.getElementById("purchases_client").style.display="block";
   show_cart.classList.remove('active');
   show_profile.classList.remove('active');
   show_purchases.classList.add('active');
   // document.getElementById("security").classList.remove('active');
}

// function show_security_client(){
//    document.getElementById("profile").style.display="none";
//    document.getElementById("cart_client").style.display="none";
//    document.getElementById("security_client").style.display="block";
//    document.getElementById("purchases_client").style.display="none";
//    document.getElementById("security").classList.add('active');
//    show_cart.classList.remove('active');
//    show_profile.classList.remove('active');
//    show_purchases.classList.remove('active');
   
// }
