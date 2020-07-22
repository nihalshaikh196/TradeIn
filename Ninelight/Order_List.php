<?php
 
session_start();
// Importing DBConfig.php file.
include 'DBConfig.php';
 

// Connecting to MySQL Database.
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 

 $json = file_get_contents('php://input');
 $obj = json_decode($json, true);

 $user_type = $obj['user_type'];
 
 
 $user = $_SESSION['user'];

$user_id = "select * from user_list where user_name='$user' or email_id='$user'";
$user_id_result = $con->query($user_id);
$user_id = $user_id_result->fetch_array();

 
 if ($user_type==2){

    $Sql_Query = "INSERT INTO orders (user_id,product_id,quantity,total_price) SELECT user_id,product_id,quantity,total_price FROM CART WHERE user_id= '$user_id[0]'" ;
 
    $Sql_Query2 = "DELETE FROM cart where user_id='$user_id[0]'";

 $Sql_Query3 ="UPDATE orders SET orders.order_status='Confirmed' WHERE user_id='$user_id[0]' AND orders.order_status='Pending'";


 if(mysqli_query($con,$Sql_Query) && mysqli_query($con,$Sql_Query2) && mysqli_query($con,$Sql_Query3)){
 
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

}

else{

    $Sql_Query = "INSERT INTO orders (user_id,product_id,quantity,total_price) SELECT user_id,product_id,quantity,total_price FROM CART WHERE user_id= '$user_id[0]'" ;
 
    $Sql_Query2 = "DELETE FROM cart where user_id='$user_id[0]'";
   
    if(mysqli_query($con,$Sql_Query) && mysqli_query($con,$Sql_Query2)){
    
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
   

}
 
 mysqli_close($con);
?>      