<?php
 
session_start();
// Importing DBConfig.php file.
include 'DBConfig.php';
 

// Connecting to MySQL Database.
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 
 // Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
 
 $user = $_SESSION['user'];

$user_id = "select * from user_list where user_name='$user' or email_id='$user'";
$user_id_result = $con->query($user_id);
$user_id = $user_id_result->fetch_array();

 
 // Creating SQL query and Updating the current record into MySQL database table.
 $Sql_Query = "INSERT INTO orders (user_id,product_id,quantity,total_price) SELECT user_id,product_id,quantity,total_price FROM CART WHERE user_id= '$user_id[0]'" ;
 
 $Sql_Query = "DELETE FROM cart where user_id='$user_id[0]'";

 if(mysqli_query($con,$Sql_Query)){
 
 // If the record inserted successfully then show the message.
$MSG = 'Ordered Successfully' ;
 
// Converting the message into JSON format.
$json = json_encode($MSG);
 
// Echo the message.
 echo $json ;
 
 }
 else{
 
 echo 'Try Again';
 
 }
 mysqli_close($con);
?>      