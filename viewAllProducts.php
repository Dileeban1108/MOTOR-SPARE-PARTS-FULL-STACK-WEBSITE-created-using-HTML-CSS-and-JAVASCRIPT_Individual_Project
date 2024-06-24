<?php
require 'dbc.php';
session_start();

// Initialize variables
$row2 = null;
$chkresult = 0;
$chkresult1 = 0;

if (isset($_SESSION['new_user'])) {
    $em = $_SESSION['new_user'];
    $sql = mysqli_query($connect, "SELECT * FROM user WHERE email='$em';");
    $row2 = mysqli_fetch_assoc($sql);
    if (!mysqli_num_rows($sql) > 0) {
        header("Location:login.php");
    }
} else {
    header("Location:login.php");
}
if (!isset($_SESSION['cart_count'])) {
    $_SESSION['cart_count'] = 0;
}

$qty = 1;
if ($row2) {
    $qty = 1;

    if (isset($_GET['pId'])) {
        $pId = $_GET['pId'];
        $stmt = $connect->prepare("SELECT * FROM cart WHERE userId = ? AND productId = ?");
        $stmt->bind_param("si", $em, $pId);
        $stmt->execute();
        $checkProductQuery = $stmt->get_result();

        if ($checkProductQuery->num_rows === 0) {
            $stmt = $connect->prepare("INSERT INTO cart (userId, productId, qty) VALUES (?, ?, ?)");
            $stmt->bind_param("sii", $em, $pId, $qty);
            $stmt->execute();
            $_SESSION['cart_count']++;
            echo '<script>
                alert("Added to cart successfully");
                window.location.href = "viewAllProducts.php";
            </script>';
        } else {
            echo '<script>
                alert("Already added to the cart");
                window.location.href = "viewAllProducts.php";
            </script>';
        }
        $stmt->close();
    }
}

$products = [];
$searchQuery = '';
if (isset($_GET['search-bar'])) {
    $searchQuery = strtolower($_GET['search-bar']); // Convert to lowercase for comparison
    $searchPattern = "%" . $searchQuery . "%"; // Add wildcard characters for LIKE clause
    $stmt = $connect->prepare("SELECT * FROM product WHERE LOWER(prod_name) LIKE ? OR LOWER(brand_name) LIKE ?");
    $stmt->bind_param("ss", $searchPattern, $searchPattern);
    $stmt->execute();
    $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $select_prod = mysqli_query($connect, "SELECT * FROM product ORDER BY prod_id DESC");
    if (mysqli_num_rows($select_prod) > 0) {
        $products = mysqli_fetch_all($select_prod, MYSQLI_ASSOC);
    }
}

$count = isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Shop</title>
    <style>
        .highlight {
            border: 5px solid #ff0000;
            background-color: rgba(255, 0, 0, 0.1);
        }

        .sub-menu-wrap {
            position: absolute;
            top: 100%;
            right: 5%;
            width: 300px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            background-color: white;
            z-index: 10;
            font-size: 15px;
        }

        .sub-menu-wrap.open {
            max-height: 500px;
            /* adjust based on your content height */
        }

        .sub-menu .user-info {
            display: flex;
            align-items: center;
            padding: 15px;
        }

        .sub-menu .user-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .sub-menu .texts h2 {
            font-size: 18px;
            margin: 0;
        }

        .sub-menu .texts h3 {
            font-size: 14px;
            color: gray;
            margin: 0;
        }

        .sub-menu hr {
            border: 0;
            height: 1px;
            background-color: #e1e1e1;
            margin: 15px 0;
        }

        .sub-menu a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            text-decoration: none;
            color: black;
            transition: background-color 0.3s;
        }

        .sub-menu a img {
            width: 24px;
            height: 24px;
            margin-right: 15px;
        }

        .sub-menu a span {
            margin-left: auto;
            font-size: 18px;
        }

        .sub-menu a:hover {
            background-color: #f1f1f1;
        }

        .logoutbtn {
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <?php
        if ($row2) {
            if (isset($_SESSION['new_user'])) {
                $ue = $_SESSION['new_user'];
                $result = mysqli_query($connect, "SELECT * FROM superadmin WHERE email='$ue'");
                $result1 = mysqli_query($connect, "SELECT * FROM admi WHERE email='$ue'");
                $chkresult = mysqli_num_rows($result);
                $chkresult1 = mysqli_num_rows($result1);
            }
        }
        ?>
        <a class="logo" href="index.php"><img class="logo" src="./images/logo.png" alt="Logo"></a>
        <div id="menu-bar"><i class="fas fa-bars"></i></div>
        <nav class="navbar">
            <a href="#review">Customer Reviews</a>
            <a href="viewAllProducts.php">Shop</a>
            <a href="index.php">Brands</a>
            <?php
            if ($chkresult == 0 && $chkresult1 == 0) {
                echo '<a href="cart.php"><i class="bx bxs-cart"></i>' . $count . '</a>';
            }
            ?>
        </nav>
        <div class="down-box">
            <div class="outter-box">
                <form action="" method="get" enctype="multipart/form-data">
                    <input class="search-bar" name="search-bar" type="text" placeholder="Search Here...">
                    <button class="search-icon" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        <?php if ($row2) { ?>

            <a href="#" class="signuplogo" onclick="toggleMenu2()">
                <img src="./images/user.png">
            </a>
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="./images/user.png">
                        <div class="texts">
                            <h2><?php echo $row2['userName']; ?></h2>
                            <h3><?php echo $row2['email']; ?></h3>
                        </div>
                    </div>
                    <hr>
                    <a href="editProfile.php">
                        <img src="./images/user-circle-solid-24.png" alt="">
                        <p>Edit Profile</p>
                        <span>></span>
                    </a>
                    <?php
                    if ($chkresult1 > 0) {
                        if ($chkresult > 0) {
                            echo '<a href="addadmin.php">
                                <img src="./images/user-circle-solid-24.png" alt="">
                                <p>Add admins</p>
                                <span>></span>
                              </a>
                        <a href="viewAdmins.php" onclick="toggleMenu2()">
                                <img src="./images/user-circle-solid-24.png" alt="">
                                <p>View admins</p>
                                <span>></span>
                        </a>';
                        }
                        echo '<a href="viewUsers.php" onclick="toggleMenu3()">
                                <img src="./images/user-circle-solid-24.png" alt="">
                                <p>View users</p>
                                <span>></span>
                        </a>';
                    }
                    ?>
                    <a href="index.php?logout" class='logoutbtn'>
                        <img src="./images/horizontal-right-regular-24.png" alt="">
                        <p>Logout</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        <?php } ?>

    </header>
    <section class="shop">
        <div class="box-container">
        <?php
            if (!empty($products)) {
                foreach ($products as $product) {
                    $highlightClass = (strpos(strtolower($product['prod_name']), $searchQuery) !== false) ? 'highlight' : '';
            ?>
                    <div class="box <?php echo $highlightClass; ?>" style="width: 300px;">
                        <h1><?php echo $product['price'] . " $"; ?></h1>
                        <img src="<?php echo $product['prod_img']; ?>" style="object-fit: cover;" alt="Product Image">
                        <h3><?php echo $product['prod_name']; ?></h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <h2><?php echo "Qty :" . $product['prod_qty']; ?></h2>
                        <h2><?php echo $product['prod_des']; ?></h2>
                        <h2><?php echo "Brand :" . $product['brand_name']; ?></h2>
                        <?php
                        if (isset($chkresult1) && $chkresult1 > 0) {
                            echo '<div class="update">
                                    <a href="updateproduct.php?pId=' . $product['prod_id'] . '">Update</a>
                                </div>';
                        } else {
                            echo '
                                <div class="buttons1">
                                    <div class="cart1">
                                        <a href="viewAllProducts.php?pId=' . $product['prod_id'] . '">Add to Cart</a>
                                    </div>
                                    <div class="buy1">
                                        <a href="checkout.php?pId=' . $product['prod_id'] . '">Buy Now</a>
                                    </div>
                                </div>';
                        }
                        ?>
                    </div>
            <?php
                }
            } else {
                echo "<div class='empty'>No products found</div>";
            }
            ?>
        </div>
    </section>
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
                    <li><a href="#home">Home</a></li>
                    <li><a href="#aboutus">About Us</a></li>
                    <li><a href="#steps">Services</a></li>
                    <li><a href="#review">Reviews</a></li>
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

    <script src="script.js"></script>
    <script>
        function toggleMenu() {
            var subMenu = document.getElementById("subMenu");
            subMenu.classList.toggle("open");
        }

        function toggleMenu2() {
            var subMenu = document.getElementById("subMenu");
            subMenu.classList.toggle("open");
        }
    </script>
</body>

</html>
