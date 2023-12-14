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
    <title>signup</title>
    <link rel="stylesheet" href="phone-number-validation\build\css\demo.css">
    <link rel="stylesheet" href="phone-number-validation\build\css\intlTelInput.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style1.css">
</head>
<body>

    <?php
    if (isset($_GET['pId'])) {
     $pId = $_GET['pId']; 
     $select_product = mysqli_query($connect, "SELECT * FROM product WHERE product_ID='$pId' ");
     $row1 = mysqli_fetch_assoc($select_product);
    }
    ?>
    <div class="product_section">
        <div class="products">
        <?php if (isset($row1)){ ?>
            <div class="image">
                 <img src="<?php echo $row1['image_addresse']; ?>" alt="">
            </div>
            <div class="name">
                <h1><?php echo $row1['name']; ?></h1>
            </div>
            <div class="price">
                <h2><?php echo $row1['price']; ?></h2>
            </div>
            <div class="qty">
                <h3><?php echo $row1['quantity']; ?></h3>
            </div>
            <div class="brand">
                <h3><?php echo $row1['brand']; ?></h3>
            </div>
            <?php } ?>
        </div>        
        <div class="update_form">
            <h3>Update product</h3>
            <?php
                 if(isset($output)){
                    echo $output;
                 }
            ?>
            <form action="updateproduct.php" method="POST" enctype="multipart/form-data">
                <div>
                    <input type="file" placeholder="Upload a new image" accept="image/png, image/jpg, image/jpeg" name="pimg">
                </div>
                <div>
                <input type="text" placeholder="<?php echo "Name [ ex : " .$row1['name']. " ]"?>"  name="pn">
                </div>
                <div>
                    <input type="text" placeholder="<?php  echo "Price [ ex : " .$row1['price']. " ]" ?>"  name="pp">
                </div>
                <div>
                    <input type="number" min="0" max="10" placeholder="<?php echo "Quantity [ ex : " . $row1['quantity']. " ]" ?>"  name="pqty">
                </div>
                <div>
                    <input type="text" placeholder="<?php  echo "Brand [ ex : " .$row1['brand']. " ]" ?>"  name="pb">
                </div>
                <div class="submit">
                    <input type="submit" value="Update" name="submit">
                </div>
            </form>
            <div class="home">
                    <a href="index.php">Home</a>
            </div>
         </div>
    </div>
    <?php
    if(isset($_POST['submit'])){
        $prodName = $_POST['pn'];
        $price=$_POST['pp'];
        $qty = $_POST['pqty'];
        $brand = $_POST['pb'];
        if (isset($_FILES['pimg']) && !empty($_FILES['pimg']['name'])) {
            $p_image = $_FILES['pimg']['name'];
            $p_image_tmp_name = $_FILES['pimg']['tmp_name'];
            $p_image_folder_arrivals = 'part_IMG/'.$p_image;
            $error = array();    
        
        if (empty($prodName)) {
            $error['l'] = "Enter product name";
        } else if (empty($price)) {
            $error['l'] = "Enter product price";
        } else if (empty($qty)) {
            $error['l'] = "Enter product quantity";
        } else if (empty($brand)) {
            $error['l'] = "Enetr product brand";
        }

        if (isset($error['l'])) {
            $output .= "<p class='alert'>" . $error['l'] . "</p>";
        } else {
            $output .= " ";
        }
            
        if (count($error) < 1) {
                $pId = $_GET['pId']; 
                $sql1 = "UPDATE product SET name='$prodName',brand='$brand',quantity='$qty',price='$price' WHERE prod_id='$pId' ";
                $res = mysqli_query($connect, $sql1);
                if($res){
                    move_uploaded_file($p_image_tmp_name,$p_image_folder_arrivals);
                    $output.="<p class='success'>product add succesfully into folder_arrivals</p>";  
                    header("Location:index.php");
                } else {
                    $output .= "<p class='alert'>Error updating the product</p>";
                }
        }
    } 
}else {
    $output .= "<p class='alert'>Please select a file to upload</p>";
}
    ?> 
    <script src="phone-number-validation\build\js\intlTelInput.js"></script>
    <script>
        var input=document.querySelector('#phone');
        window.intlTelInput(input,{});
    </script>
</body>
</html>