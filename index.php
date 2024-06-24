<?php
require 'dbc.php';
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    $_SESSION['cart_count'] = 0;
    header("Location:home.php");
    exit();
}

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

$count = isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;
$brands = [];
$searchQuery = '';
if (isset($_GET['search-bar'])) {
    $searchQuery = strtolower($_GET['search-bar']); // Convert to lowercase for comparison
    $searchPattern = "%" . $searchQuery . "%"; // Add wildcard characters for LIKE clause
    $stmt = $connect->prepare("SELECT * FROM brand WHERE LOWER(brand_name) LIKE ?");
    $stmt->bind_param("s", $searchPattern);
    $stmt->execute();
    $brands = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ABC Private Limited</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        if (isset($_SESSION['new_user'])) {
            $ue = $_SESSION['new_user'];
            $result = mysqli_query($connect, "SELECT * FROM superadmin WHERE email='$ue'");
            $result1 = mysqli_query($connect, "SELECT * FROM  admi WHERE email='$ue'");
            $res = mysqli_query($connect, "SELECT * FROM admi");
            $chkresult = mysqli_num_rows($result);
            $chkresult1 = mysqli_num_rows($result1);
        }
        ?>
        <a class="logo" href="index.php"><img class="logo" src="./images/logo.png" alt=""></a>
        <div class="down-box">
            <div class="outter-box">
                <form action="" method="get" enctype="multipart/form-data">
                    <input class="search-bar" name="search-bar" type="text" placeholder="Search Here...">
                    <button class="search-icon" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        <nav class="navbar">
            <?php
            if (isset($_SESSION['new_user'])) {
                $ue = $_SESSION['new_user'];
                $result1 = mysqli_query($connect, "SELECT * FROM admi WHERE email='$ue'");
                $chkresult1 = mysqli_num_rows($result1) > 0;
            }
            ?>
            <a href="#reveiw">customer reviews</a>
            <a href="viewAllProducts.php">shop</a>
            <?php
            if (!$chkresult || !$chkresult1) {
                echo '<a href="cart.php"><i class="bx bxs-cart"></i>' . $count . '</a>';
            }

            ?>
        </nav>

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
    </header>

    <section class="popular">
        <h1 class="heading"> <span> OUR</span> BRANDS</h1>
        <div class="box-containerp">
            <?php
            if (isset($_SESSION['new_user'])) {
                $ue = $_SESSION['new_user'];
                $sql = "SELECT * FROM admi WHERE email='$ue';";
                $result1 = mysqli_query($connect, $sql);
                $chkresult1 = mysqli_num_rows($result1);
                $row3 = mysqli_fetch_assoc($result1);

                if ($chkresult1) {
                    echo '<div class="box" style="background-color: rgba(180, 180, 180, 0.326);">
                    <a href="brands.php"><img class="plus" style=" position:relative; top:15px; padding:30px;"src="images\plus.png" alt=""></a>
                    <h6 style="color:gray; font-size:2.0rem; position: relative;top: 5rem;">add brand</h6>
                    <div class="stars">
                        
                    </div>
                    <div class="">
                        <p></p>
                        <a href="" class=""></a>
                    </div>
                </div>';
                }
            }

            ?>
            <?php
            $select_brand = mysqli_query($connect, "SELECT * FROM brand ORDER BY brand_id desc");
            if (mysqli_num_rows($select_brand) > 0) {
                while ($row1 = mysqli_fetch_assoc($select_brand)) {
                    $highlightClass = (strpos(strtolower($row1['brand_name']), $searchQuery) !== false) ? 'highlight' : '';
            ?>
                    <div class="box <?php echo $highlightClass; ?>">
                        <img src="<?php echo $row1['image_address']; ?>" style="object-fit: cover;" alt="">
                        <h3><?php echo $row1['brand_name']; ?></h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <?php
                        if ($chkresult1) {
                            echo '<div class="update">
                 <a href="updateBrand.php? bId= ' . $row1['brand_id'] . '">Update</a>
              </div>
              <div class="update">
                <a href="products.php? bId= ' . $row1['brand_id'] . '">Add products</a>
            </div>';
                        } else {
                            echo '<div class="update">
                            <a href="viewProducts.php? bId= ' . $row1['brand_id'] . '">View products</a>
                        </div>';
                        }
                        ?>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </section>
    <section class="about-us" id="aboutus">
        <div class="containerq">
            <h1>About <span style="color: orangered;">Us</span></h1>
            <p>
                Welcome to Motor Spare Parts, your trusted source for high-quality spare parts for all types of vehicles. Established in 2024, we have built a reputation for providing reliable, durable, and affordable motor parts that keep your vehicles running smoothly.

                Our mission is to ensure the longevity and performance of your vehicles by offering a comprehensive range of spare parts from the best manufacturers in the industry. Whether you're a professional mechanic or a DIY enthusiast, we have the parts you need to get the job done right.

                At Motor Spare Parts, we pride ourselves on our exceptional customer service. Our knowledgeable and friendly staff are always here to help you find the right parts for your specific needs. We believe in building lasting relationships with our customers based on trust and satisfaction.

                Thank you for choosing Motor Spare Parts. We look forward to serving you and helping you keep your vehicles in top condition.
            </p>
        </div>
    </section>
    <section class="empty"></section>

    <section class="reveiw" id="reveiw">
        <h1> <span>CUSTOMER</span> REVIEWS</h1>
        <div class="addingReview">
            <form action="addreview.php" method="POST" enctype="multipart/form-data">
                <div>
                    <input type="hidden" value="<?php echo htmlspecialchars($row2['userName']) ?>" name="rn">
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Add your review here " name="des">
                </div>
                <div class="button">
                    <input type="submit" value="Add" name="submit">
                </div>
            </form>
        </div>
        <div class="box-container">
            <?php
            $select_reviews = mysqli_query($connect, "SELECT * FROM review ORDER BY rId desc");
            if (mysqli_num_rows($select_reviews) > 0) {
                while ($row8 = mysqli_fetch_assoc($select_reviews)) {
            ?>
                    <div class="box">
                        <img src="images\customers.png" alt="">
                        <h3> <?php echo htmlspecialchars($row8['reviewerName']); ?></h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div class="comment">
                            <p><?php echo htmlspecialchars($row8['review']); ?></p>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='emptyy'>no reviews added</div>";
            };
            ?>
        </div>
    </section>

    <section class="empty"></section>
    <section class="steps" id="steps">
        <div class="step-heading">
            <h1>
                At <span style="color:red; background-color:white; padding:0 2px; border-radius:10px;">AFIXGEAR</span>, we take pride in delivering top-notch services to meet all your motor spare parts needs. Our commitment revolves around providing a seamless experience for automotive enthusiasts, mechanics, and businesses alike. Here's what sets our services apart:
            </h1>
        </div>
        <div class="box">
            <img style="width:39%" src="./images/setting.png" alt="" style="height:60%">
            <h3>choose what you need</h3>
        </div>
        <div class="box">
            <img style="width:70%" src="./images/pngwing.com (1).png" alt="">
            <h3>free and fast delivery</h3>
        </div>
        <div class="box">
            <img src="./images/pngwing.com (2).png" alt="">
            <h3>ease payments methods</h3>
        </div>
        <div class="box">
            <img src="./images/pngwing.com (3).png" alt="">
            <h3>and Finally,fix your vehicle</h3>
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
                    <li><a href="#steps">Servises</a></li>
                    <li><a href="#reveiw">Reviews</a></li>
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