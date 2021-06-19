<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <!-- connect to your database here to hide credentials -->
 
 <?php
 /*
 $myServer = "hewitt-db.database.windows.net";
 $myUser = "whitworth_db_login";
 $myPass = "r3fUndkiNgaCIev3|dea";
 $myDB = "HRFDevelopment";
 
 $conn = new mssql_connect($myServer, $myUser, $myPass)
   or die("Couldn't connect to SQL Server on $myServer");
 
    //$host = 'movie.ck2zyecwrmg1.us-east-1.rds.amazonaws.com';
    $host = 'hewitt-db.database.windows.net';
    //$user = 'movie';
    $user = 'whitworth_db_login';
   // $pass = 'PeteTucker-72';
   $pass = 'r3fUndkiNgaCIev3|dea';
    $db_name = 'Hewitt_DB';
    

    
    $conn = new mysqli($host, $user, $pass, $db_name);
    if($conn->connect_error){
        die('Connect error: ' . $conn->connect_error);  
    }else 
*/
    $serverName = "hewitt-db.database.windows.net"; 
$uid = "whitworth_db_login";   
$pwd = "r3fUndkiNgaCIev3|dea";  
$databaseName = "HRFDevelopment"; 

$connectionInfo = array("Database"=>$databaseName, "UID"=>$uid,                            
"PWD"=>$pwd); 

/* Connect using SQL Server Authentication. */  
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
   // echo "connection established. <br />";
}else{
    echo "Database connection could not be established. <br />";
    die( print_r( sqlsrv_errors(), true));
}
?>
 

 </body>
</html>