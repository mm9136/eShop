<?php
     require ("../config_and_connection.php");

	session_start();
		$sql_query=$conn->prepare("SELECT orders.order_id AS current_order FROM orders JOIN buyer ON buyer.buyer_id=orders.buyer_id JOIN user ON buyer.user_id=user.user_id  JOIN status ON status.status_id=orders.status_id WHERE user.email=:email AND status.status_id=5");
		$sql_query->bindParam(":email",$_SESSION['email']);
		try{
		    $result= $sql_query->execute();
		 }
		catch(PDOExeption $ex){
		    die("Query failed".$ex->detMessage());
		}
		$row=$sql_query->fetch();
		if(!$row){
			$sql_query=$conn->prepare("SELECT buyer.buyer_id AS current_buyer FROM  buyer JOIN user ON buyer.user_id=user.user_id  WHERE user.email=:email" );
			$sql_query->bindParam(":email",$_SESSION['email']);
			try{
		    $result= $sql_query->execute();
		     }
		    catch(PDOExeption $ex){
		        die("Query failed".$ex->detMessage());
		    }
			$row=$sql_query->fetch();

			$sql_query=$conn->prepare("INSERT INTO ORDERS (buyer_id,status_id,total) VALUES (:buyer_id,5,0)");
			$sql_query->bindParam(":buyer_id",$row['current_buyer']);
			
			try{
		        	$result= $sql_query->execute();
		     }
		     catch(PDOExeption $ex){
		            die("Query failed".$ex->detMessage());
		     }
		     $id=$conn->lastInsertId();
		     $_SESSION['current_order_id']=$id;

		}else{
			 $_SESSION['current_order_id']=$row['current_order'];
		}

     
	if(!empty($_POST)){
		$sql_query=$conn->prepare("UPDATE stockItem SET quantity =(SELECT quantity FROM stockItem WHERE product_id=:product_id)-1 where product_id=:product_id_main");
		$sql_query->bindParam(":product_id",$_POST['product_id']);
		$sql_query->bindParam(":product_id_main",$_POST['product_id']);
		try{
	    	$result= $sql_query->execute();
	     }
	    catch(PDOExeption $ex){
	        die("Query failed".$ex->detMessage());
	    }
	    $sql_query=$conn->prepare("INSERT INTO cart_item (order_id,product_id,quantity) VALUES (:order_id,:product_id,1)");
	    $sql_query->bindParam(":order_id",$_SESSION['current_order_id']);
	    $sql_query->bindParam(":product_id",$_POST['product_id']);
	    try{
	    	$result= $sql_query->execute();
	    	echo "success";
	     }
	    catch(PDOExeption $ex){
	        die("Query failed".$ex->detMessage());
	    }

	}
     
     


?>