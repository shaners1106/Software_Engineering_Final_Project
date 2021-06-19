<?php
session_start();
if (isset($_SESSION['login_user'])) {
    echo "Welcome " . $_SESSION['login_user'];
}
?>

<htst>

<head>
    <title>Student Account Creation</title>
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


<h1>New Student successfully added</h1>

<body>
    <!-- a form to take in the genre input. -->


    <div class="container">

        <!-- it then prints every result with the genre matching the input, and appends the cart if a user decides to rent it. -->
        <?php
include 'connect.php';



$stmt = "INSERT INTO dbo.student VALUES('$_POST[account_id]', '$_POST[student_id]',
       '$_POST[student_first_name]', '$_POST[student_last_name]', '$_POST[grade]',
       '$_POST[birthday]', '$_POST[entered]',
       '$_POST[start]', '$_POST[end]', 
       '$_POST[program]', '$_POST[teacher]', '$_POST[is_emailed]',
       '$_POST[is_withdrawn]', '$_POST[is_labeled]', '$_POST[book_list]',
       '$_POST[evals_ordered]', '$_POST[single_course]', '$_POST[escrow_credits]', '$_POST[sat_m]',
       '$_POST[sat_v]', '$_POST[sat_w]', '$_POST[act_c]',
      '$_POST[gpa]', '$_POST[graduation]','$_POST[questionnaire_received]', '$_POST[book_list_sent]',
       '$_POST[book_list_received]', '$_POST[eval1_sent]',  '$_POST[eval1_received]', '$_POST[eval1_paid]',
       '$_POST[eval2_sent]','$_POST[eval2_received]',  '$_POST[eval2_paid]',  '$_POST[eval3_sent]',  '$_POST[eval3_received]',
       '$_POST[eval3_paid]', '$_POST[eval4_sent]', '$_POST[eval4_received]',
       '$_POST[eval4_paid]', '$_POST[eval5_sent]', '$_POST[eval5_received]', '$_POST[eval5_paid]', 
       '$_POST[eval6_sent]', '$_POST[eval6_received]', '$_POST[eval6_paid]');";

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

</htst>