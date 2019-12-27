<?php 
if(!empty($_SESSION['email']) && !empty($_SESSION['role']) && $_SESSION['role'] == "ADMIN" ){


	echo "U r logged in";
}else{
	header("Location:../index.php");
}


?>