<?php
require 'dbc.php';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <style>
        @media(max-width:768px) {
            .reveiw .box-container .box {
                width: 40%;
            }

        }

        @media(max-width:576px) {
            .reveiw .box-container .box {
                width: 100%;
            }

        }
       .login_btn{
        background-color: orangered;
        color: white;
       }
    </style>
</head>

<body>
    <header>
        <a class="logo" href="#"><img class="logo" src="./images/logo.png" alt=""></a>
        <div class="down-box">
            <div class="outter-box">
                <form action="" method="get" enctype="multipart/form-data">
                    <input class="search-bar" name="search-bar" type="text" placeholder="Search Here...">
                    <button class="search-icon" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>  
        <nav class="navbar">
            <a href="#home" class="active">home</a>
            <a href="#reveiw">customer reviews</a>
            <a href="#steps">servises</a>
            <a href="#popular">Brands</a>
            <a href="#aboutus">About Us</a>
        </nav>
          
    </header>
    <section class="home" id="home">
        <div class="back">

        </div>
        <div class="content">
            <h3>About Us ...</h3>
            <p>Welcome to Ignite, your go-to destination for premium motorbike spare parts.
                Fueled by a <br>deep love for motorcycles, we're dedicated to enhancing your riding experience with a
                carefully <br>curated selection of high-quality components. Whether you're a seasoned rider or embarking on
                <br>your first journey, trust Ignite for reliable, precision-engineered parts that ensure every ride <br>
                is an exhilarating adventure. Gear up with confidence Ignite, where quality meets passion.
            </p>
            <div class="bor">
            <a href="viewAllProducts.php" class="btn">shop now</a>
            <a href="login.php" class="btn login_btn">Login</a>
            </div>
            

        </div>
    </section>
    <section class="popular">
        <h1 class="heading"> <span> OUR</span> BRANDS</h1>
        <div class="box-containerp">
           
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
                         
                            echo '<div class="update">
                            <a href="viewProducts.php? bId= ' . $row1['brand_id'] . '">View products</a>
                        </div>';
                        
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
        <h1 class="heading"> CUSTOMER<span style="color: orangered;"> REVIEWS</span></h1>
        <div class="box-container">
            <?php
            $select_products = mysqli_query($connect, "SELECT * FROM review ORDER BY rId desc");
            if (mysqli_num_rows($select_products) > 0) {
                while ($row = mysqli_fetch_assoc($select_products)) {
            ?>
                    <div class="box">
                        <img src="images\customers.png" alt="">
                        <h3><?php echo $row['reviewerName']; ?></h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div class="content">
                            <p><?php echo $row['review']; ?></p>
                        </div>
                    </div>
            <?php
                };
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
</body>

</html>