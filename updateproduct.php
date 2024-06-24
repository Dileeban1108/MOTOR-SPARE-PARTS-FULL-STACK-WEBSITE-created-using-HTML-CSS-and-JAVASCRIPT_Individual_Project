<?php
require 'dbc.php';
session_start();
$output = "";

if (isset($_SESSION['new_user'])) {
    $em = $_SESSION['new_user'];
    $sql = mysqli_query($connect, "SELECT * FROM user WHERE email='$em';");
    $row = mysqli_fetch_assoc($sql);
    if (!mysqli_num_rows($sql) > 0) {
        header("Location: home.php");
    }
} else {
    header("Location: home.php");
}

if (isset($_GET['pId'])) {
    $pId = $_GET['pId'];
    $select_product = mysqli_query($connect, "SELECT * FROM product WHERE prod_id='$pId'");
    $row1 = mysqli_fetch_assoc($select_product);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Brand</title>
    <link rel="stylesheet" href="phone-number-validation/build/css/demo.css">
    <link rel="stylesheet" href="phone-number-validation/build/css/intlTelInput.css">
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
        }
    </style>
</head>

<body>
    <div class="login-container">

        <div class="registration">
            <div class="title">Update Product</div>
            <?php
            if (isset($output)) {
                echo $output;
            }
            ?>
            <form action="updateproduct.php?pId=<?php echo $pId; ?>" method="POST" enctype="multipart/form-data">
                <div class="input-box" style="flex-direction: column; gap:5px">
                    <img src="<?php echo $row1['prod_img']; ?>" alt="" style="width: 100px;">
                    <label for="pimg" class="upload-button">Upload New Image</label>
                    <input type="file" placeholder="Upload a new image" accept="image/png, image/jpg, image/jpeg" name="pimg" id="pimg" class="file-upload">
                </div>
                <div class="input-box">
                    <input type="text" placeholder="<?php echo "Name [ ex: " . $row1['prod_name'] . " ]"; ?>" name="pn" value="<?php echo $row1['prod_name']; ?>">
                </div>
                <div class="input-box">
                    <input type="text" placeholder="<?php echo "Description [ ex: " . $row1['prod_des'] . " ]"; ?>" name="pd" value="<?php echo $row1['prod_des']; ?>">
                </div>
                <div class="input-box">
                    <input type="text" placeholder="<?php echo "Quantity [ ex: " . $row1['prod_qty'] . " ]"; ?>" name="pq" value="<?php echo $row1['prod_qty']; ?>">
                </div>
                <div class="input-box">
                    <input type="text" placeholder="<?php echo "Price [ ex: " . $row1['price'] . " ]"; ?>" name="pp" value="<?php echo $row1['price']; ?>">
                </div>
                <div class="button">
                    <input type="submit" value="Update" name="submit">
                </div>
            </form>
            <div class="directToLogin">
                <div class="button">
                    <a href="index.php">HOME</a>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $prodName = $_POST['pn'];
        $prodDes = $_POST['pd'];
        $prodPrice = $_POST['pp'];
        $prodQty = $_POST['pq'];
        $error = array();

        if (empty($prodName)) {
            $error['l'] = "Enter product name";
        } else if (empty($prodDes)) {
            $error['l'] = "Enter product description";
        } else if (empty($prodPrice)) {
            $error['l'] = "Enter product price";
        } else if (empty($prodQty)) {
            $error['l'] = "Enter product quantity";
        }

        if (isset($error['l'])) {
            $output .= "<p class='alert'>" . $error['l'] . "</p>";
        } else {
            $output .= " ";
        }

        if (count($error) < 1) {
            if (isset($_FILES['pimg']) && !empty($_FILES['pimg']['name'])) {
                $p_image = $_FILES['pimg']['name'];
                $p_image_tmp_name = $_FILES['pimg']['tmp_name'];
                $p_image_folder = 'arrivals/'.$p_image;

                $sql1 = "UPDATE product SET prod_name='$prodName', prod_img='$p_image_folder', prod_des='$prodDes', price='$prodPrice', prod_qty='$prodQty' WHERE prod_id='$pId'";
                $res = mysqli_query($connect, $sql1);
                if ($res) {
                    move_uploaded_file($p_image_tmp_name, $p_image_folder);
                    $output .= "<p class='success'>Product updated successfully</p>";
                    header("Location: viewProducts.php");
                } else {
                    $output .= "<p class='alert'>Error updating the product</p>";
                }
            } else {
                $sql1 = "UPDATE product SET prod_name='$prodName', prod_des='$prodDes', price='$prodPrice', prod_qty='$prodQty' WHERE prod_id='$pId'";
                $res = mysqli_query($connect, $sql1);
                if ($res) {
                    $output .= "<p class='success'>Product updated successfully</p>";
                    header("Location: viewProducts.php");
                } else {
                    $output .= "<p class='alert'>Error updating the product</p>";
                }
            }
        }
    }
    ?>

    <script src="phone-number-validation/build/js/intlTelInput.js"></script>
    <script>
        var input = document.querySelector('#phone');
        window.intlTelInput(input, {});
    </script>
</body>

</html>
