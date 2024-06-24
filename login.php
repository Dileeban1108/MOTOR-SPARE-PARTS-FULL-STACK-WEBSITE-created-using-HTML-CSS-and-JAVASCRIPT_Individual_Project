<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motor Spare Parts</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="login-container">
        <div class="login">
            <div class="title">Sign In</div>
            <?php
            include 'check.php';
            echo $output;
            ?>
            <form action="login.php" method="POST">
                <div class="input-boxL">
                    <input type="email" placeholder="Email" name="email">
                </div>
                <div class="input-boxL">
                    <input type="password" placeholder="Password" name="password">
                </div>
                <div class="button">
                    <input type="submit" value="Sign In" name="submit">
                </div>
            </form>
            <div class="directToLogin">
                <h4>Dont have an account?</h4>
                <div class="button">
                    <a href="signup.php">sign up</a>
                </div>
            </div>
            <div class="homebtn">
                <a href="index.php">Home</a>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
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
</body>

</html>
