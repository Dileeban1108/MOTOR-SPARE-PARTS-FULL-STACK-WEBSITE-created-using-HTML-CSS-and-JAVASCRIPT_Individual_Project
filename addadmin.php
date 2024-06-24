<?php
require 'dbc.php';

session_start();

if (isset($_SESSION['new_user'])) {
    $em = $_SESSION['new_user'];

    $choose = mysqli_query($connect, "SELECT * FROM user WHERE email='$em'");
    $row = mysqli_fetch_assoc($choose);


    $p = $row['passwrd'];

    $take = mysqli_query($connect, "SELECT * FROM superadmin WHERE  email='$em'  AND  passwrd='$p'");

    if (mysqli_num_rows($take) == 0) {
        header('Location:home.php');
    }
} else {
    header('Location:home.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add admin</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="phone-number-validation\build\css\demo.css">
    <link rel="stylesheet" href="phone-number-validation\build\css\intlTelInput.css">
</head>

<body>
    <div class="login-container">

        <div class="registration">
            <div class="title">
                add admin
            </div>

            <?php
            // if(isset($output)){
            include 'admin.php';
            echo $output;
            // }
            ?>

            <form action="addadmin.php" method="POST">
                <div class="input-box">
                    <input type="text" placeholder="enter name" name="name">
                </div>
                <div class="input-box">
                    <input type="tel" id="phone" max="10" placeholder="enter phone number" name="pNumber">
                </div>
                <div class="input-box" style="width: 100%;">
                    <input type="email" placeholder="enter email" name="email">
                </div>
                <div class="input-box">
                    <input type="password" placeholder="enter password" name="pwd">
                </div>
                <div class="input-box">
                    <input type="password" placeholder="confirm password" name="cpwd">
                </div>
                <div class="button">
                    <input type="submit" value="add" name="submit">
                </div>
            </form>
            <div class="homebtn">
                <a href="index.php">Home</a>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-container">
            <!-- Company Info -->
            <div class="footer-column">
                <h3>About Us</h3>
                <p>
                    We provide high-quality motor spare parts to ensure the best performance and longevity for your vehicles. Our mission is to offer reliable products and exceptional customer service.
                </p>
            </div>

            <!-- Quick Links -->
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

            <!-- Contact Info -->
            <div class="footer-column">
                <h3>Contact Us</h3>
                <p>Address: 1234 Motor Street, Auto City, AS 56789</p>
                <p>Email: info@motorspareparts.com</p>
                <p>Phone: (123) 456-7890</p>
            </div>

            <!-- Social Media -->
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

        <!-- Bottom Footer -->
        <div class="bottom-footer">
            <p>&copy; 2024 Motor Spare Parts. All Rights Reserved.</p>
        </div>
    </footer>
    <script src="phone-number-validation\build\js\intlTelInput.js"></script>
    <script>
        var input = document.querySelector('#phone');

        window.intlTelInput(input, {});
    </script>
</body>

</html>