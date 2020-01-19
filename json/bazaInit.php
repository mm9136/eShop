<?php
 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
// Initialize variable for database credentials
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'ep';
$dbname = 'eShop';
 
//Create database connection
  $dblink = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
 
//Check connection was successful
  if ($dblink->connect_errno) {
     printf("Failed to connect to database");
     exit();
  }
 
//Fetch 3 rows from actor table
  $result = $dblink->query("SELECT * FROM product");
 
//Initialize array variable
  $dbdata = array();
 
//Fetch into associative array
  while ( $row = $result->fetch_assoc())  {
    $dbdata[]=$row;
  }
 
 
 
//Print array in JSON format
 echo json_encode($dbdata);
 
 ?>