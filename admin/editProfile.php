<?php 
$success=0;
session_start();
if(empty($_SESSION['email']) || empty($_SESSION['role']) || $_SESSION['role'] !== "ADMIN" ){
	header("Location:../login.php");
	
}else{
	if(!empty($_POST)){
		require ("../config_and_connection.php");
		
		$sql_query=$conn->prepare("UPDATE user SET firstname=:firstname, lastname=:lastname,password=:password,salt=:salt WHERE email=:email AND role_id=1");
		$sql_query->bindParam(":firstname",$_POST['firstname']);
    	$sql_query->bindParam(":lastname",$_POST['lastname']);
    	$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
		$password = hash('sha256', $_POST['password'] . $salt);
		for($round = 0; $round < 65536; $round++) { 
	        $password = hash('sha256', $password . $salt);
	    }

    	$sql_query->bindParam(":salt",$salt);
    	$sql_query->bindParam(":password",$password);
    	$sql_query->bindParam(":email",$_SESSION['email']);
		
	    try{
        	$result= $sql_query->execute();
        	$success=1;
        }
         catch(PDOExeption $ex){
            die("Query failed".$ex->detMessage());
			$success=2;
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
		<title>Admin</title>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <a class="navbar-brand" href="home.php">LOGO</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNavDropdown">
		    <ul class="navbar-nav">
		      <li class="nav-item">
		        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="sellermanagement.php">Seller management</a>
		      </li>
		      <li class="nav-item active">
		        <a class="nav-link" href="editProfile.php">Edit Profile</a>
		      </li>
		      <li class="nav-item active">
		        <a class="nav-link" href="../logout.php">Log out</a>
		      </li>
		    </ul>
		  </div>
		</nav>

		<?php
			if($success==1){
				echo '<div class="alert alert-primary" role="alert"> You profile was successfully updated! </div>' ;

			} 
			else if($success==2){
				echo ' <div class="alert alert-danger" role="alert"> Error! Try again !</div>' ;

			}
		?>
		<form class="form-horizontal" method="post" action="#">
						
						<div class="form-group">
							<label for="firstname" class="cols-sm-2 control-label">Firstname</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="firstname" id="firstname"  placeholder="Enter your Firstname" required/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="lastname" class="cols-sm-2 control-label">Lastname</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="lastname" id="lastname"  placeholder="Enter your Lastname" required/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="email" class="form-control" value="<?php echo htmlentities($_SESSION['email'], ENT_QUOTES, 'UTF-8'); ?>" name="email" id="email"  placeholder="Enter your Email" required disabled/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password" required/>
								</div>
							</div>
						</div>

						<div class="form-group ">
							<button type="submit" class="btn btn-primary btn-lg btn-block login-button">Save</button>
						</div>
					</form>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script src="../js/validation.js"></script>
	</body>
</html>