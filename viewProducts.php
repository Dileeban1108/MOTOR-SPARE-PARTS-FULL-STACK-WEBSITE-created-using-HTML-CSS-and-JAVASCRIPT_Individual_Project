<?php
require 'dbc.php';
session_start();
$output="";

if(isset($_SESSION['new_user'])){
    $em=$_SESSION['new_user'];  
    $sql=mysqli_query($connect,"SELECT * FROM user WHERE email='$em';");
    $row=mysqli_fetch_assoc($sql);
    if(!mysqli_num_rows($sql)>0){
        header("Location:home.php");
    }
} else{
    header("Location:home.php");  
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<section class="shop">
        <h1 class="heading"> <span> Shop</span></h1>
        <div class="box-container">
            <?php
            if(isset($_SESSION['new_user'])){
                $ue=$_SESSION['new_user'];
                $sql="SELECT * FROM admi WHERE email='$ue';";
                $result1=mysqli_query($connect,$sql);
                $chkresult1=mysqli_num_rows($result1);
                $row3= mysqli_fetch_assoc($result1);

                if($chkresult1){
                    echo '<div class="box" style="background-color: rgba(180, 180, 180, 0.326);">
                    <a href="products.php"><img class="plus" style=" position:relative; top:15px; padding:30px;"src="images\plus.png" alt=""></a>
                    <h6 style="color:gray; font-size:2.0rem; position: relative;top: 5rem;">add product</h6>
                    <div class="stars">
                        
                    </div>
                    <div class="">
                        <p></p>
                        <a href="" class=""></a>
                    </div>
                </div>';
               }
            }

            ?>
                <?php
    $select_product= mysqli_query($connect, "SELECT * FROM product ORDER BY product_ID desc");
    if(mysqli_num_rows($select_product) > 0){
        while($row1 = mysqli_fetch_assoc($select_product)){
    ?>
    <div class="box">
         <h1><?php echo  $row1['price'] . " $" ?></h1>
        <img src="<?php echo $row1['image_addresse']; ?>" alt="">
        <h3><?php echo $row1['name']; ?></h3>
        <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
        </div>
        <h2><?php echo "Qty :" . $row1['quantity']; ?></h2>
        <h2><?php echo "Brand :" . $row1['brand']; ?></h2>
        <?php
        if($chkresult1){
        echo '<div class="update">
                 <a href="updateproduct.php? pId= '. $row1['product_ID'] . '">Update</a>
              </div>';
        }else{
        echo '<div class="update">
                <a href="">View products</a>
            </div>
            <div class="buttons1">
                <div class="cart1">
                    <a href="">add to cart</a>
                </div>
                <div class="buy1">
                    <a href="">buy now</a>
                </div>
            </div>';
        } ?>
    </div>
    <?php
        }  
    } else {
        echo "<div class='empty'>no brands added</div>";
    };
    ?>
</div>
        </div>
    </section>
</body>
</html>