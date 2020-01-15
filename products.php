 <?php
     require ("config_and_connection.php");
     $sql_query=$conn->prepare("SELECT * FROM product JOIN stockitem ON product.product_id=stockitem.product_id  WHERE stockitem.quantity>0 AND product.active=1");
      try{
        $result= $sql_query->execute();
     }
    catch(PDOExeption $ex){
        die("Query failed".$ex->detMessage());
    }
    $rows=$sql_query->fetchAll();


?>

 <div class="row" id="product_list">
    <?php foreach($rows as $row): ?>
          <div class="col-lg-2 card" style="width: 18rem;">
            <img src="https://localhost/netbeans/eShop/images/<?php echo htmlentities($row['product_id'], ENT_QUOTES, 'UTF-8'); ?>/img0.png" class="card-img-top" alt="<?php echo htmlentities($row['name'], ENT_QUOTES, 'UTF-8'); ?> image">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlentities($row['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                <p class="card-text"><?php echo htmlentities($row['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                <div class="row"> 
                      <p class="price-text"><?php echo htmlentities($row['price'], ENT_QUOTES, 'UTF-8'); ?> EUR</p>
                      <?php if(empty($_SESSION['email']) || empty($_SESSION['role'])){?>
                        <a href="login.php" class="btn btn-primary btn-add-to-cart">Add to cart</a>
                      <?php }else if(!empty($_SESSION['email']) && !empty($_SESSION['role']) && $_SESSION['role'] == "BUYER" ){?>
                         <a class="add_to_cart btn btn-primary btn-add-to-cart" data-id="<?php echo htmlentities($row['product_id'], ENT_QUOTES, 'UTF-8'); ?>">Add to cart</a>

                      <?php }?>
                </div>
            </div>
          </div>
   <?php endforeach; ?>
</div>