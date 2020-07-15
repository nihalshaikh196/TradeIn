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

$distributor_id=$obj['distributor_id'];

$user = $_SESSION['user'] ; 


$find_adder_id = "select * from user_list where user_name='$user' or email_id='$user'";
$adder_id_result = $conn->query($find_adder_id);
$row_adder_id = $adder_id_result->fetch_array();


$sql="SELECT sum(orders.total_price)as total,sum(orders.quantity) as quantity,product.product_name FROM product,orders INNER JOIN user_list ON (orders.user_id=user_list.user_id) 
where( user_list.adder_id='$distributor_id' OR orders.user_id='$distributor_id')AND orders.order_status='Accepted' AND product.product_id=orders.product_id GROUP BY orders.product_id";


 

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