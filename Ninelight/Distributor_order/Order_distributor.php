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
 
 $shopkeeper_id=$obj['shopkeeper_id'];

 $type_id=$obj['type_id'];
 $user = $_SESSION['user'];

$user_id = "select * from user_list where user_name='$user' or email_id='$user'";
$user_id_result = $con->query($user_id);
$user_id = $user_id_result->fetch_array();

 
 // Creating SQL query and Updating the current record into MySQL database table.
 if($type_id==1){
 $Sql_Query = "UPDATE orders SET order_status='Confirmed' WHERE order_status='Pending' AND user_id='$shopkeeper_id' " ;
 }
 else if($type_id==2){
    $Sql_Query = "UPDATE orders SET order_status='Delivered' WHERE order_status='Accepted' AND user_id='$shopkeeper_id' " ;
 }


 if(mysqli_query($con,$Sql_Query)){
 
 // If the record inserted successfully then show the message.
 if($type_id==1){
$MSG = 'Ordered Successfully Confirmed' ;
 }
 if($type_id==2){
    $MSG = 'Ordered Successfully Delivered';
 }
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