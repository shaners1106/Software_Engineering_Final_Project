<?php
//If in the future you want to implement a public login feature, this will get you there.
include('login.php');

if(isset($_SESSION['login_user'])){
    header("location: profile.php");
}
?>

<html>

<head>
    <title>Hewitt Learning</title>
    <link rel="stylesheet" href="mystyles.css">
</head>

<body>
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




    <div class="row">
        <div class="col">
            <!-- A button linked to all account options -->

            <a href="AccountsID.php" class="button">Accounts by ID</a>
            <a href="StudentTestRecord.php" class="button">Test Records</a>
        </div>
    </div>




    <footer>
        <div class="row">
            <div class="col">
                <p class="footer-text">Copyright Hewitt Learning, 2021
                </p>

            </div>
        </div>
    </footer>

</body>

</html>