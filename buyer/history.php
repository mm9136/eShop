<?php 

session_start();
if(empty($_SESSION['email']) || empty($_SESSION['role']) || $_SESSION['role'] !== "BUYER" ){
	header("Location:../login.php");
	
}else{
	require ("../config_and_connection.php");
	

	$sql_query=$conn->prepare("SELECT * FROM orders JOIN buyer ON orders.buyer_id=buyer.buyer_id JOIN user ON user.user_id=buyer.user_id WHERE user.email=:email AND orders.status_id IN (1,3,4)");
	$sql_query->bindParam(":email",$_SESSION['email']);

	try{
        $result= $sql_query->execute();
     }
    catch(PDOExeption $ex){
        die("Query failed".$ex->detMessage());
    }
    $rows=$sql_query->fetchAll();

}
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">

		<!-- Website CSS style -->
		<link rel="stylesheet" type="text/css" href="assets/css/main.css">

		<!-- Website Font style -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		
		<!-- Google Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="../css/menu.css">
		<title>Buyer</title>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <a class="navbar-brand" href="home.php"><img src="../images/logo.png" alt ="Logo" id="logo"/></a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNavDropdown">
		    <ul class="navbar-nav">
		      <li class="nav-item ">
		        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item ">
		        <a class="nav-link" href="cart.php">Cart</a>
		      </li>
		      <li class="nav-item active">
		        <a class="nav-link" href="history.php">History</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="editProfile.php">Edit Profile</a>
		      </li>
		      <li class="nav-item ">
		        <a class="nav-link" href="../logout.php">Log out</a>
		      </li>
		    </ul>
		  </div>
		</nav>
		
		<div class="container">
		   <div class="card shopping-cart">
		            <div class="card-header bg-dark text-light">
		                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
		                 History
		                <div class="clearfix"></div>
		            </div>
		            <div class="card-body">
		            	 <?php foreach($rows as $row): ?>
		            	 	  <div class="row">
			                        <div class="col-2 col-sm-2 col-md-2 text-center">
			                               <h4 class="product-name"><strong>Order no. <?php echo htmlentities($row['order_id'], ENT_QUOTES, 'UTF-8'); ?></strong></h4>
			                        </div>
			                        <div class="col-8 text-sm-center col-sm-8 text-md-left col-md-8">
			                            <h4 class="product-name"><strong><?php echo htmlentities($row['date'], ENT_QUOTES, 'UTF-8'); ?></strong></h4>


			                            	 <?php 

												$sql_query=$conn->prepare("SELECT product.name,product.product_id,product.price,product.description,SUM(cart_Item.quantity) AS quantity , (stockItem.quantity + SUM(cart_Item.quantity)) AS stock_quantity FROM cart_Item JOIN orders ON orders.order_id=cart_Item.order_id JOIN buyer ON buyer.buyer_id = orders.buyer_id JOIN user ON  user.user_id=buyer.user_id JOIN product ON product.product_id=cart_Item.product_id JOIN stockItem ON product.product_id=stockItem.product_id  WHERE orders.order_id=:order_id AND user.email=:email  GROUP BY product.product_id");
												$sql_query->bindParam(":email",$_SESSION['email']);

												$sql_query->bindParam(":order_id",$row['order_id']);
												try{
											        $result= $sql_query->execute();
											     }
											    catch(PDOExeption $ex){
											        die("Query failed".$ex->detMessage());
											    }
											    $rProducts=$sql_query->fetchAll();

			                            	 foreach($rProducts as $rProduct): ?>
							                    <div class="row">
							                       
							                        <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
							                            <h4 class="product-name"><strong><?php echo htmlentities($rProduct['name'], ENT_QUOTES, 'UTF-8'); ?></strong></h4>
							                           
							                        </div>
							                        <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
							                            <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
							                                <h6><strong>EUR <?php echo htmlentities($rProduct['price'], ENT_QUOTES, 'UTF-8'); ?><span class="text-muted"> x</span></strong></h6>
							                            </div>
							                            <div class="col-4 col-sm-4 col-md-4">
							                                <div class="quantity">
				                                     		<input type="number" step="1" max="<?php echo htmlentities ($rProduct['stock_quantity'], ENT_QUOTES, 'UTF-8'); ?>" min="1" value="<?php echo htmlentities ($rProduct['quantity'], ENT_QUOTES, 'UTF-8'); ?>" title="Qty" class="qty" data-id="<?php echo htmlentities ($rProduct['product_id'], ENT_QUOTES, 'UTF-8'); ?>"
							                                           size="4" disabled>
							                                    
							                                </div>
							                            </div>
							                           
							                        </div>
							                    </div>
							                    <hr>

								   			 <?php endforeach; ?>

			                            
			                        </div>
			                        <div class="col-2 text-sm-center col-sm-2 text-md-left col-md-2">
			                            <h4 class="product-name">EUR <strong><?php echo htmlentities($row['total'], ENT_QUOTES, 'UTF-8'); ?></strong></h4>
			                            
			                        </div>
 								</div>
		            	 <?php endforeach; ?>
		                   
		               
		            </div>
		            
		        </div>
		</div>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="../js/addToCart.js"></script>
	</body>
</html>