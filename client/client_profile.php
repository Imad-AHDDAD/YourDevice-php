
<?php

if(isset($_GET['success2'])){
   $msg = $_GET['success2'];
   echo '<script type="text/javascript">';
   echo "alert('$msg')";
   echo '</script>';
}

if(isset($_GET['error2'])){
   $msg = $_GET['error2'];
   echo '<script type="text/javascript">';
   echo "alert('$msg')";
   echo '</script>';
}
   session_start();
   if ($_SESSION['username_client_connected'] && $_SESSION['name_client_connected']){

      include "../db_connection/db_conn.php";
      
      $username_client = $_SESSION['username_client_connected'];
      $name_client = $_SESSION['name_client_connected'];

      $sql = "SELECT * FROM client WHERE username_client = '$username_client'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $id_client = $row['id_client'];
      $full_name = $row['name_client'];
      $email = $row['email_client'];
      $phone = $row['phone_client'];
      $country = $row['country_client'];
      $address = $row['address_client'];

      // les elements de la carte
      $sql2 = "SELECT * FROM cart WHERE id_client = $id_client";
      $stmt2 = $conn->prepare($sql2);
      $stmt2->execute();

      //les element de purchases
      $sql4 = "SELECT * FROM commande WHERE id_client = $id_client";
      $stmt4 = $conn->prepare($sql4);
      $stmt4->execute();
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo $name_client ?> | Profile</title>
   <link rel="shortcut icon" href="../images/favicon.ico">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/index.css">
   <link rel="stylesheet" href="../css/profile_client.css">
   <script src="../js/profile_script.js"></script>
   <script src="../js/searchScript.js"></script>
   <script src="../js/PaymentCartScript.js"></script>
   <script src="https://www.paypal.com/sdk/js?client-id=Aat3313ZCFWa-HNNGPnn5zGrUIZPOJxuOM9iQv9AGtDRMvS3WSiq3KCuP-5fD6bOCxBieQZe3VS-TgBH&currency=USD"></script>
   <script src="../js/paymentPaypal.js"></script>
   <script src="../js/modify_profile.js"></script>
   <style>
      .user{
         margin-right: .5rem;
      }
      tr td .qte{
         color: #2C3E50;
         font-weight: 600;
         padding: 0 1rem;
         width: 5rem;
         height: 4rem;
         font-size : 2rem;
         text-align: center;
      }

      #click_to_modify{
         cursor: pointer;
         color: #5cb85c;
      }
      tr td .op{
            color: #5cb85c;
            cursor: pointer;
            border: .1rem solid #2C3E50;
            padding: .5rem;
            border-radius: .5rem;
         }

          .downlaod{
            background-color: #5cb85c;
            padding: .5rem 1rem;
            color: white;
            text-decoration: none;
         }

         .nodownload{
            color: #cd313b;
            text-decoration: none;
         }

         tr td input::-webkit-outer-spin-button,
         tr td input::-webkit-inner-spin-button {
         -webkit-appearance: none;
         margin: 0;
         }

         #paypal-button-container{
            width: 25%;
            margin-top: 2rem;
            margin-right: 2rem;
            align-self: flex-end;
         }

   </style>
</head>
<body>

   <nav>
      <div class="logo">
         <label for=""><i class="fa-solid fa-gear"></i> YOUR <span>DEVICE</span></label>
      </div>
      
      <div class="menu_and_search">
         
         <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a class="login" href="listLaptops.php">Laptops</a></li>
            <li><a class="login" href="listPhones.php">Phones</a></li>
            <li><a href="contactForm.php">Contact</a></li>
            <li><a href="index.php#popular">Popular</a></li>
            <li>
               <?php if (array_key_exists('username_client_connected', $_SESSION) && array_key_exists('name_client_connected', $_SESSION)){ ?>
                  <a class="login" href="client_profile.php"><i class="fa-solid fa-user user"></i><?php echo $_SESSION['name_client_connected'] ?></i></a>
               <?php }else{
                  session_unset();
                  session_destroy();
               ?>
                  <a class="login" href="clientLogin.php">Login<i class="fa-solid fa-right-to-bracket"></i></a>
               <?php } ?>
            </li>
         </ul>

         <div class="search">
            <form action="searchPage.php" method="GET">
               <input type="text" name="search_text" id="search" placeholder="search">
               <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <div id="list">
               
            </div>
         </div>
         
      </div>
      <i id="menuIcon" class="fa-solid fa-bars"></i>
   </nav>

   <section class="content">

      <div class="navbar_client">
         <ul>
            <li class="active" id="show_cart"><i class="fa-solid fa-cart-shopping"></i> Cart</li>
            <li id="show_purchases"><i class="fa-solid fa-bag-shopping"></i> Purchases</li>
            <li id="show_profile"><i class="fa-solid fa-user"></i> Profile</li>
            <!-- <li id="security"><i class="fa-solid fa-lock"></i> Security</li> -->
            <a href="logout.php"><li class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</li></a>
            
         </ul>
      </div>

      <section class="other_content">

         <fieldset id="profile">
            <legend>Profile</legend>
            <form action="modifyProfileController.php" method="POST">
               <table>
                  <tr><td colspan="2" id="click_to_modify">click to modify</td></tr>
                  <tr>
                     <td>Full name : </td><td><input disabled type="text" value="<?php echo $full_name ?>" name="full_name_client" id="full_name_client"></td>
                  </tr>
                  <tr>
                     <td>phone number : </td><td><input disabled type="phone" value="<?php echo $phone ?>" name="phone_client" id="phone_client"></td>
                  </tr>
                  <tr>
                     <td>Country : </td>
                     <td>
                        <input disabled type="text" value="<?php echo $country ?>" name="country_client" id="country_client">
                        <select style="display: none;" name="country_client_select" id="country_client_select">
                           <option value="">select country</option>
                           <option value="Afghanistan">Afghanistan</option>
                           <option value="Åland Islands">Åland Islands</option>
                           <option value="Albania">Albania</option>
                           <option value="Algeria">Algeria</option>
                           <option value="American Samoa">American Samoa</option>
                           <option value="Andorra">Andorra</option>
                           <option value="Angola">Angola</option>
                           <option value="Anguilla">Anguilla</option>
                           <option value="Antarctica">Antarctica</option>
                           <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                           <option value="Argentina">Argentina</option>
                           <option value="Armenia">Armenia</option>
                           <option value="Aruba">Aruba</option>
                           <option value="Australia">Australia</option>
                           <option value="Austria">Austria</option>
                           <option value="Azerbaijan">Azerbaijan</option>
                           <option value="Bahamas">Bahamas</option>
                           <option value="Bahrain">Bahrain</option>
                           <option value="Bangladesh">Bangladesh</option>
                           <option value="Barbados">Barbados</option>
                           <option value="Belarus">Belarus</option>
                           <option value="Belgium">Belgium</option>
                           <option value="Belize">Belize</option>
                           <option value="Benin">Benin</option>
                           <option value="Bermuda">Bermuda</option>
                           <option value="Bhutan">Bhutan</option>
                           <option value="Bolivia">Bolivia</option>
                           <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                           <option value="Botswana">Botswana</option>
                           <option value="Bouvet Island">Bouvet Island</option>
                           <option value="Brazil">Brazil</option>
                           <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                           <option value="Brunei Darussalam">Brunei Darussalam</option>
                           <option value="Bulgaria">Bulgaria</option>
                           <option value="Burkina Faso">Burkina Faso</option>
                           <option value="Burundi">Burundi</option>
                           <option value="Cambodia">Cambodia</option>
                           <option value="Cameroon">Cameroon</option>
                           <option value="Canada">Canada</option>
                           <option value="Cape Verde">Cape Verde</option>
                           <option value="Cayman Islands">Cayman Islands</option>
                           <option value="Central African Republic">Central African Republic</option>
                           <option value="Chad">Chad</option>
                           <option value="Chile">Chile</option>
                           <option value="China">China</option>
                           <option value="Christmas Island">Christmas Island</option>
                           <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                           <option value="Colombia">Colombia</option>
                           <option value="Comoros">Comoros</option>
                           <option value="Congo">Congo</option>
                           <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                           <option value="Cook Islands">Cook Islands</option>
                           <option value="Costa Rica">Costa Rica</option>
                           <option value="Cote D'ivoire">Cote D'ivoire</option>
                           <option value="Croatia">Croatia</option>
                           <option value="Cuba">Cuba</option>
                           <option value="Cyprus">Cyprus</option>
                           <option value="Czech Republic">Czech Republic</option>
                           <option value="Denmark">Denmark</option>
                           <option value="Djibouti">Djibouti</option>
                           <option value="Dominica">Dominica</option>
                           <option value="Dominican Republic">Dominican Republic</option>
                           <option value="Ecuador">Ecuador</option>
                           <option value="Egypt">Egypt</option>
                           <option value="El Salvador">El Salvador</option>
                           <option value="Equatorial Guinea">Equatorial Guinea</option>
                           <option value="Eritrea">Eritrea</option>
                           <option value="Estonia">Estonia</option>
                           <option value="Ethiopia">Ethiopia</option>
                           <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                           <option value="Faroe Islands">Faroe Islands</option>
                           <option value="Fiji">Fiji</option>
                           <option value="Finland">Finland</option>
                           <option value="France">France</option>
                           <option value="French Guiana">French Guiana</option>
                           <option value="French Polynesia">French Polynesia</option>
                           <option value="French Southern Territories">French Southern Territories</option>
                           <option value="Gabon">Gabon</option>
                           <option value="Gambia">Gambia</option>
                           <option value="Georgia">Georgia</option>
                           <option value="Germany">Germany</option>
                           <option value="Ghana">Ghana</option>
                           <option value="Gibraltar">Gibraltar</option>
                           <option value="Greece">Greece</option>
                           <option value="Greenland">Greenland</option>
                           <option value="Grenada">Grenada</option>
                           <option value="Guadeloupe">Guadeloupe</option>
                           <option value="Guam">Guam</option>
                           <option value="Guatemala">Guatemala</option>
                           <option value="Guernsey">Guernsey</option>
                           <option value="Guinea">Guinea</option>
                           <option value="Guinea-bissau">Guinea-bissau</option>
                           <option value="Guyana">Guyana</option>
                           <option value="Haiti">Haiti</option>
                           <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                           <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                           <option value="Honduras">Honduras</option>
                           <option value="Hong Kong">Hong Kong</option>
                           <option value="Hungary">Hungary</option>
                           <option value="Iceland">Iceland</option>
                           <option value="India">India</option>
                           <option value="Indonesia">Indonesia</option>
                           <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                           <option value="Iraq">Iraq</option>
                           <option value="Ireland">Ireland</option>
                           <option value="Isle of Man">Isle of Man</option>
                           <option value="Israel">Israel</option>
                           <option value="Italy">Italy</option>
                           <option value="Jamaica">Jamaica</option>
                           <option value="Japan">Japan</option>
                           <option value="Jersey">Jersey</option>
                           <option value="Jordan">Jordan</option>
                           <option value="Kazakhstan">Kazakhstan</option>
                           <option value="Kenya">Kenya</option>
                           <option value="Kiribati">Kiribati</option>
                           <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                           <option value="Korea, Republic of">Korea, Republic of</option>
                           <option value="Kuwait">Kuwait</option>
                           <option value="Kyrgyzstan">Kyrgyzstan</option>
                           <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                           <option value="Latvia">Latvia</option>
                           <option value="Lebanon">Lebanon</option>
                           <option value="Lesotho">Lesotho</option>
                           <option value="Liberia">Liberia</option>
                           <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                           <option value="Liechtenstein">Liechtenstein</option>
                           <option value="Lithuania">Lithuania</option>
                           <option value="Luxembourg">Luxembourg</option>
                           <option value="Macao">Macao</option>
                           <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                           <option value="Madagascar">Madagascar</option>
                           <option value="Malawi">Malawi</option>
                           <option value="Malaysia">Malaysia</option>
                           <option value="Maldives">Maldives</option>
                           <option value="Mali">Mali</option>
                           <option value="Malta">Malta</option>
                           <option value="Marshall Islands">Marshall Islands</option>
                           <option value="Martinique">Martinique</option>
                           <option value="Mauritania">Mauritania</option>
                           <option value="Mauritius">Mauritius</option>
                           <option value="Mayotte">Mayotte</option>
                           <option value="Mexico">Mexico</option>
                           <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                           <option value="Moldova, Republic of">Moldova, Republic of</option>
                           <option value="Monaco">Monaco</option>
                           <option value="Mongolia">Mongolia</option>
                           <option value="Montenegro">Montenegro</option>
                           <option value="Montserrat">Montserrat</option>
                           <option value="Morocco">Morocco</option>
                           <option value="Mozambique">Mozambique</option>
                           <option value="Myanmar">Myanmar</option>
                           <option value="Namibia">Namibia</option>
                           <option value="Nauru">Nauru</option>
                           <option value="Nepal">Nepal</option>
                           <option value="Netherlands">Netherlands</option>
                           <option value="Netherlands Antilles">Netherlands Antilles</option>
                           <option value="New Caledonia">New Caledonia</option>
                           <option value="New Zealand">New Zealand</option>
                           <option value="Nicaragua">Nicaragua</option>
                           <option value="Niger">Niger</option>
                           <option value="Nigeria">Nigeria</option>
                           <option value="Niue">Niue</option>
                           <option value="Norfolk Island">Norfolk Island</option>
                           <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                           <option value="Norway">Norway</option>
                           <option value="Oman">Oman</option>
                           <option value="Pakistan">Pakistan</option>
                           <option value="Palau">Palau</option>
                           <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                           <option value="Panama">Panama</option>
                           <option value="Papua New Guinea">Papua New Guinea</option>
                           <option value="Paraguay">Paraguay</option>
                           <option value="Peru">Peru</option>
                           <option value="Philippines">Philippines</option>
                           <option value="Pitcairn">Pitcairn</option>
                           <option value="Poland">Poland</option>
                           <option value="Portugal">Portugal</option>
                           <option value="Puerto Rico">Puerto Rico</option>
                           <option value="Qatar">Qatar</option>
                           <option value="Reunion">Reunion</option>
                           <option value="Romania">Romania</option>
                           <option value="Russian Federation">Russian Federation</option>
                           <option value="Rwanda">Rwanda</option>
                           <option value="Saint Helena">Saint Helena</option>
                           <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                           <option value="Saint Lucia">Saint Lucia</option>
                           <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                           <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                           <option value="Samoa">Samoa</option>
                           <option value="San Marino">San Marino</option>
                           <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                           <option value="Saudi Arabia">Saudi Arabia</option>
                           <option value="Senegal">Senegal</option>
                           <option value="Serbia">Serbia</option>
                           <option value="Seychelles">Seychelles</option>
                           <option value="Sierra Leone">Sierra Leone</option>
                           <option value="Singapore">Singapore</option>
                           <option value="Slovakia">Slovakia</option>
                           <option value="Slovenia">Slovenia</option>
                           <option value="Solomon Islands">Solomon Islands</option>
                           <option value="Somalia">Somalia</option>
                           <option value="South Africa">South Africa</option>
                           <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                           <option value="Spain">Spain</option>
                           <option value="Sri Lanka">Sri Lanka</option>
                           <option value="Sudan">Sudan</option>
                           <option value="Suriname">Suriname</option>
                           <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                           <option value="Swaziland">Swaziland</option>
                           <option value="Sweden">Sweden</option>
                           <option value="Switzerland">Switzerland</option>
                           <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                           <option value="Taiwan">Taiwan</option>
                           <option value="Tajikistan">Tajikistan</option>
                           <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                           <option value="Thailand">Thailand</option>
                           <option value="Timor-leste">Timor-leste</option>
                           <option value="Togo">Togo</option>
                           <option value="Tokelau">Tokelau</option>
                           <option value="Tonga">Tonga</option>
                           <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                           <option value="Tunisia">Tunisia</option>
                           <option value="Turkey">Turkey</option>
                           <option value="Turkmenistan">Turkmenistan</option>
                           <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                           <option value="Tuvalu">Tuvalu</option>
                           <option value="Uganda">Uganda</option>
                           <option value="Ukraine">Ukraine</option>
                           <option value="United Arab Emirates">United Arab Emirates</option>
                           <option value="United Kingdom">United Kingdom</option>
                           <option value="United States">United States</option>
                           <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                           <option value="Uruguay">Uruguay</option>
                           <option value="Uzbekistan">Uzbekistan</option>
                           <option value="Vanuatu">Vanuatu</option>
                           <option value="Venezuela">Venezuela</option>
                           <option value="Viet Nam">Viet Nam</option>
                           <option value="Virgin Islands, British">Virgin Islands, British</option>
                           <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                           <option value="Wallis and Futuna">Wallis and Futuna</option>
                           <option value="Western Sahara">Western Sahara</option>
                           <option value="Yemen">Yemen</option>
                           <option value="Zambia">Zambia</option>
                           <option value="Zimbabwe">Zimbabwe</option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>Address : </td><td><input disabled type="text" value="<?php echo $address ?>" name="address_client" id="address_client"></td>
                  </tr>
               </table>
               <button style="display: none;" id="save" type="submit">Save</button>
            </form>
         </fieldset>

         <div class="cart_client" id="cart_client">
            <table>
               <tr><th colspan="8">Your Cart's Elements</th></tr>
               <tr>
                  <th>image</th>
                  <th>description</th>
                  <th>price</th>
                  <th colspan = "3">quantity</th>
                  <th>total</th>
                  <th></th>
               </tr>
               <?php $cpt = -1; $total = 0 ; while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
                  $id_produit = $row2['id_produit'];
                  $sql3 = "SELECT * FROM produit WHERE id_produit = $id_produit";
                  $stmt3 = $conn->prepare($sql3);
                  $stmt3->execute();
                  $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);   

                  $cpt = $cpt + 1;
                  $total = $total + $row2['total'];
               ?>
               <tr class="row">
                  <td id="idCart<?php echo $cpt ?>" hidden><?php echo $row2['id_cart'] ?></td>
                  <td id="idClient" hidden><?php echo $id_client ?></td>
                  <td><img src="<?php echo "../images/".$row3['img'] ?>" alt="image"></td>
                  <td><?php echo $row3['nom_produit']."<br>".$row3['libelle_produit'] ?></td>
                  <td id="price<?php echo $cpt ?>"><?php echo $row3['nouveau_prix']."$" ?></td>
                  <td><i id="moins<?php echo $cpt ?>" class="fa-solid fa-minus op"></td>
                  <td><input type="number" value="<?php echo $row2['qty'] ?>" name="qte" class="qte" id="qte<?php echo $cpt ?>"></td>
                  <td><i id="plus<?php echo $cpt ?>" class="fa-solid fa-plus op"></i></td>
                  <td id="total<?php echo $cpt ?>"><?php echo $row2['total']."$" ?></td>
                  <td><form action="deleteFromCart.php" method="POST"><button name="id_cart_to_delete" value="<?php echo $row2['id_cart'] ?>" class="delete">Delete</button></form></td>
                  <!-- <td><form action="buy_product_page.php" method="GET"><button name="id_product" style="background-color: #5cb85c;" value="<?php /*echo $id_produit */?>">Buy</button></form></td> -->
               </tr>
               <?php } ?>
               <tr><td colspan = "6"></td><th>Total</th><th id="totalGlobal"><?php echo $total."$" ?></th></tr>
            </table>
            <?php 
               if(isset($_GET['success'])){
            ?>
               <p class="success"><?php echo $_GET['success']?></p>
            <?php } 
            if($total != 0){
            ?>
            <div id="paypal-button-container"></div>
            <?php } ?>
         </div>

         <div class="purchases_client" id="purchases_client">
            <table>
               <tr><th colspan="7">Your Purchases</th></tr>
               <tr>
                  <th>image</th>
                  <th>Description</th>
                  <th>price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th>Date</th>
                  <th>Receipt</th>
               </tr>
               <?php while($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)){ 
                  $id_produit = $row4['id_product'];
                  $sql5 = "SELECT * FROM produit WHERE id_produit = $id_produit";
                  $stmt5 = $conn->prepare($sql5);
                  $stmt5->execute();
                  $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);  
                  
                  $qty = $row4['qte'];
                  $price = $row5['nouveau_prix'];
                  $total = $qty*$price;
                  $date_commande = $row4['date_commande'];
                  $pdf = $row4['receipt'];

                  if($pdf == NULL){
                     $url_to_pdf = "<label class='nodownload'>No Receipt</label>";
                  }else{
                     $url_to_pdf = "<a class='downlaod' target='_blank' href = '../factures/".$row4['receipt']."'>DOWNLOAD</>";
                  }


               ?>
               <tr>
                  <td><img src="<?php echo "../images/".$row5['img'] ?>" alt="image"></td>
                  <td><?php echo $row5['nom_produit']."<br>".$row5['libelle_produit'] ?></td>
                  <td><?php echo $price."$" ?></td>
                  <td><?php echo $qty ?></td>
                  <td><?php echo $total."$" ?></td>
                  <td><?php echo $date_commande ?></td>
                  <td><?php echo $url_to_pdf ?></td>
               </tr>
               <?php } ?>
            </table>
         </div>

         <!-- <div class="security_client" id="security_client">
            <h1>Security Settings</h1>
         </div> -->

      </section>

      
   </section>

   <section style="margin: 0; padding-top: 2rem;" class="footer">

      <div class="box-container">

         <div class="box" id="contact">
            <h3>contact info</h3>
            <a href="#"><i class="fas fa-phone"></i> +212 600 000 000 </a>
            <a href="#"><i class="fas fa-envelope"></i> ouremailaddress@gmail.com </a>
            <a href="#"><i class="fas fa-map-marker-alt"></i> Country , CITY - POSTAL CODE </a>
         </div>

         <div class="box">
            <h3>follow us</h3>
            <a target="_blank" href="#"><i class="fab fa-facebook-f"></i> facebook </a>
            <a target="_blank" href="#"><i class="fab fa-instagram"></i> instagram </a>
            <a target="_blank" href="#"><i class="fab fa-linkedin"></i> linkedin </a>
         </div>

         <div class="box">
            <img src="../images/pub-footer.gif" alt="pub-footer">
         </div>

         <div class="box">
            <img src="../images/pub-footer2.gif" alt="pub-footer">
         </div>

      </div>

      <div class="credit"><i class="fa-solid fa-gear"></i> YOUR DEVICE | <span>All rights reserved </span><span id="year"></span> </div>

   </section>
   
</body>
</html>

<?php }else{
   header("Location:clientLogin.php");
   exit();
} ?>