<?php

session_start();

include 'DBConfig.php';

// Create connection
$conn = new mysqli($HostName, $HostUser, $HostPass, $DatabaseName);

if ($conn->connect_error) {
 
 die("Connection failed: " . $conn->connect_error);
} 

$json = file_get_contents('php://input');

$obj = json_decode($json,true);

$type_id=$obj['type_id'];


$user = $_SESSION['user'];
    
$find_adder_id = "select * from user_list where user_name='$user' or email_id='$user'";
$adder_id_result = $conn->query($find_adder_id);
$row_adder_id = $adder_id_result->fetch_array();


if($type_id==1){
$sql="SELECT product.product_name,orders.product_id,sum(orders.total_price) as total_price,sum(orders.quantity) as quantity FROM orders,product where 
orders.user_id='$row_adder_id[0]' AND orders.product_id=product.product_id AND (orders.order_status='Confirmed') GROUP BY orders.product_id";
}

else if($type_id==2){
$sql="SELECT product.product_name,orders.product_id,sum(orders.total_price) as total_price,sum(orders.quantity) as quantity FROM orders,product where 
orders.user_id='$row_adder_id[0]' AND orders.product_id=product.product_id AND (orders.order_status='Accepted') GROUP BY orders.product_id";   
}


$result = $conn->query($sql);

if ($result->num_rows>0) {
 
 
 while($row[] = $result->fetch_assoc()) {
 
 $item = $row;
 	
 $json = json_encode($item);

 }


 
} else {

    $item = 'NO';
 	
    $json = json_encode($item);
}
 echo $json;
$conn->close();
?>