window.addEventListener("DOMContentLoaded" , ()=>{
  
                        paypal.Buttons({
                        // Sets up the transaction when a payment button is clicked
                        createOrder: (data, actions) => {
                           let totalWidthCurrency = document.getElementById('totalGlobal').innerHTML;
                           let total = totalWidthCurrency.substring(0,totalWidthCurrency.length-1);
                           return actions.order.create({
                              purchase_units: [{
                              amount: {
                                 value: total // Can also reference a variable or function
                              }
                              }]
                           });
                        },
                        // Finalize the transaction after payer approval
                        onApprove: (data, actions) => {
                           return actions.order.capture().then(function(orderData) {
                              // Successful capture! For dev/demo purposes:
                              console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                              const transaction = orderData.purchase_units[0].payments.captures[0];
                              console.log(orderData);
                              // alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                              // const element = document.getElementById('paypal-button-container');
                              // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                              // Or go to another URL:
                              // actions.redirect('onApprove.php');
                              // window.location.replace("onApprove.php");

                              let id_payment = orderData.purchase_units[0].payments.captures[0].id;
                              let status_payment = orderData.purchase_units[0].payments.captures[0].status;
                              let value_payment = orderData.purchase_units[0].payments.captures[0].amount.value;
                              let currency_payment = orderData.purchase_units[0].payments.captures[0].amount.currency_code;
                              let payer_id = orderData.payer.payer_id;
                              let payer_name = orderData.payer.name.given_name + " " + orderData.payer.name.surname;
                              let payer_address = orderData.payer.address.address_line_1 + " " + orderData.payer.address.admin_area_2 + " " + orderData.payer.address.postal_code;
                              let idClient = document.getElementById('idClient').innerHTML;

                              createCookie("id_payment", id_payment);
                              createCookie("status_payment", status_payment);
                              createCookie("value_payment", value_payment);
                              createCookie("currency_payment", currency_payment);
                              createCookie("id_client", idClient);
                              createCookie("payer_address", payer_address);
                              createCookie("payer_name", payer_name);
                              createCookie("payer_id", payer_id);
                              createCookie("id_client", idClient);
                                 
                              
                              function createCookie(name, value) {
                              var expires;
                                 var date = new Date();
                                 date.setTime(date.getTime() + (60 * 1000 * 5));
                                 expires = "; expires=" + date.toGMTString();
                                 document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
                              }

                             
                              window.location.replace("onApprove2.php");

                           });
                        }
                        }).render('#paypal-button-container');

});
