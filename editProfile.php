<?php
require 'dbc.php';
session_start();
$output = "";

if (isset($_SESSION['new_user'])) {
    $em = $_SESSION['new_user'];
    $sql = mysqli_query($connect, "SELECT * FROM user WHERE email='$em';");
    $row = mysqli_fetch_assoc($sql);
    if (!mysqli_num_rows($sql) > 0) {
        header("Location:home.php");
    }
} else {
    header("Location:home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="phone-number-validation/build/css/demo.css">
    <link rel="stylesheet" href="phone-number-validation/build/css/intlTelInput.css">
</head>

<body >
    <?php
    if (isset($_POST['submit'])) {
        $useName = $_POST['un'];
        $phonenumber = $_POST['unmbr'];
        $Password = md5($_POST['upwd']);
        $confirmpassword = md5($_POST['ucpwd']);

        $error = array();

        if (empty($useName)) {
            $error['l'] = "Enter your name";
        } else if (empty($Password)) {
            $error['l'] = "Enter your password";
        } else if (empty($phonenumber)) {
            $error['l'] = "Enter your phone number";
        } else if ($Password !== $confirmpassword) {
            $error['l'] = "Passwords don't match";
        }
        if (isset($error['l'])) {
            $output .= "<p class='alert'>" . $error['l'] . "</p>";
        } else {
            $output .= " ";
        }

        if (count($error) < 1) {
            // Perform the update only if no errors
            $sql = "UPDATE user SET userName='$useName', passwrd='$Password', phoneNumber='$phonenumber' WHERE email='$em'";
            $res = mysqli_query($connect, $sql);
            if ($res) {
                header("Location:index.php?UPDATE=SUCCESS");
            } else {
                // Display an error message or handle the update failure
                $output .= "<p class='alert'>Error updating the user profile</p>";
            }
        }
    }
    ?>
    <div class="login-container">
        <div class="registration">
        <div class="title">Update Profile</div>

            <?php echo $output; ?>
            <form action="editProfile.php" method="POST">
                <div class="input-box">
                    <input type="text" value="<?php echo $row['userName']; ?>" placeholder="Name" name="un">
                </div>
                <div class="input-box">
                    <input type="email" value="<?php echo $row['email']; ?>" placeholder="Email" name="uel" readonly>
                </div>
                <div class="input-box">
                    <input type="tel" value="<?php echo $row['phoneNumber']; ?>" placeholder="Phone number" name="unmbr">
                </div>
                <div class="input-box">
                    <input type="password" placeholder="New password" name="upwd">
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Confirm new password" name="ucpwd">
                </div>
                <div class="button">
                    <input type="submit" value="Update" name="submit">
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
    <script src="phone-number-validation/build/js/intlTelInput.js"></script>
    <script>
        var input = document.querySelector('#phone');
        window.intlTelInput(input, {});
    </script>
</body>

</html>