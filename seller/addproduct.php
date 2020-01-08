<?php 

session_start();
if(empty($_SESSION['email']) || empty($_SESSION['role']) || $_SESSION['role'] !== "SELLER" ){
	header("Location:../login.php");
	
}else{
	require ("../config_and_connection.php");
	$sql_query=$conn->prepare("SELECT * FROM stock");
	try{
        $result= $sql_query->execute();
     }
    catch(PDOExeption $ex){
        die("Query failed".$ex->detMessage());
    }
    $rows=$sql_query->fetchAll();


    if(!empty($_POST)){
    	$sql_query=$conn->prepare("INSERT INTO product (name,price,description,active) VALUES (:name,:price,:description,1)");
    	$sql_query->bindParam(":name",$_POST['name']);
    	$sql_query->bindParam(":price",$_POST['price']);
    	$sql_query->bindParam(":description",$_POST['description']);
    	
	    try{
        	$result= $sql_query->execute();
        	$id=$conn->lastInsertId();
        	$sql_query=$conn->prepare("INSERT INTO stockitem (product_id,stock_id,quantity) VALUES (:product_id,:stock_id,:quantity)");
	        $sql_query->bindParam(":product_id",$id);
	    	$sql_query->bindParam(":stock_id",$_POST['stock_id']);
	    	$sql_query->bindParam(":quantity",$_POST['quantity']);
	    	$result= $sql_query->execute();
	    	// Count # of uploaded files in array
			$total = count($_FILES['file']['name']);

			// Loop through each file
			for( $i=0 ; $i < $total ; $i++ ) {

			  //Get the temp file path
			  $tmpFilePath = $_FILES['file']['tmp_name'][$i];

			  //Make sure we have a file path
			  if ($tmpFilePath != ""){
				if(!file_exists("../images/".$id)){
				  	mkdir("../images/".$id,0700);

			  	}
			    //Setup our new file path
			    $newFilePath = "../images/" .$id."/img".$i.'.png';

			    //Upload the file into the temp dir
			    if(move_uploaded_file($tmpFilePath, $newFilePath)) {

			      
			    }
			  }
		}
	    	echo '<script type="text/javascript"> alert("Product created"); window.location.href="productmanagement.php";</script>';
        }
         catch(PDOExeption $ex){
            die("Query failed".$ex->detMessage());
        }
       
    }
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
		<title>Seller</title>
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
		      <li class="nav-item">
		        <a class="nav-link" href="buyermanagement.php">Buyer management</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="editProfile.php">Edit Profile</a>
		      </li>
		      <li class="nav-item active">
		        <a class="nav-link" href="productmanagement.php">Product administration</a>
		      </li>
		      <li class="nav-item ">
		        <a class="nav-link" href="../logout.php">Log out</a>
		      </li>
		    </ul>
		  </div>
		</nav>
		<div class="container">
			<div class="main-login main-center">
				<form id="add-product-form" class="form-horizontal" method="post" action="#" enctype="multipart/form-data">
						<div class="input-group flex-nowrap">
							<div class="input-group-prepand">
								<span class="input-group-text"><i class="fas fa-user fa" aria-hidden="true"></i></span>
							</div>
							<input type="text" class="form-control" name="name" id="name"  placeholder="Enter product name" required/>
						</div>
						
						
						<div class="input-group flex-nowrap">
							<div class="input-group-prepand">
								<span class="input-group-text"><i class="fas fa-dollar fa" aria-hidden="true"></i></span>
							</div>
							<input type="text" class="form-control" name="price" id="price"  placeholder="Enter product price" required/>
						</div>

						
						<div class="input-group flex-nowrap">
							<div class="input-group-prepand">
								<span class="input-group-text"><i class="fas fa-file fa" aria-hidden="true"></i></span>
							</div>
							<textarea class="form-control" name="description" id="description"  placeholder="Enter product description" required></textarea>
						</div>
						
					
						<div class="input-group flex-nowrap">
							<div class="input-group-prepand">
								<span class="input-group-text"><i class="fas fa-list-ol fa" aria-hidden="true"></i></span>
							</div>
							<input type="text" class="form-control" name="quantity" id="quantity"  placeholder="Enter product quantity" required/>
						</div>
						<div class="input-group flex-nowrap">
								<div class="input-group-prepand">
									<span class="input-group-text"><i class="fas fa-mouse-pointer fa" aria-hidden="true"></i></span>
								</div>
								<select name="stock_id" id="stock_id" class="form-control" required> 
									<option value="" disabled selected> Choose stock:</option>
									<?php foreach($rows as $row): ?>
							       	 	<option value="<?php echo htmlentities($row['stock_id'], ENT_QUOTES, 'UTF-8'); ?>"> <?php echo htmlentities($row['name'], ENT_QUOTES, 'UTF-8'); ?></option>
							        <?php endforeach; ?>
								</select>
						</div>
						<input type="file" name="file[]" multiple="multiple" /> 
						
						<div class="form-group ">
							<button type="submit" class="btn btn-primary btn-block login-button">ADD</button>
						</div>
					</form>
				</div>
			</div>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>