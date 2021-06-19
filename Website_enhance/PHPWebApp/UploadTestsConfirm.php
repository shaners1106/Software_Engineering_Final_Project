<?php
//If in the future you want to implement a public login feature, this will get you there.
session_start();
if (isset($_SESSION['login_user'])) {
    echo "Welcome " . $_SESSION['login_user'];
}
?>

<html>

<head>
    <title>Student Account Edited</title>
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


<h1>The Test Has been added.</h1>
<h3>Thank you.</h3>

<body>
    <!-- a form to take in the genre input. -->


    <div class="container">

        <!-- it then prints every result with the genre matching the input, and appends the cart if a user decides to rent it. -->
        <?php
include 'connect.php';

//print_r($_POST);
 //plop it into the database.
      
 $stmt = "INSERT INTO dbo.test_results VALUES ('$_POST[test_id]', '$_POST[subject]', '$_POST[account_id]', '$_POST[student_id]', '$_POST[group_id]', 
 '$_POST[group_qty]', '$_POST[source_id]', '$_POST[date_ordered]', '$_POST[date_printed]', '$_POST[date_taken]', '$_POST[date_scored]', '$_POST[status]', 
 '$_POST[grade]', '$_POST[level]', '$_POST[year_third]', '$_POST[raw_score]', '$_POST[rit_score]',
 '$_POST[percent_correct]', '$_POST[hewitt_percentile]', '$_POST[national_percentile]', '$_POST[overall_rank]', '$_POST[goal1_rank]', '$_POST[goal2_rank]', '$_POST[goal3_rank]',
 '$_POST[goal4_rank]', '$_POST[goal5_rank]', '$_POST[goal6_rank]', '$_POST[goal7_rank]', '$_POST[raw_responses]');";
  
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