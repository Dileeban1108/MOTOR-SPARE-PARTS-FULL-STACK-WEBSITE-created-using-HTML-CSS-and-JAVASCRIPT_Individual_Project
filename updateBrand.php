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

if (isset($_GET['bId'])) {
    $bId = $_GET['bId'];
    $select_brand = mysqli_query($connect, "SELECT * FROM brand WHERE brand_id='$bId'");
    $row1 = mysqli_fetch_assoc($select_brand);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brandName = $_POST['bn'];
    $error = array();

    if (empty($brandName)) {
        $error['l'] = "Enter brand name";
    }

    if (isset($error['l'])) {
        $output .= "<p class='alert'>" . $error['l'] . "</p>";
    } else {
        $output .= " ";
    }

    if (count($error) < 1) {
        $b_image = $row1['image_address'];
        if (isset($_FILES['b_image']) && !empty($_FILES['b_image']['name'])) {
            $b_image = $_FILES['b_image']['name'];
            $b_image_tmp_name = $_FILES['b_image']['tmp_name'];
            $b_image_folder = 'brands/' . $b_image;
            move_uploaded_file($b_image_tmp_name, $b_image_folder);
        }

        $sql1 = "UPDATE brand SET brand_name='$brandName', image_address='$b_image_folder' WHERE brand_id='$bId'";
        $res = mysqli_query($connect, $sql1);
        if ($res) {
            $output .= "<p class='success'>Brand updated successfully</p>";
            header("Location: index.php");
        } else {
            $output .= "<p class='alert'>Error updating the brand</p>";
        }
    }
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
            position: relative;
            top: 15px;
            left: 5px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="registration">
            <div class="title">Update Brand</div>
            <?php
            if (isset($output)) {
                echo $output;
            }
            ?>
            <form action="updateBrand.php?bId=<?php echo $bId; ?>" method="POST" enctype="multipart/form-data">
                <div class="input-box" style="flex-direction: column; gap:5px">
                    <img src="<?php echo $row1['image_address']; ?>" alt="" style="width: 100px;">
                    <label for="b_image" class="upload-button">Upload New Image</label>
                    <input type="file" accept="image/png, image/jpg, image/jpeg" name="b_image" id="b_image" class="file-upload">
                </div>
                <div class="input-box">
                    <input type="text" placeholder="<?php echo "Name [ ex: " . $row1['brand_name'] . " ]"; ?>" name="bn" value="<?php echo $row1['brand_name']; ?>">
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

    <script src="phone-number-validation/build/js/intlTelInput.js"></script>
    <script>
        var input = document.querySelector('#phone');
        window.intlTelInput(input, {});
    </script>
</body>

</html>
