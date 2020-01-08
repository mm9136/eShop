
<?php 
      if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')) {
          
      }else{
           header("Location:https://localhost/eShop/login.php");
      }
      session_start();
	$submmited_email='';
      $success = 0;
	if(ISSET($_POST['email']) && ISSET($_POST['password'])){

		require ('config_and_connection.php');

		if($conn){
			$user = $_POST['email'];
			$pass = $_POST['password'];
            $sql_query = $conn->prepare("SELECT user.user_id,user.email,user.password,user.salt,role.name, user.active FROM user 
            	JOIN role ON role.role_id=user.role_id WHERE email = :email");
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
            if($row['active'] == 1 && $login_ok){
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
            		header('Location:login.php');
            	}
            }
            else if($row['active'] == 0){
                  $success = 1;
                  $submmited_email = htmlentities($user, ENT_QUOTES, 'UTF-8');
            }else{
                  $success = 2;
                  $submmited_email = htmlentities($user, ENT_QUOTES, 'UTF-8');
            }
          
            
		}
	}

?>


<html> 
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
             <title> Gigatron </title>
	</head>
	<body>
            <?php include 'anonimousnavigation.php';

                  if($success==1){
                        echo '<div class="alert alert-warning" role="alert"> You account need to be approved! </div>' ;

                  } 
                  else if($success==2){
                        echo ' <div class="alert alert-danger" role="alert"> Login failed! Try again !</div>' ;

                  }
            ?>
		<div class="container">
               <div class="main-login main-center">   
			<form id="register-form" class="form-signin" action="" method="POST">
				<div class="input-group flex-nowrap">
                              <div class="input-group-prepand">
                                    <span class="input-group-text"><i class="fas fa-at fa" aria-hidden="true"></i></span>
                              </div>
                              <input type="email" class="form-control" name="email" id="email"  placeholder="Enter your Email" value="<?php echo $submmited_email;?>" required/>
                        </div>
                        <div class="input-group flex-nowrap">
                              <div class="input-group-prepand">
                                    <span class="input-group-text"><i class="fas fa-key fa" aria-hidden="true"></i></span>
                              </div>
                              <input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password" required/>
                        </div>
                        <div id ="login-btn-block">
                              <div class="input-group flex-nowrap">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg">Sign In</button>
                              </div>
                              <div class="input-group flex-nowrap">
                                     <a href="register.php"><div style="text-align: right;">Need account?</div> </a>
                              </div>
                         </div>
			</form>

			

      		</div>
            </div>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>

</html>