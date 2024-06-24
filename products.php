<?php
require 'dbc.php';
session_start();

if (isset($_SESSION['new_user'])) {
    $em = $_SESSION['new_user'];
    $sql = mysqli_query($connect, "SELECT * FROM user WHERE email='$em';");
    $row2 = mysqli_fetch_assoc($sql);
    if (!$row2) {
        header("Location:home.php");
        exit();
    }
} else {
    header("Location:home.php");
    exit();
}

$brand_name = isset($_GET['brand_name']) ? urldecode($_GET['brand_name']) : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['pn'];
    $brand_name = $_POST['bn'];
    $quantity = $_POST['qty'];
    $price = $_POST['pc'];
    $description = $_POST['des'];
    $product_image = $_FILES['p_image']['name'];
    $product_image_tmp_name = $_FILES['p_image']['tmp_name'];
    $product_image_folder = 'arrivals/'. $product_image;

    $check = mysqli_query($connect, "SELECT * FROM product WHERE prod_name='$product_name' AND brand_name='$brand_name'");
    $res = mysqli_num_rows($check);
    $error = array();
    $output = '';

    if (empty($product_name)) {
        $error['l'] = "Enter product name";
    } else if ($res > 0) {
        $error['l'] = "Product already exists";
    }

    if (isset($error['l'])) {
        $output .= "<p class='alert'>" . $error['l'] . "</p>";
    } else {
        $output .= "";
    }

    if (count($error) <= 0) {
        $insert = mysqli_query($connect, "INSERT INTO product (prod_name, brand_name, prod_qty, price, prod_des, prod_img) VALUES ('$product_name', '$brand_name', '$quantity', '$price', '$description', '$product_image_folder')");
        if ($insert) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $output .= "<p class='success'>Product added successfully</p>";
            header("Location: viewProducts.php");
            exit();
        } else {
            $output .= "<p class='alert'>Failed to add product</p>";
        }
    }
}
if (isset($_GET['bId'])) {
    $bId = $_GET['bId'];
    $select_brand = mysqli_query($connect, "SELECT * FROM brand WHERE brand_id='$bId'");
    $row1 = mysqli_fetch_assoc($select_brand);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add products</title>
    <link rel="stylesheet" href="style1.css">
    <style>
        .file-upload {
            display: none;
        }

        .upload-button {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #2c3e50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            bottom: 15px;
            right: 25px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="registration">
            <div class="title">add products</div>
            <?php if (isset($output)) { echo $output; } ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="input-box">
                    <img src="./images/msp.jpg" alt="" style="width: 80px; height: 80px; border-radius:50%">
                    <label for="pimg" class="upload-button">Upload</label>
                    <input type="file" placeholder="Upload a new image" accept="image/png, image/jpg, image/jpeg" name="p_image" id="pimg" class="file-upload">
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Product Name" name="pn">
                </div>
                <div class="input-box">
                <input type="text" placeholder="Brand Name" name="bn" value='<?php echo $row1['brand_name'] ? $row1['brand_name'] : ""; ?>' readonly>
                </div>
                <div class="input-box">
                    <input type="number" min="0" max="1000" placeholder="Quantity" name="qty">
                </div>
                <div class="input-box">
                    <input type="number" placeholder="Price" name="pc">
                </div>
                <div class="input-box" style="width:100%;">
                    <input style="height: 80px;" type="text" placeholder="Write something about the product" name="des">
                </div>
                <div class="button">
                    <input type="submit" value="Add" name="submit">
                </div>
            </form>
            <div class="directToLogin">
                <div class="button">
                    <a href="index.php">HOME</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
