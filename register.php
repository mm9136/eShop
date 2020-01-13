<?php 
	require ("config_and_connection.php");
	$success=0;
	if(!empty($_POST)){

        if($_POST['role'] == "SELLER"){
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
	        	$success=1;  	
	        }else{
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
    	}
    	if($_POST['role'] == "BUYER"){
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
	        	$success=1;  	
	        }else{
	        	$sql_query=$conn->prepare("INSERT INTO user(email,password,salt,firstname,lastname,active,role_id) VALUES (:email,:password,:salt,:firstname,:lastname,0, 2)");
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
		        	$sql_query=$conn->prepare("INSERT INTO buyer (adress,phone_number,user_id) VALUES (:adress,:phone_number,:user_id)");
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
	}

?>



<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">
    <head> 
		 <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta charset="utf-8">
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
		<?php include 'anonimousnavigation.php'; 

	          if($success==1){
	                echo '<div class="alert alert-warning" role="alert"> Email already in use! </div>' ;
	          } 
            ?>
		<div class="container">
			
				<div class="main-login main-center">
					<form id="register-form" class="form-horizontal" method="post" action="#">
						
						<div class="input-group flex-nowrap">
								<div class="input-group-prepand">
									<span class="input-group-text"><i class="fas fa-mouse-pointer fa" aria-hidden="true"></i></span>
								</div>
								<select name="role" id="role" class="form-control" required> 
									<option value="" disabled selected> Register as:</option>
									<option value="BUYER"> BUYER</option>
									<option value="SELLER"> SELLER</option>
								</select>
						</div>

						<div class="input-group flex-nowrap">
							<div class="input-group-prepand">
								<span class="input-group-text"><i class="fas fa-user fa" aria-hidden="true"></i></span>
							</div>
							<input type="text" class="form-control" name="firstname" id="firstname"  placeholder="Enter your Firstname" required/>
						</div>
						
						
						<div class="input-group flex-nowrap">
							<div class="input-group-prepand">
								<span class="input-group-text"><i class="fas fa-user fa" aria-hidden="true"></i></span>
							</div>
							<input type="text" class="form-control" name="lastname" id="lastname"  placeholder="Enter your Lastname" required/>
						</div>

						<div class="input-group flex-nowrap">
							<div class="input-group-prepand">
								<span class="input-group-text"><i class="fas fa-at fa" aria-hidden="true"></i></span>
							</div>
							<input type="email" class="form-control" name="email" id="email"  placeholder="Enter your Email" required/>
						</div>
						
						<div id="address_block" class="input-group flex-nowrap">
							<div class="input-group-prepand">
								<span class="input-group-text"><i class="fas fa-map-marker fa" aria-hidden="true"></i></span>
							</div>
							<input type="text" class="form-control" name="adress" id="adress"  placeholder="Enter your Adress"/>
						</div>

						<div id="phone_number_block" class="input-group flex-nowrap">
							<div class="input-group-prepand">
								<span class="input-group-text"><i class="fas fa-phone fa " aria-hidden="true"></i></span>
							</div>
							<input type="text" class="form-control" name="phone_number" id="phone_number"  placeholder="Enter your Phonenumber"/>
						</div>

						<div class="input-group flex-nowrap">
							<div class="input-group-prepand">
								<span class="input-group-text"><i class="fas fa-key fa" aria-hidden="true"></i></span>
							</div>
							<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password" required/>
						</div>

						<div class="input-group flex-nowrap">
								<div class="input-group-prepand">
									<span class="input-group-text"><i class="fas fa-key fa" aria-hidden="true"></i></span>
								</div>
								<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password" required/>
						</div>

						<div class="form-group ">
							<button type="submit" class="btn btn-primary btn-block login-button">Register</button>
						</div>
						
					</form>
				</div>
			
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="js/validation.js"></script>
        
	</body>
</html>
