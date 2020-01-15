<?php
     require ("../config_and_connection.php");

	session_start();
	$qty=$_POST['previous'] - $_POST['quantity'];
        
	$get_quantity= $conn->prepare("SELECT quantity from stockitem where product_id=:product_id_main ");
        $get_quantity->bindParam(":product_id_main",$_POST['product_id']);
        try{
	    $result= $get_quantity->execute();
	 }
	catch(PDOExeption $ex){
	    die("Query failed".$ex->detMessage());
	}
        $row1=$get_quantity->fetch();
        
	$sql_query=$conn->prepare("UPDATE stockitem SET quantity=:q WHERE product_id=:product_id");
	$q=$row1['quantity'] + $qty;
	$sql_query->bindParam(":q",$q);
	$sql_query->bindParam(":product_id",$_POST['product_id']);
	try{
	    $result= $sql_query->execute();
	 }
	catch(PDOExeption $ex){
	    die("Query failed".$ex->detMessage());
	}

	$sql_query=$conn->prepare("UPDATE cart_item SET quantity= :quantity WHERE product_id=:product_id AND order_id=:order_id");
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