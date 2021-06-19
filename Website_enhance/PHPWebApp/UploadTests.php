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

<h1>Upload New Graded Tests</h1>

<body>
    <h4>Please Select the .txt file to upload</h4>



  

    <form action="UploadTests.php" method="post" enctype="multipart/form-data">
   <input type="file" name="file" id="file"/><br><br><br>
<input type="submit" name="TestUpload" value="Review And Upload"><br><br><br>
<input type="submit" name="UploadALL" value="Upload All">
</form>

    <div class="container">
        <br><br><br>


        <?php
 // include 'connect.php';


  //convoluted upload of test information into database!
  //This is not at all an ideal program, but it's the best
  //we could do given the output. What would be ideal is for
  //the txt file to have a space between every entry, and then you
  //can put the who line into an array with the explode() function.
  //This will help tremendously, as right now there is no way to
  //tell if a person has a percentile value below 10. Hence the form confirmation.
  if (isset($_POST['TestUpload']) || isset($_POST['UploadAll']))
  {

    $TestNum = 1; //variable to track which form is which

    
    //Open up the txt file
    $fp = fopen($_FILES['file']['tmp_name'], 'rb');
    //iterate through each line
    while ( ($line = fgets($fp)) !== false) {
    //  echo"<h1>Test added from following line:</h1>";
   //   echo "$line<br>";
        //parse account info
        $account_id = "";
        $lineArray = str_split($line);
        for($i = 0; $i < 6; $i++){
          $account_id = ($account_id.$lineArray[$i]); 
        }
       // echo "$account_id<br>";
        
        //parse student id info
        $student_id = "";
        for($i = 6; $i < 8; $i++){
          $student_id = ($student_id.$lineArray[$i]); 
        }
       // echo "$student_id<br>";
        
        //parse test id info
        $test_id = "";
        for($i = 8; $i < 14; $i++){
          $test_id = ($test_id.$lineArray[$i]); 
        }
       // echo "$test_id<br>";
        
        //parse date taken
        $date_taken = "";
        for($i = 14; $i < 20; $i++){
          $date_taken = ($date_taken.$lineArray[$i]); 
        }
//        echo "$date_taken<br>";

        //Make a query to get other dates
        
        //get current date timestamp

         //parse year_third
         $year_third = "";
         for($i = 20; $i < 21; $i++){
           $year_third = ($year_third.$lineArray[$i]); 
         }
  //       echo "$year_third<br>";

          //parse grade
        $grade = "";
        for($i = 21; $i < 22; $i++){
          $grade = ($grade.$lineArray[$i]); 
        }
    //    echo "$grade<br>";

        //parse subject
        $subject = "";
        for($i = 22; $i < 23; $i++){
          $subject = ($subject.$lineArray[$i]); 
        }
      //  echo "$subject<br>";
        
        //parse level
        $level = "";
        for($i = 23; $i < 25; $i++){
          $level = ($level.$lineArray[$i]); 
        }
        //echo "$level<br>";

        $temp_i = 0;
        //parse raw_score
        $raw_score = "";
        for($i = 25; $i < 28; $i++){
          if($lineArray[$i]==" "){
            $temp_i = $i++;
            break;
          }
          else{
          $raw_score = ($raw_score.$lineArray[$i]);
           
          }
        }
        $temp_i = $temp_i +1;
       // echo "$raw_score<br>";
       // echo "$temp_i<br>";

        //parse percent_correct
        $percent_correct = "";
        if($lineArray[$temp_i]==0){
          $percent_correct = $lineArray[$temp_i];
          $temp_i++;
        }
        else if($lineArray[$temp_i]==1 && $lineArray[$temp_i+1]==0 && $lineArray[$temp_i+2]==0){
          $percent_correct = 100;
          $temp_i = $temp_i+3;
        }
        else{
          for($i = $temp_i; $i < ($temp_i+2); $i++){
            $percent_correct = ($percent_correct.$lineArray[$i]);
            }
            $temp_i = $temp_i +2;
          }
        
       // echo "$percent_correct<br>";
        //echo "$temp_i<br>";

         //parse RIT_score
         $rit_score = "";
         if($lineArray[$temp_i]==0){
           $rit_score = $lineArray[$temp_i];
           $temp_i++;
         }
         else if($lineArray[$temp_i]==1 && $lineArray[$temp_i+1]==0 && $lineArray[$temp_i+2]==0 && $lineArray[$temp_i+3]==0){
           $rit_score = 1000;
           $temp_i = $temp_i+4;
         }
         else{
           for($i = $temp_i; $i < ($temp_i+3); $i++){
             $rit_score = ($rit_score.$lineArray[$i]);
             }
             $temp_i = $temp_i +3;
           }
         
        // echo "$rit_score<br>";

        //parse hewitt_percentile
        $hewitt_percentile = "";
        if($lineArray[$temp_i]==0){
          $hewitt_percentile = $lineArray[$temp_i];
          $temp_i++;
        }
        else if($lineArray[$temp_i]==1 && $lineArray[$temp_i+1]==0 && $lineArray[$temp_i+2]==0){
          $hewitt_percentile = 100;
          $temp_i = $temp_i+3;
        }
        else{
          for($i = $temp_i; $i < ($temp_i+2); $i++){
            $hewitt_percentile = ($hewitt_percentile.$lineArray[$i]);
            }
            $temp_i = $temp_i +2;
          }
        
        //echo "$hewitt_percentile<br>";
    

         //parse national_percentile
         $national_percentile = "";
         if($lineArray[$temp_i]==0){
           $national_percentile = $lineArray[$temp_i];
           $temp_i++;
         }
         else if($lineArray[$temp_i]==1 && $lineArray[$temp_i+1]==0 && $lineArray[$temp_i+2]==0){
           $national_percentile = 100;
           $temp_i = $temp_i+3;
         }
         else{
           for($i = $temp_i; $i < ($temp_i+2); $i++){
             $national_percentile = ($national_percentile.$lineArray[$i]);
             }
             $temp_i = $temp_i +2;
           }
         
        // echo "$national_percentile<br>";

         //parse overall_rank
         $overall_rank = "";
           for($i = $temp_i; $i < ($temp_i+2); $i++){
             $overall_rank = ($overall_rank.$lineArray[$i]);
             }
             $temp_i = $i;
        // echo "$overall_rank<br>";
         
         //parse goal1_rank
         $goal1_rank = "";
           for($i = $temp_i; $i < ($temp_i+2); $i++){
             $goal1_rank = ($goal1_rank.$lineArray[$i]);
             }
             $temp_i = $i;
        // echo "$goal1_rank<br>";

         //parse goal12_rank
         $goal2_rank = "";
           for($i = $temp_i; $i < ($temp_i+2); $i++){
             $goal2_rank = ($goal2_rank.$lineArray[$i]);
             }
             $temp_i = $i;
        // echo "$goal2_rank<br>";

         //parse goal1_rank
         $goal3_rank = "";
           for($i = $temp_i; $i < ($temp_i+2); $i++){
             $goal3_rank = ($goal3_rank.$lineArray[$i]);
             }
             $temp_i = $i;
//         echo "$goal3_rank<br>";

         //parse goal1_rank
         $goal4_rank = "";
           for($i = $temp_i; $i < ($temp_i+2); $i++){
             $goal4_rank = ($goal4_rank.$lineArray[$i]);
             }
             $temp_i = $i;
  //       echo "$goal4_rank<br>";

         //parse goal1_rank
         $goal5_rank = "";
           for($i = $temp_i; $i < ($temp_i+2); $i++){
             $goal5_rank = ($goal5_rank.$lineArray[$i]);
             }
             $temp_i = $i;
    //     echo "$goal5_rank<br>";

         //parse goal1_rank
         $goal6_rank = "";
           for($i = $temp_i; $i < ($temp_i+2); $i++){
             $goal6_rank = ($goal6_rank.$lineArray[$i]);
             }
             $temp_i = $i;
         //echo "$goal6_rank<br>";

         //parse goal1_rank
         $goal7_rank = "";
           for($i = $temp_i; $i < ($temp_i+2); $i++){
             $goal7_rank = ($goal7_rank.$lineArray[$i]);
             }
             $temp_i = $i;
         //echo "$goal7_rank<br>";

         //parse raw_responses
         $raw_responses = "";
           while($temp_i < sizeof($lineArray)){
             $raw_responses = ($raw_responses.$lineArray[$temp_i]);
            $temp_i++; 
            }
            
        // echo "$raw_responses<br>";
        include 'connect.php';
         //query test_orders to get date_ordered and shipped
         $stmt = "SELECT date_ordered, date_printed, group_id, group_qty
        FROM dbo.test_order
        WHERE test_id = '$test_id';";
        $result = sqlsrv_query($conn, $stmt);
        sqlsrv_close( $conn );
       // echo "$result";
       while($results = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){

        //echo "<h2>{$results['date_ordered']} </h2>";
        //echo "<h2>{$results['date_printed']} </h2>";
        $source_id = $test_id;
        $status = 7;
        $group_id = $results['group_id'];
        $group_qty = $results['group_qty'];
       $date_ordered = $results['date_ordered'];
       $date_printed = $results['date_printed'];
       $date_scored = date("Y-m-d");
       //echo "$date_ordered<br>";
       //echo "$date_printed<br>";
       //echo "$date_scored<br>";

       

      //make a form to confirm
      echo"<form action = 'UploadTestsConfirm.php' id = '$TestNum' name = '$TestNum' method = 'post' target='_blank'>";
      echo"<table>";
     echo"<tr><td>";
      echo"<label>test_id:</label>";
       echo"<input type='text' name = 'test_id' value='$test_id'><br>"; 
       echo"</td><td>";
       echo"<label>subject:</label>";
       echo"<input type='text' name = 'subject' value='$subject'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>account_id:</label>";
       echo"<input type='text' name = 'account_id' value='$account_id'><br>";
       echo"</td><td>"; 
       echo"<label>student_id:</label>";
       echo"<input type='text' name = 'student_id' value='$student_id'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>group_id:</label>";
       echo"<input type='text' name = 'group_id' value='$group_id'><br>"; 
       echo"</td><td>"; 
       echo"<label>group_qty:</label>";
       echo"<input type='text' name = 'group_qty' value='$group_qty'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>source_id:</label>";
       echo"<input type='text' name = 'source_id' value='$source_id'><br>"; 
       echo"</td><td>"; 
       echo"<label>date_ordered:</label>";
       echo"<input type='text' name = 'date_ordered' value='$date_ordered'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>date_printed:</label>";
       echo"<input type='text' name = 'date_printed' value='$date_printed'><br>";
       echo"</td><td>";  
       echo"<label>date_taken:</label>";
       echo"<input type='text' name = 'date_taken' value='$date_taken'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>date_scored:</label>";
       echo"<input type='text' name = 'date_scored' value='$date_scored'><br>";
       echo"</td><td>";  
       echo"<label>status:</label>";
       echo"<input type='text' name = 'status' value='$status'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>grade:</label>";
       echo"<input type='text' name = 'grade' value='$grade'><br>";
       echo"</td><td>";  
       echo"<label>level:</label>";
       echo"<input type='text' name = 'level' value='$level'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>year_third:</label>";
       echo"<input type='text' name = 'year_third' value='$year_third'><br>";
       echo"</td><td>"; 
       echo"<label>raw_score:</label>";
       echo"<input type='text' name = 'raw_score' value='$raw_score'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>rit_score:</label>";
       echo"<input type='text' name = 'rit_score' value='$rit_score'><br>";
       echo"</td><td>";  
       echo"<label>percent_correct:</label>";
       echo"<input type='text' name = 'percent_correct' value='$percent_correct'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>hewitt_percentile:</label>";
       echo"<input type='text' name = 'hewitt_percentile' value='$hewitt_percentile'><br>";
       echo"</td><td>";  
       echo"<label>national_percentile:</label>";
       echo"<input type='text' name = 'national_percentile' value='$national_percentile'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>overall_rank:</label>";
       echo"<input type='text' name = 'overall_rank' value='$overall_rank'><br>";
       echo"</td><td>";  
       echo"<label>goal1_rank:</label>";
       echo"<input type='text' name = 'goal1_rank' value='$goal1_rank'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>goal2_rank:</label>";
       echo"<input type='text' name = 'goal2_rank' value='$goal2_rank'><br>";
       echo"</td><td>";  
       echo"<label>goal3_rank:</label>";
       echo"<input type='text' name = 'goal3_rank' value='$goal3_rank'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>goal4_rank:</label>";
       echo"<input type='text' name = 'goal4_rank' value='$goal4_rank'>'<br>";
       echo"</td><td>";  
       echo"<label>goal5_rank:</label>";
       echo"<input type='text' name = 'goal5_rank' value='$goal5_rank'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>goal6_rank:</label>";
       echo"<input type='text' name = 'goal6_rank' value='$goal6_rank'><br>";
       echo"</td><td>";
       echo"<label>goal7_rank:</label>";
       echo"<input type='text' name = 'goal7_rank' value='$goal7_rank'><br>";
       echo"</td></tr><tr><td>";
       echo"<label>raw_responses:</label>";
       echo"<input type='text' name = 'raw_responses' value='$raw_responses'><br>";
       echo"</td></tr>";
       echo"</table>";
       echo"<br>";
      echo"<input type='submit' name = $TestNum id='$TestNum' value='Insert Test'>";
     echo"</form>";
     echo"<br>";
     echo"<br>";
     echo"<br>";
    /* 
     if (isset($_POST['UploadAll'])){
      $conn->query("INSERT INTO Hewitt_DB.test_results VALUES ($test_id, $subject, $account_id, $student_id, $group_id, 
      $group_qty, $source_id, $date_ordered, $date_printed, $date_taken, $date_scored, $status, 
      $grade, $level, $year_third, $raw_score, $rit_score,
      $percent_correct, $hewitt_percentile, $national_percentile, $overall_rank, $goal1_rank, $goal2_rank, $goal3_rank,
      $goal4_rank, $goal5_rank, $goal6_rank, $goal7_rank, $raw_responses);");
       
            
     }

     else{

            $TestNum++;

       }//end of else */

     } //end of line loop
   //  echo"<button onclick='uploadAll($TestNum)' class='button'>Upload All Tests</button>";
  
    }
    
  




  
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

 // $conn->close();
?>


    </div>
</body>


<script>
/*function uploadAll(numforms){
  var i = 1;
  document.getElementById(1).submit();
  document.getElementById(3).submit();
    document.getElementById(2).submit();
  
}*/
</script>

<footer>
    <div class="row">
        <div class="col">
            <p class="footer-text">Copyright Hewitt Learning, 2021
            </p>

        </div>
    </div>
</footer>