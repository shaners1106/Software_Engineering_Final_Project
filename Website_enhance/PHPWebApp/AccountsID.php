<?php 
//If in the future you want to implement a public login feature, this will get you there.
      session_start();
      if(isset($_SESSION['login_user']))
      {
          echo "Welcome " . $_SESSION['login_user'];
      }
?>

<html>

<head>
    <title>Search by ID</title>
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

<h1>Search for Account by ID</h1>

<body>
    <h4> Numbers Only, Please</h4>
    <!-- a form to take in the genre input. -->


    </form>
    <form action="AccountsID.php" method="get">
        ID:<br><input type="text" name="ID"><br><br><br><br>
        <input type="submit">
    </form>
    <br><br><br><br>
    <div class="container">

        <!-- it then prints every result with the genre matching the input, and appends the cart if a user decides to rent it. -->
        <?php
  include 'connect.php';
  
if (isset($_GET['ID']))
{
    $ID = $_GET["ID"];

  
  echo"<h1>All Accounts Under $ID </h1>";

  $stmt = "SELECT  ml.account_id, ml.company, ml.customer1_last_name, ml.customer1_first_name, ml.address1, 
  ml.city1, ml.state1, ml.zipcode1, ml.phone1, ml.email1 
  FROM dbo.mailing_list as ml
  WHERE ml.account_id LIKE UPPER('%$ID%');";

$result = sqlsrv_query($conn, $stmt);
   
      echo"<table>";
    echo"<thead>";
    echo "<tr><th><h3>Acct</h3></th><th><h3>Company</h3></th><th><h3>LName1</h3></th><th><h3>FName1</h3></th><th><h3>Address</h3></th><th><h3>City</h3></th><th><h3>Zip</h3></th><th><h3>Phone</h3></th><th><h3>EXPAND</h3></th></tr>\n";
    echo "</thead>";
    echo "<tbody>";
  
    while($results = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
  
    echo "<tr><td><h2>{$results['account_id']} </h2></td><td><h3>{$results['company']}</h3></td><td><h3>{$results['customer1_last_name']} </h3></td><td><h3>{$results['customer1_first_name']} </h3></td>
    <td><h3>{$results['address1']} </h3></td><td><h3>{$results['city1']}</h3></td><td><h3>{$results['zipcode1']}</h3></td><td><h3>{$results['phone1']} </h3></td>
    <td><form action='AccountEdit.php' method='post'><input name='edit_button' type='submit' value={$results['account_id']}></form></td></tr>\n";
  
  }
  echo"</tbody>";
  echo"</table>";
  }
  //If the user presses the rent button on a movie, that movie is then appended to the cart if the user is logged into a profile
 if (!empty($_GET['rent_button'])){
    if(!isset($_SESSION['login_user']))
    {
      echo "<script type='text/javascript'> document.location = 'loginpage.php'; </script>";
    } 
    else
    {
      $temp_arr = array($_GET['rent_button']);
      if(empty($_SESSION['Cart']))
      {
        $_SESSION['Cart'] = $temp_arr;
      }
      else if(!in_array($_GET['rent_button'], $_SESSION['Cart']))
      {
        $_SESSION['Cart']= array_merge($_SESSION['Cart'], $temp_arr);
      }
      echo "<script type='text/javascript'> document.location = 'Cart.php'; </script>";
    }
  }

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