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
 
 $distributor_id=$obj['distributor_id'];

 $user = $_SESSION['user'];

$user_id = "select * from user_list where user_name='$user' or email_id='$user'";
$user_id_result = $con->query($user_id);
$user_id = $user_id_result->fetch_array();


 // Creating SQL query and Updating the current record into MySQL database table.
    $Sql_Query = "UPDATE orders INNER JOIN user_list ON (orders.user_id=user_list.user_id) SET orders.order_status='Accepted'
    where (user_list.adder_id='$distributor_id' OR orders.user_id='$distributor_id') AND orders.order_status='Confirmed' " ;

    
 if(mysqli_query($con,$Sql_Query)){
 
 // If the record inserted successfully then show the message.
$MSG = 'Ordered Successfully Accepted' ;
 
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