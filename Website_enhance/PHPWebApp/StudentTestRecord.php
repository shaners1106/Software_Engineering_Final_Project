<?php 
      session_start();
      if(isset($_SESSION['login_user']))
      {
          echo "Welcome " . $_SESSION['login_user'];
      }
?>

<html>

<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
    <title>Retrieve Tests</title>
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

<h1>Student Records by Account</h1>

<body>
    <h4>Need a Different Account?</h4>



    </form>
    <form action="StudentTestRecord.php" method="get">
        Account ID:<br><input type="text" name="ID"><br><br><br><br>
        Student ID:<br><input type="text" name="SID"><br><br><br><br>
        <input type="submit">
    </form>



    <div class="container">
        <br><br><br>


        <?php
  include 'connect.php';
  
  if (isset($_GET['ID']))
  {

    $_SESSION['account_id'] = $_GET["ID"];
    $_SESSION['student_account_id'] = $_GET["SID"];
      $ID = $_GET["ID"];
      $SID = $_GET["SID"];
  
    }
    
    echo"<h1>Test Records for Student: ". $_SESSION['account_id']. "_". $_SESSION['student_account_id']. "</h1>";

    $stmt = "SELECT ln.test_id, ln.subject, ln.grade, ln.year_third, ln.date_ordered, ln.date_printed, ln.date_taken,
    ln.level, ln.raw_score, ln.percent_correct, ln.rit_score, ln.hewitt_percentile, ln.national_percentile, ln.overall_rank, ln.goal1_rank,
    ln.goal2_rank, ln.goal3_rank, ln.goal4_rank, ln.goal5_rank, ln.goal6_rank, ln.goal7_rank
    FROM dbo.test_results as ln
    WHERE ln.account_id = ".$_SESSION['account_id']." AND ln.student_id = ".$_SESSION['student_account_id'].";";

$result = sqlsrv_query($conn, $stmt);
     
        echo"<table id='testResults'>";
       
        echo"<button onclick='testResults()' class='button'>Download PDF</button>";
      echo"<thead>";
      echo "<tr><th><h3>test_id</h3></th><th><h3>subject</h3></th><th><h3>grade</h3></th><th><h3>year_third</h3></th><th><h3>date_ordered</h3></th><th><h3>date_printed</h3></th><th><h3>date_taken</h3></th>
      <th><h3>level</h3></th></tr>\n";
      echo "</thead>";
      echo "<tbody>";
    
      while($results = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
  
      echo "<tr><td><h2>{$results['test_id']} </h2></td><td><h3>{$results['subject']} </h3></td><td><h3>{$results['grade']} </h3></td>
      <td><h3>{$results['year_third']} </h3></td><td><h3>{$results['date_ordered']}</h3></td><td><h3>{$results['date_printed']} </h3></td><td><h3>{$results['date_taken']} </h3></td>
      <td><h3>{$results['level']} </h3></td>
      </tr>\n";
    
    }
    echo"</tbody>";
    echo"</table>";
    $stmt = "SELECT ln.test_id, ln.subject, ln.grade, ln.year_third, ln.date_ordered, ln.date_printed, ln.date_taken,
    ln.level, ln.raw_score, ln.percent_correct, ln.rit_score, ln.hewitt_percentile, ln.national_percentile, ln.overall_rank, ln.goal1_rank,
    ln.goal2_rank, ln.goal3_rank, ln.goal4_rank, ln.goal5_rank, ln.goal6_rank, ln.goal7_rank
    FROM dbo.test_results as ln
    WHERE ln.account_id = ".$_SESSION['account_id']." AND ln.student_id = ".$_SESSION['student_account_id'].";";

$result = sqlsrv_query($conn, $stmt);
    
    echo"<table id='testResults2'>";
    echo"<thead>";
    echo"<tr><th><h3>raw_score</h3></th><th><h3>percent_correct</h3></th><th><h3>rit_score</h3></th><th><h3>hewitt_percentile</h3></th>
    <th><h3>national_percentile</h3></th><th><h3>overall_rank</h3></th>\n";
    echo "</thead>";
    echo "<tbody>";

    while($results = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
    echo"<td><h3>{$results['raw_score']}</h3></td><td><h3>{$results['percent_correct']} </h3></td><td><h3>{$results['rit_score']} </h3></td>
    <td><h3>{$results['hewitt_percentile']} </h3></td><td><h3>{$results['national_percentile']}</h3></td><td><h3>{$results['overall_rank']} </h3></td></tr>\n";
    }
    echo"</tbody>";

    echo"</table>";

    $stmt = "SELECT ln.test_id, ln.subject, ln.grade, ln.year_third, ln.date_ordered, ln.date_printed, ln.date_taken,
    ln.level, ln.raw_score, ln.percent_correct, ln.rit_score, ln.hewitt_percentile, ln.national_percentile, ln.overall_rank, ln.goal1_rank,
    ln.goal2_rank, ln.goal3_rank, ln.goal4_rank, ln.goal5_rank, ln.goal6_rank, ln.goal7_rank
    FROM dbo.test_results as ln
    WHERE ln.account_id = ".$_SESSION['account_id']." AND ln.student_id = ".$_SESSION['student_account_id'].";";
    
    $result = sqlsrv_query($conn, $stmt);

    echo"<table id='testResults3'>";
    echo"<thead>";
    echo"<th><h3>goal_1_rank</h3></th><th><h3>goal_2_rank</h3></th><th><h3>goal_3_rank</h3></th>
    <th><h3>goal_4_rank</h3></th><th><h3>goal_5_rank</h3></th><th><h3>goal_6_rank</h3></th><th><h3>goal_7_rank</h3></th></tr>\n";
    echo "</thead>";
    echo "<tbody>";

    while($results = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
    echo"<tr><td><h3>{$results['goal1_rank']} </h3></td>
    <td><h3>{$results['goal2_rank']} </h3></td><td><h3>{$results['goal3_rank']}</h3></td><td><h3>{$results['goal4_rank']} </h3></td><td><h3>{$results['goal5_rank']} </h3></td>
    <td><h3>{$results['goal6_rank']} </h3></td><td><h3>{$results['goal7_rank']} </h3></td></tr>\n";
    }
    echo"</tbody>";

    echo"</table>";
  
  




  
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


<script>
function testResults(){
var doc = new jsPDF('l')
var my_var = <?php echo $_SESSION['account_id']; ?>;
var my_other_var = <?php echo $_SESSION['student_account_id']; ?>;
var my_string_var = String(my_var)+"_"+String(my_other_var)

doc.text(7, 10, "Test Results for "+my_string_var)


doc.autoTable({ html: '#testResults'})
doc.autoTable({ html: '#testResults2'})
doc.autoTable({ html: '#testResults3'})

doc.save("TestResults"+my_string_var+".pdf")
}
</script>

<footer>
    <div class="row">
        <div class="col">
            <p class="footer-text">Copyright Hewitt Learning, 2021
            </p>

        </div>
    </div>
</footer>