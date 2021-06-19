<?php
/*this makes a separate connection to the database in order to make sure the session persists */
$connection = mysqli_connect("server", "name", "pwd", "db");

session_start();

$user_check = $_SESSION['login_user'];

$query = "SELECT Email from CustomerLogin where Email = '$user_check'";
$ses_sql = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($ses_sql);
$login_session = $row['Email'];

?>