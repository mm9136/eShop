<?php
     require ("../config_and_connection.php");

		session_start();
		$sql_query=$conn->prepare("SELECT orders.order_id AS current_order FROM orders "
                        . "JOIN buyer ON buyer.buyer_id=orders.buyer_id "
                        . "JOIN user ON buyer.user_id=user.user_id  "
                        . "JOIN status ON status.status_id=orders.status_id WHERE user.email=:email AND orders.status_id=5");
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
			$sql_query=$conn->prepare("INSERT INTO orders (buyer_id,status_id,total) VALUES (:buyer_id,5,0)");
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
		$get_quantity=$conn->prepare("SELECT quantity FROM stockitem WHERE product_id=:product_id ");
        $get_quantity->bindParam(":product_id",$_POST['product_id']);
		
		try{
		    $result= $get_quantity->execute();
		 }
		catch(PDOExeption $ex){
		    die("Query failed".$ex->detMessage());
		}
		
		$row1=$get_quantity->fetch();

		$sql_query=$conn->prepare("UPDATE stockitem SET quantity =:q where product_id=:product_id_main");
        $q=$row1['quantity'] -1;
		$sql_query->bindParam("q",$q);
		$sql_query->bindParam(":product_id_main",$_POST['product_id']);
		try{
	    	$result= $sql_query->execute();
	     }
	    catch(PDOExeption $ex){
	        die("Query failed".$ex->detMessage());
	    }


	    $sql_query=$conn->prepare("SELECT * FROM  cart_item  WHERE order_id=:order_id AND product_id=:product_id" );
	    $sql_query->bindParam(":order_id",$_SESSION['current_order_id']);
	    $sql_query->bindParam(":product_id",$_POST['product_id']);
	    try{
			$result= $sql_query->execute();
		}
		catch(PDOExeption $ex){
			die("Query failed".$ex->detMessage());
		}
		$row=$sql_query->fetch();
		if(!$row){

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
		}else{
			$get_quantity=$conn->prepare("SELECT quantity FROM cart_item WHERE order_id=:order_id AND product_id=:product_id ");
			$get_quantity->bindParam(":order_id",$_SESSION['current_order_id']);
		    $get_quantity->bindParam(":product_id",$_POST['product_id']);
			try{
				$result= $get_quantity->execute();
			 }
			catch(PDOExeption $ex){
				die("Query failed".$ex->detMessage());
			}
			
			$row1=$get_quantity->fetch();
		
			$sql_query=$conn->prepare("UPDATE cart_item SET quantity =:q WHERE order_id=:order_idmain AND product_id=:product_idmain");	    
			$q=$row1['quantity'] + 1;
		    $sql_query->bindParam(":q",$q);
		    $sql_query->bindParam(":order_idmain",$_SESSION['current_order_id']);
		    $sql_query->bindParam(":product_idmain",$_POST['product_id']);
		    try{
		    	$result= $sql_query->execute();
		    	echo "success";
		     }
		    catch(PDOExeption $ex){
		        die("Query failed".$ex->detMessage());
		     }
		}

	}

?>