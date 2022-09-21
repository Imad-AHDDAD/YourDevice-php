window.addEventListener("DOMContentLoaded", function(){

   let tr = document.getElementsByClassName('row');

   for(let i = 0 ; i<tr.length ; i++){
      let moins = document.getElementById('moins'+i);
      moins.addEventListener('click' , ()=>{
         decrementQty(i);
      });

      let plus = document.getElementById('plus'+i);
      plus.addEventListener('click' , ()=>{
         incrementQty(i);
      });
   }


   // la fonction decrement qty
   function decrementQty(i){
      if(Number(document.getElementById('qte'+i).value) > 1){
         fetch(`decrementQty.php?idCart=${document.getElementById("idCart"+i).innerHTML}`)
         .then((response)=>{
            if(response.ok){
               return response.json();
            }else{
               console.log("mauvaise reponse reseau");
            }
         }).then((data)=>{
            document.getElementById("qte"+i).value = data['qty'];
            document.getElementById("total"+i).innerHTML = data['total']+"$";
            updateTotalGlobal();
         }).catch((err)=>{
            console.log("erreur");
         });
      }
   }


   // la fonction increment qty
   function incrementQty(i){
      fetch(`incrementQty.php?idCart=${document.getElementById("idCart"+i).innerHTML}`)
      .then((response)=>{
          if(response.ok){
             return response.json();
           }else{
             console.log("mauvaise reponse reseau");
           }
        }).then((data)=>{
         document.getElementById("qte"+i).value = data['qty'];
         document.getElementById("total"+i).innerHTML = data['total']+"$";
         updateTotalGlobal();
      }).catch((err)=>{
         console.log("erreur");
      });
      
   }


   // la fonction update total global
   function updateTotalGlobal(){
      let total = 0;
      for(let i = 0 ; i<tr.length ; i++){
         let sum = document.getElementById('total'+i).innerHTML;
         let totalLine = sum.substring(0,sum.length-1);
         total+=Number(totalLine);;
      }

      document.getElementById('totalGlobal').innerHTML = total+"$";
   
   }

});