<?php
require 'dbc.php';
session_start();
$output = "";

if (isset($_SESSION['new_user'])) {
    $e = $_SESSION['new_user'];
    $res = "SELECT * FROM user WHERE email='$e';";
    $con = mysqli_query($connect, $res);
    $row = mysqli_fetch_assoc($con);
    $pws = $row['passwrd'];
    $res1 = "SELECT * FROM admi WHERE email='$e' AND passwrd='$pws';";
    $tke = mysqli_query($connect, $res1);

    if (!mysqli_num_rows($tke) > 0) {
        header("Location: home.php");
    }
} else {
    header("Location: home.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['bn'];
    $b_image = $_FILES['b_image']['name'];
    $b_image_tmp_name = $_FILES['b_image']['tmp_name'];
    $b_image_folder = 'brands/' . $b_image;

    $check = mysqli_query($connect, "SELECT * FROM brand WHERE brand_name='$name'");
    $res = mysqli_num_rows($check);
    $error = array();
    if (empty($name)) {
        $error['l'] = "Enter brand name";
    } else if ($res > 0) {
        $error['l'] = "Brand already exists";
    }

    if (isset($error['l'])) {
        $output .= "<p class='alert'>" . $error['l'] . "</p>";
    } else {
        $output .= "";
    }
    if (count($error) <= 0) {
        $insert = mysqli_query($connect, "INSERT INTO brand (brand_name, image_address) VALUES ('$name', '$b_image_folder')");
        if ($insert) {
            move_uploaded_file($b_image_tmp_name, $b_image_folder);
            $output .= "<p class='success'>Brand added successfully</p>";
            header("Location: index.php");
            exit();
        } else {
            $output .= "<p class='alert'>Failed to add brand</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Brands</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            <div class="title">Add Brands</div>
            <?php
            if (isset($output)) {
                echo $output;
            }
            ?>
            <form action="brands.php" method="POST" enctype="multipart/form-data">
                <div class="input-box">
                    <img src="./images/msp.jpg" alt="" style="width: 80px; height: 80px; border-radius:50%">
                    <label for="b_image" class="upload-button">Upload</label>
                    <input type="file" accept="image/png, image/jpg, image/jpeg" name="b_image" id="b_image" class="file-upload">
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Brand Name" name="bn">
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
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-column">
                <h3>About Us</h3>
                <p>We provide high-quality motor spare parts to ensure the best performance and longevity for your vehicles. Our mission is to offer reliable products and exceptional customer service.</p>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contact Us</h3>
                <p>Address: 1234 Motor Street, Auto City, AS 56789</p>
                <p>Email: info@motorspareparts.com</p>
                <p>Phone: (123) 456-7890</p>
            </div>
            <div class="footer-column">
                <h3>Follow Us</h3>
                <div class="social-media">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="bottom-footer">
            <p>&copy; 2024 Motor Spare Parts. All Rights Reserved.</p>
        </div>
    </footer>
</body>

</html>
