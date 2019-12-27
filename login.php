<?php 

	$submmited_email='';
	if(ISSET($_POST['email']) && ISSET($_POST['password'])){

		require ('config_and_connection.php');

		if($conn){
			$user = $_POST['email'];
			$pass = $_POST['password'];
            $sql_query = $conn->prepare("SELECT user.user_id,user.email,user.password,user.salt,role.name FROM user 
            	JOIN role ON role.role_id=user.role_id WHERE email = :email ");
            $sql_query->bindParam(":email",$user);
            try{
            	$result= $sql_query->execute();
            }
            catch(PDOExeption $ex){
            	die("Query failed".$ex->detMessage());
            }

            $login_ok=false;
            $row=$sql_query->fetch();
            if($row){
            	$check_password=hash('sha256',$pass.$row['salt']);

            	for($i=0;$i <65536;$i++){
            		$check_password=hash('sha256',$check_password.$row['salt']);
            	}
            	if($check_password == $row['password']){
            		$login_ok=true;
            	}
            }

            if($login_ok){
            	unset($row['salt']);
            	unset($row['password']);
            	$_SESSION['email']=$row['email'];
            	$_SESSION['role']=$row['name'];
            	if($_SESSION['role']=='ADMIN'){
            		header('Location:admin/home.php');
            	}
            	else if($_SESSION['role']=='BUYER'){
            		header('Location:buyer/home.php');
            	}
            	else if($_SESSION['role']=='SELLER'){
            		header('Location:seller/home.php');
            	}
            	else{
            		header('Location:index.php');
            	}
            }
            else{

            	echo 'Login failed';
            	$submmited_email = htmlentities($user, ENT_QUOTES, 'UTF-8');
            }
          
            
		}
	}

?>


<html> 
	<head>
		<title>
			Shoes eshop
		</title>
		<meta charset="UTF-8"> 
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link href="css/index.css" rel="stylesheet">
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	</head>
	<body>
		<div id="fullscreen_bg" class="fullscreen_bg"/>

		<div class="container">

			<form class="form-signin" action="" method="POST">
				<h1 class="form-signin-heading text-muted">Sign In</h1>
				<input type="text" class="form-control" placeholder="Email address" required="" autofocus="" name="email" value="<?php echo $submmited_email;?>">
				<input type="password" class="form-control" placeholder="Password" required="" name="password">
				<button class="btn btn-lg btn-primary btn-block" type="submit">
					Sign In
				</button>
			</form>

			<a href="register.php"><div style="text-align: right;">Need account?</div> </a>

		</div>

	</body>

</html>