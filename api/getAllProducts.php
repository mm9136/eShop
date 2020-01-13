<?php
     require ("../config_and_connection.php");
     $sql_query=$conn->prepare("SELECT * FROM product JOIN stockitem ON product.product_id=stockitem.product_id  WHERE stockitem.quantity>0 AND product.active=1");
      try{
        $result= $sql_query->execute();
     }
    catch(PDOExeption $ex){
        die("Query failed".$ex->detMessage());
    }
    $rows=$sql_query->fetchAll();
    echo json_encode($rows);

?>
