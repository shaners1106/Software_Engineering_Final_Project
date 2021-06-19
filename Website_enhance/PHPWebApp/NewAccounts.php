<?php 
      session_start();
      if(isset($_SESSION['login_user']))
      {
          echo "Welcome " . $_SESSION['login_user'];
      }
?>

<html>

<head>
    <title>Create New Account</title>
    <link rel="stylesheet" href="mystyles.css">
</head>
<!-- Creates the Headers, including the logo and hyperlinks at the top of the page -->
<header>
    <div class="row">
        <div class="col">
            <a href="index.php"><img class="style-logo" src="images/logo.png" alt="Hewitt Logo"></a>
            <nav class="style-nav">
                <ul>
                    <div class="dropdown">
                        <li><a href="#"><a class="dropbtn">Accounts</button></a></li>
                        <div class="dropdown-content">
                            <a href="AccountsName.php">Search By Last Name</a>
                            <a href="AccountsPhone.php">Search By Phone </a>
                            <a href="AccountsID.php">Search By Account ID</a>
                            <a href="AccountsEmail.php">Search By Email</a>
                            <a href="AccountsCompany.php">Search By Company</a>
                            <a href="NewAccounts.php">Add New Account</a>
                        </div>
                    </div>
                    <div class="dropdown">
                            <li><a href="#"><a class="dropbtn">Test Results</button></a></li>
                            <div class="dropdown-content">
                                <a href="StudentTestRecord.php">Retrieve Records</a>
                                <a href="UploadTests.php">Upload New Results</a>
                        </div>
                    </div>
                </ul>
            </nav>
        </div>
    </div>
</header>


<h1>Create New Account</h1>

<body>

    <div class="container">

        <!-- it then prints every result with the genre matching the input, and appends the cart if a user decides to rent it. -->
        <?php
   include 'connect.php';


echo"<h1>Edit Account Information</h1>";
//assign main account variables for giant form fields
$customer1_first_name = '';
$customer1_last_name = '';
$customer2_first_name = '';
$customer2_last_name = '';
$customer3_first_name = '';
$customer3_last_name = '';
$company = '';
$address1 = '';
$address2 = '';
$city1 = '';
$state1 = '';
$city2 = '';
$state2 = '';
$zipcode1 = '';
$zipcode2 = '';
$plus4_1 = '';
$plus4_2 = '';
$country_code1 = '';
$country_code2 = '';
$country_name1 = '';
$country_name2 = '';
$ship_first_name1 = '';
$ship_first_name2 = '';
$ship_last_name1 = '';
$ship_last_name2 = '';
$ship_company = '';
$ship_address = '';
$ship_city = '';
$ship_state = '';
$ship_zipcode = '';
$ship_plus4 = '';

$ship_country_code = '';
$ship_country_name = '';
$phone1 = '';
$phone2 = '';
$email1 = '';
$email2 = '';
$fax = '';
$comments = '';
$customer_flag = '';
$source = '';

$batch_label = '';
$bulk_label = '';
$imed_mail_label = '';
$imed_ship_label = '';
$mail_exclude = '';
$registration_expire = '';
$counseling = '';
$last_access = '';
$last_change = '';
$usps_address_code = '';
$account_id = '';

 echo"<form action = 'NewAccountsConfirm.php' method = 'post'>";
 echo"<table>";
echo"<tr><td>";
 echo"<label>Customer1 First Name:</label>";
  echo"<input type='text' name = 'customer1_first_name' value='$customer1_first_name'><br>"; 
  echo"</td><td>";
  echo"<label>Customer1 Last Name:</label>";
  echo"<input type='text' name = 'customer1_last_name' value='$customer1_last_name'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>customer2_first_name:</label>";
  echo"<input type='text' name = 'customer2_first_name' value='$customer2_first_name'><br>";
  echo"</td><td>"; 
  echo"<label>customer2_last_name:</label>";
  echo"<input type='text' name = 'customer2_last_name' value='$customer2_last_name'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>customer3_first_name:</label>";
  echo"<input type='text' name = 'customer3_first_name' value='$customer3_first_name'><br>"; 
  echo"</td><td>"; 
  echo"<label>customer3_last_name:</label>";
  echo"<input type='text' name = 'customer3_last_name' value='$customer3_last_name'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>company:</label>";
  echo"<input type='text' name = 'company' value='$company'><br>"; 
  echo"</td></tr><tr><td>";
  echo"<label>address1:</label>";
  echo"<input type='text' name = 'address1' value='$address1'><br>";
  echo"</td>";
  echo"<td>"; 
  echo"<label>address2:</label>";
  echo"<input type='text' name = 'address2' value='$address2'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>city1:</label>";
  echo"<input type='text' name = 'city1' value='$city1'><br>";
  echo"</td><td>";
  echo"<label>state1:</label>";
  echo"<input type='text' name = 'state1' value='$state1'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>city2:</label>";
  echo"<input type='text' name = 'city2' value='$city2'><br>";
  echo"</td><td>";
  echo"<label>state2:</label>";
  echo"<input type='text' name = 'state2' value='$state2'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>zipcode1:</label>";
  echo"<input type='text' name = 'zipcode1' value='$zipcode1'><br>";
  echo"</td><td>";  
  echo"<label>zipcode2:</label>";
  echo"<input type='text' name = 'zipcode2' value='$zipcode2'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>plus4_1:</label>";
  echo"<input type='text' name = 'plus4_1' value='$plus4_1'><br>";
  echo"</td><td>";  
  echo"<label>plus4_2:</label>";
  echo"<input type='text' name = 'plus4_2' value='$plus4_2'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>country_code1:</label>";
  echo"<input type='text' name = 'country_code1' value='$country_code1'><br>";
  echo"</td><td>";  
  echo"<label>country_code2:</label>";
  echo"<input type='text' name = 'country_code2' value='$country_code2'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>country_name1:</label>";
  echo"<input type='text' name = 'country_name1' value='$country_name1'><br>";
  echo"</td><td>";  
  echo"<label>country_name2:</label>";
  echo"<input type='text' name = 'country_name2' value='$country_name2'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>ship_first_name1:</label>";
  echo"<input type='text' name = 'ship_first_name1' value='$ship_first_name1'><br>";
  echo"</td><td>";
  echo"<label>ship_first_name2:</label>";
  echo"<input type='text' name = 'ship_first_name2' value='$ship_first_name2'><br>";
  echo"</td></tr><tr><td>"; 
  echo"<label>ship_last_name1:</label>";
  echo"<input type='text' name = 'ship_last_name1' value='$ship_last_name1'><br>";
  echo"</td><td>"; 
  echo"<label>ship_last_name2:</label>";
  echo"<input type='text' name = 'ship_last_name2' value='$ship_last_name2'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>ship_company:</label>";
  echo"<input type='text' name = 'ship_company' value='$ship_company'><br>";
  echo"</td><td>";  
  echo"<label>ship_address:</label>";
  echo"<input type='text' name = 'ship_address' value='$ship_address'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>ship_city:</label>";
  echo"<input type='text' name = 'ship_city' value='$ship_city'><br>";
  echo"</td><td>"; 
  echo"<label>ship_state:</label>";
  echo"<input type='text' name = 'ship_state' value='$ship_state'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>ship_zipcode:</label>";
  echo"<input type='text' name = 'ship_zipcode' value='$ship_zipcode'><br>";
  echo"</td><td>";
  echo"<label>ship_plus4:</label>";
  echo"<input type='text' name = 'ship_plus4' value='$ship_plus4'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>ship_country_code:</label>";
  echo"<input type='text' name = 'ship_country_code' value='$ship_country_code'><br>";
  echo"</td><td>";
  echo"<label>ship_country_name:</label>";
  echo"<input type='text' name = 'ship_country_name' value='$ship_country_name'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>phone1:</label>";
  echo"<input type='text' name = 'phone1' value='$phone1'><br>";
  echo"</td><td>";
  echo"<label>phone2:</label>";
  echo"<input type='text' name = 'phone2' value='$phone2'>'<br>";
  echo"</td></tr><tr><td>";  
  echo"<label>email1:</label>";
  echo"<input type='text' name = 'email1' value='$email1'><br>";
  echo"</td><td>";
  echo"<label>email2:</label>";
  echo"<input type='text' name = 'email2' value='$email2'><br>";
  echo"</td></tr><tr><td>"; 
  echo"<label>fax:</label>";
  echo"<input type='text' name = 'fax' value='$fax'><br>";
  echo"</td><td>"; 
  echo"<label>comments:</label>";
  echo"<input type='text' name = 'comments' value='$comments'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>customer_flag:</label>";
  echo"<input type='text' name = 'customer_flag' value='$customer_flag'><br>";
  echo"</td><td>";
  echo"<label>source:</label>";
  echo"<input type='text' name = 'source' value='$source'><br>";
 echo"</td></tr><tr><td>";
  echo"<label>batch_label:</label>";
  echo"<input type='text' name = 'batch_label' value='$batch_label'><br>";
  echo"</td><td>";
  echo"<label>bulk_label:</label>";
  echo"<input type='text' name = 'bulk_label' value='$bulk_label'><br>";
  echo"</td></tr><tr><td>"; 
  echo"<label>imed_mail_label:</label>";
  echo"<input type='text' name = 'imed_mail_label' value='$imed_mail_label'><br>";
  echo"</td><td>";
  echo"<label>imed_ship_label:</label>";
  echo"<input type='text' name = 'imed_ship_label' value='$imed_ship_label'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>mail_exclude:</label>";
  echo"<input type='text' name = 'mail_exclude' value='$mail_exclude'><br>";
  echo"</td><td>";
  echo"<label>registration_expire:</label>";
  echo"<input type='text' name = 'registration_expire' value='$registration_expire'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>counseling:</label>";
  echo"<input type='text' name = 'counseling' value='$counseling'><br>";
  echo"</td><td>";
  echo"<label>last_access:</label>";
  echo"<input type='text' name = 'last_access' value='$last_access'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>last_change:</label>";
  echo"<input type='text' name = 'last_change' value='$last_change'><br>";
  echo"</td><td>";
  echo"<label>usps_address_code:</label>";
  echo"<input type='text' name = 'usps_address_code' value='$usps_address_code'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>account_id:</label>";
  echo"<input type='text' name = 'account_id' value='$account_id'>";
  echo"</td></tr><tr><td>";
  echo"</table>";
  echo"<br>";
 echo"<input type='submit' name = 'EDIT' id='EDIT' value='CREATE ACCOUNT'>";
echo"</form>";
  
 
  
 ?>


    </div>
</body>
<footer>
    <div class="row">
        <div class="col">
            <p class="footer-text">Copyright Hewitt Learning, 2021
            </p>

        </div>
    </div>
</footer>

</html>