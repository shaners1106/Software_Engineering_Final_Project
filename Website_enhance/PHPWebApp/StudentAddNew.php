<?php 
      session_start();
      if(isset($_SESSION['login_user']))
      {
          echo "Welcome " . $_SESSION['login_user'];
      }
?>

<html>

<head>
    <title>Add New Student</title>
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

<h1>Add New Student</h1>

<body>
   

    <div class="container">
    <br><br><br>

        <!-- it then prints every result with the genre matching the input, and appends the cart if a user decides to rent it. -->
        <?php
  include 'connect.php';

  

  echo"<h1>Create a New Student for Account: ". $_SESSION['account_id']. "</h1>";



echo"<h3>Insert Student Information</h3>";
//assign main account variables for giant form fields

$newSID = $_SESSION['student_account_id'];
$newSID = $newSID+1;

$account_id = $_SESSION['account_id'];
$student_id = $newSID;
$student_first_name = '';
$student_last_name = '';

$birthday = '';
$entered = '';
$start = '';
$end = '';
$grade = '';
$program = '';
$teacher = '';
$is_emailed = '';
$is_withdrawn = '';
$is_labeled = '';
$book_list = '';
$evals_ordered = '';
$single_course = '';
$escrow_credits = '';

$sat_m = '';
$sat_v = '';
$sat_w = '';
$act_c = '';
$gpa = '';
$graduation = '';
$questionnaire_received = '';
$book_list_sent = '';
$book_list_received = '';
$eval1_sent = '';

$eval1_received = '';
$eval1_paid = '';
$eval2_sent = '';
$eval2_received = '';
$eval2_paid = '';

$eval3_sent = '';
$eval3_received = '';
$eval3_paid = '';
$eval4_sent = '';
$eval4_received = '';
$eval4_paid = '';
$eval5_sent = '';
$eval5_received = '';
$eval5_paid = '';
$eval6_sent = '';
$eval6_received = '';
$eval6_paid = '';


 echo"<form action = 'NewStudentConfirm.php' method = 'post'>";
 echo"<table>";
echo"<tr><td>";
 echo"<label>account_id:</label>";
  echo"<input type='text' name = 'account_id' value='$account_id'><br>"; 
  echo"</td><td>";
  echo"<label>student_id:</label>";
  echo"<input type='text' name = 'student_id' value='$student_id'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>student_first_name:</label>";
  echo"<input type='text' name = 'student_first_name' value='$student_first_name'><br>";
  echo"</td><td>"; 
  echo"<label>student_last_name:</label>";
  echo"<input type='text' name = 'student_last_name' value='$student_last_name'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>birthday:</label>";
  echo"<input type='text' name = 'birthday' value='$birthday'><br>"; 
  echo"</td><td>"; 
  echo"<label>entered:</label>";
  echo"<input type='text' name = 'entered' value='$entered'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>start:</label>";
  echo"<input type='text' name = 'start' value='$start'><br>"; 
  echo"</td><td>"; 
  echo"<label>end:</label>";
  echo"<input type='text' name = 'end' value='$end'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>grade:</label>";
  echo"<input type='text' name = 'grade' value='$grade'><br>";
  echo"</td><td>";  
  echo"<label>program:</label>";
  echo"<input type='text' name = 'program' value='$program'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>teacher:</label>";
  echo"<input type='text' name = 'teacher' value='$teacher'><br>";
  echo"</td><td>";  
  echo"<label>is_emailed:</label>";
  echo"<input type='text' name = 'is_emailed' value='$is_emailed'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>is_withdrawn:</label>";
  echo"<input type='text' name = 'is_withdrawn' value='$is_withdrawn'><br>";
  echo"</td><td>";  
  echo"<label>is_labeled:</label>";
  echo"<input type='text' name = 'is_labeled' value='$is_labeled'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>book_list:</label>";
  echo"<input type='text' name = 'book_list' value='$book_list'><br>";
  echo"</td><td>"; 
  echo"<label>evals_ordered:</label>";
  echo"<input type='text' name = 'evals_ordered' value='$evals_ordered'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>single_course:</label>";
  echo"<input type='text' name = 'single_course' value='$single_course'><br>";
  echo"</td><td>";  
  echo"<label>escrow_credits:</label>";
  echo"<input type='text' name = 'escrow_credits' value='$escrow_credits'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>sat_m:</label>";
  echo"<input type='text' name = 'sat_m' value='$sat_m'><br>";
  echo"</td><td>";  
  echo"<label>sat_v:</label>";
  echo"<input type='text' name = 'sat_v' value='$sat_v'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>sat_w:</label>";
  echo"<input type='text' name = 'sat_w' value='$sat_w'><br>";
  echo"</td><td>";  
  echo"<label>act_c:</label>";
  echo"<input type='text' name = 'act_c' value='$act_c'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>gpa:</label>";
  echo"<input type='text' name = 'gpa' value='$gpa'><br>";
  echo"</td><td>";  
  echo"<label>graduation:</label>";
  echo"<input type='text' name = 'graduation' value='$graduation'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>questionnaire_received:</label>";
  echo"<input type='text' name = 'questionnaire_received' value='$questionnaire_received'>'<br>";
  echo"</td><td>";  
  echo"<label>book_list_sent:</label>";
  echo"<input type='text' name = 'book_list_sent' value='$book_list_sent'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>book_list_received:</label>";
  echo"<input type='text' name = 'book_list_received' value='$book_list_received'><br>";
  echo"</td></tr><tr><td>"; 
  echo"<label>eval1_sent:</label>";
  echo"<input type='text' name = 'eval1_sent' value='$eval1_sent'><br>";
  echo"</td><td>";
  echo"<label>eval1_received:</label>";
  echo"<input type='text' name = 'eval1_received' value='$eval1_received'><br>";
  echo"</td><td>";  
  echo"<label>eval1_paid:</label>";
  echo"<input type='text' name = 'eval1_paid' value='$eval1_paid'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>eval2_sent:</label>";
  echo"<input type='text' name = 'eval2_sent' value='$eval2_sent'><br>";
  echo"</td><td>";  
  echo"<label>eval2_received:</label>";
  echo"<input type='text' name = 'eval2_received' value='$eval2_received'><br>";
  echo"</td><td>";
  echo"<label>eval2_paid:</label>";
  echo"<input type='text' name = 'eval2_paid' value='$eval2_paid'><br>";
  echo"</td></tr><tr><td>";  
  echo"<label>eval3_sent:</label>";
  echo"<input type='text' name = 'eval3_sent' value='$eval3_sent'><br>";
  echo"</td><td>";
  echo"<label>eval3_received:</label>";
  echo"<input type='text' name = 'eval3_received' value='$eval3_received'><br>";
  echo"</td><td>";  
  echo"<label>eval3_paid:</label>";
  echo"<input type='text' name = 'eval3_paid' value='$eval3_paid'><br>";
  echo"</td></tr><tr><td>";
  echo"<label>eval4_sent:</label>";
  echo"<input type='text' name = 'eval4_sent' value='$eval4_sent'><br>";
  echo"</td><td>";  
  echo"<label>eval4_received:</label>";
  echo"<input type='text' name = 'eval4_received' value='$eval4_received'><br>";
  echo"</td><td>";
  echo"<label>eval4_paid:</label>";
  echo"<input type='text' name = 'eval4_paid' value='$eval4_paid'><br>";
  echo"</td></tr><tr><td>";   
  echo"<label>eval5_sent:</label>";
  echo"<input type='text' name = 'eval5_sent' value='$eval5_sent'><br>";
  echo"</td><td>";
  echo"<label>eval5_received:</label>";
  echo"<input type='text' name = 'eval5_received' value='$eval5_received'><br>";
  echo"</td><td>";  
  echo"<label>eval5_paid:</label>";
  echo"<input type='text' name = 'eval5_paid' value='$eval5_paid'>";
  echo"</td></tr><tr><td>";
  echo"<label>eval6_sent:</label>";
  echo"<input type='text' name = 'eval6_sent' value='$eval6_sent'><br>";
  echo"</td><td>";  
  echo"<label>eval6_received:</label>";
  echo"<input type='text' name = 'eval6_received' value='$eval6_received'>";
  echo"</td><td>";
  echo"<label>eval6_paid:</label>";
  echo"<input type='text' name = 'eval6_paid' value='$eval6_paid'>";
  echo"</td></tr><tr><td>";
  echo"</table>";
  echo"<br>";
 echo"<input type='submit' name = 'AddNewStudent' id='EDIT' value='Create Student'>";
echo"</form>";
  


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