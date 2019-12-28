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
        	$sql_query=$conn->prepare("INSERT INTO USER (email,password,salt,firstname,lastname,active,role_id) VALUES (:email,:password,:salt,:firstname,:lastname,0, 3)");
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
    	if($_POST['role'] == "BUYER"){
        	$sql_query=$conn->prepare("INSERT INTO USER (email,password,salt,firstname,lastname,active,role_id) VALUES (:email,:password,:salt,:firstname,:lastname,0, 2)");
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
        		$sql_query = $conn->prepare("SELECT user.user_id FROM user where email=:email;");
				$sql_query->bindParam(":email",$_POST['email']);
            	$result= $sql_query->execute();
            	$row=$sql_query->fetch();
	        	$sql_query=$conn->prepare("INSERT INTO BUYER (adress,phone_number,user_id) VALUES (:adress,:phone_number,:user_id)");
	        	$sql_query->bindParam(":adress",$_POST['adress']);
	        	$sql_query->bindParam(":phone_number",$_POST['phone_number']);
		    	$sql_query->bindParam(":user_id",$row['user_id']);
            	$result= $sql_query->execute();
	        }
	         catch(PDOExeption $ex){
	            die("Query failed".$ex->detMessage());
	        }

	        echo '<script type="text/javascript"> alert("Account created"); window.location.href="index.php";</script>';
    	}
	}

?>



<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">
    <head> 
		 <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta charset="utf-8">
            <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">

            <!-- Website CSS style -->
            <link rel="stylesheet" type="text/css" href="assets/css/main.css">

            <!-- Website Font style -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
            
            <!-- Google Fonts -->
            <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
            <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

             <link rel="stylesheet" href="css/menu.css">

            <title>Gigatron</title>
	</head>
	<body>
		<?php include 'anonimousnavigation.php'; ?>
		<div class="container">
			
				<div class="main-login main-center">
					<form class="form-horizontal" method="post" action="#">
						
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="firstname" id="firstname"  placeholder="Enter your Firstname" required/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="lastname" id="lastname"  placeholder="Enter your Lastname" required/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="email" class="form-control" name="email" id="email"  placeholder="Enter your Email" required/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="adress" id="adress"  placeholder="Enter your Adress" required/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="phone_number" id="phone_number"  placeholder="Enter your Phonenumber" required/>
								</div>
							</div>
						</div>
						
						<div class="input-group flex-nowrap">
							<div class="input-group-prepand">
								<span class="input-group-text"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
							</div>
							<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password" required/>
						</div>

						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password" required/>
								</div>
							</div>
						</div>


						<div class="form-group">
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        
	</body>
</html>
