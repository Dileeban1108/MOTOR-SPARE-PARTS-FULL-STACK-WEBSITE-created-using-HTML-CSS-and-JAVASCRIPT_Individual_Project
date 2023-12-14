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
    if (isset($_GET['brand_Id'])) {
     $bId = $_GET['brand_Id']; 
     $select_brand = mysqli_query($connect, "SELECT * FROM brand WHERE brand_id='$bId' ");
     $row1 = mysqli_fetch_assoc($select_brand);
    }
    ?>
    <div class="product_section">
        <div class="products">
        <?php if (isset($row1)){ ?>
            <div class="image">
                 <img src="<?php echo $row1['image_address']; ?>" alt="">
            </div>
            <div class="name">
                <h1><?php echo $row1['brand_name']; ?></h1>
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
            <form action="updateBrand.php" method="POST" enctype="multipart/form-data">
                <div>
                    <input type="file" placeholder="Upload a new image" accept="image/png, image/jpg, image/jpeg" name="pimg">
                </div>
                <div>
                <input type="text" placeholder="<?php echo "Name [ ex : " .$row1['brand_name']. " ]"?>"  name="pn">
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
        $brandName = $_POST['pn'];
        if (isset($_FILES['bimg']) && !empty($_FILES['bimg']['name'])) {
            $b_image = $_FILES['bimg']['name'];
            $b_image_tmp_name = $_FILES['bimg']['tmp_name'];
            $b_image_folder= 'brands/'.$b_image;
            $error = array();    
        
        if (empty($prodName)) {
            $error['l'] = "Enter product name";
        }

        if (isset($error['l'])) {
            $output .= "<p class='alert'>" . $error['l'] . "</p>";
        } else {
            $output .= " ";
        }
            
        if (count($error) < 1) {
                $bId = $_GET['brand_Id']; 
                $sql1 = "UPDATE brand SET brand_name='$brandName',prod_des='$des ' WHERE brand_id='$bId' ";
                $res = mysqli_query($connect, $sql1);
                if($res){
                    move_uploaded_file($b_image_tmp_name,$b_image_folder);
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