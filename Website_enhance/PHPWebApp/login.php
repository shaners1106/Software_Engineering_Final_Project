<?php
//If in the future you want to implement a public login feature, this will get you there.
//This is a rough skeleton of what a login page may look and function as.
include 'connect.php';
session_start();
$error = '';


if (isset($_POST['submit'])){
    //Requires both email and password to be set in order to login
    if (empty($_POST['Email']) || empty($_POST['Password'])){
        $error = "User email or password is invalid";
    }
    else
    {
        $cust_id = 0;
        $username = $_POST['Email'];
        $password = $_POST['Password'];

        

        $query = "SELECT CustomerID, Email, Password FROM CustomerLogin WHERE Email=? AND Password=? LIMIT 1";
        //Runs the query, and securely stores the information where desired
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->bind_result($cust_id, $username, $password);
        $stmt->store_result();

        if($stmt->fetch()){
            //Information is stored as session variables for later access and authentication, and cart is initialized
            $_SESSION['login_user'] = $username;
            $_SESSION['CustomerID']= $cust_id;
            $_SESSION['Cart'] = array();
            echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
        }
        else{
            $error = "Username of Password invalid";
        }
        mysqli_close($conn);
    }
}
?>