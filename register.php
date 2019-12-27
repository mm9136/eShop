<?php 
	require ("config_and_connection.php");

	if(!empty($_POST)){
		$sql_query=$conn->prepare("SELECT * FROM user WHERE email=:email");
		$sql_query->bindParam(":email",$_POST['email']);
		try{
            	$result= $sql_query->execute();
        }
         catch(PDOExeption $ex){
            die("Query failed".$ex->detMessage());
        }
        $row=$sql_query->fetch();
        if($row){
        	die ("email already in use");
        }
        if($_POST['role'] == "SELLER"){
        	$sql_query=$conn->prepare("INSERT INTO USER (email,password,salt,firstname,lastname,active,role_id) VALUES (:email,:password,:salt,:firstname,:lastname,1, 3)");
        	$sql_query->bindParam(":email",$_POST['email']);
        	$sql_query->bindParam(":firstname",$_POST['firstname']);
        	$sql_query->bindParam(":lastname",$_POST['lastname']);
        	$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
			$password = hash('sha256', $_POST['password'] . $salt);
			for($round = 0; $round < 65536; $round++) { 
		        $password = hash('sha256', $password . $salt);
		    }

        	$sql_query->bindParam(":salt",$salt);
        	$sql_query->bindParam(":password",$password);

		    try{
            	$result= $sql_query->execute();
	        }
	         catch(PDOExeption $ex){
	            die("Query failed".$ex->detMessage());
	        }

	        echo '<script type="text/javascript"> alert("Account created"); window.location.href="index.php";</script>';
    	}
	}

?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

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

		<title>Admin</title>
	</head>
	<body>
		<div class="container">
			<div class="row main">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<h1 class="title">Welcome to eShop </h1>
	               		<hr />
	               	</div>
	            </div> 
				<div class="main-login main-center">
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
									<input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email" required/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="adress" class="cols-sm-2 control-label">Adress</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="adress" id="adress"  placeholder="Enter your Adress" required/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="phonenumber" class="cols-sm-2 control-label">Phone number</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="phonenumber" id="phonenumber"  placeholder="Enter your Phonenumber" required/>
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


						<div class="form-group">
							<label for="role" class="cols-sm-2 control-label">Role</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<select name="role" id="role" class="form-control" required> 
										<option value="BUYER"> BUYER</option>
										<option value="SELLER"> SELLER</option>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group ">
							<button type="submit" class="btn btn-primary btn-lg btn-block login-button">Register</button>
						</div>
						<div class="login-register">
				            <a href="index.php">Login</a>
				         </div>
					</form>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	</body>
</html>
