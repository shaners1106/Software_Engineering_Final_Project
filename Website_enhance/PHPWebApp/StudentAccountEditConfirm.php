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


<h1>The Student account has been changed.</h1>
<h3>Please return to the Home Screen or navigate to another page.</h3>

<body>
    <!-- a form to take in the genre input. -->


    <div class="container">

        <!-- it then prints every result with the genre matching the input, and appends the cart if a user decides to rent it. -->
        <?php
include 'connect.php';

$stmt = "UPDATE dbo.student as st SET st.account_id = '$_POST[account_id]', st.student_id = '$_POST[student_id]',
       st.student_first_name = '$_POST[student_first_name]', st.student_last_name = '$_POST[student_last_name]',
       st.grade = '$_POST[grade]', st.birthday = '$_POST[birthday]',
       st.entered = '$_POST[entered]', st.start = '$_POST[start]', st.end = '$_POST[end]', st.program = '$_POST[program]', st.teacher = '$_POST[teacher]',
       st.is_emailed = '$_POST[is_emailed]', st.is_withdrawn = '$_POST[is_withdrawn]', st.is_labeled = '$_POST[is_labeled]',
       st.book_list = '$_POST[book_list]', st.evals_ordered = '$_POST[evals_ordered]', st.single_course = '$_POST[single_course]', st.escrow_credits = '$_POST[escrow_credits]', st.sat_m = '$_POST[sat_m]',
       st.sat_v = '$_POST[sat_v]', st.sat_w = '$_POST[sat_w]', st.act_c = '$_POST[act_c]', st.gpa = '$_POST[gpa]',
       st.graduation = '$_POST[graduation]', st.questionnaire_received = '$_POST[questionnaire_received]', st.book_list_sent = '$_POST[book_list_sent]', st.book_list_received = '$_POST[book_list_received]', 
       st.eval1_sent = '$_POST[eval1_sent]', st.eval1_received = '$_POST[eval1_received]', st.eval1_paid = '$_POST[eval1_paid]',
       st.eval2_sent = '$_POST[eval2_sent]', st.eval2_received = '$_POST[eval2_received]', st.eval2_paid = '$_POST[eval2_paid]',
       st.eval3_sent = '$_POST[eval3_sent]', st.eval3_received = '$_POST[eval3_received]', st.eval3_paid = '$_POST[eval3_paid]',
       st.eval4_sent = '$_POST[eval4_sent]', st.eval4_received = '$_POST[eval4_received]', st.eval4_paid = '$_POST[eval4_paid]',
       st.eval5_sent = '$_POST[eval5_sent]', st.eval5_received = '$_POST[eval5_received]', st.eval5_paid = '$_POST[eval5_paid]',
       st.eval6_sent = '$_POST[eval6_sent]', st.eval6_received = '$_POST[eval6_received]', st.eval6_paid = '$_POST[eval6_paid]' 
       WHERE st.account_id = '$_POST[account_id]' AND st.student_id = '$_POST[student_id]';";

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