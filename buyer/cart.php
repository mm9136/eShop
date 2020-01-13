<?php 

session_start();
if(empty($_SESSION['email']) || empty($_SESSION['role']) || $_SESSION['role'] !== "BUYER" ){
	header("Location:../login.php");
	
}else{
	require ("../config_and_connection.php");
	

	$sql_query=$conn->prepare("SELECT product.name,product.product_id,product.price,product.description,SUM(cart_item.quantity) AS quantity ,"
                . " (stockitem.quantity + SUM(cart_item.quantity)) AS stock_quantity FROM cart_item JOIN orders ON orders.order_id=cart_item.order_id "
                . "JOIN buyer ON buyer.buyer_id = orders.buyer_id JOIN user ON user.user_id=buyer.user_id JOIN product ON product.product_id=cart_item.product_id "
                . "JOIN stockitem ON product.product_id=stockitem.product_id WHERE orders.status_id=5 AND user.email=:email "
                . "GROUP BY product.name,product.product_id,product.price,product.description,stockitem.quantity");
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
		      <li class="nav-item active">
		        <a class="nav-link" href="cart.php">Cart</a>
		      </li>
		      <li class="nav-item ">
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
		                Shipping cart
		                <a href="home.php" class="btn btn-outline-info btn-sm pull-right">Continue shopping</a>
		                <div class="clearfix"></div>
		            </div>
		            <div class="card-body">
		                    <!-- PRODUCT -->
		                    <?php foreach($rows as $row): ?>
			                    <div class="row">
			                        <div class="col-12 col-sm-12 col-md-2 text-center">
			                                <img class="img-responsive" src="http://localhost/eShop/images/<?php echo htmlentities($row['product_id'], ENT_QUOTES, 'UTF-8'); ?>/img0.png" alt="prewiew" width="120" height="80">
			                        </div>
			                        <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
			                            <h4 class="product-name"><strong><?php echo htmlentities($row['name'], ENT_QUOTES, 'UTF-8'); ?></strong></h4>
			                            <h4>
			                                <small><?php echo htmlentities($row['description'], ENT_QUOTES, 'UTF-8'); ?></small>
			                            </h4>
			                        </div>
			                        <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
			                            <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
			                                <h6><strong>EUR <?php echo htmlentities($row['price'], ENT_QUOTES, 'UTF-8'); ?><span class="text-muted"> x</span></strong></h6>
			                            </div>
			                            <div class="col-4 col-sm-4 col-md-4">
			                                <div class="quantity">
                                     		<input type="number" step="1" max="<?php echo htmlentities ($row['stock_quantity'], ENT_QUOTES, 'UTF-8'); ?>" min="1" value="<?php echo htmlentities ($row['quantity'], ENT_QUOTES, 'UTF-8'); ?>" title="Qty" class="qty" data-id="<?php echo htmlentities ($row['product_id'], ENT_QUOTES, 'UTF-8'); ?>"
			                                           size="4">
			                                    
			                                </div>
			                            </div>
			                            <div class="col-2 col-sm-2 col-md-2 text-right">
			                                <button type="button" class="delete_product btn btn-outline-danger btn-xs" data-id="<?php echo htmlentities ($row['product_id'], ENT_QUOTES, 'UTF-8'); ?>">
			                                    <i class="fa fa-trash" aria-hidden="true"></i>
			                                </button>
			                            </div>
			                        </div>
			                    </div>
			                    <hr>

				   			 <?php endforeach; ?>
		                    <!-- END PRODUCT -->
		                   
		               
		            </div>
		            <div class="card-footer">
		              
		                <div class="pull-right" style="margin: 10px">
		                    <a href="checkOutPage.php" class="btn btn-success pull-right">Checkout</a>
		                    
		                </div>
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