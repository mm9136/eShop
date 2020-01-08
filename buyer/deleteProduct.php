<?php
     require ("../config_and_connection.php");

	session_start();
	$sql_query=$conn->prepare("SELECT SUM(quantity) AS quantity FROM cart_item JOIN orders ON orders.order_id=cart_item.order_id JOIN buyer ON buyer.buyer_id=orders.buyer_id JOIN user ON buyer.user_id=user.user_id  JOIN status ON status.status_id=orders.status_id WHERE user.email=:email AND status.status_id=5 AND cart_item.product_id=:product_id AND orders.order_id=:order_id");
	$sql_query->bindParam(":email",$_SESSION['email']);
	$sql_query->bindParam(":product_id",$_POST['product_id']);
	$sql_query->bindParam(":order_id",$_SESSION['current_order_id']);
	try{
	    $result= $sql_query->execute();
	 }
	catch(PDOExeption $ex){
	    die("Query failed".$ex->detMessage());
	}
	$row=$sql_query->fetch();

	$sql_query=$conn->prepare("UPDATE stockItem SET quantity=(SELECT quantity from stockItem where product_id=:product_id_main ) + :quantity WHERE product_id=:product_id");
	$sql_query->bindParam(":product_id_main",$_POST['product_id']);
	$sql_query->bindParam(":quantity",$row['quantity']);
	$sql_query->bindParam(":product_id",$_POST['product_id']);
	try{
	    $result= $sql_query->execute();
	 }
	catch(PDOExeption $ex){
	    die("Query failed".$ex->detMessage());
	}

	$sql_query=$conn->prepare("DELETE FROM cart_item WHERE cart_item.product_id=:product_id AND cart_item.order_id=:order_id");
	$sql_query->bindParam(":product_id",$_POST['product_id']);
	$sql_query->bindParam(":order_id",$_SESSION['current_order_id']);
	try{
	    $result= $sql_query->execute();
	 }
	catch(PDOExeption $ex){
	    die("Query failed".$ex->detMessage());
	}
		
     


?>