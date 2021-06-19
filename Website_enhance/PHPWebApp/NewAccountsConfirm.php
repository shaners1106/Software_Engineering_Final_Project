<?php
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


<h1>New Account Successfully Created</h1>

<body>
    <!-- a form to take in the genre input. -->


    <div class="container">

        <!-- it then prints every result with the genre matching the input, and appends the cart if a user decides to rent it. -->
        <?php
include 'connect.php';

$stmt = "INSERT INTO dbo.mailing_list VALUES ('$_POST[account_id]', ' ', '$_POST[customer1_first_name]', '$_POST[customer1_last_name]',
       '$_POST[customer2_first_name]', '$_POST[customer2_last_name]',
       '$_POST[customer3_first_name]', '$_POST[customer3_last_name]',
       '$_POST[company]', '$_POST[address1]', '$_POST[address2]', '$_POST[city1]', '$_POST[state1]', '$_POST[city2]', '$_POST[state2]',
      '$_POST[zipcode1]', '$_POST[zipcode2]', '$_POST[plus4_1]', '$_POST[plus4_2]', '$_POST[country_code1]', '$_POST[country_code2]',
       '$_POST[country_name1]', '$_POST[country_name2]', '$_POST[ship_first_name1]','$_POST[ship_first_name2]',
       '$_POST[ship_last_name1]', '$_POST[ship_last_name2]', '$_POST[ship_company]', '$_POST[ship_address]',  '$_POST[ship_city]', '$_POST[ship_state]',
       '$_POST[ship_zipcode]', '$_POST[ship_plus4]',  '$_POST[ship_country_code]',
       '$_POST[ship_country_name]', '$_POST[phone1]', '$_POST[phone2]', '$_POST[email1]',
       '$_POST[email2]', '$_POST[fax]', '$_POST[comments]', '$_POST[customer_flag]',
       '$_POST[source]', '$_POST[batch_label]', '$_POST[bulk_label]', '$_POST[imed_mail_label]',
       '$_POST[imed_ship_label]', '$_POST[mail_exclude]', '$_POST[registration_expire]',
       '$_POST[counseling]', '$_POST[last_access]', '$_POST[last_change]', '$_POST[usps_address_code]');";

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