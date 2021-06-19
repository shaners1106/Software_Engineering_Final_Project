<?php
//If in the future you want to implement a public login feature, this will get you there.
session_start();
if (isset($_SESSION['login_user'])) {
    echo "Welcome " . $_SESSION['login_user'];
}
?>

<html>

<head>
    <title>Account Edited!</title>
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


<h1>The account has been changed.</h1>
<h3>Please return to the Home Screen or navigate to another page.</h3>

<body>
    <!-- a form to take in the genre input. -->


    <div class="container">

        <!-- it then prints every result with the genre matching the input, and appends the cart if a user decides to rent it. -->
        <?php
include 'connect.php';

$stmt = "UPDATE dbo.mailing_list as ml SET ml.customer1_first_name = '$_POST[customer1_first_name]', ml.customer1_last_name = '$_POST[customer1_last_name]',
       ml.customer2_first_name = '$_POST[customer2_first_name]', ml.customer2_last_name = '$_POST[customer2_last_name]',
       ml.customer3_first_name = '$_POST[customer3_first_name]', ml.customer3_last_name = '$_POST[customer3_last_name]',
       ml.company = '$_POST[company]', ml.address1 = '$_POST[address1]', ml.address2 = '$_POST[address2]', ml.city1 = '$_POST[city1]', ml.city2 = '$_POST[city2]',
       ml.state1 = '$_POST[state1]', ml.state2 = '$_POST[state2]', ml.zipcode1 = '$_POST[zipcode1]',
       ml.zipcode2 = '$_POST[zipcode2]', ml.plus4_1 = '$_POST[plus4_1]', ml.plus4_2 = '$_POST[plus4_2]',ml.country_code1 = '$_POST[country_code1]',ml.country_code2 = '$_POST[country_code2]',
       ml.country_name1 = '$_POST[country_name1]', ml.country_name2 = '$_POST[country_name2]', ml.ship_first_name1 = '$_POST[ship_first_name1]', ml.ship_first_name2 = '$_POST[ship_first_name2]',
       ml.ship_last_name1 = '$_POST[ship_last_name1]', ml.ship_last_name2 = '$_POST[ship_last_name2]', ml.ship_company = '$_POST[ship_company]', ml.ship_address = '$_POST[ship_address]', ml.ship_city = '$_POST[ship_city]',
       ml.ship_zipcode = '$_POST[ship_zipcode]', ml.ship_plus4 = '$_POST[ship_plus4]', ml.ship_country_code = '$_POST[ship_country_code]',
       ml.ship_country_name = '$_POST[ship_country_name]', ml.phone1 = '$_POST[phone1]', ml.phone2 = '$_POST[phone2]', ml.email1 = '$_POST[email1]',
       ml.email2 = '$_POST[email2]', ml.fax = '$_POST[fax]', ml.comments = '$_POST[comments]', ml.customer_flag = '$_POST[customer_flag]',
       ml.source = '$_POST[source]', ml.batch_label = '$_POST[batch_label]', ml.bulk_label = '$_POST[bulk_label]', ml.imed_mail_label = '$_POST[imed_mail_label]',
       ml.imed_ship_label = '$_POST[imed_ship_label]', ml.mail_exclude = '$_POST[mail_exclude]', ml.registration_expire = '$_POST[registration_expire]',
       ml.counseling = '$_POST[counseling]', ml.last_access = '$_POST[last_access]', ml.last_change = '$_POST[last_change]', ml. usps_address_code = '$_POST[usps_address_code]' 
       WHERE ml.account_id = '$_POST[account_id]';";

$result = sqlsrv_query($conn, $stmt);

sqlsrv_close( $conn );
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