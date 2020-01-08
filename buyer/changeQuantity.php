<?php
     require ("../config_and_connection.php");

	session_start();
	$qty=$_POST['previous'] - $_POST['quantity'];
	echo $qty;
	$sql_query=$conn->prepare("UPDATE stockItem SET quantity=(SELECT quantity from stockItem where product_id=:product_id_main ) + :quantity WHERE product_id=:product_id");
	$sql_query->bindParam(":product_id_main",$_POST['product_id']);
	$sql_query->bindParam(":quantity",$qty);
	$sql_query->bindParam(":product_id",$_POST['product_id']);
	try{
	    $result= $sql_query->execute();
	 }
	catch(PDOExeption $ex){
	    die("Query failed".$ex->detMessage());
	}

	$sql_query=$conn->prepare("UPDATE cart_Item SET quantity= :quantity WHERE product_id=:product_id AND order_id=:order_id");
	$sql_query->bindParam(":quantity",$_POST['quantity']);
	$sql_query->bindParam(":product_id",$_POST['product_id']);
	$sql_query->bindParam(":order_id",$_SESSION['current_order_id']);
	try{
	    $result= $sql_query->execute();
	 }
	catch(PDOExeption $ex){
	    die("Query failed".$ex->detMessage());
	}
     


?>