window.addEventListener("DOMContentLoaded",()=>{

   let fullname = document.getElementById('full_name');
   fullname.addEventListener('input',checkFullName);

   let email = document.getElementById('email_create');
   email.addEventListener('input',checkEmail);

   let phone = document.getElementById('phone_create');
   phone.addEventListener('input',checkPhone);

   let country = document.getElementById('country');
   country.addEventListener('change',checkCountry);

   let address = document.getElementById('address_create');
   address.addEventListener('input',checkAddress);

   let username = document.getElementById('username_create');
   username.addEventListener('input',checkUsername);

   let password = document.getElementById('password_create');
   password.addEventListener('input',checkPassword);

   let passwordCnf = document.getElementById('password_Cnf_create');
   passwordCnf.addEventListener('input',checkPasswordCnf);


   //create le formulaire
   document.getElementById("create").addEventListener("click",function(e){
      createClicked(e);
   });






   // la fonction checkFullName
   function checkFullName(){
      let reg = /^[a-zA-Z ]{2,30}$/;
      if(fullname.value.match(reg)){
         document.getElementById('full_name_error').style.display="none";
         fullname.classList.remove('invalid');
         fullname.classList.add('valid');
      }else{
         document.getElementById('full_name_error').style.display="block";
         fullname.classList.add('invalid');
         fullname.classList.remove('valid');
      }
   }

      // la fonction checkemail
      function checkEmail(){
         let reg = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
         if(email.value.match(reg)){
            document.getElementById('email_error').style.display="none";
            email.classList.remove('invalid');
            email.classList.add('valid');
         }else{
            document.getElementById('email_error').style.display="block";
            email.classList.add('invalid');
            email.classList.remove('valid');
         }
      }

      // la fonction checkPhone
      function checkPhone(){
         let reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
         if(phone.value.match(reg)){
            document.getElementById('phone_error').style.display="none";
            phone.classList.remove('invalid');
            phone.classList.add('valid');
         }else{
            document.getElementById('phone_error').style.display="block";
            phone.classList.add('invalid');
            phone.classList.remove('valid');
         }
      }

      // la fonction checkCountry
      function checkCountry(){
         let opt = country.options[country.selectedIndex];
         if(opt.value != ""){
            document.getElementById('country_error').style.display="none";
            country.classList.remove('invalid');
            country.classList.add('valid');
         }else{
            document.getElementById('country_error').style.display="block";
            country.classList.remove('valid');
            country.classList.add('invalid');
         }
      }

      // la fonction checkAddress
      function checkAddress(){
         let reg = /^[a-zA-Z ]{19,}$/;
         if(address.value.match(reg)){
            document.getElementById('address_error').style.display="none";
            address.classList.remove('invalid');
            address.classList.add('valid');
         }else{
            document.getElementById('address_error').style.display="block";
            address.classList.add('invalid');
            address.classList.remove('valid');
         }
      }

      // la fonction checkUsername
      function checkUsername(){
         let reg = /^[a-zA-Z\-]+$/;
         if(username.value.match(reg)){
            document.getElementById('username_error').style.display="none";
            username.classList.remove('invalid');
            username.classList.add('valid');
         }else{
            document.getElementById('username_error').style.display="block";
            username.classList.add('invalid');
            username.classList.remove('valid');
         }
      }

      // la fonction checkPassword
      function checkPassword(){
         let reg = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
         if(password.value.match(reg)){
            document.getElementById('password_error').style.display="none";
            password.classList.remove('invalid');
            password.classList.add('valid');
         }else{
            document.getElementById('password_error').style.display="block";
            password.classList.add('invalid');
            password.classList.remove('valid');
         }
      }

      // la fonction checkPasswordCnf
      function checkPasswordCnf(){
         if(password.value === passwordCnf.value){
            document.getElementById('password_Cnf_error').style.display="none";
            passwordCnf.classList.remove('invalid');
            passwordCnf.classList.add('valid');
         }else{
            document.getElementById('password_Cnf_error').style.display="block";
            passwordCnf.classList.add('invalid');
            passwordCnf.classList.remove('valid');
         }
      }

      // la fonction sendClicked
      function createClicked(e){

         let infos = document.getElementsByClassName("info");
         let errs = document.getElementsByClassName("errorCreate");
         let ind=0;
         for(let i=0; i<infos.length ; i++){

            if(infos[i].classList.contains("valid")){
               ind++;
            }else{
               infos[i].classList.add("invalid");
               errs[i].style.display = "block";
            }

         }

         if(ind != 8) {
            e.preventDefault();
         }

      }

});

