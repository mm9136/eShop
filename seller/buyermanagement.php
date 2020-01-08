<?php 

session_start();
if(empty($_SESSION['email']) || empty($_SESSION['role']) || $_SESSION['role'] !== "SELLER" ){
	header("Location:../login.php");
	
}else{
	require ("../config_and_connection.php");
	
    if(!empty($_POST)){
    	if($_POST['active']==1){
			$sql_query=$conn->prepare("UPDATE user SET active=0 WHERE user_id=:user_id");
	 	}else{
	 		$sql_query=$conn->prepare("UPDATE user SET active=1 WHERE user_id=:user_id");
	 	}
	 	$sql_query->bindParam(":user_id",$_POST['user_id']);

    	try{
	        $result= $sql_query->execute();
	     }
	    catch(PDOExeption $ex){
	        die("Query failed".$ex->detMessage());
	    }
    	
    }
	$sql_query=$conn->prepare("SELECT * FROM user JOIN buyer ON user.user_id=buyer.user_id WHERE role_id=2");
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
		      <li class="nav-item active">
		        <a class="nav-link" href="buyermanagement.php">Buyer management</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="editProfile.php">Edit Profile</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="productmanagement.php">Product administration</a>
		      </li>
		      <li class="nav-item ">
		        <a class="nav-link" href="../logout.php">Log out</a>
		      </li>
		    </ul>
		  </div>
		</nav>
		<div id="buyers-table" >
			<table class="table table-striped" >
				<thead class="thead-dark">
					<tr>
						<th>Id</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Email</th>
						<th>Address</th>
						<th>Phone number</th>
						<th>Active</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($rows as $row): ?>
				        <tr>
				            <td><?php echo $row['user_id']; ?></td>
				            <td><?php echo htmlentities($row['firstname'], ENT_QUOTES, 'UTF-8'); ?></td>
				            <td><?php echo htmlentities($row['lastname'], ENT_QUOTES, 'UTF-8'); ?></td>
				            <td><?php echo htmlentities($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
				            <td><?php echo htmlentities($row['adress'], ENT_QUOTES, 'UTF-8'); ?></td>
				            <td><?php echo htmlentities($row['phone_number'], ENT_QUOTES, 'UTF-8'); ?></td>
				            <td><?php echo htmlentities($row['active']==1 ? "Active":"Inactive", ENT_QUOTES, 'UTF-8'); ?></td>
				            <td>
				            	<form method='post' action='#' > 
				            		<input type='hidden' name='user_id' value="<?php echo htmlentities ($row['user_id'], ENT_QUOTES, 'UTF-8'); ?>"></input>
				            		<input type='hidden' name='active' value="<?php echo htmlentities ($row['active'], ENT_QUOTES, 'UTF-8'); ?>"></input>
				            		<button type="submit" class="btn btn-primary btn-xs btn-block">Change status</button>
				            	</form>
				            </td>
				        </tr> 
				    <?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>