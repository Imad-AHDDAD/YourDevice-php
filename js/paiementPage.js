window.addEventListener("DOMContentLoaded",function(){
   
   let plus = document.getElementById('plus');
   let moins = document.getElementById('moins');
   let qte = document.getElementById('qte');

   plus.addEventListener('click',()=>{
      qte.value=Number(qte.value) + 1;
   });

   moins.addEventListener('click',()=>{
      if(Number(qte.value)>1){
         qte.value=Number(qte.value) - 1;
      }
   });

});