<?php
	$database_name="eshop";
	$server_name="localhost";
	$user="root";
	$password="";
	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
	try{
		$conn=new PDO("mysql:host=$server_name;dbname=$database_name",$user,$password,$options);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	}
	catch(PDOExeption $e){
		die ("Failed to connect to database:".$e->getMessage());
	}
	
?>